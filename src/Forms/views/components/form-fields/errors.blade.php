@@if ($errors->count())
    <ul class="border border-red-500 bg-red-200 text-red-700 rounded p-4 mb-4">
        @@foreach ($errors->all() as $message)
            <li>@{{ $message }}</li>
            @@endforeach
    </ul>
    
@@endif
