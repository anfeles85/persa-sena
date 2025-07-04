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
        return view('reports.index', compact('Course'));
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
                
        return $pdf->download('permission_type.pdf');
    }   
    /**
     * reporte que genera el listado de actividades de un técnico
     */
    public function export_reason_by_permission(Request $request)
    {
        $permissions = Permission::where('permission_type_id', $request['permission_id'])->get();
                
        $data = array(
            'permissions' => $permissions
        );

        $pdf = Pdf::loadView('reports.export_reason_by_permission', $data)
                ->setPaper('letter', 'portrait')
                ->setOptions([
                    'defaultFont'=>'sans-serif', 
                    'isRemoteEnabled'=>true
                ]); 
                
        return $pdf->download('Permission_typeByPermission-' . $request['permission_type_id'] . '.pdf');
    }
     /**
     * reporte que genera listado ordenes en un rango de fechas 
     */
    public function export_users_by_date_range(Request $request)
    {
        $users = User::whereBetween('legalization_date', [$request['date1'], $request['date2']])->get();
                
        $data = array(
            'users' => $users,
            'date1' => $request['date1'],
            'date2' => $request['date2']
        );

        $pdf = Pdf::loadView('reports.export_users_by_date_range', $data)
                ->setPaper('letter', 'portrait')
                ->setOptions([
                    'defaultFont'=>'sans-serif', 
                    'isRemoteEnabled'=>true
                ]); 
                
        return $pdf->download('PersaByData.pdf');
    }

    
}