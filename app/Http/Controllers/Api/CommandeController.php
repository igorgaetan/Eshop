<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\commande;
use App\Models\ligneCommande;
use App\Models\produit;
use App\Models\ville;
use Illuminate\Http\Request;
use App\Http\Controllers\WhatsAppApi;

class CommandeController extends Controller
{
    public function store(Request $request){
        $commande = $request->validate([
            "montant" => 'required|numeric',
            "nomClient" => ["required", "string", "min:2", "max:30"],
            "mobile" => ["required", "string", "max:20"],
            "addresse" => ["string"],
            "commentaire" => "string",
            "ville_id" => 'required|numeric',
            "productList" => 'required|array|min:1'
        ]);

        
        $productList = $request->productList;
        $ville_id = $request->ville_id;
        unset($commande["ville_id"]);
        unset($commande["productList"]);

        $commande_creer = commande::create($commande);
        foreach ($productList as $ligneCommande) {
            $product = produit::find($ligneCommande["codePro"]);
            unset($ligneCommande["codePro"]);  
            $ligne_creer = new ligneCommande($ligneCommande);
            $product->ligneCommandes()->save($ligne_creer);
            $commande_creer->ligneCommandes()->save($ligne_creer);
        }
        $commande_creer->save();

        $ville = ville::find($ville_id);
        $ville->commandes()->save($commande_creer);
        
        

        $commande_creer = commande::latest()->first();
        
        if(config('app.whatsapp')){
             $service = new WhatsAppApi();
              $response = $service->sendChatMessage($commande_creer->mobile, '*Votre Commande numéro '. $commande_creer->id .' a été enregistrée.*');
            }
            
            
        return response()->json([
            'status_message' => 'ok',
            "Commande" => $commande_creer
        ], 201);
    }

    public function listVille()
    {
        return response()->json(["ville" => ville::latest()->get()], 200);
    }
}
