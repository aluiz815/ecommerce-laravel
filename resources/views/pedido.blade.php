@extends('layouts.app')


@section('content')
    <h2>SEUS PEDIDOS</h2>
    @switch($produtos && $pedidos)
        @case(true)
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preco</th>
                    <th>Quantidade</th>
                    <th>Status</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
            @foreach($produtos as $produto)
                <tr>
                    <td>{{$produto->name}}</td>
                    <td>{{$produto->price}}</td>
                    <td>{{$produto->pivot->quantity}}</td>
                    @foreach($pedidos as $pedido)
                    @if($pedido->status === 'completo')
                    <td class="rounded btn-success">{{$pedido->status}}</td>
                    @elseif($pedido->status === 'pendente')
                    <td class="rounded btn-primary">{{$pedido->status}}</td>
                    @elseif($pedido->status === 'processando')
                    <td class="rounded btn-primary">{{$pedido->status}}</td>
                    @else
                    <td class="rounded btn-danger">{{$pedido->status}}</td>
                    @endif
                    @endforeach
                    <td><img  class="card-img-top w-25" src="storage/{{$produto->cover_img}}" alt=""></td>
                </tr>
             @endforeach
            </tbody>
            </table>
            @break
            @default
                <h3>Você Não Possui Pedidos</h3>
            @endswitch
@endsection()
