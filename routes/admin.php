<?php

use App\Http\Controllers\Admin\TelCompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::get('/', ['as' => 'dashboard.index', 'uses' => 'DashboardController@getIndex']);
Route::resource('article', 'ArticleController');
Route::get('php-info', function(){
    echo phpinfo();
});
Route::get('translate/article/{id}', ['as' => 'translate.article', 'uses' => 'ArticleController@translateArticle']);

Route::get('translate/article/edit/{id}', ['as' => 'translate.article.edit', 'uses' => 'ArticleController@translateArticleEdit']);

Route::post('translate/article/save', ['as' => 'translate.article.save', 'uses' => 'ArticleController@translateArticleSave']);

Route::post('translate/article/update', ['as' => 'translate.article.update', 'uses' => 'ArticleController@translateArticleUpdate']);
Route::get('roles/all', ['as' => 'roles.all', 'uses' => 'RolesController@index']);
Route::get('roles/add', ['as' => 'roles.add', 'uses' => 'RolesController@add']);
Route::get('roles/edit/{id}', ['as' => 'roles.edit', 'uses' => 'RolesController@edit']);
Route::post('roles/insert', ['as' => 'roles.insert', 'uses' => 'RolesController@insert']);
Route::post('roles/update/{id}', ['as' => 'roles.update', 'uses' => 'RolesController@update']);
Route::post('roles/assign-permissions', ['as' => 'roles.assignPermissions', 'uses' => 'RolesController@assignPermissions']);
Route::get('roles/permissions/{id}', ['as' => 'roles.rolesPermissions', 'uses' => 'RolesController@rolesPermissions']);
Route::get('roles/activate/{id}', ['as' => 'roles.activate', 'uses' => 'RolesController@activate']);
Route::get('roles/deactivate/{id}', ['as' => 'roles.deactivate', 'uses' => 'RolesController@deactivate']);
Route::post("roles/assign-roles", ['as' => 'assignRoles', 'uses' => 'UserController@assignRoles']);
Route::get("roles/{id}", ['as' => 'roles', 'uses' => 'UserController@userRoles']);
Route::get("user-password/{user}", ['as' => 'user.user-password', 'uses' => 'UserController@userPassword']);
Route::post("update-password/{user}", ['as' => 'user.update-password.update', 'uses' => 'UserController@updatePassword']);
Route::get('access-denied', function () {
    return view('access_denied');
})->name('access-denied');
Route::get('permissions/all', ['as' => 'permissions.all', 'uses' => 'PermissionsController@index']);
Route::get('permissions/add', ['as' => 'permissions.add', 'uses' => 'PermissionsController@add']);
Route::get('permissions/edit/{id}', ['as' => 'permissions.edit', 'uses' => 'PermissionsController@edit']);
Route::get('permissions/activate/{id}', ['as' => 'permissions.activate', 'uses' => 'PermissionsController@activate']);
Route::get('permissions/deactivate/{id}', ['as' => 'permissions.deactivate', 'uses' => 'PermissionsController@deactivate']);
Route::post('permissions/update/{id}', ['as' => 'permissions.update', 'uses' => 'PermissionsController@update']);
Route::post('permissions/insert', ['as' => 'permissions.insert', 'uses' => 'PermissionsController@insert']);

Route::post('credit-numbers/import', ['as' => 'numbers.import', 'uses' => 'TelCompanyController@import']);
Route::get('tcompany/index', ['as' => 'tcompany.listing', 'uses' => 'TelCompanyController@index']);
Route::get('tcompany/create', ['as' => 'tcompany.create', 'uses' => 'TelCompanyController@create']);
Route::post('tcompany/save', ['as' => 'tcompany.store', 'uses' => 'TelCompanyController@store']);
Route::get('tcompany/{id}/edit', ['as' => 'tcompany.edit', 'uses' => 'TelCompanyController@edit']);
Route::post('update/tcompany/{id}', ['as' => 'tcompany.update', 'uses' => 'TelCompanyController@update']);
Route::get('delete/tcompany/{id}', ['as' => 'tcompany.destroy', 'uses' => 'TelCompanyController@destroy']);


Route::resource('category', 'CategoryController');
Route::get('listing/categories', ['as' => 'all.categories', 'uses' => 'CategoryController@categories']);


Route::get('translate/category/{id}', ['as' => 'translate.category', 'uses' => 'CategoryController@translateCategory']);
Route::post('translate/category/save', ['as' => 'translate.category.save', 'uses' => 'CategoryController@translateCategorySave']);



