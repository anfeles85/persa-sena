<?php

namespace App\Http\Controllers;

use App\Imports\CourseImport;
use App\Models\Career;
use App\Models\Course;
use App\Models\InstructorCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Throwable;

class CourseController extends Controller
{
    private $rules = [
        'number_group' => 'required|numeric|min:1|max:99999999999999999999',
        'shift' => 'required|string|min:3|max:50',
        'trimester' => 'required|string|min:1|max:50',
        'year' => 'required|numeric|min:1|max:2100',
        'status' => 'required|string|min:3|max:50',
        'career_id' => 'required|numeric|min:1|max:99999999999999999999'
    ];

    private $traductionAttributes = [
        'number_group' => 'numero de ficha',
        'shift' => 'jornada',
        'trimester' => 'trimestre',
        'year' => 'año',
        'status' => 'estado',
        'career_id' => 'programa'
    ];

    private $trimesters = [
        ['name' => 'T1', 'value' => 'T1'],
        ['name' => 'T2', 'value' => 'T2'],
        ['name' => 'T3', 'value' => 'T3'],
        ['name' => 'T4', 'value' => 'T4'],
    ];

    private $shifts = [
        ['name' => 'DIURNA', 'value' => 'DIURNA'],
        ['name' => 'MIXTA', 'value' => 'MIXTA'],
        ['name' => 'NOCTURNA', 'value' => 'NOCTURNA']
    ];

    private $status = [
        ['name' => 'ACTIVO', 'value' => 'ACTIVO'],
        ['name' => 'INACTIVO', 'value' => 'INACTIVO']
    ];

    public function import(Request $request)
    {
        $request->validate([
            'archivo' => 'required|mimes:xlsx,xls',
        ]);

        try {
        Excel::import(new CourseImport, $request->file('archivo'));

        return back()->with('success', 'Archivo importado correctamente.');
        } catch (ValidationException $e) {

            return back()->with('error', 'Error al importar: ' . implode(', ', $e->errors()['headers'] ?? ['Error desconocido']));
        } catch (Throwable $e) {
            return back()->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    }
    
    public function index()
    {
        $courses = Course::all();
        return view('course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $careers = Career::all();
        $instructors = InstructorCourse::all();
        $shifts = $this->shifts;
        $trimesters = $this->trimesters;
        $status = $this->status;
        return view('course.create', compact('courses','careers', 'instructors','shifts','trimesters','status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules)->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('course.create')->withInput()->withErrors($validator->errors());
        }

        Course::create($request->all());
        return redirect()->route('course.index')->with('success', 'Curso creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id){
        $course = Course::find($id);
        if ($course) {
            $courses = Course::all();
            $careers = Career::all();
            $shifts = $this->shifts;
            $trimesters = $this->trimesters;
            $status = $this->status;

            // Consultar instructores disponibles (rol = 2)
            $query = DB::select("SELECT * FROM users 
                WHERE role_id = 2 
                AND users.id NOT IN (
                    SELECT instructor_course.instructor_id FROM instructor_course
                    WHERE instructor_course.course_id = ?)", [$id]);

            $availableInstructors = Collection::make($query);

            // Instructores ya asignados a este curso
            $addedInstructors = $course->instructors;

            return view('course.edit', compact(
                'course', 'courses', 'careers', 'shifts', 'trimesters', 'status',
                'availableInstructors', 'addedInstructors'
            ));
        } else {
            session()->flash('warning', 'No se encuentra el curso solicitado');
            return redirect()->route('course.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('course.edit', $id)->withInput()->withErrors($errors);
        }
        $course = Course::find($id);
        if($course) 
        {
            $course->update($request->all());
            session()->flash('message', 'Curso actualizado exitosamente');
        }
        else
        {
            session()->flash('warning', 'No se encuentra el curso solicitado');
            return redirect()->route('course.index');
        }

        return redirect()->route('course.index')->with('success', 'El curso se editó correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Course::destroy($id); 
        return redirect()->route('course.index')->with('success', 'Curso eliminado correctamente');
    }

    public function add_instructor(string $course_id, string $instructor_id){
        $course = Course::find($course_id);
        if (!$course) {
            session()->flash('error', 'No se encuentra el curso');
            return redirect()->route('course.edit', $course_id);
        }

        $instructor = \App\Models\User::find($instructor_id);
        if (!$instructor || $instructor->role_id != 2) {
            session()->flash('error', 'El usuario seleccionado no es un instructor válido');
            return redirect()->route('course.edit', $course_id);
        }

        // Asociar instructor al curso
        $course->instructors()->attach($instructor_id);
        session()->flash('message', 'Instructor agregado exitosamente');
        return redirect()->route('course.edit', $course_id);
    }

    public function remove_instructor(string $course_id, string $instructor_id){
        $course = Course::find($course_id);
        if (!$course) {
            session()->flash('error', 'No se encuentra el curso');
            return redirect()->route('course.edit', $course_id);
        }

        $instructor = \App\Models\User::find($instructor_id);
        if (!$instructor || $instructor->role_id != 2) {
            session()->flash('error', 'El usuario seleccionado no es un instructor válido');
            return redirect()->route('course.edit', $course_id);
        }

        // Quitar relación
        $course->instructors()->detach($instructor_id);
        session()->flash('message', 'Instructor eliminado exitosamente');
        return redirect()->route('course.edit', $course_id);
    }



}
