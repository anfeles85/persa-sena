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

    public function index()
    {
        $careers = Career::all();
        return view('career.index', compact('careers'));
    }

    public function create()
    {
        return view('career.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules)->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('career.create')->withInput()->withErrors($validator->errors());
        }

        Career::create($request->all());
        session()->flash('message', 'Programa creado exitosamente');
        return redirect()->route('career.index');
    }

    public function edit($id)
    {
        $career = Career::find($id);
        if ($career) {
            return view('career.edit', compact('career'));
        }
        session()->flash('warning', 'Programa no encontrado');
        return redirect()->route('career.index');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules)->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('career.edit', $id)->withInput()->withErrors($validator->errors());
        }

        $career = Career::find($id);
        if ($career) {
            $career->update($request->all());
            session()->flash('message', 'Programa actualizado exitosamente');
        } else {
            session()->flash('warning', 'Programa no encontrado');
        }

        return redirect()->route('career.index');
    }

    public function destroy($id)
    {
        $career = Career::find($id);
        if ($career) {
            $career->delete();
            session()->flash('message', 'Programa eliminado exitosamente');
        } else {
            session()->flash('warning', 'Programa no encontrado');
        }

        return redirect()->route('career.index');
    }
}