Route::get('translate/category/edit/{id}', ['as' => 'translate.category.edit', 'uses' => 'CategoryController@edittranslateCategory']);

Route::post('translate/category/update', ['as' => 'translate.category.update', 'uses' => 'CategoryController@translateCategoryUpdate']);

Route::get('delete/cat', ['as' => 'delete.cat', 'uses' => 'CategoryController@deleteRecord']);
Route::post('update/cat', ['as' => 'update.cat', 'uses' => 'CategoryController@updateCategory']);
Route::post('update/package', ['as' => 'update.package', 'uses' => 'PackageController@update']);
Route::any('delete/package/{id}', ['as' => 'delete.package', 'uses' => 'PackageController@delete']);
Route::post('update/bundle', ['as' => 'update.bundle', 'uses' => 'BundleController@update']);
Route::any('delete/bundle/{id}', ['as' => 'delete.bundle', 'uses' => 'BundleController@delete']);

Route::resource('packages', 'PackageController');
Route::resource('bundles', 'BundleController');
Route::get('winners/{id}', ['as' => 'bundle.winners', 'uses' => 'BundleController@winners']);
Route::get('all-winners', ['as' => 'all.winners', 'uses' => 'BundleController@allWinners']);
Route::get('lottery-winners', ['as' => 'lottery.winners', 'uses' => 'BundleController@lotteryWinners']);
Route::get('gift-winners', ['as' => 'gift.winners', 'uses' => 'BundleController@giftWinners']);

Route::get('listing/sliders', ['as' => 'all.sliders', 'uses' => 'SliderController@sliders']);
Route::resource('slider', 'SliderController');
Route::get('listing/admin', ['as' => 'list.admin', 'uses' => 'UserController@listAdmin']);
Route::get('create/admin', ['as' => 'create.admin', 'uses' => 'UserController@createAdmin']);
Route::any('save/admin', ['as' => 'save.admin', 'uses' => 'UserController@saveAdmin']);
Route::any('delete/{user}', ['as' => 'delete.admin', 'uses' => 'UserController@deleteAdmin']);
Route::post('update/admin', ['as' => 'update.admin', 'uses' => 'UserController@updateAdmin']);
Route::get('edit/{id}', ['as' => 'edit.admin', 'uses' => 'UserController@editAdmin']);
Route::get('delete/slider/{id}', ['as' => 'delete.slider', 'uses' => 'SliderController@deleteRecord']);
Route::get('edit/slider/{id}', ['as' => 'edit.slider', 'uses' => 'SliderController@editSlider']);
Route::post('update/slider', ['as' => 'update.slider', 'uses' => 'SliderController@updateSlider']);


Route::resource('product', 'ProductController');
Route::get('delete-image/{id}/{name}', ['as' => 'delete.image', 'uses' => 'ProductController@deleteImage']);
Route::get('delete/product', ['as' => 'delete.product', 'uses' => 'ProductController@deleteRecord']);
Route::post('update/product', ['as' => 'update.product', 'uses' => 'ProductController@updateProduct']);
Route::get('listing/products/', ['as' => 'listing.products', 'uses' => 'ProductController@products']);
Route::get('translate/product/{id}', ['as' => 'translate.product', 'uses' => 'ProductController@translateProduct']);
Route::get('view/product/{id}', ['as' => 'viewProduct', 'uses' => 'ProductController@viewProduct']);
Route::get('product/change-status/{id}', ['as' => 'changeStatus', 'uses' => 'ProductController@changeStatus']);
Route::get('copy-products', ['as' => 'copyProducts', 'uses' => 'ProductController@copyProducts']);
Route::get('copy-categories', ['as' => 'copyCategories', 'uses' => 'ProductController@copyCategories']);
Route::get('delete-products', ['as' => 'deleteArabicProducts', 'uses' => 'ProductController@deleteArabicProducts']);
Route::get('delete-categories', ['as' => 'deleteArabicCategories', 'uses' => 'ProductController@deleteArabicCategories']);

Route::post('translate/product/save', ['as' => 'translate.product.save', 'uses' => 'ProductController@translateProductSave']);

Route::get('translate/product/edit/{id}', ['as' => 'translate.product.edit', 'uses' => 'ProductController@edittranslateProduct']);
Route::post('translate/product/update', ['as' => 'translate.product.update', 'uses' => 'ProductController@translateProductUpdate']);

