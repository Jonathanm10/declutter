@extends('layouts.master')

@section('title')
    Liste des annonces
@endsection

@section('main')
    <div class="grid grid--center">
        <div class="grid__item md-w-1/2">
            <h1>Annonces</h1>
            <table>
                <thead>
                <tr>
                    <th>Titre</th>
                    <th>Prix</th>
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
                            <a href="#">Edit</a>
                            <a href="#">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection