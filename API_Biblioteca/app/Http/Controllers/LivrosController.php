<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\User;
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
        //verifica se o usuário está logado (a priori, apenas verificando se o campo 'email', possui um email válido[o email válido é o gerado pelo banco])
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response()->json(['message'=> 'Usuario precisa estar logado'],400);
        }
        $livro  = Livro::create($request->all());
        $livro->save();
        return response()->json(['message' => 'Livro cadastrado'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $livro = Livro::find($id);
        if (!$livro) {
            return response()->json(['message' => 'O livro não existe'], 502);
        }
        return response()->json(['message' => 'Livro encontrado', "result" => $livro], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //verifica se o usuário está logado (a priori, apenas verificando se o campo 'email', possui um email válido)
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response()->json(['message'=> 'Usuario precisa estar logado'],400);
        }
        $livro = Livro::find($id);
        if (!$livro) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }
        $livro->update($request->all());
        return response()->json(['message' => 'Livro editado'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //aqui verificaria se o usuario está logado e é admin
        $livro = Livro::find($id);
        if (!$livro) {
            return response()->json(['message' => 'Livro não encontrado'], 404);
        }
        $livro->delete();
        return response()->json(['message' => 'Livro deletado'], 200);
    }
}
