<?php

namespace App\Http\Controllers;

use App\Models\categorie;
use App\Models\facture;
use App\Models\gestionStock;
use App\Models\ligneCommande;
use App\Models\ligneFacture;
use App\Models\produit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;


require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;


class ProduitController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }
    public function index(Request $request)
    {



        $search=$request->search;

        $impression=$request->imprimer;

        #Recuperation des produits
        if(isset($search)){

          $search1=str_replace('-', '', $search);

          $produits=produit::where('nomPro', 'LIKE', '%' . $search . '%')
                        ->orWhere('codePro', 'LIKE', '%' . $search1 . '%')
                        ->orWhere('codeArrivage', 'LIKE', '%' . $search . '%');

        }else{
            $produits = produit::query();
        }

        $total=$produits->count();


        #impression
         if(isset($impression)){


             $dompdf = new Dompdf();


        	    $htmlResult = view('produits.impression', ["produits" => $produits->latest()->get(), "total" => $total, "search"=>$search, "date"=>Carbon::today()])->render();


      	     $dompdf->loadHtml($htmlResult);
             $dompdf->setPaper('A4', 'portrait');
             $dompdf->render();

             $nomfichier = "ListeProduit.pdf";
              $dompdf->stream($nomfichier,array("Attachment" => true));


             header('Content-Type: application/pdf');
             header('Content-Disposition: attachment; filename="'.$nomfichier.'"');

        		 $dompdf->output();

          }



          return view('produits.index', [
            'produits' => $produits->latest()->paginate(25),
            'total'=>$total,
          ]);try{
       }catch (Exception $e){
            return view('400');
        }

    }

    public function audit(Request $request)
    {
        try{
          $request->validate(['codePro'=>"required"]);
          $code=str_replace('-', '', $request->codePro);

          $produit=produit::where('codePro',$code)->first();

          if($produit){
            if(isset($request->details)){
                return redirect()->route('produit.edit',['produit'=>$produit]);
            }
              $date1 = $request->input('date1');
              $date2 = $request->input('date2');

              if (isset($date1) && isset($date2)) {
                $date1 = Carbon::create($date1);
                $date2 = Carbon::create($date2)->addDay();

                $gestionsStock = gestionStock::whereBetween('created_at', [$date1,$date2])
                                                ->whereBelongsTo($produit);


                $lignesFacture = ligneFacture::whereBelongsTo($produit)
                                        ->whereHas('facture', function($query) use ($date1, $date2) {
                                            $query->where('paiementValid', true)
                                                  ->whereBetween('updated_at', [$date1,$date2]);

                                        });

                }else {
                      $gestionsStock = gestionStock::whereYear('updated_at', Carbon::now()->year)
                                                ->whereBelongsTo($produit);
                      $lignesFacture = ligneFacture::whereBelongsTo($produit)
                                              ->whereHas('facture', function($query) {
                                                  $query->where('paiementValid', true)
                                                        ->whereYear('updated_at', Carbon::now()->year);
                                              });
                }




              $sumAjout= $gestionsStock->clone()->where('operation',1)->sum('qte');
              $sumRetrait= $gestionsStock->clone()->where('operation',0)->sum('qte');

              $sumCommande= $lignesFacture->clone()->sum('qte');

                return view('produits.audit',['sumAjout'=>$sumAjout,'sumRetrait'=>$sumRetrait,'sumFacture'=>$sumCommande,'lignesStock'=>$gestionsStock->get(),'lignesFac'=>$lignesFacture->get(), 'produit'=>$produit]);



          }else{

            return back()->withErrors(['message' => 'Aucun produit trouvé']);

          }
          }catch (Exception $e){
              return view('400');
          }

    }

    public function show(produit $produit, Request $request)
    {

        try{
            $nombreFac = 0;
            $qte=0;
            $recette=0;
            $capital=0;
            $netPercu=0;
            $lignesFacture=[];


            $date1 = $request->input('date1Fac');
            $date2 = $request->input('date2Fac');

            if (isset($date1) && isset($date2)) {
                $date1 = Carbon::create($date1);
                $date2 = Carbon::create($date2)->addDay();
                $factures= facture::whereBetween('updated_at', [$date1, $date2])
                            ->where('paiementValid', true)->get();

            }else {
                $factures= facture::where('updated_at','>', Carbon::today())
                            ->where('paiementValid', true)->get();

            }

            foreach ($factures as $facture) {
                $lignes=$facture->ligneFactures;

                foreach ($lignes as $ligne){
                    if($ligne->produit==$produit){
                        $nombreFac++;
                        $qte+=$ligne->qte;
                        $recette+=$ligne->qte*$ligne->prix;
                        $capital+=$ligne->qte*$ligne->prixAchat;
                        $netPercu+=(1-$ligne->facture->remise/100)*$ligne->qte*$ligne->prix;

                        array_push($lignesFacture,$ligne);
                    }
                }
            }

            #Historique de gestion
            $date1Ges = $request->input('date1Ges');
            $date2Ges = $request->input('date2Ges');

            if (isset($date1Ges) && isset($date2Ges)) {
                $date1 = Carbon::create($date1Ges);
                $date2 = Carbon::create($date2Ges)->addDay();

                $gestionsHistorique = gestionStock::whereBetween('created_at', [$date1, $date2])
                    ->where('produit_codePro', $produit->codePro)
                    ->get();

            } else {
                $gestionsHistorique = gestionStock::where('created_at', '>', Carbon::now()->startOfMonth())
                    ->where('produit_codePro', $produit->codePro)
                    ->get();
            }



            return view('produits.edit', [
                'produit' => $produit,
                'categories' => categorie::orderBy('nomCat')->get(),
                'qte' => $qte,
                'nombreFac' => $nombreFac,
                'recette'=>$recette,
                'capital'=>$capital,
                'netPercu'=>$netPercu,
                'lignesFacture' => $lignesFacture,
                'gestionsHistorique' => $gestionsHistorique
            ]);
        }catch (Exception $e){
            return view('400');
        }
    }

    public function store_views()
    {
        return view("produits.create", ['categories' => categorie::orderBy('nomCat')->get()]);
    }
    public function store(Request $request)
    {


            $produit = $request->validate([
                "codePro" => "required|numeric|unique:produits,codePro",
                "nomPro" => 'required|string',
                "prix" => 'required|numeric',
                "description" => 'required|string',
                "codeArrivage" => 'required|string',
                "actif" => "boolean",
                "categorie_id" => "required|numeric",
                "prixAchat" => "required|numeric",
                #"pourcentage" => 'required|numeric',
                "promo" => 'boolean'
            ]);
          try{
          DB::beginTransaction();

            $produit["qte"] = 0;
            $categorie_id = $request->categorie_id;

            unset($produit["categorie_id"]);
            $produit_creer = new produit($produit);
            $categorie = categorie::find($categorie_id);
            $categorie->produits()->save($produit_creer);

            DB::commit();
            return redirect()->route('produit.edit', ['produit' => produit::latest()->first()])
                ->with('success', 'Produit créé');

        }catch (Exception $e){
            DB::rollBack();
            return view('400');
        }
    }

    public function update(produit $produit, Request $request)
    {
        try{
            DB::beginTransaction();
            $validation = $request->validate([
                "nomPro" => 'string',
                "prix" => 'numeric',
                "description" => 'string',
                "codeArrivage" => 'string',
                "actif" => "boolean",
                "categorie_id" => "integer",
                "prixAchat" => "numeric",
                "pourcentage" => 'numeric',
                "promo" => 'boolean'
            ]);


            $produit->update($validation);
            $categorie = categorie::find($validation["categorie_id"]);
            $categorie->produits()->save($produit);

            DB::commit();
            return redirect()->route('produit.edit', ['produit' => $produit])
                ->with('success', 'Modification reussie');

        }catch (Exception $e){
            DB::rollBack();
            return view('400');
        }
    }

    public function destroy(produit $produit)
    {

        return back()->with('success_produit', 'Suppression reussie!');
        ;
    }

}
