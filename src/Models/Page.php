<?php

namespace Edado\AdvancedCMS\Models;

use Webkul\CMS\Models\Page as BasePage;
use Webkul\CMS\Contracts\Page as PageContract;

class Page extends BasePage
{
    protected $fillable = ['layout', 'editor_type'];

    public $translatedAttributes = [
        'page_title',
        'html_content',
        'meta_title',
        'url_key',
        'meta_keywords',
        'meta_description',
        'structured_content',
    ];
}