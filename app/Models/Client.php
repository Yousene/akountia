<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';
    protected $guarded = [];



    public static function getDataForDataTable()
    {
        $query = self::query()->where('deleted', '0');

        return DataTables::of($query)
            ->editColumn('name', function ($client) {
                return '<div class="d-flex align-items-center">
                            <span class="ms-1">' . e($client->name) . '</span>
                        </div>';
            })
            ->editColumn('link', function ($client) {
                return '<a href="' . url($client->link) . '" target="_blank" class="text-primary">
                            ' . e($client->link) . '
                            <i class="bx bx-link-external ms-1"></i>
                        </a>';
            })
            ->editColumn('icon_image', function ($client) {
                if ($client->icon_image && Storage::disk('public')->exists($client->icon_image)) {
                    return '<a href="' . Storage::url($client->icon_image) . '" target="_blank">
                                <img src="' . Storage::url($client->icon_image) . '" class="rounded" width="50" height="50" style="object-fit: cover;">
                            </a>';
                }
                return '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/></svg>';
            })
            ->editColumn('image', function ($client) {
                if ($client->image && Storage::disk('public')->exists($client->image)) {
                    return '<a href="' . Storage::url($client->image) . '" target="_blank">
                                <img src="' . Storage::url($client->image) . '" class="rounded" width="50" height="50" style="object-fit: cover;">
                            </a>';
                }
                return '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/></svg>';
            })
            ->addColumn('action', function ($client) {
                return view('back.client.actions', compact('client'))->render();
            })
            ->rawColumns(['action', 'name', 'icon_image', 'image', 'link'])
            ->make(true);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($client) {
            if (empty($client->link)) {
                $client->link = Str::slug($client->name);
            }
        });
    }

    public function getImageUrl($field)
    {
        if ($this->$field && Storage::disk('public')->exists($this->$field)) {
            return Storage::url($this->$field);
        }
        return null;
    }
}
