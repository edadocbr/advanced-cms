<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->string('editor_type')->default('tinymce')->after('layout');
        });

        Schema::table('cms_page_translations', function (Blueprint $table) {
            $table->json('structured_content')->nullable()->after('html_content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->dropColumn('editor_type');
        });

        Schema::table('cms_page_translations', function (Blueprint $table) {
            $table->dropColumn('structured_content');
        });
    }
};
