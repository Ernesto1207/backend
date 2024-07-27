<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;

class DishController extends Controller
{
    public function index()
    {
        return response()->json(Dish::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $dish = Dish::create($request->all());

        return response()->json($dish, 201);
    }

    public function show($id)
    {
        return response()->json(Dish::find($id));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $dish = Dish::findOrFail($id);
        $dish->update($request->all());

        return response()->json($dish);
    }

    public function destroy($id)
    {
        Dish::destroy($id);

        return response()->json(null, 204);
    }
}
