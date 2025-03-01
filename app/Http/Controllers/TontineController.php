<?php

namespace App\Http\Controllers;

use App\Models\clientCarte;
use App\Models\tontine;
use Illuminate\Http\Request;

class TontineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request, clientCarte $clientCarte)
    {
        $tontine = $request->validate([
            'montant' => 'required|numeric',
            'commentaire' => 'string',
            'validite' => 'required|boolean',
            'action' => 'required|boolean'
        ]);
        $user = auth()->user();

        $newTontine = tontine::create($tontine);
        $clientCarte->tontines()->save($newTontine);
        if ($tontine["action"]) {
            $clientCarte->montantTontine += $tontine["montant"];
        } else {
            $clientCarte->montantTontine -= $tontine["montant"];
        }
        $user->tontines()->save($newTontine);
        $clientCarte->save();
        return back()->with('success', 'Tontine ajoutée');

    }
    
    public function index(Request $request, clientCarte $clientCarte)
    {
       
        return view('client.tontine',['tontines'=>tontine::latest()->paginate(25),'total'=>tontine::count()]);

    }
}
