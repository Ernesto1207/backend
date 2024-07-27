<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mesas = Mesa::all();
        return response()->json($mesas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|in:disponible,ocupada,reservada',
            'capacidad' => 'required|integer|min:1',
        ]);

        $mesa = Mesa::create($validated);

        return response()->json($mesa, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mesa $mesa)
    {
        return response()->json($mesa);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mesa $mesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mesa $mesa)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|in:disponible,ocupada,reservada',
            'capacidad' => 'required|integer|min:1',
        ]);

        $mesa->update($validated);

        return response()->json($mesa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesa $mesa)
    {
        $mesa->delete();

        return response()->json(null, 204);
    }
}
