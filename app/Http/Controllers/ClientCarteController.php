<?php

namespace App\Http\Controllers;

use App\Models\bonAchat;
use App\Models\clientCarte;
use App\Models\ligneCarte;
use App\Models\tontine;
use App\Models\ville;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;


class ClientCarteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        try{
            $this->authorize('voir les cartes clients');

            $query = clientCarte::query()->with('ligneCartes', 'tontines');
            $search = $request->input('search');
            if ($search) {
                $query->where('matr', 'LIKE', '%' . $search . '%')
                      ->orwhere('nom','LIKE','%' . $search . '%')
                      ->orwhere('mobile','LIKE','%' . $search . '%');
            }
            
            $result = $query->orderBy('nom');
            $total=$query->count();
            
            
            #impression
            $impression=$request->imprimer;
           if(isset($impression)){
               $dompdf = new Dompdf();
    	
          	    $htmlResult = view('client.impression', ["clientCartes" => $result->get(), "total" => $total, "search"=>$search, "date"=>Carbon::today()])->render();
          	
          	
        	     $dompdf->loadHtml($htmlResult);
               $dompdf->setPaper('A4', 'portrait');
               $dompdf->render();
       
               $nomfichier = "ListeClient.pdf";
                $dompdf->stream($nomfichier,array("Attachment" => true));
        	   
         
               header('Content-Type: application/pdf');
               header('Content-Disposition: attachment; filename="'.$nomfichier.'"');
      
          		 $dompdf->output();
            
            }

            return view('client.index', [
                'clientCartes' => $query->latest()->paginate(25),
                'total'=>$total
               
            ]);
        }catch (Exception $e){
            return view('400');
        }
    }

    public function create_views()
    {
        try{
            $this->authorize('voir les cartes clients');
            return view('client.create', [
                'villes' => ville::orderBy('libelle')->get()
            ]);
        }catch(Exception $e){
            return view('400');
        }
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
            $client = $request->validate([
                'matr' => 'required|integer|min:1|unique:client_cartes,matr',
                'nom' => 'required|string',
                'sexe' => 'required|boolean',
                'dateNaiss' => 'required|string',
                'ville_id' => 'required|numeric',
                'mobile' => 'required|string|unique:client_cartes,mobile',
                'whatsapp' => 'boolean',
                'montantTontine' => 'decimal', 
                'addresse'=>'nullable|string'
            ]);
          try{
            $ville_id = $client["ville_id"];
            unset($client["ville_id"]);

            $ville = ville::find($ville_id);
            $client_creer = new clientCarte($client);
            $ville->clientCartes()->save($client_creer);

            $client_creer=clientCarte::latest()->first();
            
            
            if(config('app.whatsapp')){
             $service = new WhatsAppApi();
              $response = $service->sendChatMessage($client_creer->mobile, '*Votre Carte Fidélité  a été créée.* \nMatricule: '. $client_creer->matr .' \nTel: '. $client_creer->mobile);
            }
            
            
            return redirect()->route('edit.clientCarte',['clientCarte'=>$client_creer]);
        }catch(Exception $e){
            return view('400');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(clientCarte $clientCarte, Request $request)
    {
        try{
            $this->authorize('voir les cartes clients');
            
            
            $bonAchat= bonAchat::query()
                        ->whereBelongsTo($clientCarte)
                        ->where('actif',true)
                        ->first();

            $date1 = $request->input('date1');
            $date2 = $request->input('date2');

            if (isset($date1) && isset($date2)) {
                $date1 = Carbon::create($date1);
                $date2 = Carbon::create($date2)->addDay();
            
                $tontines=tontine::whereBelongsTo($clientCarte)
                            ->whereBetween('created_at',[$date1,$date2])
                            ->get();

                $lignesCarte=ligneCarte::whereBelongsTo($clientCarte)
                            ->whereBetween('created_at',[$date1,$date2])
                            ->get();
                
            }else{
                $tontines=tontine::whereBelongsTo($clientCarte)
                                ->where('created_at','>',Carbon::now()->startOfYear())
                                ->get();

                $lignesCarte=ligneCarte::whereBelongsTo($clientCarte)
                            ->where('created_at','>',Carbon::now()->startOfYear())
                            ->get();
            }

            return view('client.edit', [
                'clientCarte' => $clientCarte,
                'villes' => ville::latest()->get(),
                'bonAchat'=>$bonAchat,
                'tontines'=>$tontines,
                'lignesCarte'=>$lignesCarte
            ]);
        }catch(Exception $e){
            return view('400');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, clientCarte $clientCarte)
    {
        
            $client = $request->validate([
                'nom' => 'required|string',
                'sexe' => 'nullable|boolean',
                'dateNaiss' => 'nullable|string',
                'ville_id' => 'required|numeric',
                'mobile' => 'required|string',
                'whatsapp' => 'nullable|boolean',
                'addresse'=>'nullable|string'
                
            ]);
            
            

          try{
          
            $clientExist=clientCarte::where('mobile',$request->mobile)->first();
            
            if($clientExist && $clientExist!=$clientCarte){
              return back()->withErrors(['message' => 'Ce numero existe deja']);
            }
            
            $clientCarte->update($client);
            $ville_id = $client["ville_id"];
            $ville = ville::find($ville_id);
            $ville->clientCartes()->save($clientCarte);
        
            if(config('app.whatsapp')){
             $service = new WhatsAppApi();
              $response = $service->sendChatMessage($clientCarte->mobile, '*Votre Carte Fidélité  a été mise à jour.* \nMatricule: '. $clientCarte->matr .' \nTel: '. $clientCarte->mobile);
            }
            
            return back()->with('success', 'Mise a jour reussie');
        }catch(Exception $e){
            return view('400');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(clientCarte $clientCarte)
    {
        //
    }
}
