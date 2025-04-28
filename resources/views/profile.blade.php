@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
    <h1 class="h4 mb-4">Edit Profil</h1>
    <hr>
    @livewire('profile.update-profile-information-form')

    <hr>
    @livewire('profile.update-password-form')
@endsection
