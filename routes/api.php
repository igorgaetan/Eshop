<?php

use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\ClientCarteController;
use App\Http\Controllers\Api\CommandeController;
use App\Http\Controllers\Api\GestionnaireController;
use App\Http\Controllers\Api\ProduitController;
use Illuminate\Support\Facades\Route;


Route::controller(ProduitController::class)->group(function () {
    Route::get('/produitsList', 'index');
    Route::get('/showProduit/{produit}', 'show');
    Route::get('/produitByCategories/{categorie}', 'produitsByCategorie');
});


Route::controller(CommandeController::class)->group(function () {
    Route::post('/createCommande', 'store');
    Route::get('/listVille', 'listVille');
});

Route::get('/listCategories', [CategorieController::class, 'index']);
Route::get('categories/{id}', [CategorieController::class, 'show']);

Route::controller(GestionnaireController::class)->group(function () {
    Route::post('/loginGest', 'login');
    Route::get('/user', 'user');
 });


 
Route::get('/client/{matr}/{mobile}', [ClientCarteController::class, 'getClientByMatrAndMobile']);


Route::group(["middleware" => ['auth:sanctum']], function () {
    Route::get('/logoutGest', [GestionnaireController::class, 'logout']);
    Route::controller(ProduitController::class)->group(function () {
        Route::get('/getquantity/{codePro}', 'getQuantity');
    
    });
 
});