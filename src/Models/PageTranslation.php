<?php

namespace Edado\AdvancedCMS\Models;

use Webkul\CMS\Models\PageTranslation as BasePageTranslation;
use Webkul\CMS\Contracts\PageTranslation as PageTranslationContract;

class PageTranslation extends BasePageTranslation
{

    protected $fillable = [
        'page_title',
        'url_key',
        'html_content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'locale',
        'cms_page_id',
        'structured_content'
    ];

    protected $casts = [
        'structured_content' => 'array',
    ];
}