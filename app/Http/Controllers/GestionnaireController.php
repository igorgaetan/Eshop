<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class GestionnaireController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('login');
        $this->middleware('guest')->only('login');
    }

    public function index()
    {
        try{
            $this->authorize('create and edit users');
            
            $users = User::where('typeGest', '!=', 0)->get();
            return view('equipe.index', ['users' => $users]);
        }catch(Exception $e){
            return view('400');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
            $user= $request->validate([
                'nomGest'=>'required|string|max:45',
                'login' => 'required|string|unique:users,login',
                'typeGest'=>'required|numeric',
                'mobile'=>'required|string|max:20',
                'password'=> 'required|string',
            ]);
        try{
            $user['password'] = Hash::make($user['password']);
    
            $newUser = User::create($user);

            return redirect()->route('user.edit',["user"=>$newUser]);
        }catch(Exception $e){
            return view('400');
        }
    }

    public function login(Request $request)
    {
        try{
          $user=User::where('login',$request->login)->first();
          if ($user && $user->actif==0){
              return  back()->withErrors([
                  'message' => "Utilisateur non reconnu"
              ]);
          }

          $credentials = $request->only('login', 'password');
          if (Auth::attempt($credentials, (bool) $request->remember)) {
              $request->session()->regenerate();
              
             
              auth()->user()->syncRoles([]);
              (auth()->user()->typeGest==0)&&(auth()->user()->assignRole('admin'));
              if(auth()->user()->typeGest==1){
                  auth()->user()->assignRole('caissiere');
                  return redirect()->route('facture.index');
              }
  
              if(auth()->user()->typeGest==2){
                  auth()->user()->assignRole('magasinier');
                  return redirect()->route('produits.index');
              }
              
              if(auth()->user()->typeGest==3){
                  auth()->user()->assignRole('gestionnaireCommande');
                  return redirect()->route('commande.index');
              }
              if(auth()->user()->typeGest==4){
                  auth()->user()->assignRole('auditeur');
                  return redirect()->route('produits.index');
              }
              
              (auth()->user()->typeGest==5)&&(auth()->user()->assignRole('financier'));
              
             
              return redirect()->route('index')->with('success', 'Connexion reussie');
          }
          return back()->withErrors([
              'message' => "Utilisateur non reconnu"
          ]);
        }catch(Exception $e){
            return view('400');
        }
    }


    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Deconnexion reussie');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try{
          $this->authorize('create and edit users');
          return view('equipe.edit', ['user' => $user]);
        }catch(Exception $e){
            return view('400');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try{
            DB::beginTransaction();
            $request->validate([
                'nomGest' => 'string',
                'login' => 'string',
                'mobile' => 'string',
                'password' => 'nullable|string|min:8|confirmed',
                'typeGest' => 'numeric',
            ]);
            
            $user1=User::where('login',$request->login)->first();
            if (isset($user1) && $user1!=$user){
                return back()->withErrors([
                    'message' => "Ce login a deja été utilisé"
                ]);
            }
            
            $user->nomGest = $request->nomGest;
            $user->login = $request->login;
            $user->mobile = $request->mobile;
            $user->typeGest = $request->typeGest;
            $user->actif = $request->actif;
            
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
        
            
            $user->save();
            
            DB::commit();
            
            return redirect()->route('user.edit',["user"=>$user])->with('success', 'Mise a jour reussie');
          
          }catch(Exception $e){
               DB::rollBack();
              return view('400');
          }
    }

    public function update_my_profile(Request $request, User $user){
        
        $validatedData = $request->validate([
            'nomGest' => 'string|max:255',
            'login' => 'string|max:255',
            'mobile' => 'string|max:20',
            'password' => 'required|string', 
            'new_password' => 'nullable|string|min:8|confirmed', 
        ]);
        
        if (!Hash::check($validatedData['password'], $user->password)) {
            return back()->withErrors(['message' => 'Mot de passe non reconnu']);
        }
    
        $user1=User::where('login',$request->login)->first();
        if (isset($user1) && $user1!=$user){
            return back()->withErrors(['message' => 'Ce login a deja été utilisé']);
        }
        
        if ($request->filled('nomGest')) {
            $user->nomGest = $validatedData['nomGest'];
        }
    
        if ($request->filled('login')) {
            $user->login = $validatedData['login'];
        }
    
        if ($request->filled('mobile')) {
            $user->mobile = $validatedData['mobile'];
        }
    
        
        if ($request->filled('new_password')) {
            $user->password = bcrypt($validatedData['new_password']);
        }
    
        
        $user->save();
    
        return redirect()->route('user.edit',["user"=>$user])->with('success', 'Mise a jour reussie');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->actif=0;
        $user->save();
        return back()->with('success', 'Profile updated successfully.');
    }
}
