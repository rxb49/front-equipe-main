@extends('layouts.app')

@section('title', ' - Membre Equipe')

@section('custom-css')
    <link href="/css/home.css" rel="stylesheet"/>
@endsection

    <ul>
        @foreach($membres as $membre)
            <li>{{ $membre->nom,prenom }}</li>
        @endforeach
    </ul>

@section('content')

@endsection
