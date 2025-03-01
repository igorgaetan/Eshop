<?php

namespace App\Http\Controllers;

use App\Models\categorie;
use App\Models\facture;
use App\Models\produit;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:see category');
    }
    public function index(Request $request)
    {
        try{
            $this->authorize('see category');

            $date1 = $request->input('date1');
            $date2 = $request->input('date2');


            if (isset($date1) && isset($date2)) {
                $date1 = Carbon::create($date1);
                $date2 = Carbon::create($date2)->addDay();
                $factures= facture::whereBetween('updated_at', [$date1, $date2])
                            ->where('paiementValid', true);

            }else {
                $factures= facture::where('updated_at','>', Carbon::today())
                            ->where('paiementValid', true);

            }


            $recetteParCategorie = [];
            $capitalParCategorie = [];
            $netPercuParCategorie=[];
            $topCategorieNoms=[];

            $facture1=$factures->clone()->get();

            foreach($facture1 as $facture){

                $Lignes= $facture->ligneFactures;
                foreach($Lignes as $ligne){
                    $categorie=$ligne->produit->categorie;

                    if (array_key_exists($categorie->nomCat, $recetteParCategorie)) {
                        $recetteParCategorie[$categorie->nomCat] +=  $ligne->qte * $ligne->prix;
                        $capitalParCategorie[$categorie->nomCat] += $ligne->qte * $ligne->prixAchat;;
                        $netPercuParCategorie[$categorie->nomCat] += (1 - $facture->remise / 100) * $ligne->qte * $ligne->prix;
                    } else {
                        array_push($topCategorieNoms,$categorie->nomCat);
                        $recetteParCategorie[$categorie->nomCat]=$ligne->qte * $ligne->prix;
                        $capitalParCategorie[$categorie->nomCat] =  $ligne->qte * $ligne->prixAchat;
                        $netPercuParCategorie[$categorie->nomCat] = (1 - $facture->remise / 100) * $ligne->qte * $ligne->prix;
                    }
                }
            }


            $search=$request->search;

            if(isset($search)){
                $categories=categorie::where('nomCat','LIKE', '%' . $search . '%')->orderBy('nomCat');
            }else{
              $categories=categorie::query()->orderBy('nomCat');
            }
            $total=$categories->count();

            return view('categories.index', [
                'categories' => $categories->latest()->paginate(25),
                'recetteParCategorie'=>$recetteParCategorie,
                'capitalParCategorie'=>$capitalParCategorie,
                'netPercuParCategorie'=>$netPercuParCategorie,
                'topCategorieNoms'=>$topCategorieNoms,
                'total'=>$total
            ]);
        }catch (Exception $e){
            return view('400');
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


            $request->validate([
                "nomCat" => 'required|string|unique:categories,nomCat',
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:4096',
                "actif" => "required|boolean"
            ]);

        try{
            DB::beginTransaction();
            $photoName = time() . '.' . $request->image->extension();

            //pour le sous domaine
			      $request->image->move(base_path('../public_html/backend/images'), $photoName);

             //Pour le domaine
            //$request->image->move(public_path('images'), $photoName);

            $categorie = new categorie([
                'nomCat'=>$request["nomCat"],
                'image'=>'images/' . $photoName,
                'actif'=>$request["actif"]
            ]);
            $categorie->save();

            DB::commit();

            return redirect()->route('categorie.edit',["categorie"=>$categorie]);

        }catch (Exception $e){
            DB::rollBack();
            return view('400');
        }
    }

    /**
     * Display the specified resource.
     */

     public  function produits (categorie $categorie, Request $request){
        $this->authorize('see category');


            $search=$request->search;

            if(isset($search)){
              $query = produit::query();
              $query = $query->whereBelongsTo($categorie)->latest();

              $search1=str_replace('-', '', $search);

              $produits=$query->where('nomPro', 'LIKE', '%' . $search . '%')
                            ->orWhere('codePro', 'LIKE', '%' . $search1 . '%')
                            ->orWhere('codeArrivage', 'LIKE', '%' . $search . '%');

            }else{
              $produits=produit::whereBelongsTo($categorie)->latest();
            }

            $total=$produits->count();

            //Impression
            $impression=$request->imprimer;
            if(isset($impression)){

             $dompdf = new Dompdf();


             $htmlResult = view('produits.impression', ["produits" => $produits->get(), "total" => $total, "search"=>$search, "date"=>Carbon::today(), "categorie"=>$categorie])->render();


      	     $dompdf->loadHtml($htmlResult);
             $dompdf->setPaper('A4', 'portrait');
             $dompdf->render();

             $nomfichier = "ListeProduit.pdf";
              $dompdf->stream($nomfichier,array("Attachment" => true));


             header('Content-Type: application/pdf');
             header('Content-Disposition: attachment; filename="'.$nomfichier.'"');

        		 $dompdf->output();

            }

            return view('categories.edit', [
                "categorie" => $categorie,
                'produits'=>$produits->paginate(25),
                'total'=>$total
            ]);
     }
    public function show(categorie $categorie, Request $request)
    {
        try{
            $date1 = $request->input('date1');
            $date2 = $request->input('date2');

            if (isset($date1) && isset($date2)) {
                $date1 = Carbon::create($date1);
                $date2 = Carbon::create($date2)->addDay();

                $factures= facture::whereBetween('created_at', [$date1, $date2])
                            ->where('paiementValid', true);

            }else {
                $factures= facture::where('created_at','>', Carbon::today())
                            ->where('paiementValid', true);
            }

            $recette=0;
            $capital=0;
            $netPercu=0;

            $recetteParProduit = [];
            $capitalParProduit = [];
            $qteParProduit=[];
            $netPercuParProduit=[];
            $photosProduits=[];
            $topProduitsCodes=[];

            $facture1=$factures->get();
            foreach($facture1 as $facture){
                $Lignes= $facture->ligneFactures;
                foreach($Lignes as $ligne){
                    if($ligne->produit->categorie_id == $categorie->id){
                        $recette+=$ligne->qte*$ligne->prix;
                        $capital+=$ligne->qte*$ligne->prixAchat;
                        $netPercu+=(1-$facture->remise/100)*$ligne->qte*$ligne->prix;


                        if (array_key_exists($ligne->produit_codePro, $recetteParProduit)) {
                            $recetteParProduit[$ligne->produit_codePro] +=  $ligne->qte * $ligne->prix;
                            $netPercuParProduit[$ligne->produit_codePro] += (1 - $ligne->facture->remise / 100) * $ligne->qte * $ligne->prix;
                            $capitalParProduit[$ligne->produit_codePro] += $ligne->qte * $ligne->prixAchat;
                            $qteParProduit[$ligne->produit_codePro] += $ligne->qte;
                        } else {
                            array_push($topProduitsCodes,$ligne->produit_codePro);
                            $photosProduits[$ligne->produit_codePro]=$ligne->produit->photos()->first();
                            $recetteParProduit[$ligne->produit_codePro] =  $ligne->qte * $ligne->prix;
                            $netPercuParProduit[$ligne->produit_codePro] = (1 - $ligne->facture->remise / 100) * $ligne->qte * $ligne->prix;
                            $capitalParProduit[$ligne->produit_codePro] = $ligne->qte * $ligne->prixAchat;
                            $qteParProduit[$ligne->produit_codePro] = $ligne->qte;
                        }
                    }

                }
            }

            return view('categories.edit', [
                "categorie" => $categorie,
                "facture" => $facture1,
                "recette"=>$recette,
                "capital"=>$capital,
                "netPercu"=>$netPercu,
                "recetteParProduit"=>$recetteParProduit,
                "capitalParProduit"=>$capitalParProduit,
                "qteParProduit"=>$qteParProduit,
                "netPercuParProduit"=>$netPercuParProduit,
                "photosProduits"=>$photosProduits,
                "topProduitsCodes"=>$topProduitsCodes,
            ]);
        }catch (Exception $e){
            return view('400');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try{
            DB::beginTransaction();
            $request->validate([
                "nomCat" => 'string',
                "image" => 'mimes:jpeg,png,jpg,gif|max:4096',
                "categorie_id" => 'required|integer',
                "actif" => "required|boolean"
            ]);
            $categorie = categorie::find($request->categorie_id);
            $categorie->actif=$request->actif;
            if ($request->nomCat) {
                $categorie->nomCat = $request->nomCat;
            }
            if ($request->image) {
                try {
                    unlink($categorie->image);
                } catch (Exception $e) {
                }
                $photoName = time() . '.' . $request->image->extension();


                //pour le sous domaine
      			      $request->image->move(base_path('../public_html/backend/images'), $photoName);

                 //Pour le domaine
                //$request->image->move(public_path('images'), $photoName);


                $categorie->image = 'images/' . $photoName;

            }

            $categorie->save();
            DB::commit();
            return redirect()->route('categorie.edit', ['categorie' => $categorie]);
        }catch (Exception $e){
            DB::rollBack();
            return view('400');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(categorie $categorie)
    {
        try{
            $categorie_id = $categorie->id;
            $produits = produit::whereHas('categorie', function ($query) use ($categorie_id) {
                $query->where('categorie_id', $categorie_id);
            })->get();
            if ($produits->count() > 0) {
                return back()->withErrors([
                    'echec_produit' => "Vous ne pouvez pas supprimer cette categorie car elle est liée a certains produits!"
                ]);
            } else {
                try {
                    unlink($categorie->image);
                } catch (Exception $e) {

                }
                $categorie->delete();

                return back()->with('success', 'Suppresion reussie');

            }
        }catch (Exception $e){
            return view('400');
        }

    }
}
