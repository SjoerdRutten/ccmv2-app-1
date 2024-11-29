@aware(['site'])

@if ($site->favicon)
    <link rel="shortcut icon" href="{{ route('frontend::assets.favicon') }}"/>
@endif
