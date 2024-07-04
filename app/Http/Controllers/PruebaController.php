<?php
namespace App\Http\Controllers;

use App\Models\Prueba;
use Illuminate\Http\Request;

class PruebaController extends Controller
{
    public function index()
    {
        return Prueba::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $prueba = Prueba::create($request->all());
        return response()->json($prueba, 201);
    }

    public function show($id)
    {
        return Prueba::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|max:255',
            'content' => 'string',
        ]);

        $prueba = Prueba::findOrFail($id);
        $prueba->update($request->all());
        return response()->json($prueba, 200);
    }

    public function destroy($id)
    {
        Prueba::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
