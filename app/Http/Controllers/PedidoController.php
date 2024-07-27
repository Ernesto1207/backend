<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Mesa;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PedidoController extends Controller
{
    public function index()
    {
        // $pedidos = Pedido::with('mesa', 'user')->get();
        // return response()->json($pedidos);
        $pedidos = Pedido::with('dishes')->get();
        return response()->json($pedidos);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'mesa_id' => 'required|exists:mesas,id',
    //         'user_id' => 'required|exists:users,id',
    //         'estado' => 'required|in:pendiente,preparacion,completado',
    //         'dish_ids' => 'array',
    //         'dish_ids.*' => 'exists:dishes,id',
    //         'dishes.*.quantity' => 'required|integer|min:1',
    //     ]);

    //     $pedido = Pedido::create($request->only('mesa_id', 'user_id', 'estado'));
    //     // $pedido->dishes()->attach($request->dishes);
    //     if ($request->has('dish_ids')) {
    //         $pedido->dishes()->sync($request->dish_ids);
    //     }

    //     // Adjuntar los platos al pedido y actualizar la cantidad en el inventario
    //     foreach ($request['dishes'] as $dish) {
    //         $plato = Dish::find($dish['id']);
    //         if ($plato->quantity < $dish['quantity']) {
    //             throw new \Exception('No hay suficiente cantidad del plato ' . $plato->name);
    //         }
    //         $pedido->platos()->attach($dish['id'], ['quantity' => $dish['quantity']]);
    //         $plato->quantity -= $dish['quantity'];
    //         $plato->save();
    //     }

    //     // Actualizar el estado de la mesa a 'ocupada'
    //     $mesa = Mesa::find($request['mesa_id']);
    //     if ($mesa) {
    //         $mesa->estado = 'ocupada';
    //         $mesa->save();
    //     }
    //     return response()->json($pedido, 201);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'mesa_id' => 'required|exists:mesas,id',
            'user_id' => 'required|exists:users,id',
            'estado' => 'required|in:pendiente,preparacion,completado',
            'dish_ids' => 'array',
            'dish_ids.*' => 'exists:dishes,id',
            'dishes' => 'array',
            'dishes.*.id' => 'required|exists:dishes,id',
            'dishes.*.quantity' => 'required|integer|min:1',
        ]);

        $pedido = Pedido::create($request->only('mesa_id', 'user_id', 'estado'));

        // Adjuntar los platos al pedido y actualizar la cantidad en el inventario
        foreach ($request['dishes'] as $dish) {
            $plato = Dish::find($dish['id']);
            if ($plato->quantity < $dish['quantity']) {
                throw new \Exception('No hay suficiente cantidad del plato ' . $plato->name);
            }
            $pedido->dishes()->attach($dish['id'], ['quantity' => $dish['quantity']]);
            $plato->quantity -= $dish['quantity'];
            $plato->save();
        }

        // Actualizar el estado de la mesa a 'ocupada'
        $mesa = Mesa::find($request['mesa_id']);
        if ($mesa) {
            $mesa->estado = 'ocupada';
            $mesa->save();
        }

        return response()->json($pedido, 201);
    }




    public function show(Pedido $pedido)
    {
        return response()->json($pedido->load('dishes'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => 'sometimes|in:pendiente,preparacion,completado',
        ]);

        $pedido->update($request->only('estado'));

        if ($request->has('dishes')) {
            $pedido->dishes()->sync($request->dishes);
        }

        return response()->json($pedido->load('dishes'));
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return response()->json(null, 204);
    }
}
