<div wire:loading.remove>
    <div class="px-4 sm:px-6 lg:px-8">
        <x-ccm::pages.intro title="E-mail wijzigen">
            <x-slot:actions>
                <x-ccm::buttons.back :href="route('ems::emails::overview')">Terug</x-ccm::buttons.back>
                <x-ccm::buttons.save wire:click="save"></x-ccm::buttons.save>
            </x-slot:actions>
        </x-ccm::pages.intro>

        <x-ccm::tabs.base>
            <x-slot:tabs>
                <x-ccm::tabs.nav-tab :index="0">Basisinformatie</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="1">Inhoud HTML-deel</x-ccm::tabs.nav-tab>
                <x-ccm::tabs.nav-tab :index="2">Inhoud Tekst-deel</x-ccm::tabs.nav-tab>
            </x-slot:tabs>

            <x-ccm::tabs.tab-content :index="0">
                <div class="w-1/2 flex flex-col gap-4">
                    <x-ccm::forms.input name="form.name" wire:model.live="form.name">
                        Naam
                    </x-ccm::forms.input>
                    <x-ccm::forms.select
                            name="form.email_category_id"
                            wire:model.live="form.email_category_id"
                            label="Rubriek"
                    >
                        <option></option>
                        @foreach ($form->categories() AS $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-ccm::forms.select>
                    <x-ccm::forms.input name="form.description" wire:model.live="form.description">
                        Omschrijving
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.sender_email" wire:model.live="form.sender_email">
                        Afzender e-mail
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.sender_name" wire:model.live="form.sender_name">
                        Afzender naam
                    </x-ccm::forms.input>
                    <div class="flex gap-4">
                        <x-ccm::forms.select
                                name="form.recipient_type"
                                wire:model.live="form.recipient_type"
                                label="Ontvanger type"
                        >
                            <option value="CRMFIELD">CRM Veld</option>
                            <option value="TEXT">Tekstveld</option>
                        </x-ccm::forms.select>
                        @if ($this->form->recipient_type === 'CRMFIELD')
                            <x-ccm::forms.select
                                    name="form.recipient_crm_field_id"
                                    wire:model.live="form.recipient_crm_field_id"
                                    label="CRM Veld"
                                    :grow="true"
                            >
                                <option></option>
                                @foreach ($form->emailFields() AS $field)
                                    <option value="{{ $field->id }}">
                                        {{ $field->name }}
                                    </option>
                                @endforeach
                            </x-ccm::forms.select>
                        @else
                            <x-ccm::forms.input name="form.recipient"
                                                wire:model.live="form.recipient"
                                                :grow="true">
                                Ontvanger
                            </x-ccm::forms.input>
                        @endif
                    </div>
                    <x-ccm::forms.input name="form.reply_to" wire:model.live="form.reply_to">
                        Reply to
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.subject" wire:model.live="form.subject">
                        Onderwerp
                    </x-ccm::forms.input>
                    <x-ccm::forms.input name="form.optout_url" wire:model.live="form.optout_url">
                        Uitschrijflink
                    </x-ccm::forms.input>
                    <x-ccm::forms.select
                            name="form.html_type"
                            wire:model.live="form.html_type"
                            label="HTML Editor"
                            :disabled="$this->form->id > 0"
                    >
                        <option value="STRIPO">Stripo</option>
                        <option value="WYSIWYG EDITOR">TinyMce</option>
                        <option value="HTML">Tekstveld</option>
                    </x-ccm::forms.select>
                </div>
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="1">
                @if ($this->form->html_type === 'HTML')
                    <div
                            wire:ignore
                            x-data="{
                                monacoContent: $wire.entangle('form.html'),
                                monacoLanguage: 'html',
                                monacoPlaceholder: true,
                                monacoPlaceholderText: '',
                                monacoLoader: true,
                                monacoFontSize: '15px',
                                monacoId: $id('monaco-editor'),
                                monacoEditor(editor){
                                    editor.onDidChangeModelContent((e) => {
                                        this.monacoContent = editor.getValue();
                                        this.updatePlaceholder(editor.getValue());
                                    });
                                    editor.onDidBlurEditorWidget(() => {
                                        this.updatePlaceholder(editor.getValue());
                                    });
                                    editor.onDidFocusEditorWidget(() => {
                                        this.updatePlaceholder(editor.getValue());
                                   });
                                },
                                updatePlaceholder: function(value) {
                                    if (value == '') {
                                        this.monacoPlaceholder = true;
                                        return;
                                    }
                                    this.monacoPlaceholder = false;
                                },
                                monacoEditorFocus(){
                                    document.getElementById(this.monacoId).dispatchEvent(new CustomEvent('monaco-editor-focused', { monacoId: this.monacoId }));
                                },
                                monacoEditorAddLoaderScriptToHead() {
                                    script = document.createElement('script');
                                    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.39.0/min/vs/loader.min.js';
                                    document.head.appendChild(script);
                                }
                            }"
                            x-init="
                                if(typeof _amdLoaderGlobal == 'undefined'){
                                    monacoEditorAddLoaderScriptToHead();
                                }
                                monacoLoaderInterval = setInterval(function(){
                                    if(typeof _amdLoaderGlobal !== 'undefined'){
                                        // Based on https://jsfiddle.net/developit/bwgkr6uq/ which works without needing service worker. Provided by loader.min.js.
                                        require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.39.0/min/vs' }});
                                        let proxy = URL.createObjectURL(new Blob([` self.MonacoEnvironment = { baseUrl: 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.39.0/min' }; importScripts('https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.39.0/min/vs/base/worker/workerMain.min.js');`], { type: 'text/javascript' }));
                                        window.MonacoEnvironment = { getWorkerUrl: () => proxy };
                                        require(['vs/editor/editor.main'], function() {
                                            monacoTheme = {'base':'vs-dark','inherit':true,'rules':[{'background':'0C1021','token':''},{'foreground':'aeaeae','token':'comment'},{'foreground':'d8fa3c','token':'constant'},{'foreground':'ff6400','token':'entity'},{'foreground':'fbde2d','token':'keyword'},{'foreground':'fbde2d','token':'storage'},{'foreground':'61ce3c','token':'string'},{'foreground':'61ce3c','token':'meta.verbatim'},{'foreground':'8da6ce','token':'support'},{'foreground':'ab2a1d','fontStyle':'italic','token':'invalid.deprecated'},{'foreground':'f8f8f8','background':'9d1e15','token':'invalid.illegal'},{'foreground':'ff6400','fontStyle':'italic','token':'entity.other.inherited-class'},{'foreground':'ff6400','token':'string constant.other.placeholder'},{'foreground':'becde6','token':'meta.function-call.py'},{'foreground':'7f90aa','token':'meta.tag'},{'foreground':'7f90aa','token':'meta.tag entity'},{'foreground':'ffffff','token':'entity.name.section'},{'foreground':'d5e0f3','token':'keyword.type.variant'},{'foreground':'f8f8f8','token':'source.ocaml keyword.operator.symbol'},{'foreground':'8da6ce','token':'source.ocaml keyword.operator.symbol.infix'},{'foreground':'8da6ce','token':'source.ocaml keyword.operator.symbol.prefix'},{'fontStyle':'underline','token':'source.ocaml keyword.operator.symbol.infix.floating-point'},{'fontStyle':'underline','token':'source.ocaml keyword.operator.symbol.prefix.floating-point'},{'fontStyle':'underline','token':'source.ocaml constant.numeric.floating-point'},{'background':'ffffff08','token':'text.tex.latex meta.function.environment'},{'background':'7a96fa08','token':'text.tex.latex meta.function.environment meta.function.environment'},{'foreground':'fbde2d','token':'text.tex.latex support.function'},{'foreground':'ffffff','token':'source.plist string.unquoted'},{'foreground':'ffffff','token':'source.plist keyword.operator'}],'colors':{'editor.foreground':'#F8F8F8','editor.background':'#0C1021','editor.selectionBackground':'#253B76','editor.lineHighlightBackground':'#FFFFFF0F','editorCursor.foreground':'#FFFFFFA6','editorWhitespace.foreground':'#FFFFFF40'}};
                                            monaco.editor.defineTheme('blackboard', monacoTheme);
                                            document.getElementById(monacoId).editor = monaco.editor.create($refs.monacoEditorElement, {
                                                value: monacoContent,
                                                theme: 'blackboard',
                                                fontSize: monacoFontSize,
                                                lineNumbersMinChars: 3,
                                                automaticLayout: true,
                                                language: monacoLanguage
                                            });
                                            monacoEditor(document.getElementById(monacoId).editor);
                                            document.getElementById(monacoId).addEventListener('monaco-editor-focused', function(event){
                                                document.getElementById(monacoId).editor.focus();
                                            });
                                            updatePlaceholder(document.getElementById(monacoId).editor.getValue());
                                        });
                                        clearInterval(monacoLoaderInterval);
                                        monacoLoader = false;
                                    }
                                }, 5);
                            "
                            :id="monacoId"
                            class="flex flex-col items-center relative justify-start w-full bg-[#0C1021] min-h-[500px] pt-3 h-[500px]"
                    >
                        <div x-show="monacoLoader"
                             class="absolute inset-0 z-20 flex items-center justify-center w-full h-[500px] duration-1000 ease-out">
                            <svg class="w-4 h-4 text-gray-400 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <div x-show="!monacoLoader" class="relative z-10 w-full h-full">
                            <div x-ref="monacoEditorElement" class="w-full h-full text-lg"></div>
                            <div x-ref="monacoPlaceholderElement" x-show="monacoPlaceholder"
                                 @click="monacoEditorFocus()" :style="'font-size: ' + monacoFontSize"
                                 class="w-full text-sm font-mono absolute z-50 text-gray-500 ml-14 -translate-x-0.5 mt-0.5 left-0 top-0"
                                 x-text="monacoPlaceholderText"></div>
                        </div>
                    </div>

                    {{--                    <x-ccm::forms.textarea name="text" wire:model="form.html" rows="30"></x-ccm::forms.textarea>--}}
                @elseif ($this->form->html_type === 'STRIPO')
                    <x-ccm::forms.textarea name="text" wire:model="form.html" rows="30"></x-ccm::forms.textarea>
                @elseif ($this->form->html_type === 'WYSIWYG EDITOR')
                    <x-ccm::forms.textarea name="text" wire:model="form.html" rows="30"></x-ccm::forms.textarea>
                @else
                    Onbekend HTML_TYPE: {{ $this->form->html_type }}
                @endif
            </x-ccm::tabs.tab-content>
            <x-ccm::tabs.tab-content :index="2">
                <x-ccm::forms.textarea name="text" wire:model="form.text" rows="30"></x-ccm::forms.textarea>
            </x-ccm::tabs.tab-content>
        </x-ccm::tabs.base>
    </div>
</div>
