@extends('layouts.plantilla')

@section('title', 'Index')
@section('content')
<h1> Bienvenidos a la página de comics </h1>

<ul>
    @foreach ($comic as $comics)
        <li>{{$comics->id}}<a href="{{route('comics.show', $comics->id)}}"> {{$comics->titulo}}</a></li>
    @endforeach
</ul>

{{$comic->links()}}
@endsection