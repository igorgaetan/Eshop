<?php

use App\Http\Controllers\BonAchatController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientCarteController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\GestionnaireController;
use App\Http\Controllers\GestionStockController;
use App\Http\Controllers\LigneCarteController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProduitFeaturesController;
use App\Http\Controllers\TontineController;
use App\Http\Controllers\MessageController;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [GestionnaireController::class, 'login'])->name('login');
Route::get('/logout', [GestionnaireController::class, 'logout'])->name('logout');
Route::get('/', [GeneralController::class, 'index'])->name('index');


Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
Route::get('/produits/create', [ProduitController::class, 'store_views'])->name('produits.create');
Route::get('/produit/{produit}', [ProduitController::class, 'show'])->name('produit.edit');
Route::delete('/produit/delete/{produit}', [ProduitController::class, 'destroy'])->name('delete.produit');
Route::post('/produit/update/{produit}', [ProduitController::class, 'update'])->name('produit.update');
Route::post('/produit/QteUpdate/{produit}', [GestionStockController::class, 'store'])->name('produit.QteUpdate');
Route::post('/produit/Enregistrement', [ProduitController::class, 'store'])->name('produits.store');
Route::get('/audit', function () {
    return view('produits.audit');
})->name('produits.audit');
Route::get('/FindProduct', function () {
    return view('produits.Rechercher');
})->name('produits.search');
Route::post('/audit', [ProduitController::class, 'audit'])->name('produits.audit');



Route::post('/produit/storeSize/{produit}', [ProduitFeaturesController::class, 'storeSize'])->name('produit.storeSize');
Route::post('/produit/storeColor/{produit}', [ProduitFeaturesController::class, 'storeColor'])->name('produit.storeColor');
Route::post('/produit/storePhoto/{produit}', [ProduitFeaturesController::class, 'storePhoto'])->name('produit.storePhoto');
Route::delete('/produit/deletePhoto/{photo}', [ProduitFeaturesController::class, 'destroyPhoto'])->name('produit.deletePhoto');
Route::delete('/produit/deleteColor/{color}', [ProduitFeaturesController::class, 'destroyColor'])->name('produit.deleteColor');
Route::delete('/produit/deleteSize/{size}', [ProduitFeaturesController::class, 'destroySize'])->name('produit.deleteSize');



Route::get('/facture/{facture}', [FactureController::class, 'show'])->name('facture.edit');
Route::get('/facture', [FactureController::class, 'index'])->name('facture.index');
Route::get('/factureEnattente', [FactureController::class, 'index2'])->name('facture.index2');
Route::post('/facture/store', [FactureController::class, 'store'])->name('facture.store');
Route::delete('/delete/{facture}',[FactureController::class,'destroy'])->name('destroyFac');
Route::delete('facture/deleteLigne/{ligneFacture}', [FactureController::class, 'destroyLigneFac'])->name('facture.destroyLigneFac');
Route::post('/facture/storeLigne/{facture}', [FactureController::class, 'storeLigneFac'])->name('facture.storeLigneFac');
Route::get('/facture/addProduct/{facture}', [FactureController::class, 'addLigneFacView'])->name('facture.addLigneFacView');
Route::post('/facture/update/{facture}', [FactureController::class, 'update'])->name('facture.update');
Route::get('/generateBill/{facture}', [FactureController::class, 'genereFac'])->name('generateFac');
Route::get('/NewFacture', function () {
    return view('factures.nouveau');
})->name('newFacture');
Route::post('/findProduit',[FactureController::class,'findProduit'])->name('findProduit');


Route::post('/categorie/create', [CategorieController::class, 'store'])->name('categorie.store');
Route::get('/categories', [CategorieController::class, 'index'])->name('categorie.index');
Route::get('/categorie/{categorie}', [CategorieController::class, 'show'])->name('categorie.edit');
Route::get('/categorie/Produits/{categorie}', [CategorieController::class, 'produits'])->name('categorie.produits');
Route::delete('/categorie/delete/{categorie}', [CategorieController::class, 'destroy'])->name('categorie.delete');
Route::post('/categorie/update', [CategorieController::class, 'update'])->name('categorie.update');


