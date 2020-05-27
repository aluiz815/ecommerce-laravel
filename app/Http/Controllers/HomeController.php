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
    public function index()
    {
        $produtos = Produto::paginate(10);
        return view('home', ['produtos'=>$produtos]);
    }
}
