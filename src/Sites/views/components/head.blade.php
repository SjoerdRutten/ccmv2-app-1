@props([
    'site',
    'layout',
    'page'
])
<head>
    <x-sites::title/>

    <x-sites::favicon/>
    <x-sites::meta/>
    {{ $meta ?? null }}

    {{ $js ?? null }}
    <x-sites::js/>

    {{ $css ?? null }}
    <x-sites::css/>
</head>