@extends('layouts.master')

@section('title')
    Ajouter une annonce
@endsection

@section('main')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Ajouter une nouvelle annonce</h1>
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

        <form action="{{ route('ads_store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Titre">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="img_url">Image url</label>
                <input type="text" class="form-control" id="img_url" name="img_url" placeholder="Image url">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">CHF</span>
                </div>
                <input type="text" class="form-control" id="price" name="price" placeholder="Prix">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </main>
@endsection
