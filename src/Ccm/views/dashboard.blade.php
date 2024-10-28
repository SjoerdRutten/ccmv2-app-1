@extends('ccm::layouts.app')

@section('content')
    <x-ccm::cards.cards cols="4">
        @if (Auth::user()->isAdmin)
            <x-ccm::dashboard.typesense-card/>
        @endif
    </x-ccm::cards.cards>
@endsection