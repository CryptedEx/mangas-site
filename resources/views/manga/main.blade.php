@extends('layouts.app')

@section('title', $manga->name)

@section('content')

    <div class="row bg-dark-1 p-4 mb-4">
        <div class="col-md-3">
            <img src="{{ asset($manga->cover) }}" alt="cover" class="img-fluid main-cover">
        </div>
        <div class="col-md-9">
            <h1>{{ $manga->name }}</h1>
            <h4>Author: {{ $manga->author }}</h4>
            <div class="mb-1">
                <small>
                    Genres: <br>
                    @foreach ($manga->genres as $genre_key => $genre)
                        <a href="{{ route('app.genre', $genre_key) }}" class="badge black-hover bg-secondary rounded-pill text-decoration-none" >{{ $genre }}</a>
                    @endforeach
                </small>
            </div>
            <div>
                <small>Description:</small>
            </div>
            <div class="px-3 mb-1">{{ $manga->desc }}</div>
            <div class="text-success-1">
                {{ $manga->ongoing ? 'Ongoing' : 'Finished' }}
            </div>
            <small>Chapters: {{ $manga->chapters->count() }}</small><br>
            <div class="mb-3">
                <small>Scanlator:
                    @if (isset($manga->scanlator))
                        <a href="{{ route('app.scan.view', $manga->scanlator) }}" class="text-secondary">{{ $manga->scanlator->name }}</a>
                    @else
                        <span class="text-warning">None</span>
                    @endif
                </small>
            </div>
            @can('request', [\App\Models\Request::class, $manga])
                <form action="{{ route('request.create', $manga->id) }}" method="post">
                    @csrf
                    <button class="btn {{ is_null($requested) ? 'btn-primary' : 'btn-secondary' }}" {{ is_null($requested) ? '' : 'disabled' }} type="submit">Request</button>
                </form>
            @endcan
            @auth
                <form action="{{ route('favorite.create', $manga) }}" method="post" class="mt-2">
                    @csrf

                    @if (\App\Models\Favorite::isMangaOnFavorites(Auth::id(), $manga->id))
                        @method('delete')
                        <button class="btn btn-danger text-light" formaction="{{ route('favorite.remove', $manga) }}" type="submit">Remove from Favorites</button>
                    @else
                        <button class="btn btn-warning text-light" type="submit">Favorite</button>
                    @endif
                </form>
            @endauth
        </div>
    </div>

    <div class="bg-dark-1 p-4 mb-4">
        @foreach ($manga->chapters as $chapter)
                <a href="{{ route('app.manga.view', ['id' => $manga->id, 'chapter_order' => $chapter->order]) }}" class="d-block bg-light w-100 my-2 p-2 text-dark text-decoration-none">
                    <div class="row">
                        <div class="d-flex col-6 justify-content-start">
                            {{ $chapter->name }}
                        </div>
                        <div class="d-flex col-6 justify-content-end">
                            Uploaded at: {{ $chapter->created_at }}
                        </div>
                    </div>
                </a>
        @endforeach
    </div>

@endsection