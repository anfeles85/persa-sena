<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
            $permissions = Permission::where('status', 'PENDIENTE')
            ->whereNull('departure_time')
            ->where('permission_date', '<', Carbon::today())
            ->update(['status' => 'CANCELADO']);

        $this->info("Se cancelaron {$permissions} permisos pendientes.");
    }
}
