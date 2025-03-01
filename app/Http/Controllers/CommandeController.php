<?php

namespace App\Http\Controllers;

use App\Models\categorie;
use App\Models\clientCarte;
use App\Models\commande;
use App\Models\facture;
use App\Models\gestionCommande;
use App\Models\ligneCarte;
use App\Models\ligneCommande;
use App\Models\ligneFacture;
use App\Models\produit;
use App\Models\ville;
use App\Models\expedition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;


require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        
        $this->middleware('auth')->except('genereFac');
       
    }
    public function index(Request $request)
    {
        
        

        try{
            $this->authorize('see orders');
            
            $date1 = $request->input('date1');
            $date2 = $request->input('date2');

            if (isset($date1) && isset($date2)) {
                $date1 = Carbon::create($date1);
                $date2 = Carbon::create($date2)->addDay();
                
                if(auth()->user()->hasRole('caissiere')){
                    $result=commande::query()
                            ->whereBetween('created_at',[$date1,$date2])->where('type', 3)->get();
                }else{
                    $result = commande::query()
                    ->whereBetween('created_at',[$date1,$date2])->latest()->get();
                }
            }else{
                if(auth()->user()->hasRole('caissiere')){
                    $result=commande::query()
                            ->where('created_at','>',Carbon::today())->where('type', 3)->get();
                }else{
                    $result = commande::query()
                            ->where('created_at','>',Carbon::today())->latest()->get();
                }
            }

            return view('commande.index', ['commandes' => $result]);
        
        }catch(Exception $e){
            return view('400');
        }
    }

   
    /**
     * Display the specified resource.
     */
    public function createVille(Request $request)
    {
      
        $ville = $request->validate([
            "libelle" => 'required|string|unique:villes,libelle'
        ]);
      try{
        $ville_creer = ville::create($ville);
        return back()->with('success', 'Ville ajoutée');
      }catch(Exception $e){
            return view('400');
      }
    }

    //Ajax pour rendre un produit disponible
    public function handleRequest(Request $request)
    {
        // Requette pour rendre les produits disponibles ou non

        $ligne = ligneCommande::find($request->ligne);
        if ($request->disponible == "true") {
            $ligne->disponible = 1;
        } else {
            $ligne->disponible = 0;
        }

        $ligne->save();

        $data = [
            'success' => true,
            'message' => 'Requête AJAX traitée avec succès',
            'data' => $ligne
        ];

        return response()->json($data);
    }



    //Cette fonction est utilise pour faire evoluer l'etat de la commande
    public function avancerEtat(commande $commande)
    {
        try{
            DB::beginTransaction();

            if ($commande->type==0){
                $gestion= new gestionCommande(['etat'=>1]);
                $commande->gestionCommandes()->save($gestion);
                $user=auth()->user();
                $user->gestionCommandes()->save($gestion);
            }elseif($commande->type==1){
                $gestion= gestionCommande::whereBelongsTo($commande)
                                        ->where('etat',1)
                                        ->first();
            
                $gestion->etat=2;
                $gestion->save();
            }


            $commande->type += 1;
            ($commande->type==3)&&($commande->livrer=1);
            $commande->save();
            DB::commit();
            return back();
        }catch(Exception $e){
            DB::rollBack();
            return view('400');
        }
    }
    //Cette fonction est utilise pour faire rentrer l'etat de la commande
    public function rentrerEtat(commande $commande)
    {

        try{
            DB::beginTransaction();


            if($commande->type==2){
                $gestion= new gestionCommande(['etat'=>1]);
                $commande->gestionCommandes()->save($gestion);
                $user=auth()->user();
                $user->gestionCommandes()->save($gestion);
            }elseif($commande->type==1){
                $gestion= gestionCommande::whereBelongsTo($commande)
                                        ->where('etat',1)
                                        ->first();
            
                $gestion->etat=0;
                $gestion->save();
            }


            $commande->type -= 1;
            ($commande->type==2)&&($commande->livrer=0);
            $commande->save();
            DB::commit();
            return back();

        }catch(Exception $e){
            DB::rollBack();
            return view('400');
        }
    }
    //Cette fonction est utilise pour reserver commande
    public function reserver (commande $commande)
    {
        try{
            DB::beginTransaction();
            $commande->type += 1;
            $commande->livrer=2;
            $commande->save();
            DB::commit();
            return back();
        }catch(Exception $e){
            DB::rollBack();
            return view('400');
        }
        
    }

    //Voir une commande
    public function show(commande $commande)
    {
        try{
        $this->authorize('see orders');
        return view('commande.edit', [
            'commande' => $commande,
            'villes' => ville::orderBy('libelle')->get()
        ]);
        }catch(Exception $e){
            DB::rollBack();
            return view('400');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function addLigneComView(Request $request, commande $commande)
    {
        try{
        return view('commande.produit', [
            'commande' => $commande
        ]);
        }catch(Exception $e){
            DB::rollBack();
            return view('400');
        }
    }
    
    //Ajouter une ligne a la commande
    public function storeLigneCom(commande $commande, Request $request)
    {

        try{
            $ligne = $request->validate([
                'qte' => 'required|integer|min:1',
                'codePro' => 'required|integer|',
                'taille' => 'string',
                'couleur' => 'string'

            ]);
            $produit = produit::find($ligne['codePro']);
            DB::beginTransaction();
            if (isset($produit) && $produit->qte >= $ligne["qte"]) {

                unset($ligne['codePro']);
                $ligne_creer = new ligneCommande($ligne);

                $produit->ligneCommandes()->save($ligne_creer);
                $commande->ligneCommandes()->save($ligne_creer);
                $commande->montant += $ligne["qte"] * $produit->prix;

                $commande->save();
            }
            DB::commit();
            return redirect()->route('commande.show', ["commande" => $commande]);
        }catch(Exception $e){
            DB::rollBack();
            return view('400');
        }
    }

    public function destroyLigneCom(ligneCommande $ligneCommande)
    {

        try{
            DB::beginTransaction();
            $commande = $ligneCommande->commande()->first();
            
            $commande->montant -= $ligneCommande->qte * $ligneCommande->produit->prix;
            $commande->save();
            $ligneCommande->delete();

            DB::commit();
            return back()->with('success', 'Mise a jour reussie');

        }catch(Exception $e){
            DB::rollBack();
            return view('400');
        }
    }
    
    //update une commande
    public function update(commande $commande, Request $request)
    {
        

            $update = $request->validate([
                "montant" => "numeric",
                "nomClient" => "string|min:2|max:30",
                "mobile" => "string|max:20",
                "addresse" => "string",
                "commentaire" => 'string',
                "livrer" => 'boolean',
                "avance" => "numeric",
                "remise" => "numeric",
                "type" => "boolean",
                "ville_id" => 'numeric',
                "montantLivraison"=>"numeric|min:0"
            ]);

        try{
            $commande->update($update);


            if ($request->ville_id) {
                $ville = ville::find($request->ville_id);
                $ville->commandes()->save($commande);
            }

            return back()->with(
                'success',
                'Mise a jour reussie'
            );
        }catch(Exception $e){
            return view('400');
        }
    }

    public function commandeToFacture (commande $commande){

        try{

            $facture=$commande->facture;
            if($facture){
                return back()->with(
                    'success',
                    'Veuillez modifier directement la facture'
                );
            }

            DB::beginTransaction();
            $facture = new facture([
                'remise'=>$commande->remise,
                'montant'=>0+$commande->montantLivraison,
                'tva'=>0,
                'typeFac'=>0,
                'paiementValid'=>0,
                'tel'=>$commande->mobile,
                'capital'=>0
            ]);
       
            $user = auth()->user();
            $user->factures()->save($facture);
            $commande->facture()->save($facture);
        
            foreach ($commande->ligneCommandes as $ligne){
                
                $produit = $ligne->produit;
                if (isset($produit) && $produit->qte >= $ligne["qte"]) {
                    $facture->montant += $ligne->qte * $produit->prix;
                    $facture->capital += $ligne->qte * $produit->prixAchat;
                    $facture->save();

                    $newLigneFacture = new ligneFacture([
                        'prix'=>$produit->prix,
                        'qte'=>$ligne->qte,
                        'prixAchat'=>$produit->prixAchat
                    ]);
                    $produit->ligneFactures()->save($newLigneFacture);
                    $facture->ligneFactures()->save($newLigneFacture);
                }
            }

        
            $commande->facture()->save($facture);
            $commande->type=4;
            $commande->save();

            $client=$commande->clientCarte;
            if(!isset($client)){
                $client=clientCarte::query()
                                    -> where('mobile',$commande->mobile)
                                    ->first();
                if(!isset($client)){
                    $matricule=fake()->unique()->randomNumber(6, true);
                    $client = clientCarte::create([
                        'matr'=>$matricule,
                        'nom'=>$commande->nomClient,
                        'mobile'=>$commande->mobile,
                        'sexe'=>1
                    ]);
                    $client=clientCarte::latest()->first();
                    
                  if(config('app.whatsapp')){
                     $service = new WhatsAppApi();
                      $response = $service->sendChatMessage($client->mobile, '*Votre Carte Fidélité  a été créée.* \nMatricule: '. $client->matr .' \nTel: '. $client->mobile);
            }
                }
            }
    
            $ligne = new ligneCarte([
                'point'=>0,
                'montantFac'=>$facture->montant
            ]);
            
            $ville=$commande->ville;
            $ville->clientCartes()->save($client);
        
            $facture->ligneCarte()->save($ligne);
            $client->ligneCartes()->save($ligne);  

            DB::commit();
            return redirect()->route('facture.edit', ["facture" => $facture]);
           
           
        }catch(Exception $e)
        {   
            DB::rollBack();
            return view('400');
        }            
    }

    public function destroy(commande $commande)
    {
        try{
          $commande->delete();
          return redirect()->route('commande.index');
        }catch(Exception $e)
        {   
            DB::rollBack();
            return view('400');
        }  
    }

    public function genereFac(commande $commande, Request $request)
    {
         try{
         
         $impression=$request->imprimer;
         
         if(auth()->user() || isset($impression)){
         $dompdf = new Dompdf();
	
	
      	$htmlResult = view('commande', ["commande" => $commande])->render();
      	
      	
  	     $dompdf->loadHtml($htmlResult);
         $dompdf->setPaper('A4', 'portrait');
         $dompdf->render();
 
         $nomfichier = "Commande".$commande->id.".pdf";
          $dompdf->stream($nomfichier,array("Attachment" => true));
  	   
   
         header('Content-Type: application/pdf');
         header('Content-Disposition: attachment; filename="'.$nomfichier.'"');

    		 $dompdf->output();
          }else{
            return view('commande', ["commande" => $commande]);
          }
        }catch(Exception $e)
        {   
            
            return view('400');
        }  
    }
    
    
    public function transporteurList()
    {
       try{
           $this->authorize('see orders');
          return view('commande.expedition',
              ['transporteurs'=>expedition::orderBy('transporteur')->get(),
                  'villes'=>ville::orderBy('libelle')->get(),
                  'total'=>expedition::count()]); 
        }catch(Exception $e)
        {   
            DB::rollBack();
            return view('400');
        }  
    }
    
     public function transporteurAdd(Request $request)
    {
        $transporteur=$request->validate([
        "ville_id" => 'required|numeric',
        "mobile1"=>'required|string',
        "mobile2"=>'required|string',
        "transporteur"=>'required|string|max:250',
        "prix" => 'required|numeric',
        ]);
       try{
         $this->authorize('see orders');
         $new=expedition::create($transporteur);
         $ville = ville::find($request->ville_id);
         $ville->expeditions()->save($new);
         
         return back()->with('success', 'Transporteur ajouté');
         
        }catch(Exception $e)
        {   
            DB::rollBack();
            return view('400');
        }  
    }
    
    public function transporteurDestroy(expedition $expedition)
    {
      try{
          $expedition->delete();
          return back()->with('success', 'Suppression reussie');
        }catch(Exception $e)
        {   
            DB::rollBack();
            return view('400');
        }  
    }
}
