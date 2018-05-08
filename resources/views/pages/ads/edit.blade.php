@extends('layouts.master')

@section('title')
    Editer {{ $ad->title }}
@endsection

@section('main')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Editer {{ $ad->title }}</h1>
        </div>

        {!! Form::model($ad, ['route'=> ['ads.update', $ad->id], 'method' => 'patch']) !!}
            @include('pages.ads.form', ['submitButtonText' => 'Edit'])
        {!! Form::close() !!}
    </main>
@endsection
