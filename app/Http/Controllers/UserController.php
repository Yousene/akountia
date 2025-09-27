<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\RefTable;
use App\Models\Droit;
use App\Models\Employe;
use App\Models\Client;
use App\Models\Ville;
use App\Models\Role;
use App\Rules\UserClient;
use App\Rules\EmployeClient;
use App\Rules\UserEmploye;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'role' => ['required'],
            'last_name' => ['required', 'string', 'max:50'],
            'first_name' => ['required', 'string', 'max:50'],
            'login' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $request->flash();
        $request->flash();
        $users = User::fetchAll();
        $roles = Role::fetchAll();
        return response()->view('back.user.index', ['users' => $users, 'roles' => $roles]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        //        dd(\auth()->user()->userRole->label);
        return response()->view('back.user.create', ['roles' => Role::fetchAll()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|void
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name' => ['required', 'string', 'max:50'],
            'first_name' => ['required', 'string', 'max:50'],
            'login' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {

            $user = [
                'name' => $data['name'],
                'first_name' => $data['first_name'],
                'login' => $data['login'],
                'role' => $data['role'],
                'password' => Hash::make($data['password']),
                'validated' => 1,
            ];

        }
        User::create($user);
        Redirect::to(route('user.index'))->send();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user): Response
    {
        return response()->view(
            'back.user.edit',
            [
                'roles' => Role::fetchAll(),
                'droits' => Droit::all()->where('deleted', "0"),
                'user' => $user
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(User $user, Request $request): RedirectResponse
    {
        $data = $request->all();
        $rules = [
            'name' => ['required', 'string', 'max:50'],
            'first_name' => ['required', 'string', 'max:50'],
            'login' => ['required', 'string', 'max:50'],
            'password' => ['confirmed'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {

            $user->first_name = $request->all()["first_name"];
            $user->name = $request->all()["name"];
            $user->login = $request->all()["login"];
            $user->role = $request->all()["role"];
            if (empty($request->get('password'))) {
                //$data = $request->except('password');
                //$user->update($data);
                $user->save();
            } else {
                //$data = $request->all();
                $user->password = Hash::make($data['password']);
                $user->save();
            }

            Redirect::to(route('user.index'))->send();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->update(['deleted' => 1, 'deleted_at' => date("Y-m-d H:i:s"), 'deleted_by' => Auth::user()->id]);
        return response()->json(['success' => true, 'message' => "L'enregistrement a été supprimé avec succès"]);
    }


    public function myProfil(Request $request)
    {
        $data = $request->all();

        $request->flash();
        $roles = Role::fetchAll();
        $rules = [

            'lastName' => ['required', 'string', 'max:50'],
            'firstName' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => 'confirmed',
            'password_confirmation' => 'confirmed',

        ];
        $user = User::where('id', \Auth::user()->id)->first();

        if ($request->isMethod('post')) {

            if (strlen(trim($data['password'])) < 1) {
                unset($rules['password']);
            }
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            if ($user) {
                if (strlen(trim($data['password'])) > 1) {
                    $user->password = Hash::make($data['password']);
                }

                $user->name = $request->input('lastName');
                $user->first_name = $request->input('firstName');
                $user->email = $request->input('email');

                // $user->ClientDetail->save(); // if needed

                if ($request->file('photo')) {
                    $fileName = time() . '.' . $request->file('photo')->extension();
                    $request->file('photo')->move(public_path('uploads/photos'), $fileName);
                    $user->photo = $fileName;
                }

                $user->save();
                $request->session()->flash('success', 'Profil modifié avec succés');

            }
        }

        return view(
            'back/user/profil',
            [
                'roles' => $roles,
                'user' => User::where('id', \Auth::user()->id)->first()
            ]
        );
    }




    public function data()
    {
        return user::getDataForDataTable();
    }

}
