<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    private $rules = [
        'name' => 'required|string|max:50',
        'address' => 'required|string|max:50',
        'guard'=> 'required|string|max:50',
    ];

    private $traductionAttributes = [
        'name' => 'nombre',
        'address' => 'dirección',
        'guard' => 'Tiene guardia?'
    ];

    public function index()
    {
        $locations = Location::all();

        return view('location.index', compact('locations'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('location.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules)->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('location.create')->withInput()->withErrors($validator->errors());
        }

        Location::create($request->all());
        return redirect()->route('location.index')->with('success', 'Ubicacion creada exitosamente');
    }

    public function edit($id){
        $location = Location::findOrFail($id);
        $types = [
            ['name' => 'Principal', 'value' => 'principal'],
            ['name' => 'Secundaria', 'value' => 'secundaria'],
        ];
        return view('location.edit', compact('location', 'types'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('location.edit', $id)->withInput()->withErrors($errors);
        }
        $location = Location::find($id);
        if($location) 
        {
            $location->update($request->all());
            session()->flash('message', 'Actividad actualizada exitosamente');
        }
        else
        {
            session()->flash('warning', 'No se encuentra la actividad solicitado');
            return redirect()->route('location.index');
        }

        return redirect()->route('location.index')->with('success', 'La sede se editó correctamente.');
    }

    public function destroy($id)
    {
        Location::destroy($id); 
        return redirect()->route('location.index')->with('success', 'Sede eliminada correctamente');
    }
}
