@aware(['page', 'layout'])

@foreach ($layout->siteImportsJs AS $import)
    <script src="{{ route('frontend::assets.siteImport', ['siteImport' => $import, 'name' => $import->fileName]) }}"></script>
@endforeach