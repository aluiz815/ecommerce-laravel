<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{

    public function index()
    {
        $pedidos = Pedido::where('user_id','=',auth()->id())->paginate(10);
        if($pedidos[0] === null){
            $produtos = null;
            return view('pedido',compact('pedidos','produtos'));
        }
        $produtos = Pedido::find($pedidos[0]->id)->items()->paginate(10);
        return view('pedido',compact('pedidos','produtos'));
    }
    
    public function store(Request $request)
    {
        //Validacao dos dados
        $request->validate([
            'shipping_fullname' => 'required',
            'shipping_state' => 'required',
            'shipping_city' => 'required',
            'shipping_address' => 'required',
            'shipping_phone' => 'required',
            'shipping_zipcode' => 'required',
            'metodo_pagamento' => 'required',
        ]);
        //criando Pedido
        $pedido= new Pedido();
        //Dados do pedido
        $pedido->pedido_id = uniqid('OrderNumber-');
    
        $pedido->shipping_fullname = $request->input('shipping_fullname');
        $pedido->shipping_state = $request->input('shipping_state');
        $pedido->shipping_city = $request->input('shipping_city');
        $pedido->shipping_address = $request->input('shipping_address');
        $pedido->shipping_phone = $request->input('shipping_phone');
        $pedido->shipping_zipcode = $request->input('shipping_zipcode');
    
        if(!$request->has('billing_fullname')) {
            $pedido->billing_fullname = $request->input('shipping_fullname');
            $pedido->billing_state = $request->input('shipping_state');
            $pedido->billing_city = $request->input('shipping_city');
            $pedido->billing_address = $request->input('shipping_address');
            $pedido->billing_phone = $request->input('shipping_phone');
            $pedido->billing_zipcode = $request->input('shipping_zipcode');
        }else {
            $pedido->billing_fullname = $request->input('billing_fullname');
            $pedido->billing_state = $request->input('billing_state');
            $pedido->billing_city = $request->input('billing_city');
            $pedido->billing_address = $request->input('billing_address');
            $pedido->billing_phone = $request->input('billing_phone');
            $pedido->billing_zipcode = $request->input('billing_zipcode');
        }

        
        $pedido->grand_total = \Cart::session(auth()->id())->getTotal();

        $pedido->item_qty = \Cart::session(auth()->id())->getContent()->count();

        $pedido->user_id = auth()->id();
        
        if (request('metodo_pagamento') == 'paypal') {
            $pedido->metodo_pagamento = 'paypal';
        }
        //Salvando Pedido no BD
        $pedido->save();
        //Pegando os itens do Carrinho
        $cartItems = \Cart::session(auth()->id())->getContent();
        //Percorrendo os itens e salvando na tabela pivot
        foreach($cartItems as $item) {
            $pedido->items()->attach($item->id, ['price'=> $item->price, 'quantity'=> $item->quantity]);
        }


        //redirecionamento para o paypal
        if(request('metodo_pagamento') == 'paypal') {
            return redirect()->route('paypal.checkout', $pedido->id);

        }

        //Limpar Carrinho
        \Cart::session(auth()->id())->clear();
       


        return redirect()->route('home')->withMessage('Pedido Realizado');
    }

}
