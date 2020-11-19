<?php


namespace App\Http\Controllers;

use App\Produto;

class ProdutoController extends Controller
{
    public function getProduto($codigo){
        return response()->json(Produto::where('CODIGO', $codigo)->first());
    }
}
