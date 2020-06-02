<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    //Pegando os produtos com paginacao e retornando a view home com os produtos para serem renderizados no frontend
    public function index()
    {
        $produtos = Produto::paginate(10);
        return view('home', ['produtos'=>$produtos]);
    }
}
