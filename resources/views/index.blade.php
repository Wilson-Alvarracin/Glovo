@extends('layouts.plantilla')

@section('title', 'Index')
@section('content')
<h1> Bienvenidos a la página de comics </h1>

<ul>
    @foreach ($restaurante as $restaurantes)
        <li>{{$restaurantes->id}}<a href="{{route('glovo.show', $restaurantes->id)}}"> {{$restaurantes->titulo}}</a></li>
    @endforeach
</ul>

{{$restaurantes->links()}}
@endsection