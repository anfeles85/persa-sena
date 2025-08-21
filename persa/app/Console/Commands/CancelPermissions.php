<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelPermissions extends Command
{
    protected $signature = 'status:cancel-permissions';
    protected $description = 'Cancela automáticamente todos los permisos pendientes cuya fecha ya pasó 
                            y no registraron hora de salida';

    public function handle()
    {
        $today = Carbon::today();

        $records = Permission::where('status', 'PENDIENTE')
            ->where('permission_date', '<', $today)
            ->update(['status' => 'CANCELADO']);

        $this->info("Se actualizaron {$records} registros a CANCELADO.");
        \Log::info("se pasaron {$records} registros a CANCELADO");
    }
}