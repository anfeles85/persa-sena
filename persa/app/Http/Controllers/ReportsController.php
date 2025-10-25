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
    public function index(){
        $user = auth()->user();

        if ($user->role_id == 2) {
            // cursos activos asignados al instructor
            $courses = Course::with('career')
                ->where('status', 'ACTIVO')
                ->whereExists(function ($query) use ($user) {
                    $query->select('*')
                        ->from('instructor_course')
                        ->whereRaw('instructor_course.course_id = course.id')
                        ->where('instructor_course.instructor_id', $user->id);
                })
                ->get();

            // aprendices solo de esos cursos
            $users = User::where('role_id', 3)
                ->whereHas('courses', function ($query) use ($courses) {
                    $query->whereIn('course.id', $courses->pluck('id')); // 👈 singular
                })
                ->get();
        } else {
            $courses = Course::with('career')->where('status', 'ACTIVO')->get();
            $users = User::where('role_id', 3)->get();
        }

        return view('reports.index', compact('courses', 'users'));
    }



    /**
     * Show the form for creating a new resource.
     */
    
    /**
     * reporte que genera el permiso de un aprendiz en especifico
     */
    public function export_permissions_by_apprentice(Request $request){
        $apprenticeId = $request->input('apprentice_id');
        
        $apprentice = User::where('id', $apprenticeId)
                          ->where('role_id', 3)
                          ->firstOrFail();

        $permissions = Permission::where('apprentice_id', $apprenticeId)
                          ->with(['permissionType', 'location'])
                          ->orderBy('permission_date', 'desc')
                          ->get();

        $pdf = Pdf::loadView('reports.export_permissions_by_apprentice', compact('permissions', 'apprentice'))
            ->setPaper('letter', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
            ]);

        return $pdf->download('Permisos_Aprendiz_' . $apprentice->fullname . '.pdf');
    }

     /**
     * reporte que genera listado ordenes en un rango de fechas 
     */
    public function export_permissions_by_date_range(Request $request)
    {
        $date1 = $request->input('date1');
        $date2 = $request->input('date2');

        $permissions = Permission::with([
            'apprentice_user.courses.career',
            'location',
            'permissionType',
        ])
        ->whereBetween('permission_date', [$date1, $date2])
        ->orderBy('permission_date', 'desc')
        ->get();

        $pdf = Pdf::loadView('reports.export_permissions_by_date_range', compact('permissions', 'date1', 'date2'))
                ->setPaper('letter', 'landscape')
                ->setOptions([
                    'defaultFont' => 'sans-serif', 
                    'isRemoteEnabled' => true,
                    'isHtml5ParserEnabled' => true,
                ]); 
                
        return $pdf->download('Permisos_' . $date1 . '_a_' . $date2 . '.pdf');
    }

    /**
     * reporte que genera listado de permisos por curso
     */
    public function export_permissions_by_course(Request $request){
        $courseId = $request->input('course_id');

        $course = Course::with('career')->findOrFail($courseId);

        // Obtener aprendices del curso con sus permisos
        $apprentices = User::where('role_id', 3)
            ->whereHas('courses', function($query) use ($courseId) {
                $query->where('course.id', $courseId);
            })
            ->with(['permissions' => function($query) {
                $query->with(['permissionType', 'location'])
                      ->orderBy('permission_date', 'desc');
            }])
            ->get();

        $pdf = Pdf::loadView('reports.export_permissions_by_course', compact('course', 'apprentices'))
            ->setPaper('letter', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
            ]);

        return $pdf->download('Permisos_Ficha_' . $course->number_group . '.pdf');
    }
}