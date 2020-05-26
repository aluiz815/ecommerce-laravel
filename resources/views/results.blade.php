@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Resultado</h2>
    <div class="row">
        @if(session('status'))
            <h3>{{session('status')}}</h3>
        @endif

    </div>
</div>
@endsection
