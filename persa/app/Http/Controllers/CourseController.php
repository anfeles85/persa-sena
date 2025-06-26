<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    private $rules = [
        'shift' => 'required|string|min:3|max:50',
        'trimester' => 'required|string|min:1|max:50',
        'year' => 'required|numeric|min:1|max:2100',
        'status' => 'required|string|min:3|max:50',
        'career_id' => 'required|numeric|min:1|max:99999999999999999999'
    ];

    private $traductionAttributes = [
        'shift' => 'jornada',
        'trimester' => 'trimestre',
        'year' => 'año',
        'status' => 'estado',
        'career_id' => 'programa id'
    ];

    private $trimesters = [
        ['name' => 'T1', 'value' => 'T1'],
        ['name' => 'T2', 'value' => 'T2'],
        ['name' => 'T3', 'value' => 'T3'],
        ['name' => 'T4', 'value' => 'T4'],
        ['name' => 'T5', 'value' => 'T5'],
        ['name' => 'T6', 'value' => 'T6'],
        ['name' => 'T7', 'value' => 'T7']
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
        $shifts = $this->shifts;
        $trimesters = $this->trimesters;
        $status = $this->status;
        return view('course.create', compact('courses','careers','shifts','trimesters','status'));
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
        return redirect()->route('course.index')->with('created_successfully', true);
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
    public function edit(string $id)
    {
        $course = Course::find($id);
        if ($course) // si existe
        {
            return view('course.edit', compact('course'));
        }
        else
        {
            session()->flash('warning', 'No se encuentra el técnico solicitado');
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
}
