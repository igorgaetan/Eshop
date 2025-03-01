<?php

namespace App\Http\Controllers;

use App\Models\facture;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    public function index(Request $request)
    {
        
       
            $this->authorize('voir les finances');


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

            $nombreCustumer = $factures->clone()
                ->distinct('tel')
                ->count();

            #calcul de la recette, capital et remise
            $factures=$factures->get();
            $recette=0;
            $capital=0;
            $netPercu=0;

            

            foreach($factures as $facture){
                $recette+=$facture->montant;
                $capital+=$facture->capital;
                $netPercu+=(1-$facture->remise/100)*$facture->montant;
            }
            
            return view('welcome', [
                'nombreCustumer' => $nombreCustumer,
                'recette'=>$recette,
                'capital'=>$capital,
                'netPercu'=>$netPercu,
                'factures'=>$factures
            ]);
        try {
        }catch (Exception $e){
            return view('400');
        }
    }

}
