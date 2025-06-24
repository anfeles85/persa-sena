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
        return redirect()->route('location.index')->with('created_successfully', true);
    }

    public function edit($id)
    {
        return redirect()->back()->with('success', 'La sede se edito correctamente.');
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        Location::destroy($id); 
        return redirect()->route('location.index')->with('success', 'Sede eliminada correctamente');
    }
}