Route::resource('city', 'CityController');
Route::get('listing/cities/', ['as' => 'listing.cities', 'uses' => 'CityController@cities']);

Route::get('delete/cities', ['as' => 'delete.city.one', 'uses' => 'CityController@deleteRecord']);

Route::post('update/only/city', ['as' => 'update.only.city', 'uses' => 'CityController@updateCity']);

Route::get('translate/city/{id}', ['as' => 'translate.city', 'uses' => 'CityController@translateCity']);

Route::post('translate/city/save', ['as' => 'translate.city.save', 'uses' => 'CityController@translateCitySave']);

Route::get('translate/city/edit/{id}', ['as' => 'translate.city.edit', 'uses' => 'CityController@edittranslateCity']);

Route::post('translate/city/update', ['as' => 'translate.city.update', 'uses' => 'CityController@translateCityUpdate']);


Route::get('/cache-clear', function () {
    $exitCode = Artisan::call('cache:clear');
    return $exitCode;
});

Route::get('/config-clear', function () {
    $exitCode = Artisan::call('config:clear');
    return $exitCode;
});


Route::resource('page', 'PageController');

Route::resource('campaign', 'CampaignController');

Route::get('sticks/listing', ['as' => 'sticks.listings', 'uses' => 'CampaignController@sticksListing']);
Route::get('sticks/create', ['as' => 'sticks.create', 'uses' => 'CampaignController@sticksCreate']);
Route::post('sticks/save', ['as' => 'sticks.save', 'uses' => 'CampaignController@sticksSave']);
Route::get('sticks/edit/{id}', ['as' => 'sticks.edit', 'uses' => 'CampaignController@sticksEdit']);
Route::post('sticks/update', ['as' => 'sticks.update', 'uses' => 'CampaignController@sticksUpdate']);
Route::get('sticks/delete', ['as' => 'sticks.delete', 'uses' => 'CampaignController@sticksDelete']);

Route::get('lottery/gifts/listing', ['as' => 'lottery.giftlistings', 'uses' => 'CampaignController@lotteryGiftListing']);

Route::get('print/gifts/listing', ['as' => 'print.giftlistings', 'uses' => 'CampaignController@printGiftListing']);

Route::get('lottery/printing', ['as' => 'lottery.printing', 'uses' => 'CampaignController@lotteryPrinting']);

Route::get('mekano/listing', ['as' => 'mekano.listing', 'uses' => 'CampaignController@mekanoWinnerListing']);

Route::get('settings/time/delete', ['as' => 'settings.deleteTime', 'uses' => 'CampaignController@deleteTime']);
Route::get('setting/add-time', ['as' => 'settings.addTime', 'uses' => 'CampaignController@addTime']);
Route::get('setting/delete-time', ['as' => 'settings.deleteTime', 'uses' => 'CampaignController@deleteTime']);
Route::get('setting/assign-times', ['as' => 'settings.assignTimes', 'uses' => 'CampaignController@assignTimes']);
Route::get('settings/winners', ['as' => 'winners.settings', 'uses' => 'CampaignController@winnerSettings']);
Route::get('settings/winners/ajax', ['as' => 'winners.ajax.settings', 'uses' => 'CampaignController@winnersAjaxSettings']);
Route::get('settings/winners/save', ['as' => 'winners.save.settings', 'uses' => 'CampaignController@saveWinnerSettings']);
Route::get('settings/winners/delete', ['as' => 'winners.delete.settings', 'uses' => 'CampaignController@deleteWinnerSetting']);
Route::get('participants/report', ['as' => 'participants.report', 'uses' => 'CampaignController@participants']);
Route::get('send-business-message', ['as' => 'business.message.send', 'uses' => 'CampaignController@sendBusinessMessage']);


Route::get('print-text-batches', ['as' => 'batches.listing', 'uses' => 'CampaignController@printTextBatches']);
Route::get('print-text-batch-files', ['as' => 'batches.fileslisting', 'uses' => 'CampaignController@printTextBatchFiles']);
Route::get('print-text-batch-file-download', ['batches.filesdownload', 'uses' => 'CampaignController@printTextBatchFileDownload']);
Route::get('tcompany/quota/{id}', ['see.Quota', 'uses' => 'TelCompanyController@viewQuota']);
Route::get('assign-quota/{company_id}', ['assign.Quota', 'uses' => 'TelCompanyController@assignQuota']);
Route::post('assign-quota/save', ['assignQuota.save', 'uses' => 'TelCompanyController@assignQuotaSave']);
Route::post('export-pdf-qrcodes/{type}', ['export.PdfLotteryGift', 'uses' => 'CampaignController@exportPdfQrcodes']);
Route::post('print-text-telecom-codes', ['export.PrintTextTelecomCodes', 'uses' => 'CampaignController@printTextTelecomCodes']);

