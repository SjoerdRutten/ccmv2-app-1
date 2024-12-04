@aware([
    'page',
    'layout',
    'site',
])

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="{{ $layout?->meta_description ?? '' }}">
<meta name="keywords" content="{{ $layout?->meta_keywords ?? '' }}">

<meta property="og:title" content="{{ $layout?->meta_title ?? '' }}">
<meta property="og:description" content="{{ $layout?->meta_description ?? '' }}">
<meta property="og:site_name" content="{{ $site?->name ?? '' }}">
<meta property="og:type" content="website">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no">

<meta name="robots"
      content="{{ $layout?->index ? 'index' : 'noindex' }},{{ $layout?->follow ? 'follow' : 'nofollow' }}">