<x-admin::layouts>
    <!--Page title -->
    <x-slot:title>
        @lang('admin::app.cms.create.title')
    </x-slot>

    <v-create-cms-page></v-create-cms-page>

    @pushOnce('scripts')
        <script 
            type="text/x-template" 
            id="v-static-content-cms-template"
        >

            <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
                <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                    <div class="mb-2.5 flex items-center justify-between gap-x-2.5">
                        <div class="flex flex-col gap-1">
                            <p class="text-base font-semibold text-gray-800 dark:text-white">
                                @lang('admin::app.settings.themes.edit.static-content')
                            </p>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-300">
                                @lang('admin::app.settings.themes.edit.static-content-description')
                            </p>
                        </div>

                        <div
                            class="flex gap-2.5"
                            v-if="isHtmlEditorActive"
                        >
                            <!-- Hidden Input Filed for upload images -->
                            <label
                                class="secondary-button"
                                for="cms_image"
                            >
                                @lang('admin::app.settings.themes.edit.add-image-btn')
                            </label>

                            <input 
                                type="file"
                                name="cms_image"
                                id="cms_image"
                                class="hidden"
                                accept="image/*"
                                ref="cms_image"
                                label="Image"
                                @change="storeImage($event)"
                            >
                        </div>

                    </div>

                    <div class="pt-4 text-center text-sm font-medium text-gray-500">
                        <div class="tabs">
                            <div class="mb-4 flex gap-4 border-b-2 pt-2 max-sm:hidden">
                                <!-- HTML Tab Header -->
                                <p @click="switchEditor('v-html-editor-cms', 1)">
                                    <div                                    
                                        class="cursor-pointer px-2.5 pb-3.5 text-base font-medium transition"
                                        :class="inittialEditor == 'v-html-editor-cms' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 dark:text-gray-300'"
                                    >
                                        @lang('admin::app.settings.themes.edit.html')
                                    </div>
                                </p>
                               
                                <!-- CSS Tab Editor -->
                                <p @click="switchEditor('v-css-editor-cms', 0);">
                                    <div
                                        class="cursor-pointer px-2.5 pb-3.5 text-base font-medium transition"
                                        :class="inittialEditor == 'v-css-editor-cms' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 dark:text-gray-300'"
                                    >
                                        @lang('admin::app.settings.themes.edit.css')
                                    </div>
                                </p>
                                
                                <!-- Preview Tab Editor -->
                                <p @click="switchEditor('v-preview-cms', 0);">
                                    <div
                                        class="cursor-pointer px-2.5 pb-3.5 text-base font-medium transition"
                                        :class="inittialEditor == 'v-preview-cms' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 dark:text-gray-300'"
                                    >
                                        @lang('admin::app.settings.themes.edit.preview')
                                    </div>
                                </p>
                               
                            </div>
                        </div>
                    </div>

                    <input 
                        type="hidden" 
                        name="structured_content[html]" 
                        :value="options.html"
                    >

                    <input 
                        type="hidden" 
                        name="structured_content[css]" 
                        :value="options.css"
                    >

                    <KeepAlive class="[&>*]:dark:bg-gray-900 [&>*]:dark:!text-white">
                        <component
                            :is="inittialEditor"
                            ref="editor"
                            @editor-data="editorData"
                            :options="options"
                        ></component>
                    </KeepAlive>
                </div>
            </div>
        </script>

         <!-- Html Editor Template -->
        <script 
            type="text/x-template" 
            id="v-html-editor-cms-template"
        >
            <div ref="html"></div>
        </script>

        <!-- Css Editor Template -->
        <script 
            type="text/x-template" 
            id="v-css-editor-cms-template"
        >
            <div ref="css"></div>
        </script>

        <!-- Static Content Previewer -->
        <script 
            type="text/x-template" 
            id="v-preview-cms-template"
        >
            <div v-html="getPreviewContent()"></div>
        </script>

        <script type="text/x-template" id="v-create-cms-page-template">
            <!--Create Page Form -->
            <x-admin::form
                :action="route('admin.cms.store')"
                enctype="multipart/form-data"
            >

                {!! view_render_event('bagisto.admin.cms.pages.create.create_form_controls.before') !!}

                <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
                    <p class="text-xl font-bold text-gray-800 dark:text-white">
                        @lang('admin::app.cms.create.title')
                    </p>


                    <div class="flex items-center gap-x-2.5">
                        <!-- Back Button -->
                        <a
                            href="{{ route('admin.cms.index') }}"
                            class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800"
                        >
                            @lang('admin::app.account.edit.back-btn')
                        </a>

                        <!--Save Button -->
                        <button
                            type="submit"
                            class="primary-button"
                        >
                            @lang('admin::app.cms.create.save-btn')
                        </button>
                    </div>
                </div>

                <!-- body content -->
                <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
                    <!-- Left sub-component -->
                    <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">

                        {!! view_render_event('bagisto.admin.cms.pages.create.card.description.before') !!}

                        <input type="hidden" name="editor_type" value="{{ request('editor_type', 'tinymce') }}">

                        @if (request('editor_type') == 'structured')
                            <v-static-content-cms></v-static-content-cms>
                        @else
                            <!--Content -->
                            <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                                <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                                    @lang('admin::app.cms.create.description')
                                </p>

                                <!-- Html Content -->
                                <x-admin::form.control-group class="!mb-0">
                                    <x-admin::form.control-group.label class="required">
                                        @lang('admin::app.cms.create.content')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="textarea"
                                        id="content"
                                        name="html_content"
                                        rules="required"
                                        :value="old('html_content')"
                                        :label="trans('admin::app.cms.create.content')"
                                        :placeholder="trans('admin::app.cms.create.content')"
                                        :tinymce="true"
                                        :prompt="core()->getConfigData('general.magic_ai.content_generation.cms_page_content_prompt')"
                                    />

                                    <x-admin::form.control-group.error control-name="html_content" />
                                </x-admin::form.control-group>
                            </div>
                        @endif                        

                        {!! view_render_event('bagisto.admin.cms.pages.create.card.description.after') !!}

                        {!! view_render_event('bagisto.admin.cms.pages.create.card.seo.before') !!}

                        <!-- SEO Input Fields -->
                        <div class="box-shadow rounded bg-white p-4 dark:bg-gray-900">
                            <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                                @lang('admin::app.cms.create.seo')
                            </p>

                            <!-- SEO Title & Description Blade Component -->
                            <x-admin::seo/>

                            <!-- Meta Title -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label>
                                    @lang('admin::app.cms.create.meta-title')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="text"
                                    id="meta_title"
                                    name="meta_title"
                                    :value="old('meta_title')"
                                    :label="trans('admin::app.cms.create.meta-title')"
                                    :placeholder="trans('admin::app.cms.create.meta-title')"
                                />

                                <x-admin::form.control-group.error control-name="meta_title" />
                            </x-admin::form.control-group>

                            <!-- URL Key -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('admin::app.cms.create.url-key')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="text"
                                    id="url_key"
                                    name="url_key"
                                    rules="required"
                                    :value="old('url_key')"
                                    :label="trans('admin::app.cms.create.url-key')"
                                    :placeholder="trans('admin::app.cms.create.url-key')"
                                />

                                <x-admin::form.control-group.error control-name="url_key" />
                            </x-admin::form.control-group>

                            <!-- Meta Keywords -->
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label>
                                    @lang('admin::app.cms.create.meta-keywords')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="textarea"
                                    id="meta_keywords"
                                    name="meta_keywords"
                                    :value="old('meta_keywords')"
                                    :label="trans('admin::app.cms.create.meta-keywords')"
                                    :placeholder="trans('admin::app.cms.create.meta-keywords')"
                                />

                                <x-admin::form.control-group.error control-name="meta_keywords" />
                            </x-admin::form.control-group>

                            <!-- Meta Description -->
                            <x-admin::form.control-group class="!mb-0">
                                <x-admin::form.control-group.label>
                                    @lang('admin::app.cms.create.meta-description')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="textarea"
                                    id="meta_description"
                                    name="meta_description"
                                    :value="old('meta_description')"
                                    :label="trans('admin::app.cms.create.meta-description')"
                                    :placeholder="trans('admin::app.cms.create.meta-description')"
                                />

                                <x-admin::form.control-group.error control-name="meta_description" />
                            </x-admin::form.control-group>
                        </div>

                        {!! view_render_event('bagisto.admin.cms.pages.create.card.seo.after') !!}
                    </div>

                    <!-- Right sub-component -->
                    <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">
                        <!-- General -->

                        {!! view_render_event('bagisto.admin.cms.pages.create.card.accordion.general.before') !!}

                        <x-admin::accordion>
                            <x-slot:header>
                                <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                    @lang('admin::app.cms.create.general')
                                </p>
                            </x-slot>

                            <x-slot:content>
                                <!-- Page Title -->
                                <x-admin::form.control-group>
                                    <x-admin::form.control-group.label class="required">
                                        @lang('admin::app.cms.create.page-title')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="text"
                                        id="page_title"
                                        name="page_title"
                                        rules="required"
                                        :value="old('page_title')"
                                        :label="trans('admin::app.cms.create.page-title')"
                                        :placeholder="trans('admin::app.cms.create.page-title')"
                                    />

                                    <x-admin::form.control-group.error control-name="page_title" />
                                </x-admin::form.control-group>

                                <!-- Select Channels -->
                                <x-admin::form.control-group.label class="required">
                                    @lang('admin::app.cms.create.channels')
                                </x-admin::form.control-group.label>

                                @foreach(core()->getAllChannels() as $channel)
                                    <x-admin::form.control-group class="!mb-2 flex select-none items-center gap-2.5 last:!mb-0">
                                        <x-admin::form.control-group.control
                                            type="checkbox"
                                            :id="'channels_' . $channel->id"
                                            name="channels[]"
                                            rules="required"
                                            :value="$channel->id"
                                            :for="'channels_' . $channel->id"
                                            :label="trans('admin::app.cms.create.channels')"
                                        />

                                        <label
                                            class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                            for="channels_{{ $channel->id }}"
                                            v-pre
                                        >
                                            {{ core()->getChannelName($channel) }}
                                        </label>
                                    </x-admin::form.control-group>
                                @endforeach

                                <x-admin::form.control-group.error control-name="channels[]" />
                            </x-slot>
                        </x-admin::accordion>

                        {!! view_render_event('bagisto.admin.cms.pages.create.card.accordion.general.after') !!}

                    </div>
                </div>

                {!! view_render_event('bagisto.admin.cms.pages.create.create_form_controls.after') !!}

            </x-admin::form>
        </script>

        <script type="module">
            app.component('v-create-cms-page', {
                template: '#v-create-cms-page-template',
            });

            @if (request('editor_type') == 'structured')
            app.component('v-static-content-cms', {
                template: '#v-static-content-cms-template',

                data() {
                    return {
                        inittialEditor: 'v-html-editor-cms',

                        options: { html: '', css: '' },

                        isHtmlEditorActive: true,
                    };
                },

                created() {
                    if (this.options === null) {
                        this.options = { html: '', css: '' };
                    }  
                },

                mounted() {
                    this.applydarkColor();
                },

                methods: {
                    switchEditor(editor, isActive) {
                        this.inittialEditor = editor;

                        this.isHtmlEditorActive = isActive;

                        this.$nextTick(() => {
                            this.applydarkColor();
                            if (editor == 'v-preview-cms') {
                                this.$refs.editor.review = this.options;
                            }
                        });
                    },

                    editorData(value) {
                        if (value.html) {
                            this.options.html = value.html;
                        } else {
                            this.options.css = value.css;
                        } 
                        
                    },

                    storeImage($event) {
                        let imageInput = this.$refs.cms_image;

                        if (imageInput.files == undefined) {
                            return;
                        }

                        const validFiles = Array.from(imageInput.files).every(file => file.type.includes('image/'));

                        if (! validFiles) {
                            this.$emitter.emit('add-flash', {
                                type: 'warning',
                                message: '@lang('admin::app.settings.themes.edit.image-upload-message')'
                            });

                            imageInput.value = '';

                            return;
                        }

                        imageInput.files.forEach((file, index) => {
                            this.$refs.editor.storeImage($event);
                        });
                    },

                    applydarkColor() {
                        this.$nextTick(() => {
                            const gutters = this.$el.querySelector('.CodeMirror-gutters');
                            if (gutters) gutters.classList.add('dark:bg-gray-900', 'dark:!text-white');
                        });
                    },
                },
            });
            @endif
        </script>

        <!-- Html Editor Component -->
        <script type="module">
            @if (request('editor_type') == 'structured')
            app.component('v-html-editor-cms', {
                template: '#v-html-editor-cms-template',
                
                data() {
                    return {
                        options: {
                            html: '', 
                        },
                        cursorPointer: {},
                    };
                },

                created() {
                    this.initHtmlEditor();

                    this.$emitter.on('change-theme', (theme) => this._html.setOption('theme', (theme === 'dark') ? 'ayu-dark' : 'default'));
                },

                methods: {
                    initHtmlEditor() {
                        this.$nextTick(() => {
                            this.options.html = SimplyBeautiful().html(this.options.html);

                            this._html = new CodeMirror(this.$refs.html, {
                                lineNumbers: true,
                                tabSize: 4,
                                lineWrapping: true,
                                lineWiseCopyCut: true,
                                value: this.options.html,
                                mode: 'htmlmixed',
                                theme: document.documentElement.classList.contains('dark') ? 'ayu-dark' : 'default',
                            });

                            this._html.on('changes', (e) => {
                                this.options.html = this._html.getValue();

                                this.cursorPointer = e.getCursor();
                                
                                this.$emit('editorData', this.options);
                            });
                        });
                    },

                    storeImage($event) {
                        let selectedImage = $event.target.files[0];

                        if (! selectedImage) {
                            return;
                        }

                        const allowedImageTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];

                        if (! allowedImageTypes.includes(selectedImage.type)) {
                            return;
                        }

                        let formData = new FormData();

                        formData.append('image', selectedImage);

                        this.$axios.post('{{ route('admin.cms.upload_image') }}', formData)
                            .then((response) => {
                                let editor = this._html.getDoc();

                                let cursorPointer = editor.getCursor();

                                editor.replaceRange(`<img class="lazy" data-src="${response.data}">`, {
                                    line: cursorPointer.line, ch: cursorPointer.ch
                                });

                                editor.setCursor({
                                    line: cursorPointer.line, ch: cursorPointer.ch + response.data.length
                                });
                            })
                            .catch((error) => {
                                if (error.response.status == 422) {
                                    this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.message });
                                }
                            });
                    },
                },
            });
            @endif
        </script>

        <!-- Css Editor Component -->
        <script type="module">
            @if (request('editor_type') == 'structured')
            app.component('v-css-editor-cms', {
                template: '#v-css-editor-cms-template',

                data() {
                    return {
                        options: {
                            css: '', 
                        },
                    };                    
                },

                created() {
                    this.initCssEditor();

                    this.$emitter.on('change-theme', (theme) => this._css.setOption('theme', (theme === 'dark') ? 'ayu-dark' : 'default'));
                },

                methods: {
                    initCssEditor() {
                        this.$nextTick(() => {
                            this.options.css = SimplyBeautiful().css(this.options.css);

                            this._css = new CodeMirror(this.$refs.css, {
                                lineNumbers: true,
                                lineWrapping: true,
                                tabSize: 4,
                                lineWiseCopyCut: true,
                                value: this.options.css,
                                mode: 'css',
                                theme: document.documentElement.classList.contains('dark') ? 'ayu-dark' : 'default',
                            });

                            this._css.on('changes', () => {
                                this.options.css = this._css.getValue();

                                this.$emit('editorData', this.options);
                            });
                        });
                    },
                },
            });
            @endif
        </script>

        <!-- Static Content Previewer -->
        <script type="module">
            @if (request('editor_type') == 'structured')
            app.component('v-preview-cms', {
                template: '#v-preview-cms-template',

                props: ['options'],

                methods: {
                    getPreviewContent() {
                        let html = this.options.html.slice();

                        html = html.replaceAll('src=""', '').replaceAll('data-src', 'src').replaceAll('src="storage/theme/', "src=\"{{ config('app.url') }}/storage/theme/").replaceAll('src="storage/cms_structured/', `src="{{ config('app.url') }}/storage/cms_structured/`);;

                        return html + '<style type=\"text/css\">' +   this.options.css + '</style>';
                    },
                },
            });
            @endif
        </script>

        @if (request('editor_type') === 'structured')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/codemirror.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/xml/xml.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/htmlmixed/htmlmixed.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/css/css.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/simply-beautiful@latest/dist/index.min.js"></script>
        @endif
    @endPushOnce

    @if (request('editor_type') === 'structured')
        @pushOnce('styles')
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/codemirror.css">
            <link rel="stylesheet" href="https://codemirror.net/5/theme/ayu-dark.css">
        @endPushOnce
    @endif
</x-admin::layouts>