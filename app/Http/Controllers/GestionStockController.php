<?php

namespace App\Http\Controllers;

use App\Models\gestionStock;
use App\Models\produit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GestionStockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, produit $produit)
    {
        try{
            DB::beginTransaction();
            $operation = $request->validate([
                "qte" => 'required|integer|min:1',
                "operation" => 'required|boolean'
            ]);

            $operation["operation"] && ($produit->qte += $operation["qte"]);
            !($operation["operation"]) && ($produit->qte -= $operation["qte"]);

            if($produit->qte<0){
                abort(500, 'Something went wrong');
            }

            $user = auth()->user();
            $operation_creer = gestionStock::create($operation);
            $user->gestionStocks()->save($operation_creer);

            $produit->gestionStocks()->save($operation_creer);

            $produit->save();

            DB::commit();
            return back()
                ->with('success', 'Stock Mis a jour');

        }catch (Exception $e){
            DB::rollBack();
            return view('400');
        }
    }
}
