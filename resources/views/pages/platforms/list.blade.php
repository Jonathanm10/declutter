@extends('layouts.master')

@section('title')
    Liste des plateformes
@endsection

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Plateformes</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>Type</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($platforms as $platform)
                <tr>
                    <td>
                        <a href="{{ route('platforms.edit', $platform->id) }}">
                            {{ $platform->type }}
                        </a>
                    </td>
                    <td>
                        <a class="platform-remove-conf" href="{{ route('platforms.remove_config', $platform->id) }}"
                           data-has-ads="{{ count($platform->ads) > 0 }}">
                            Supprimer la configuration
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        new window.ConditionallyAlert(
          '.platform-remove-conf',
          'data-has-ads',
          'La plateforme contient des annonces. Ceci dépubliera toutes celles-ci. Êtes-vous sûr ?'
        );
      });
    </script>
@endpush
