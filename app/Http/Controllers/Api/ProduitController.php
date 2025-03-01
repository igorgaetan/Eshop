<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\categorie;
use App\Models\produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduitController extends Controller
{
    public function index(Request $request)
	{
    $query = produit::query()
              ->where('actif', 1)
              ->with('photos','sizes','colors');
    $perPage = 10;
    $page = $request->input('page', 1);

    # Filtre avec le mot
    $search = $request->input('search');
    if ($search) {
        $query->where('nomPro', 'LIKE', '%' . $search . '%')
            ->orWhere('codePro', 'LIKE', '%' . $search . '%');
    }

    # Filtre par prix
    $prix1 = $request->input('prix1');
    $prix2 = $request->input('prix2');
    if ($prix1 && $prix2) {
        $query->whereBetween('prix', [$prix1, $prix2]);
    }

    # Filtre par date de création
    $dateStart = $request->input('dateStart');
    $dateEnd = $request->input('dateEnd');
    if ($dateStart && $dateEnd) {
        $query->whereBetween('created_at', [$dateStart, $dateEnd]);
    }

    # Filtre par quantité (qte > 0)
    $user = Auth::user();
    if(!isset($user)){
        $query->where('qte', '>', 0);
    }
   

    $total = $query->count();
    $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->latest()->get();

    return response()->json([
        'current_page' => $page,
        'last_page' => ceil($total / $perPage),
        'total' => $total,
        'items' => $result
    ], 200);
    }

	public function produitsByCategorie(categorie $categorie, Request $request)
	{
    $query = produit::query()->with('photos','sizes','colors');
    $perPage = 10;
    $page = $request->input('page', 1);
    $query->where('categorie_id', $categorie->id);

    # Filtre avec le mot
    $search = $request->input('search');
    if ($search) {
        $query->where('nomPro', 'LIKE', '%' . $search . '%')
            ->orWhere('description', 'LIKE', '%' . $search . '%');
    }

    # Filtre par prix
    $prix1 = $request->input('prix1');
    $prix2 = $request->input('prix2');
    if ($prix1 && $prix2) {
        $query->whereBetween('prix', [$prix1, $prix2]);
    }

    # Filtre par quantité (qte > 0)
    $user = Auth::user();
    if(!isset($user)){
        $query->where('qte', '>', 0);
    }

    $total = $query->count();
    $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->latest()->get();

    return response()->json([
        'current_page' => $page,
        'last_page' => ceil($total / $perPage),
        'total' => $total,
        'items' => $result
    ], 200);
    }


    public function show(produit $produit)
    {
        return response()->json(["produit" => $produit->load('photos','sizes','colors')], 200);
    }

}
