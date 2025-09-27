<?php

namespace App;

use App\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Droit;
use App\Models\Ville;
use App\Models\Parameter;
use Yajra\DataTables\DataTables;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role');
    }
    public function hasPermission($permission)
    {
        // Check if the user has the given permission.
        return $this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->where('name', $permission);
        })->exists();
    }


    public function droits()
    {
        return $this->belongsToMany(Droit::class, 'users_droits');
    }


    public static function fetchAll()
    {
        return \DB::table("users")
            ->select("*", \DB::raw('users.id as id'), \DB::raw('roles.label as role_label'))
            ->leftJoin('roles', 'roles.id', '=', 'users.role')
            ->where('users.deleted', '0')
            ->get();
    }

    public static function hasRoute($route)
    {
        return is_numeric(array_search($route, session('user_routes', [])));
    }

    public static function hasRessource($ressource)
    {
        return is_numeric(array_search($ressource, session('user_ressources', [])));
    }

    public static function getRessourcesByFonctionnalites($fonctionnalites)
    {

        $ressources = \DB::table("fonctionnalites_ressources")
            ->select(
                "*",
                \DB::raw('ressources.id as id'),
                \DB::raw('ressources.name as ressource_name')
            )
            ->leftJoin('ressources', 'ressources.id', '=', 'fonctionnalites_ressources.ressource_id')
            ->where('ressources.deleted', '0')
            ->whereIn('fonctionnalite_id', $fonctionnalites)
            ->get();
        return array_column($ressources->toArray(), 'ressource_name');
    }

    public static function getRoutesByFonctionnalites($fonctionnalites)
    {

        $ressources = \DB::table("fonctionnalites_routes")
            ->whereIn('fonctionnalite_id', $fonctionnalites)
            ->get();
        return array_column($ressources->toArray(), 'route');
    }

    public static function getUserVilles()
    {
        return \Auth::user()->relatedVilles()->allRelatedIds()->toArray();
    }


    public static function getUserVillesCharger()
    {
        return \Auth::user()->relatedVillesCharger()->allRelatedIds()->toArray();
    }

    public static function storeUserData()
    {
        $role = \App\Models\Role::find(\Auth::user()->role);
        $fonctionnalites = $role->fonctionnalites()->allRelatedIds()->toArray();
        $ressources = self::getRessourcesByFonctionnalites($fonctionnalites);
        $routes = self::getRoutesByFonctionnalites($fonctionnalites);

        session(['user_ressources' => $ressources]);
        session(['user_routes' => $routes]);
        session(['global_parameters' => Parameter::find(1)]);
    }

    public function relatedVilles()
    {
        return $this->belongsToMany(Ville::class, 'villes_users', 'ville_id', 'user_id');
    }

    public function relatedVillesCharger()
    {
        return $this->belongsToMany(Ville::class, 'villes_users_charger', 'ville_id', 'user_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getDataForDataTable()
    {
        $query = self::with(['roles'])
            ->leftJoin('roles', 'users.role', '=', 'roles.id')
            ->select('users.*', 'roles.label as role_label', 'roles.color as role_color')
            ->where('users.deleted', '0');

        return DataTables::of($query)
            ->editColumn('created_at', function ($user) {
                // Format the created_at field to a readable format
                return date('Y-m-d H:i:s', strtotime($user->created_at));
            })
            ->editColumn('utilisateur', function ($user) {
                $initial = mb_substr($user->name, 0, 1) . mb_substr($user->first_name, 0, 1);
                $photo = $user->photo ? "<img src=\"/uploads/photos/$user->photo\" alt=\"$user->photo\" class=\"rounded-circle\">" : "<span class=\"avatar-initial rounded-circle bg-label-primary\">$initial</span>";
                $href = route('user.edit', ['user' => $user->id]);
                return <<<HTML
                        <div class="d-flex justify-content-left align-items-center">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-3">
                                $photo
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="$href" class="text-body text-truncate">
                                <span class="fw-medium">$user->name $user->first_name</span></a>
                                <small class="text-muted">$user->login</small>
                            </div>
                        </div>
                HTML;
            })
            ->editColumn('role', function ($user) {
                $href = route('role_update', ['role' => $user->role]);
                return "<a href=\"$href\"><span class=\"badge bg-label-$user->role_color me-1\">$user->role_label</span></a>";
            })
            ->addColumn('action', function ($user) {
                return view('back.user.actions', compact('user'))->render();
            })
            ->filterColumn('role', function ($query, $keyword) {
                $query->where('roles.label', 'like', "%{$keyword}%");
            })
            ->filterColumn('utilisateur', function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('users.name', 'like', "%{$keyword}%")
                        ->orWhere('users.first_name', 'like', "%{$keyword}%")
                        ->orWhere('users.login', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['action', 'utilisateur', 'role'])
            ->make(true);
    }
}