Route::get('export-lottery-numbers/{type}', ['export.lotteryNumbers', 'uses' => 'CampaignController@exportQrCodes']);
Route::get('export-credit-numbers/{company}', ['export.creditNumbersCompany', 'uses' => 'TelCompanyController@exportOfCompany']);
Route::get('export-credit-numbers', ['export.creditNumbers', 'uses' => 'TelCompanyController@export']);
Route::post('add-credit-number', ['as' => 'addCreditNumber', 'uses' => 'TelCompanyController@addCreditNumber']);
Route::post('export-pdf-numbers', ['as' => 'exportPdfNumbers', 'uses' => 'TelCompanyController@exportPdfNumbers']);
Route::get('download-number-import-sample', ['as' => 'downloadnumberssample.import', 'uses' => 'TelCompanyController@downloadSampleImportNumbers']);
Route::get('credit-numbers/{company_id}', ['as' => 'numbers.listings', 'uses' => 'TelCompanyController@creditNumbers']);
Route::get('all-credit-numbers', ['as' => 'allnumbers.listings', 'uses' => 'TelCompanyController@allCreditNumbers']);
Route::get('lottery/listing', ['as' => 'lottery.listings', 'uses' => 'CampaignController@lotteryListing']);
Route::get('instant/listing', ['as' => 'instant.listings', 'uses' => 'CampaignController@instantListing']);
Route::get('telecom/listing', ['as' => 'telecom.listings', 'uses' => 'CampaignController@telecomListing']);
Route::get('gifts/winners', ['as' => 'gifts.winners', 'uses' => 'CampaignController@giftWinner']);
Route::get('lottery/winners/{package_id}', ['as' => 'lottery.winners', 'uses' => 'CampaignController@lotteryWinner']);
Route::get('assign-instant/{package_id}', ['as' => 'instant.assign', 'uses' => 'CampaignController@assignInstant']);
Route::post('assign-instant/save', ['as' => 'instant.assignsave', 'uses' => 'CampaignController@makeInstantWinner']);
Route::get('make/giftwinner', ['as' => 'make.giftwinner', 'uses' => 'CampaignController@makeGiftWinner']);
Route::get('make/mekanowinner', ['as' => 'make.mekanowinner', 'uses' => 'CampaignController@makeMekanoWinner']);
Route::get('lotteryrandom/numbers', ['as' => 'lotteryrandom.numbers', 'uses' => 'CampaignController@addRandomNumbers']);
Route::get('instantrandom/numbers/{bundle_id}', ['as' => 'instantrandom.numbers', 'uses' => 'CampaignController@addInstantNumbers']);
Route::get('upload-mekano', ['as' => 'mekano.upload', 'uses' => 'CampaignController@uploadMekano']);
Route::post('save-mekano', ['as' => 'mekano.save', 'uses' => 'CampaignController@saveMekano']);

Route::post('save/randomnumbers', ['as' => 'save.randomnumbers', 'uses' => 'CampaignController@saveRandomNumbers']);
Route::post('save/instantnumbers', ['as' => 'save.instantnumbers', 'uses' => 'CampaignController@saveInstantNumbers']);

Route::get('make/lotterywinner', ['as' => 'make.lotterywinner', 'uses' => 'CampaignController@makeLotteryWinner']);

Route::get('make/lotteryautowinner', ['as' => 'make.lotteryautowinner', 'uses' => 'CampaignController@makeWinnerAuto']);

Route::get('lottery', ['as' => 'lottery', 'uses' => 'CampaignController@lottery']);
Route::get('translate/page/{id}', ['as' => 'translate.page', 'uses' => 'PageController@translatePage']);

Route::get('translate/page/edit/{id}', ['as' => 'translate.page.edit', 'uses' => 'PageController@translatePageEdit']);

Route::post('translate/page/save', ['as' => 'translate.page.save', 'uses' => 'PageController@translatePageSave']);

Route::post('translate/page/update', ['as' => 'translate.page.update', 'uses' => 'PageController@translatePageUpdate']);

Route::resource('user', 'UserController');
