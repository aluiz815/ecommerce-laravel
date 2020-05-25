<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
class CarrinhoController extends Controller
{
    public function add(Produto $produto)
     {
        \Cart::session(auth()->id())->add(array(
            'id' => $produto->id,
            'name' => $produto->name,
            'price' => $produto->price,
            'quantity' => 1,
            'attributes' => array(),
            'associatedModel' => $produto
        ));
        return redirect()->route('carrinho.index');
    }

    public function index()
    {
        $itenscarrinho = \Cart::session(auth()->id())->getContent();
        return view('carrinho.index',compact('itenscarrinho'));
    }
    public function destroy($itemId)
    {
        \Cart::session(auth()->id())->remove($itemId);
        return back();
    }
    public function update($itemId)
    {
        \Cart::session(auth()->id())->update($itemId,[
            'quantity' => array(
                'relative' => false,
                'value' => request('quantity')
            )
        ]);
        return back();
    }
    public function checkout()
    {
        return view('carrinho.checkout');
    }
}
