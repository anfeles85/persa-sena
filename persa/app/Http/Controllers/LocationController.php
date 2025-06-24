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
    ];

    private $traductionAttributes = [
        'name' => 'nombre',
        'address' => 'dirección',
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
<<<<<<< HEAD
        return redirect()->route('location.index')->with('created_successfully', true);
=======
        session()->flash('message', 'Sede creada exitosamente');
        return redirect()->route('location.index');
>>>>>>> deb5c7d (Fix's)
    }

    public function edit($id)
    {
<<<<<<< HEAD
        return redirect()->back()->with('success', 'La sede se edito correctamente.');
=======
        $location = Location::find($id);
        if ($location) {
            return view('location.edit', compact('location'));
        } else {
            session()->flash('warning', 'No se encontró la sede');
            return redirect()->route('location.index');
        }
>>>>>>> deb5c7d (Fix's)
    }

    public function update(Request $request, $id)
    {

<<<<<<< HEAD
=======
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
>>>>>>> deb5c7d (Fix's)
    }

    public function destroy($id)
    {
<<<<<<< HEAD
        Location::destroy($id); 
        return redirect()->route('location.index')->with('success', 'Sede eliminada correctamente');
=======
        $location = Location::find($id);
        if ($location) {
            $location->delete();
            session()->flash('message', 'Sede eliminada exitosamente');
        } else {
            session()->flash('warning', 'No se encontró la sede');
        }

        return redirect()->route('location.index');
>>>>>>> deb5c7d (Fix's)
    }
}
