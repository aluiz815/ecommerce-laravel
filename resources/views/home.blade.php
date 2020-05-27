@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Produtos</h2>
    <div class="row">
    @foreach ($produtos as $produto)
    <div class="col-4">
     <div class="card">
         <img class="card-img-top" src="storage/{{$produto->cover_img}}" alt="Card image cap">
         <div class="card-body">
             <h4 class="card-title">{{$produto->title}}</h4>
             <p class="card-text">{{$produto->description}}</p>
             <h3>R${{$produto->price}}</h3>
         </div>
         <div class="card-body">
             <a href="{{route('carrinho.add', $produto->id)}}" class="card-link">Adicionar ao carrinho</a>
         </div>
     </div>
    </div>
    @endforeach
    </div>
    <p class="mt-5">{{$produtos->links()}}</p>

</div>
@endsection
