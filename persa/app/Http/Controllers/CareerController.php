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
        ['name' => 'TECNOLOGO', 'value' => 'TECNOLOGO']
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
        return redirect()->back()->with('success', 'El registro editado correctamente.');
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        Career::destroy($id); 
        return redirect()->route('career.index')->with('success', 'Carrera eliminada correctamente');
    }
}
