<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {

        $categories = categorie::latest()->where('actif', 1)->get();
        return response()->json($categories, 200);

    }

    public function show(string $id)
    {
        $category = Categorie::findOrFail($id);

        return response()->json([
            'id' => $category->id,
            'nomCat' => $category->nomCat,
            'image' => $category->image,
        ]);
    }

}
