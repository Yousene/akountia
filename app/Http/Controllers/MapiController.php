<?php

namespace App\Http\Controllers;



class MapiController extends Controller
{
    public function __construct(Request $request)
    {
    }

    public function login(Request $request)
    {
        $data = json_decode($request->getContent());
        $credentials = ['login' => $data->{"login"}, 'password' => $data->{"password"}];
        if (\Auth::attempt($credentials)) {
            return response()->json(User::where('login', $credentials['login'])->first()->toArray());
        } else {
            return response()->json([
                'error' => '401', 'message' => 'coordonner incorecte'
            ], 401);
        }
    }

}
