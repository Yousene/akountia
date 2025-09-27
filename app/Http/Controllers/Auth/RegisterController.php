<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Models\Client;
use App\Models\Ville;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\Register\CatClient;
use App\Rules\Inputs\Tel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Notifications\RegistredUser;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;



    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $user->notify(new RegistredUser());

        return redirect()->route('successfull');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view(
            'auth.register',
            [
                'villes' => Ville::all()->where('deleted', "0")
            ]
        );
    }


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        // dd(substr_count($data['rib'],$data['rib'][0]),$data['rib'][0]);

        Validator::extend('rib_check', function ($attribute, $value, $parameters, $validator) {
            return substr_count($value,$value[0]) != 24;
        },'incorrect RIB');
        if ($data['categorie'] == 2) {
            $rules = [
                'name' => [new CatClient(), 'max:50'],
                'cin' => [new CatClient(), 'max:50'],
                'raisonsociale' => [new CatClient(), 'max:50'],
                'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
                'adresse' => ['required', 'string', 'max:50'],
                'ville' => ['required', 'string', 'max:50'],
                'telephone' => ['required', 'string', 'max:10', new Tel(), 'starts_with: 07,05,06'],
                'telephone2' => ['required', 'string', 'max:50', new Tel(), 'starts_with: 07,05,06'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'rib' => ['max:24', 'min:24','rib_check'],

            ];
        } else {
            $rules = [
                'name' => [new CatClient(), 'max:50'],
                'cin' => [new CatClient(), 'max:50'],
                'rib' => ['max:24', 'min:24','rib_check'],
                'raisonsociale' => [new CatClient(), 'max:50'],
                'rc' => [new CatClient(), 'max:6', 'min:6'],
                'ice' => [new CatClient(), 'max:15', 'min:15'],
                'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
                'adresse' => ['required', 'string', 'max:50'],
                'ville' => ['required', 'string', 'max:50'],
                'telephone' => ['required', 'string', 'max:50', new Tel(), 'starts_with: 07,05,06'],
                'telephone2' => ['required', 'string', 'max:50', new Tel(), 'starts_with: 07,05,06'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ];
        }



        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $client = new Client();

        if ($data['categorie'] == 2) {
            $client->libelle = $data['categorie'] == 1 ? $data['raisonsociale'] : $data['name'];
            $client->type_client = $data['categorie'];
            $client->adresse = $data['adresse'];
            $client->ville = $data['ville'];
            $client->agence = $data['ville'];
            $client->telephone = $data['telephone'];
            $client->cin = $data['cin'];
            $client->email = $data['email'];
            $client->email_nolivre = $data['email'];
            $client->email_rembroursement = $data['email'];
            $client->rib = $data['rib'];
            $client->port = 'PD';
            $client->valeur_declaree = '1';
            $client->factureMois = 'Non';
            $client->colisSimple = 'Non';
            $client->colisEchange = 'Non';
            $client->num_exp = 'AUTO';
            $client->code =  'C' . sprintf("%06d", Client::all()->count() + 1);
            $client->seuil_colis = 5;
        } else {
            $client->libelle = $data['categorie'] == 1 ? $data['raisonsociale'] : $data['name'];
            $client->type_client = $data['categorie'];
            $client->adresse = $data['adresse'];
            $client->ville = $data['ville'];
            $client->agence = $data['ville'];
            $client->telephone = $data['telephone'];
            $client->cin = $data['cin'];
            $client->email = $data['email'];
            $client->email_nolivre = $data['email'];
            $client->email_rembroursement = $data['email'];
            $client->rib = $data['rib'];
            $client->rc_org = $data['rc'];
            $client->ice_org = $data['ice'];
            $client->port = 'PD';
            $client->valeur_declaree = '1';
            $client->factureMois = 'Non';
            $client->colisSimple = 'Non';
            $client->colisEchange = 'Non';
            $client->num_exp = 'AUTO';
            $client->code =  'C' . sprintf("%06d", Client::all()->count() + 1);
            $client->seuil_colis = 5;
        }
        $client->save();

        return User::create([
            'role' => 3,
            'login' => $data['email'],
            'email' => $data['email'],
            'client' => $client->id,
            'confirmation_token' => str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),
            'password' => Hash::make($data['password']),
        ]);
    }

    public function confirm($id, $token, Request $request)
    {
        $user = User::where('id', $id)->where('confirmation_token', $token)->first();
        if ($user) {
            $user->update(['confirmation_token' => null, 'activated_at' => date("Y-m-d H:i:s"), 'activated_by' => $id]);
            //$this->guard()->login($user);
            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());
        } else {
            return redirect('/login');
        }
    }
}
