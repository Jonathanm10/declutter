@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    {!! Form::label('title', 'Titre') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Description') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('img_url', 'Image url') !!}
    {!! Form::text('img_url', null, ['class' => 'form-control']) !!}
</div>
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text">CHF</span>
    </div>
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>
{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
