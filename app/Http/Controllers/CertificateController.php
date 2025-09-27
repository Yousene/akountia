<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Contrôleur pour la gestion des certificats
 */
class CertificateController extends Controller
{
    /**
     * Constructeur du contrôleur
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Affiche la vue principale des certificats
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $courses = Course::where('deleted', '0')
                           ->orderBy('name')
                           ->get(['id', 'name']);

            return view('back.certificate.index', compact('courses'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'affichage de la page des certificats: ' . $e->getMessage());
            return redirect()->route('admin')->with('error', 'Une erreur est survenue lors du chargement de la page.');
        }
    }
}
