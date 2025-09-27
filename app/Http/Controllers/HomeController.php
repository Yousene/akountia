<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Ville;
use App\Models\Taxation;
use App\Models\Expedition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // abort(400);
        // die;
        return view('auth/login');
    }

    public function getFile($token, $type, $id, Request $request)
    {

        $user = User::where('token', $token)->first();
        if ($user) {
            Auth::guard()->login($user);
            \App\User::storeUserData();
            switch ($type) {
                case 'f':
                    return redirect("/facture/print-detail/" . $id);
                    break;
                case 'ov':
                    return redirect("/remboursement/ordre-virement/" . $id);
                    break;
                default:
                    # code...
                    break;
            }
        } else {
            abort(403);
        }
    }
}
