<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    private $rules = [
        'name' => 'required|string|max:50',
        'description' => 'required|string|max:255',
    ];

    private $traductionAttributes = [
        'name' => 'nombre',
        'description' => 'descripción',
    ];

    public function index()
    {
        $locations = Location::all();
        return view('location.index', compact('locations'));
    }

    public function create()
    {
        return view('location.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('location.create')->withInput()->withErrors($validator->errors());
        }

        Location::create($request->all());
        session()->flash('message', 'Sede creada exitosamente');
        return redirect()->route('location.index');
    }

    public function edit($id)
    {
        $location = Location::find($id);
        if ($location) {
            return view('location.edit', compact('location'));
        } else {
            session()->flash('warning', 'No se encontró la sede');
            return redirect()->route('location.index');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules);
        $validator->setAttributeNames($this->traductionAttributes);

        if ($validator->fails()) {
            return redirect()->route('location.edit', $id)->withInput()->withErrors($validator->errors());
        }

        $location = Location::find($id);
        if ($location) {
            $location->update($request->all());
            session()->flash('message', 'Sede actualizada exitosamente');
        } else {
            session()->flash('warning', 'No se encontró la sede');
        }

        return redirect()->route('location.index');
    }

    public function destroy($id)
    {
        $location = Location::find($id);
        if ($location) {
            $location->delete();
            session()->flash('message', 'Sede eliminada exitosamente');
        } else {
            session()->flash('warning', 'No se encontró la sede');
        }

        return redirect()->route('location.index');
    }
}
