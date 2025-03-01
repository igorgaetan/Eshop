<?php

namespace App\Http\Controllers;

use App\Models\color;
use App\Models\photo;
use App\Models\produit;
use App\Models\size;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class ProduitFeaturesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function destroyPhoto(photo $photo)
    {
        try {
            unlink($photo->lienPhoto);
        } catch (Exception $e) {

        }
        $photo->delete();
        return back()
            ->with('success', 'Photo supprimée');
    }

    public function storePhoto(produit $produit, Request $request)
    {
        
            $request->validate([
                "photo" => 'required|mimes:jpeg,png,jpg,gif|max:4096'
            ]);
        try{
            DB::beginTransaction();
            $photoName = time() . '.' . $request->photo->extension();
			
			//Pour le sous domaines backend
			$request->photo->move(base_path('../public_html/backend/images'), $photoName);
			
			//Si c'est un domaine
            //$request->photo->move(public_path('images'), $photoName);

            $photo = new photo();
            $photo->lienPhoto = 'images/' . $photoName;
            $produit->photos()->save($photo);
            DB::commit();
            return back()
                ->with('success', 'Photo ajoutée');
        }catch (Exception $e){
            DB::rollBack();
            return view('400');
        }
    }

    public function destroyColor(color $color)
    {
        $color->delete();
        return back()
            ->with('success', 'Couleur supprimée');
    }

    public function destroySize(size $size)
    {
        $size->delete();
        return back()
            ->with('success', 'Taille supprimée');
    }
    public function storeColor(produit $produit, Request $request)
    {
        try{
            DB::beginTransaction();
            $request->validate([
                "name" => 'required|string'
            ]);
            $color = new color();
            $color->colorName = $request->name;
            $produit->colors()->save($color);

            DB::commit();
            
            return back()
                ->with('success', 'Couleur ajoutée');
        
        }catch (Exception $e){
            DB::rollBack();
            return view('400');
        }

    }
    public function storeSize(produit $produit, Request $request)
    {
        try{
            DB::beginTransaction();
            $request->validate([
                "name" => 'required|string'
            ]);
            $size = new size();
            $size->sizeName = $request->name;
            $produit->sizes()->save($size);
            DB::commit();
            return back()
                ->with('success', 'Taille ajoutée');
        }catch (Exception $e){
            DB::rollBack();
            return view('400');
        }

    }

}