Route::get('/clientCarte', [ClientCarteController::class, 'index'])->name('index.client');
Route::post('/clientCarte/Enregistrement', [ClientCarteController::class, 'store'])->name('client.store');
Route::post('/clientCarte/update/{clientCarte}', [ClientCarteController::class, 'update'])->name('client.update');
Route::get('/clientCarte/create', [ClientCarteController::class, 'create_views'])->name('client.create');
Route::get('/clientCarte/{clientCarte}', [ClientCarteController::class, 'show'])->name('edit.clientCarte');

Route::post('/ligneCarte/create/{facture}', [LigneCarteController::class, 'store'])->name('create.ligneCarte');
Route::get('/addFacToClient/{clientCarte}', [LigneCarteController::class, 'addFacToClient'])->name('addFacToClient');
Route::delete('LigneCarte/Destroy/{ligneCarte}', [LigneCarteController::class, 'destroy'])->name('destroy.ligneCarte');

Route::get('/validerBonAchat/{facture}',[BonAchatController::class,'update'])->name('validerBonAchat');
Route::get('/creerBonAchat/{clientCarte}',[BonAchatController::class,'store'])->name('creerBonAchat');

Route::post('/createTontine/{clientCarte}', [TontineController::class, 'store'])->name('tontine.store');
Route::get('/tontines', [TontineController::class, 'index'])->name('tontine.index');


Route::get('/commande', [CommandeController::class, 'index'])->name('commande.index');
Route::get('/commande/{commande}', [CommandeController::class, 'show'])->name('commande.show');
Route::post('/commande/update/{commande}', [CommandeController::class, 'update'])->name('commande.update');
Route::get('/commande/ToFacture/{commande}', [CommandeController::class, 'commandeToFacture'])->name('commandeToFacture');
Route::get('/commande/addLigne/{commande}', [CommandeController::class, 'addLigneComView'])->name('addLigneComView');
Route::post('/commande/addProduct/{commande}', [CommandeController::class, 'storeLigneCom'])->name('storeLigneCom');
Route::delete('/commande/deleteLigne/{ligneCommande}', [CommandeController::class, 'destroyLigneCom'])->name('destroyLigneCom');
Route::delete('/commande/delete/{commande}',[CommandeController::class,'destroy'])->name('deleteCommande');
Route::post('/ajax-request', [CommandeController::class, 'handleRequest'])->name('ajax.request');
Route::get('/avancerEtat/{commande}', [CommandeController::class, 'avancerEtat'])->name('avancerEtat');
Route::get('/rentrerEtat/{commande}', [CommandeController::class, 'rentrerEtat'])->name('rentrerEtat');
Route::get('/reserver/{commande}',[CommandeController::class,'reserver'])->name('reserver');
Route::get('/commande/genereBill/{commande}',[CommandeController::class,'genereFac'])->name('commande.generateFac');
Route::post('/ville/create', [CommandeController::class, 'createVille'])->name('createVille');

Route::get('/transporteurs',[CommandeController::class, 'transporteurList'])->name('transporteurList');
Route::post('/storeTransporteurs',[CommandeController::class, 'transporteurAdd'])->name('transporteurAdd');
Route::delete('/deleteTransporteurs/{expedition}',[CommandeController::class, 'transporteurDestroy'])->name('transporteurDestroy');


Route::get('/sendMessage',[MessageController::class,'sendMessage']);



Route::post('/Enregistrement_utilisateur', [GestionnaireController::class, 'store'])->name('user.store');
Route::get('/equipe/create',function(){
    return view('equipe.create');
})->name('user.create');
Route::get('/equipe/{user}',[GestionnaireController::class,'show'])->name('user.edit');
Route::get('/equipes', [GestionnaireController::class, 'index'])->name('equipe.index');
Route::put('/equipe/{user}', [GestionnaireController::class, 'update'])->name('user.update');
Route::put('/myProfile/{user}', [GestionnaireController::class, 'update_my_profile'])->name('user.update_profile');
Route::get('/user/profile/{user}',function(){
    return view('equipe.myProfile');
})->name('user.view_profile');
Route::get('/profile',function(){
    return view ('profile');
});
