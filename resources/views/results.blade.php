@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Resultado</h2>
    <div class="row">
        @if(session()->has('statusAprovado'))
            <div class="alert alert-success container" role="alert">
                <h3>{{session('statusAprovado')}}</h3>
            </div>

        @elseif(session()->has('statusError'))
            <div class="alert alert-danger container" role="alert">
                <h3>{{session('statusError')}}</h3>
            </div>

        @endif

    </div>
</div>
@endsection
