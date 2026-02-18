<!-- SEO Meta Content -->
@push('meta')
    <meta name="title" content="{{ $page->meta_title }}" />

    <meta name="description" content="{{ $page->meta_description }}" />

    <meta name="keywords" content="{{ $page->meta_keywords }}" />
@endPush

<!-- Page Layout -->
<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{ $page->meta_title }}
    </x-slot>

    <!-- Page Content -->
    @if (isset($page->editor_type) && $page->editor_type == 'structured')
        @php
            $data = $page->structured_content;
        @endphp

        @if (! empty($data['css']))
            @push ('styles')
                <style>
                    {{ $data['css'] }}
                </style>
            @endpush
        @endif

        @if (! empty($data['html']))
            {!! $data['html'] !!}
        @endif
    @else
        <div class="container mt-8 px-[60px] max-lg:px-8">
            {!! $page->html_content !!}
        </div>
    @endif
</x-shop::layouts>