@extends('ccm::layouts.app')

@section('content')
    <x-ccm::cards.cards cols="4">
        @if (Auth::user()->isAdmin)
            <x-ccm::dashboard.scheduled-tasks-logs-card/>
            <x-ccm::dashboard.queue-card/>
            <x-ccm::dashboard.servers-card/>
        @endif
    </x-ccm::cards.cards>
@endsection