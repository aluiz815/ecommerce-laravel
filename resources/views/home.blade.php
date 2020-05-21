@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Produtos</h2>
    <div class="row">
    @foreach ($produtos as $produto)

    <div class="col-4">
     <div class="card">
         <img class="card-img-top" src="{{ asset('default.jpg') }}" alt="Card image cap">
         <div class="card-body">
             <h4 class="card-title">Title</h4>
             <p class="card-text">Text</p>
         </div>
         <div class="card-body">
             <a href="#" class="card-link">Adicionar ao carrinho</a>
         </div>
     </div>
    </div>

    @endforeach
    </div>
</div>
@endsection
