@extends('layouts.app')


@section('content')

    <h2>Seu Carrinho</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preco</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($itenscarrinho as $itemcarrinho)
                    <tr>
                        <td scope="row">{{$itemcarrinho->name}}</td>
                        <td>
                            {{Cart::session(auth()->id())->get($itemcarrinho->id)->getPriceSum()}}
                        </td>
                        <td>
                            <form action="{{route('carrinho.update',$itemcarrinho->id)}}">
                                <input name="quantity" type="number" value="{{$itemcarrinho->quantity}}">
                                <input type="submit" value="save">
                            </form>
                        </td>
                        <td><a href="{{route('carrinho.destroy',$itemcarrinho->id)}}">Deletar</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

<h3>
    Preço Total:  R${{\Cart::session(auth()->id())->getTotal()}}
</h3>

<a class="btn btn-primary" href="{{route('carrinho.checkout')}}" role="button">Finalizar Compra</a>
@endsection()
