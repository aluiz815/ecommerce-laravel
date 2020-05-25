@extends('layouts.app')


@section('content')
<h2>Finalizar Compra</h2>
<h3>Informações</h3>
<form action="{{route('pedido.store')}}" method="post">
    @csrf
    <div class="form-group">
        <label for="">Nome Completo</label>
        <input type="text" name="shipping_fullname" id="" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Estado</label>
        <input type="text" name="shipping_state" id="" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Cidade</label>
        <input type="text" name="shipping_city" id="" class="form-control">
    </div>

    <div class="form-group">
        <label for="">CEP</label>
        <input type="number" name="shipping_zipcode" id="" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Endereço</label>
        <input type="text" name="shipping_address" id="" class="form-control">
    </div>

    <div class="form-group">
        <label for="">Celular</label>
        <input type="text" name="shipping_phone" id="" class="form-control">
    </div>

    <h4>Pagamento</h4>

    <div class="form-check">
        <label class="form-check-label">
            <input type="radio" class="form-check-input" name="metodo_pagamento" value="dinheiro">
            Dinheiro
        </label>

    </div>

    <div class="form-check">
        <label class="form-check-label">
            <input type="radio" class="form-check-input" name="metodo_pagamento" value="paypal">
            Paypal
        </label>

    </div>


    <button type="submit" class="btn btn-primary mt-3">Finalizar</button>


</form>
@endsection()
