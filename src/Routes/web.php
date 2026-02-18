<?php

use Edado\AdvancedCMS\Http\Controllers\PageController;  
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {

    Route::controller(PageController::class)->prefix('cms')->group(function () {
        
        Route::post('upload-image', 'uploadImage')->name('admin.cms.upload_image');

        Route::get('create', 'create')->name('admin.cms.create');

        Route::post('create', 'store')->name('admin.cms.store');

        Route::get('edit/{id}', 'edit')->name('admin.cms.edit');
        Route::put('edit/{id}', 'update')->name('admin.cms.update');
        
        Route::delete('delete/{id}', 'delete')->name('admin.cms.delete');
        Route::post('mass-delete', 'massDelete')->name('admin.cms.mass_delete');
    });

});