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
<<<<<<< HEAD
<<<<<<< HEAD
        return redirect()->route('career.index')->with('created_successfully', true);
=======
=======
>>>>>>> origin/G1
        session()->flash('message', 'Programa creado exitosamente');
        return redirect()->route('career.index');
>>>>>>> deb5c7d (Fix's)
    }

    public function edit($id)
    {
<<<<<<< HEAD
        return redirect()->back()->with('success', 'El registro editado correctamente.');
=======
        $career = Career::find($id);
        if ($career) {
            return view('career.edit', compact('career'));
        }
        session()->flash('warning', 'Programa no encontrado');
        return redirect()->route('career.index');
>>>>>>> deb5c7d (Fix's)
    }

    public function update(Request $request, $id)
    {

<<<<<<< HEAD
=======
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
>>>>>>> deb5c7d (Fix's)
    }

    public function destroy($id)
    {
<<<<<<< HEAD
        Career::destroy($id); 
        return redirect()->route('career.index')->with('success', 'Carrera eliminada correctamente');
=======
        $career = Career::find($id);
        if ($career) {
            $career->delete();
            session()->flash('message', 'Programa eliminado exitosamente');
        } else {
            session()->flash('warning', 'Programa no encontrado');
        }

        return redirect()->route('career.index');
>>>>>>> deb5c7d (Fix's)
    }
}
