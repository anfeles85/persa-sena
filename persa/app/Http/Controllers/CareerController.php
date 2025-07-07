<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::all();
        return view('career.index', compact('careers'));
    }

    public function create(){
        $types = [
            ['name' => 'Técnica', 'value' => 'tecnica'],
            ['name' => 'Tecnológica', 'value' => 'tecnologica'],
            ['name' => 'Especialización', 'value' => 'especializacion'],
        ];
        return view('career.create', compact('types'));
    }

    public function store(Request $request)
    {
        Career::create($request->all());
        return redirect()->route('career.index')->with('success', 'Carrera creada correctamente.');
    }

    public function edit($id){
        $career = Career::findOrFail($id);
        $types = [
            ['name' => 'Técnica', 'value' => 'tecnica'],
            ['name' => 'Tecnológica', 'value' => 'tecnologica'],
            ['name' => 'Especialización', 'value' => 'especializacion'],
        ];
        return view('career.edit', compact('career', 'types'));
    }

    public function update(Request $request, $id)
    {
        $career = Career::findOrFail($id);
        $career->update($request->all());
        return redirect()->route('career.index')->with('success', 'Carrera actualizada correctamente.');
    }

    public function destroy($id)
    {
        $career = Career::findOrFail($id);
        $career->delete();
        return redirect()->route('career.index')->with('success', 'Carrera eliminada correctamente.');
    }
}