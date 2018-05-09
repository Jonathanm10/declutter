@extends('layouts.master')

@section('title')
    Editer la configuration de {{ $platform->type }}
@endsection

@section('main')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
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

        {!! Form::open(['route'=> ['platforms.update', $platform->id], 'method' => 'patch']) !!}
            @foreach ($formFields as $formField)
                <div class="form-group">
                    {!! Form::label($formField['name'], $formField['label']) !!}
                    @php
                        $form = "Form::{$formField['type']}";
                        if ($formField['type'] === 'password') {
                            echo $form($formField['name'], ['class' => 'form-control']);
                        } else {
                            echo $form($formField['name'], $platform->config[$formField['name']], ['class' => 'form-control']);
                        }
                    @endphp
                </div>
            @endforeach
            {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </main>
@endsection
