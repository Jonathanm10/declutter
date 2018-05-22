@extends('layouts.master')

@section('title')
    Ajouter une annonce
@endsection

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ajouter une nouvelle annonce</h1>
    </div>

    {!! Form::open(['action' => 'AdController@store']) !!}
    @include('pages.ads.form', ['submitButtonText' => 'Ajouter'])
    {!! Form::close() !!}
@endsection
