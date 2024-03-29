@extends('layout')

@section('title', 'Profile')

@section('content')

<div class="container m-vh-80">

    @if (session('status'))
    <div class="alert alert-success mt-5">
        {{ session('status') }}
    </div>
    @endif

    {{-- Menampilkan data user --}}
    <div class="media border rounded mt-5 p-4">
        <img src="{{ asset('storage/users/' . $user->picture) }}" class="mr-3 rounded profile-pic" alt="...">
        <div class="media-body">
            <div class="mt-3 font-weight-bold title">{{ $user->name }}

                {{-- Mengecek apakah profile yang dibuka adalah profile dari user yang sedang log in --}}
                @if($user->loggedInUser())
                <a href="{{ route('edit-user', auth()->user()->id) }}" class="btn btn-primary float-right">Update Profile</a>
                @endif
            </div>
            <div class="font-weight-normal mt-2">{{ $user->email }}</div>
            <div class="font-weight-normal mt-2">{{ $user->address }}</div>
        </div>
    </div>

    {{-- Mengecek apakah profile yang dibuka adalah bukan profile dari user yang sedang log in --}}
    @if(!$user->loggedInUser())
    <div class="border rounded bg-light">
        {{-- Form untuk mengirimkan pesan --}}
        <form action="{{ route('send-message', $user->id) }}" method="post">
            <div class="m-4">
                @csrf
                @method('put')
                <input type="hidden" name="receiver" value="{{ $user->id }}">
                <textarea class="form-control" id="message" name="message" placeholder="Message..." rows="6"></textarea>
                <button type="submit" class="btn btn-primary mt-3">Send Message</button>
            </div>
        </form>
    </div>
    @endif
</div>

@endsection