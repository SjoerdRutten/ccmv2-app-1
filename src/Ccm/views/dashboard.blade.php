@extends('ccm::layouts.app')

@section('content')
    <x-ccm::cards.cards cols="4">
        {{--        <x-ccm::dashboard.typesense-collections-card/>--}}
        {{--        @if (Auth::user()->isAdmin)--}}
        {{--            <x-ccm::dashboard.typesense-memory-card/>--}}
        {{--        @endif--}}
    </x-ccm::cards.cards>
@endsection