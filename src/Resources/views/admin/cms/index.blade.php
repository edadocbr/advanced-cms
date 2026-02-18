<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.cms.index.title')
    </x-slot>

    <div class="flex items-center justify-between">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('admin::app.cms.index.title')
        </p>

        <div class="flex items-center gap-x-2.5">
            <!-- Export Modal -->
            <x-admin::datagrid.export :src="route('admin.cms.index')" />

            <!-- Create New Pages Button -->
            @if (bouncer()->hasPermission('cms.create'))
                <x-admin::form method="GET" action="{{ route('admin.cms.create') }}">
                    <x-admin::modal>
                        
                        <x-slot:toggle>
                            <button type="button" class="primary-button">
                                @lang('admin::app.cms.index.create-btn')
                            </button>
                        </x-slot>

                        <x-slot:header>
                            <p class="text-lg font-bold text-gray-800 dark:text-white">
                                @lang('advanced_cms::app.cms.index.select-type-editor')
                            </p>
                        </x-slot>

                        <x-slot:content>
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('advanced_cms::app.cms.index.editor-type')
                                </x-admin::form.control-group.label>
                                <x-admin::form.control-group.control
                                    type="select"
                                    name="editor_type"
                                    id="editor_type"
                                    class="cursor-pointer"
                                    value="tinymce"
                                >
                                    <option value="tinymce">@lang('advanced_cms::app.cms.index.tinymce')</option>
                                    
                                    <option value="structured">@lang('advanced_cms::app.cms.index.structured')</option>
                                </x-admin::form.control-group.control>
                            </x-admin::form.control-group>
                        </x-slot>

                        <x-slot:footer>
                            <div class="flex justify-end">
                                <button type="submit" class="primary-button">
                                    @lang('advanced_cms::app.cms.index.continue')
                                </button>
                            </div>
                        </x-slot:footer>

                    </x-admin::modal>
                </x-admin::form>
            @endif
        </div>
    </div>

    {!! view_render_event('bagisto.admin.cms.pages.list.before') !!}

    <x-admin::datagrid :src="route('admin.cms.index')" />
    
    {!! view_render_event('bagisto.admin.cms.pages.list.after') !!}

</x-admin::layouts>
