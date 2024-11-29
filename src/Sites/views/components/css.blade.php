@aware(['page', 'layout'])

@foreach ($layout->siteImportsCss AS $import)
    <link href="{{ route('frontend::assets.siteImport', ['siteImport' => $import, 'name' => $import->fileName]) }}"
          rel="stylesheet">
@endforeach