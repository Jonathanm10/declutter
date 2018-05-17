@extends('layouts.master')

@section('title')
    Liste des annonces
@endsection

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Annonces</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('ads.create') }}" class="btn btn-sm btn-outline-primary">
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
                    <td>
                        <a href="{{ route('ads.edit', $ad->id) }}">{{ $ad->title }}</a>
                    </td>
                    <td>{{ $ad->price }}</td>
                    <td>
                        @foreach ($platforms as $platform)
                            @php ($isPublished = in_array($platform->id, $ad->platforms->pluck('id')->toArray()))

                            <a href="{{ route('ads.toggle_publish', ['id' => $ad->id, 'platform_id' => $platform->id]) }}">
                                {{ $platform->type }}
                            </a>
                            <span class="{{ $isPublished ? 'text-success' : 'text-danger' }}">
                                    @svg('solid/globe')
                            </span>
                            <br/>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('ads.delete', $ad->id) }}" class="ad-delete"
                           data-is-published="{{ count($ad->platforms->pluck('id')->toArray()) > 0 }}">
                            @svg('solid/trash')
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
        const adDeleteLinks = document.querySelectorAll('.ad-delete');
        if (adDeleteLinks) {
          adDeleteLinks.forEach(function (ad) {
            ad.addEventListener('click', (e) => {
              e.preventDefault();
              if (e.currentTarget.getAttribute('data-is-published') === '1') {
                if (confirm("Les annonces publiées seront automatiquement dépubliées, êtes-vous sûr ?")) {
                  window.location = e.currentTarget.href;
                } else {
                  return;
                }
              }
              window.location = e.currentTarget.href;
            });
          });
        }
      });
    </script>
@endpush
