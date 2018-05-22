@extends('layouts.master')

@section('title')
    Éditer {{ $ad->title }}
@endsection

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Éditer {{ $ad->title }}</h1>
    </div>

    {!! Form::model($ad, ['route'=> ['ads.update', $ad], 'method' => 'patch']) !!}
    @include('pages.ads.form', ['submitButtonText' => 'Éditer'])
    {!! Form::close() !!}
@endsection
