<?php

namespace App\Http\Controllers;

use App\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_fullname' => 'required',
            'shipping_state' => 'required',
            'shipping_city' => 'required',
            'shipping_address' => 'required',
            'shipping_phone' => 'required',
            'shipping_zipcode' => 'required',
            'metodo_pagamento' => 'required',
        ]);

        $pedido= new Pedido();
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

        $pedido->save();

        $cartItems = \Cart::session(auth()->id())->getContent();

        foreach($cartItems as $item) {
            $pedido->items()->attach($item->id, ['price'=> $item->price, 'quantity'=> $item->quantity]);
        }


        //payment
        if(request('metodo_pagamento') == 'paypal') {
                //redirect to paypal
            return redirect()->route('paypal.checkout', $pedido->id);

        }

        //empty cart
        \Cart::session(auth()->id())->clear();
        //send email to customer


        return redirect()->route('home')->withMessage('Pedido Realizado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
