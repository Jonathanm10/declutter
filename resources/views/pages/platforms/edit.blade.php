@extends('layouts.master')

@section('title')
    Editer la configuration de {{ $platform->type }}
@endsection

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Editer la configuration de {{ $platform->type }}</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(['route'=> ['platforms.update', $platform], 'method' => 'patch']) !!}
        @foreach ($formFields as $formField)
            <div class="form-group">
                {!! Form::label($formField['name'], $formField['label']) !!}
                @if ($formField['type'] === 'password')
                    {!! Form::password($formField['name'], ['class' => 'form-control']) !!}
                @else
                    {!! Form::{$formField['type']}($formField['name'], $platform->config[$formField['name']], ['class' => 'form-control']) !!}
                @endif
            </div>
        @endforeach
        {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection
