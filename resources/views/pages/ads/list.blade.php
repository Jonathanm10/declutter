@extends('layouts.master')

@section('title')
    Liste des annonces
@endsection

@section('main')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Annonces</h1>

            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('ads_create') }}" class="btn btn-sm btn-outline-secondary">
                    @svg('solid/plus')
                    Ajouter
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Titre</th>
                    <th>Prix (CHF)</th>
                    <th>Plateforme(s)</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ads as $ad)
                    <tr>
                        <td>{{ $ad->title }}</td>
                        <td>{{ $ad->price }}</td>
                        <td>
                            @foreach ($ad->platforms as $platform)
                                {{ $platform->type }}
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('ads_edit', $ad->id) }}">Edit</a>
                            <a href="{{ route('ads_delete', $ad->id) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection