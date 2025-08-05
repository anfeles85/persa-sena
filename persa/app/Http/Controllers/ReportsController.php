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
        $users = User::where('role_id', 3)->get();
        return view('reports.index', compact('courses', 'users'));
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
         $pdf = Pdf::loadView('reports.export_courses', $data)
                ->setPaper('letter', 'portrait')
                ->setOptions([
                    'defaultFont'=>'sans-serif', 
                    'isRemoteEnabled'=>true
                ]); //landscape: horizontal
                
        return $pdf->download('Courses.pdf');
    }   
    /**
     * reporte que genera el permiso de un aprendiz en especifico
     */
    public function export_permissions_by_apprentice(Request $request)
{
    // Validar que el aprendiz exista y tenga rol de aprendiz (role_id = 3)
    $apprentice = User::where('id', $request->input('apprentice_id'))
                      ->where('role_id', 3)
                      ->firstOrFail();

    // Obtener permisos de ese aprendiz
    $permissions = Permission::where('apprentice_id', $apprentice->id)->get();

    // Generar PDF
    $pdf = Pdf::loadView('reports.export_permissions_by_apprentice', [
            'permissions' => $permissions,
            'apprentice' => $apprentice
        ])
        ->setPaper('letter', 'portrait')
        ->setOptions([
            'defaultFont' => 'sans-serif',
            'isRemoteEnabled' => true
        ]);

    return $pdf->download('Permisos_Aprendiz_' . $apprentice->id . '.pdf');
}

     /**
     * reporte que genera listado ordenes en un rango de fechas 
     */
    public function export_permissions_by_date_range(Request $request)
    {
        $permissions = Permission::with([
            'apprentice_user.apprenticeCourse.course.career',
            'instructor_user',
            'guard_user',
            'location',
            'permissionType',
        ])->whereBetween('permission_date', [$request['date1'], $request['date2']])->get();
        

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

    /**
     * reporte que genera listado de permisos por curso
     */
    public function export_permissions_by_course(Request $request)
{
    $courseId = $request->input('course_id');
    $course = Course::with([
        'career',
        'apprentices.permissions.permissionType',
        'apprentices.permissions.location'
    ])->findOrFail($courseId);

    $data = [
        'course' => $course,
        'apprentices' => $course->apprentices,
    ];

    $pdf = Pdf::loadView('reports.export_permissions_by_course', $data)
        ->setPaper('letter', 'portrait')
        ->setOptions([
            'defaultFont' => 'sans-serif',
            'isRemoteEnabled' => true
        ]);

    return $pdf->download('Permisos_Curso_' . $course->id . '.pdf');
}
}