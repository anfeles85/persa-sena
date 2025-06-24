<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CareerController extends Controller
{
    private $rules = [
        'name' => 'required|string|max:50',
        'type' => 'required|string|max:50',
    ];

    private $traductionAttributes = [
        'name' => 'nombre',
        'type' => 'tipo',
    ];

    private $types = [
        ['name' => 'TECNICO', 'value' => 'TECNICO'],
        ['name' => 'TECNOLOGO', 'value' => 'TECNOLOGO'],
        ['name' => 'AUXILIAR', 'value' => 'AUXILIAR']
    ];

    public function index()
    {
        $careers = Career::all();
        return view('career.index', compact('careers'));
    }

    public function create()
    {
        $careers = Career::all();
        $types = $this->types;  
        return view('career.create', compact('careers', 'types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules)->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('career.create')->withInput()->withErrors($validator->errors());
        }

        Career::create($request->all());
        return redirect()->route('career.index')->with('created_successfully', true);
    }

    public function edit($id)
    {
        $career = Career::find($id);
        if ($career) // si existe
        {
            $types = $this->types;
            return view('career.edit', compact('career', 'types'));
        }
        else
        {
            session()->flash('warning', 'No se encuentra el técnico solicitado');
            return redirect()->route('career.index');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('career.edit', $id)->withInput()->withErrors($errors);
        }
        $careers = Career::find($id);
        if($careers) 
        {
            $careers->update($request->all());
            session()->flash('message', 'Actividad actualizada exitosamente');
        }
        else
        {
            session()->flash('warning', 'No se encuentra la actividad solicitado');
            return redirect()->route('career.index');
        }

        return redirect()->route('career.index')->with('success', 'El programa se editó correctamente.');
    }

    public function destroy($id)
    {
        Career::destroy($id); 
        return redirect()->route('career.index')->with('success', 'Carrera eliminada correctamente');
    }
}
