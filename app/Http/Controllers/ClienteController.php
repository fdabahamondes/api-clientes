<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return response()->json(Cliente::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rut' => 'required|string|unique:clientes,rut',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:clientes,email',
            'telefono' => 'nullable|string|max:20'
        ]);

        $cliente = Cliente::create($request->only([
            'rut',
            'nombre',
            'apellido',
            'email',
            'telefono'
        ]));

        return response()->json($cliente, 201);
    }

    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return response()->json($cliente, 200);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'rut' => 'sometimes|required|string|unique:clientes,rut,' . $id,
            'nombre' => 'sometimes|required|string|max:100',
            'apellido' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:clientes,email,' . $id,
            'telefono' => 'nullable|string|max:20'
        ]);

        $cliente->update($request->only([
            'rut',
            'nombre',
            'apellido',
            'email',
            'telefono'
        ]));

        return response()->json($cliente, 200);
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return response()->json([
            'message' => 'Cliente eliminado correctamente'
        ], 200);
    }
}
