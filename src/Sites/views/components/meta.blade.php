@aware(['page', 'layout'])

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="{{ $layout?->meta_description ?? '' }}">
<meta name="keywords" content="{{ $layout?->meta_keywords ?? '' }}">
<meta name="robots"
      content="{{ $layout?->index ? 'index' : 'noindex' }},{{ $layout?->follow ? 'follow' : 'nofollow' }}">