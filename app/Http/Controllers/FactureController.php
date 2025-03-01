<?php

namespace App\Http\Controllers;

use App\Models\bonAchat;
use App\Models\clientCarte;
use App\Models\facture;
use App\Models\ligneCarte;
use App\Models\ligneFacture;
use App\Models\produit;
use App\Models\tontine;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;


require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {


        try {
            $this->authorize('see daily invoices');

            $factures= facture::where('updated_at','>', Carbon::today())
                            ->where('paiementValid', true);

            if(isset($request->typeFac) && in_array($request->typeFac, [0,1,2,3,4,5])){
              $factures=$factures->where('typeFac',$request->typeFac);
            }
            $factures=$factures->get();

             $recette=0;
             $netPercu=0;
             $total=0;

            foreach($factures as $facture){
                $recette+=$facture->montant;
                $netPercu+=(1-$facture->remise/100)*$facture->montant;
                $total++;
            }


            $date1 = $request->input('date1');
            $date2 = $request->input('date2');

            if (isset($date1) && isset($date2)) {
                $date1 = Carbon::create($date1);
                $date2 = Carbon::create($date2)->addDay();
                $factures = facture::whereBetween('created_at', [$date1, $date2])
                                  ->orwhere('updated_at','>', Carbon::today());
            } else {
                $factures = facture::where('created_at', '>', Carbon::today())
                                      ->orwhere('updated_at','>', Carbon::today());
            }

            return view('factures.index', [
                'factures' => $factures->get(),
                'recette'=>$recette,
                 'netPercu'=>$netPercu,
                 'total'=>$total
            ]);
        } catch (Exception $e) {
            return view('400');
        }
    }

    public function index2(Request $request)
    {
        try {
            $this->authorize('see daily invoices');

            $date1 = $request->input('date1');
            $date2 = $request->input('date2');

            if (isset($date1) && isset($date2)) {
                $date1 = Carbon::create($date1);
                $date2 = Carbon::create($date2)->addDay();
                $factures = facture::whereBetween('created_at', [$date1, $date2])
                                  ->where('paiementValid', false);;
            } else {
                $factures = facture::where('created_at', '>', Carbon::today())
                                      ->where('paiementValid', false);
            }

            return view('factures.index2', [
                'factures' => $factures->latest()->get()
            ]);
        } catch (Exception $e) {
            return view('400');
        }
    }


    public function addLigneFacView(Request $request, facture $facture)
    {
        return view('factures.nouveauProduits', [
            'facture' => $facture
        ]);
    }
    public function storeLigneFac(facture $facture, Request $request)
    {

        try{

            $ligne = $request->validate([
                'qte' => 'required|integer|min:1',
                'codePro' => 'required|integer|'
            ]);
            DB::beginTransaction();
            $produit = produit::find($ligne['codePro']);
            if (isset($produit) && $produit->qte >= $ligne["qte"]) {


                unset($ligne['codePro']);
                $ligne_creer = new ligneFacture($ligne);
                $ligne_creer->prix = $produit->prix;
                $ligne_creer->prixAchat = $produit->prixAchat;
                $ligne_creer->save();

                $produit->ligneFactures()->save($ligne_creer);
                $facture->ligneFactures()->save($ligne_creer);
                $facture->montant += $ligne["qte"] * $produit->prix;
                $facture->capital += $ligne["qte"] * $produit->prixAchat;
                $facture->save();
            }
            DB::commit();
            return redirect()->route('facture.edit', ["facture" => $facture]);
        } catch (Exception $e) {
            DB::rollBack();
            return view('400');
        }
    }

    public function destroyLigneFac(ligneFacture $ligneFacture)
    {

        try{
            DB::beginTransaction();
            $facture = $ligneFacture->facture;

            $facture->montant -= $ligneFacture->qte * $ligneFacture->prix;
            $facture->capital -= $ligneFacture->qte * $ligneFacture->prixAchat;

            $facture->save();
            $ligneFacture->delete();

            DB::commit();
            return back()->with('success', 'Mise a jour reussie');
        } catch (Exception $e) {
            DB::rollBack();
            return view('400');
        }
    }

    /** FindProduit for facture (Create Facture) */
    public function findProduit(Request $request)
    {
        try {
            $produit = produit::find($request->codePro);
            if ($produit) {
                $data = [
                    'success' => true,
                    'prix' => $produit->prix,
                    'qte' => $produit->qte,
                    'photos' => $produit->photos,
                    'tailles' => $produit->sizes,
                    'couleurs' => $produit->colors
                ];

                return response()->json($data);
            } else {
                $data = [
                    'success' => false,
                ];

                return response()->json($data);
            }

        } catch (Exception $e) {
            return view('400');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $this->authorize('create and edit invoices');

            $facture = $request->validate([
                "remise" => 'numeric',
                "tel" => 'required|string',
                "typeFac" => 'required|numeric',
                "tva" => 'required|numeric',
                "ligneFacture" => 'required|string'
            ]);
            $facture["montant"] = 0;
            $facture["capital"] = 0;

            $user = auth()->user();

            $ligneFacture = json_decode($request->ligneFacture, true);
            unset($facture['ligneFacture']);

            DB::beginTransaction();
            $facture_creer = facture::create($facture);
            $user->factures()->save($facture_creer);

            foreach ($ligneFacture as $ligne) {
                $produit = produit::find($ligne['codePro']);
                if (isset($produit) && $produit->qte >= $ligne["qte"]) {

                    $facture_creer->montant += $ligne["qte"] * $produit->prix;
                    $facture_creer->capital += $ligne["qte"] * $produit->prixAchat;
                    $facture_creer->save();

                    $ligne_creer = ligneFacture::create([
                        'qte' => $ligne["qte"],
                        'prix' => $produit->prix,
                        'prixAchat' => $produit->prixAchat
                    ]);

                    $produit->ligneFactures()->save($ligne_creer);
                    $facture_creer->ligneFactures()->save($ligne_creer);
                }
            }

            $client = clientCarte::query()->where('mobile', $facture_creer->tel)->first();


            if ($client) {
                $ligne_creer = new ligneCarte();
                $ligne_creer->montantFac = $facture_creer->montant;
                $ligne_creer->point = 0;
                $facture_creer->ligneCarte()->save($ligne_creer);
                $client->ligneCartes()->save($ligne_creer);
            }

            DB::commit();
            return redirect()->route('facture.edit', ["facture" => $facture_creer]);
        } catch (Exception $e) {
            DB::rollBack();
            return view('400');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(facture $facture)
    {
        $this->authorize('see daily invoices');
        try {
            $ligneCarte = $facture->ligneCarte;
            if ($ligneCarte) {
                $client = $ligneCarte->clientCarte;
                $bonAchat = bonAchat::query()
                    ->whereBelongsTo($client)
                    ->where('actif', true)
                    ->first();
                $montant = 0;
                $bonAchat && ($montant = $bonAchat->montantGlobal);
                return view('factures.edit', [
                    'facture' => $facture,
                    'client' => $client,
                    'bonAchat' => $montant
                ]);
            } else {
                return view('factures.edit', [
                    'facture' => $facture,
                    'client' => false
                ]);
            }
        } catch (Exception $e) {
            return view('400');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, facture $facture)
    {
        try {
            $update = $request->validate([
                "tva" => "numeric",
                "remise" => "numeric",
                "tel" => "required|string",
                "typeFac" => 'required|numeric',
            ]);

            $facture->update($update);
            $remiseMax = config('app.remise');
            ($facture->remise > $remiseMax) && ($facture->remise = $remiseMax);


            if ($facture->typeFac == 2) {
                return redirect()->route('validerBonAchat', ['facture' => $facture]);
            }

            DB::beginTransaction();
            if ($facture->typeFac == 1) {

                $ligneCarte = $facture->ligneCarte;
                $client = $ligneCarte->clientCarte;

                if ($client->montantTontine >= (((1 - $facture->remise / 100) * $facture->montant)*(1+$facture->tva/100))) {

                    $client->montantTontine -= $facture->montant;
                    $client->save();


                    $tontine = new tontine([
                        'montant' => (1 - $facture->remise / 100) * $facture->montant,
                        'action' => 0,
                        'validite' => 0,
                        'commentaire' => 'Paiement de la facture numero ' . $facture->id
                    ]);

                    $user = auth()->user();
                    $user->tontines()->save($tontine);
                    $client->tontines()->save($tontine);
                } else {
                    DB::rollBack();
                    return back()->withErrors(['message' => 'Tontine insuffisante']);
                }
            }


            foreach ($facture->ligneFactures as $ligne) {
                $produit = $ligne->produit;

                if ($produit->qte < $ligne->qte) {
                    $facture->montant -= $ligne->qte * $ligne->prix;
                    $facture->capital -= $ligne->qte * $ligne->capital;
                    $ligne->delete();
                } else {
                    $produit->qte -= $ligne->qte;
                    $produit->save();
                }
            }


            $facture->paiementValid = 1;
            $facture->save();

            $ligneCarte = $facture->ligneCarte;
            if ($ligneCarte) {
                $ligneCarte->update(['point' => getPoint($facture->montant, $facture->remise)]);
                $client = $ligneCarte->clientCarte;
                $client->point += $ligneCarte->point;
                $client->save();
            }
            DB::commit();
            return back()->with('success', 'Facture enregistree');
        } catch (Exception $e) {
            DB::rollBack();
            return view('404');
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(facture $facture)
    {
        $facture->delete();
        return back()->with('success', 'Facture supprimee');
    }
    public function genereFac(facture $facture)
    {

        try{
          $ligneCarte = $facture->ligneCarte;

          $client = null;
          if ($ligneCarte) {
              $client = $ligneCarte->clientCarte;
          }


          $dompdf = new Dompdf();


        	$htmlResult = view('facture', ["facture" => $facture, "client" => $client])->render();


    	     $dompdf->loadHtml($htmlResult);
           $dompdf->setPaper('A4', 'portrait');
           $dompdf->render();

           $nomfichier = "Facture".$facture->id.".pdf";
            $dompdf->stream($nomfichier,array("Attachment" => true));


           header('Content-Type: application/pdf');
           header('Content-Disposition: attachment; filename="'.$nomfichier.'"');

      		 $dompdf->output();
           //return view('facture', ["facture" => $facture, "client" => $client]);

         }catch(Exception $e)
          {

              return view('400');
          }
      }
}
