<?php

namespace App\Http\Controllers;

use App\Models\clientCarte;
use App\Models\facture;
use App\Models\ligneCarte;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LigneCarteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, facture $facture)
    {

        try{
            $ligne = $request->validate([
                'tel' => 'required|string',
            ]);

            DB::beginTransaction();

            $client = clientCarte::query()->where('mobile',$ligne["tel"])->first();
            if(!isset($client)){
                DB::rollBack();
                return back()->with('success', 'Aucun client trouvé');
            }
        
            $ligneCarte=$facture->ligneCarte;

        
            if ($ligneCarte) {
                DB::rollBack();
                return back();
            }

            $ligne_creer = new ligneCarte([
                'montantFac'=> $facture->montant,
                'point'=>0
            ]);
           
            $facture->ligneCarte()->save($ligne_creer);
            $client->ligneCartes()->save($ligne_creer);

            DB::commit();
            return redirect()->route('facture.edit', ['facture' => $facture]);
        }catch(Exception $e){
            DB::rollBack();
            return view('403');
        }

    }

}
