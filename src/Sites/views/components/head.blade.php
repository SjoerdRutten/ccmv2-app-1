@props([
    'site',
    'layout',
    'page',
    'crmCard',
    'crmCardData',
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