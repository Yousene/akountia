<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CloseOpenedCaisse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'caisse:close-opened';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close opened caisses';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \App\Models\Caisse::where('statut', 1)->update(['confirme_par' => "Admin Système", 'date_fin' => date('Y-m-d 00:00'), 'date_confirmation' => date('Y-m-d 00:00'), 'statut'=>2]);
    }
}