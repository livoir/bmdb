@extends('layout')

@section('title', 'BMDb | Home')

@section('content')


<div class="container m-vh-80">
    @if (session('status'))
    <div class="alert alert-success mt-5">
        {{ session('status') }}
    </div>
    @endif

    {{-- form untuk search movie by title or genre --}}

    <form class="form-inline mt-3" method="get" action=" {{ route('search') }} ">
        <input class="form-control mr-sm-2 my-2 bg-transparent col-4" id="q" name="q" placeholder="Search by Movie Title or Genre" value="{{ request('q') }}">
        <button class="btn btn-dark" type="submit">Search</button>
    </form>

    {{-- Menampilakan data movie yang telah dikirim --}}

    @foreach($movies as $movie)
    <div class="card mb-3 bg-transparent">
        <div class=" row no-gutters">
            <div class="col-md-4">
                <a href=" {{ route('movie', $movie->id) }} ">
                    <img class="picture m-2" src="{{ asset('storage/movies/' . $movie->picture) }}" class="card-img" alt="...">
                </a>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <div class="card-title">

                        {{-- Mengecek apakah user sedang login dan role user adalah member dan movie tersebut sudah disimpan oleh user,
                                lalu untuk memunculkan tombol Unsave --}}

                        @if(Auth::check() && auth()->user()->role_id != 1)
                        @if($movie->isSaved())
                        <form action="{{ route('unsave', $movie->id) }}" method="post">
                            <a href=" {{ route('movie', $movie->id) }} " class="font-weight-bold title text-primary">{{$movie->title}}</a>
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $movie->id }}">
                            <button type="submit" class="btn btn-warning float-right">Unsave</button>
                        </form>

                        {{-- Mengecek apakah user sedang login dan role user adalah member dan movie tersebut tidak disimpan oleh user,
                                lalu untuk memunculkan tombol Save --}}

                        @else
                        <form action="{{ route('save') }}" method="post">
                            @csrf
                            <a href=" {{ route('movie', $movie->id) }} " class="font-weight-bold title text-primary">{{$movie->title}}</a>

                            <input type="hidden" name="id" value="{{ $movie->id }}">
                            <button type="submit" class="btn btn-outline-dark float-right">Save</button>
                        </form>
                        @endif
                        @else
                        <a href=" {{ route('movie', $movie->id) }} " class="font-weight-bold title text-primary">{{$movie->title}}</a>
                        @endif
                    </div>
                    <p class="card-text text-muted">{{$movie->genres->name}}</p>
                    <p class="card-text">{{$movie->description}}</p>
                    <img src="{{ asset('img/star.png') }}" alt="">
                    <span class="font-weight-bold rating">{{$movie->rating}}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Menampilakn link untuk pagination --}}

    <div class="text-center">
        {{ $movies->links() }}
    </div>

</div>



@endsection