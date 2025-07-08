<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Permission;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return view('reports.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
     public function export_courses()
    {
        $courses = Course::all();
        $data = array(
            'courses' => $courses
        );

        /**
         * dompdf version 3.x
         * se debe agregar setOptions
         */
         $pdf = Pdf::loadView('reports.export_course', $data)
                ->setPaper('letter', 'portrait')
                ->setOptions([
                    'defaultFont'=>'sans-serif', 
                    'isRemoteEnabled'=>true
                ]); //landscape: horizontal
                
        return $pdf->download('courses.pdf');
    }   
    /**
     * reporte que genera el permiso de un aprendiz en especifico
     */
    public function export_permissions_by_apprentice(Request $request)
{
    // Filtrar permisos por el aprendiz que los solicitó
    $permissions = Permission::where('user_id', $request['apprentice_id'])->get();

    $data = [
        'permissions' => $permissions
    ];

    $pdf = Pdf::loadView('reports.export_permissions_by_apprentice', $data)
        ->setPaper('letter', 'portrait')
        ->setOptions([
            'defaultFont' => 'sans-serif',
            'isRemoteEnabled' => true
        ]);

    return $pdf->download('Permisos_Aprendiz_' . $request['apprentice_id'] . '.pdf');
}

     /**
     * reporte que genera listado ordenes en un rango de fechas 
     */
    public function export_permissions_by_date_range(Request $request)
    {
        $permissions = Permission::whereBetween('permission_date', [$request['date1'], $request['date2']])->get();
                
        $data = array(
            'permissions' => $permissions,
            'date1' => $request['date1'],
            'date2' => $request['date2']
        );

        $pdf = Pdf::loadView('reports.export_permissions_by_date_range', $data)
                ->setPaper('letter', 'portrait')
                ->setOptions([
                    'defaultFont'=>'sans-serif', 
                    'isRemoteEnabled'=>true
                ]); 
                
        return $pdf->download('PersaByData.pdf');
    }

    
}