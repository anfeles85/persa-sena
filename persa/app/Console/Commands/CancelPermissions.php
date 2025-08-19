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
        $now = Carbon::now();     
        $canceled = Permission::where('status', 'PENDIENTE')
            ->where(function ($query) use ($now) {
                    $query->Where(function ($query) use ($now) {
                        $query->where('permission_date', '=', $now->toDateString())
                            ->where('end_time', '<', $now->toTimeString());
                    });
            })
            ->update(['status' => 'CANCELADO']);

        $this->info("Se cancelaron {$canceled} permisos pendientes expirados.");
        return 0;
    }
}