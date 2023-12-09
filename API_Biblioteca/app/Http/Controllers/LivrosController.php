<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Exception;

class LivrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livros = Livro::all();
        return response()->json(['message' => 'Livros cadastrados', "result" => $livros], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {     
        Log::info('Token no Cadastro: ' . $request->bearerToken());
        if($request->bearerToken()){
            $livro  = Livro::create($request->all());
            $livro->save();
            return response()->json(['message' => 'Livro cadastrado'], 201);
        }else{
            return response()->json(['message' => 'Você precisa estar autenticado'], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $livro = Livro::find($id);
        if (!$livro) {
            return response()->json(['message' => 'O livro nao existe'], 404);
        }
        return response()->json(['message' => 'Livro encontrado', "result" => $livro], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if($request->bearerToken()){
            $livro = Livro::find($request->id);
            
            $livro->update($request->all());
            return response()->json(['message' => 'Livro editado'], 200);
        }else{
            return response()->json(['message' => 'Você precisa estar autenticado'], 401);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Log::info('Token no delete: ' . $request->bearerToken());
        if($request->bearerToken()){
            $livro = Livro::find($request->id);
            $livro->delete();
            return response()->json(['message' => 'Livro deletado'], 200);
        }else{
            return response()->json(['message' => 'Você precisa estar autenticado'], 401);
        }
    }
}
