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
                    $query->whereIn('course.id', $courses->pluck('id')); 
                })
                ->get();
        } else {
            $courses = Course::with('career')->where('status', 'ACTIVO')->get();
            $users = User::where('role_id', 3)->get();
        }

        return view('reports.index', compact('courses', 'users'));
    }

    /**
     * reporte que genera el permiso de un aprendiz en especifico
     */
    public function export_permissions_by_apprentice(Request $request){
        $apprentice = User::where('id', $request->input('apprentice_id'))
                          ->where('role_id', 3)
                          ->with([
                              'permissions.permissionType', 
                              'permissions.location',
                              'courses.career'
                          ])
                          ->firstOrFail();

        $permissions = $apprentice->permissions;
        
        $course = $apprentice->courses->first();

        $pdf = Pdf::loadView('reports.export_permissions_by_apprentice', compact('permissions', 'apprentice', 'course'))
            ->setPaper('letter', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isRemoteEnabled' => true,
            ]);

        return $pdf->download('Permisos_Aprendiz_' . $apprentice->id . '.pdf');
    }

     /**
     * reporte que genera listado ordenes en un rango de fechas 
     */
    public function export_permissions_by_date_range(Request $request)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 300);

        $permissions = Permission::with([
            'apprentice_user.courses',
            'instructor_user',
            'guard_user',
            'location',
            'permissionType',
        ])
        ->whereHas('apprentice_user') 
        ->whereBetween('permission_date', [$request['date1'], $request['date2']])
        ->get();
        

        $data = array(
            'permissions' => $permissions,
            'date1' => $request['date1'],
            'date2' => $request['date2']
        );

        $pdf = Pdf::loadView('reports.export_permissions_by_date_range', $data)
                ->setPaper('letter', 'landscape')
                ->setOptions([
                    'defaultFont'=>'sans-serif', 
                    'isRemoteEnabled'=>true
                ]); 
                
        return $pdf->download('PersaByData.pdf');
    }

    /**
     * reporte que genera listado de permisos por curso
     */
    public function export_permissions_by_course(Request $request){
        $courseId = $request->input('course_id');

        $course = Course::with([
            'career',
            'apprentices.permissions.permissionType',
            'apprentices.permissions.location',
        ])->findOrFail($courseId);

        $apprentices = $course->apprentices;

        $pdf = Pdf::loadView('reports.export_permissions_by_course', compact('course', 'apprentices'))
            ->setPaper('letter', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isRemoteEnabled' => true,
            ]);

        return $pdf->download('Permisos_Curso_' . $course->id . '.pdf');
    }
}