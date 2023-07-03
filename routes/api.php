<?php
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\SliderController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\LeveltwosubcategoryController;
use App\Http\Controllers\API\CampaignController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
//Base ur in case localhost

//http://localhost/boiler/public/api/
Route::post('get-message-status', function (Request $request) {
    $data = $request->all();
    Log::Info($data);
});
Route::post('webhooks/inbound', [CampaignController::class,'getBusinessMessages']);
Route::get('get-sliders',[SliderController::class,'getSliders']);
Route::get('add-names',[UserController::class,'addFullNames']);
Route::get('get-sticks',[CampaignController::class,'getSticks']);
Route::get('get-gifts/{id}',[CampaignController::class,'getUserGifts']);
Route::get('get-all-gifts/{id}',[CampaignController::class,'getUserAllGifts']);
Route::get('get-lotteries/{id}',[CampaignController::class,'getUserLotteries']);
Route::get('get-mekanos/{id}',[CampaignController::class,'getUserMekanos']);
Route::get('get-winning-mekanos/{id}',[CampaignController::class,'getWinningMekanos']);
Route::get('get-mekanos-winners/{type}',[CampaignController::class,'allMekanosWinners']);
Route::get('get-all-notifications/{user_id}',[CampaignController::class,'getAllNotifications']);
Route::get('get-new-notifications/{user_id}',[CampaignController::class,'getNewNotifications']);
Route::get('set-notifications/{user_id}/{type}',[CampaignController::class,'setNotifications']);
Route::get('get-gifts-lotteries/{user_id}/{type}',[CampaignController::class,'getGiftsLotteries']);

Route::post('send-verification-code', [UserController::class, 'sendVerificationCode']);
Route::post('send-code-again', [UserController::class, 'sendCodeAgain']);
Route::post('verify-otp', [UserController::class, 'verifyOtp']);

Route::post('is-active-user', [UserController::class, 'isActiveUser']);
Route::post('assign-code', [CampaignController::class, 'assignCode']);
Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);
Route::post('profile/update/{id}', [UserController::class, 'updateProfile']);
Route::post('change-password/{id}',[UserController::class, 'changePassword']);
Route::get('/cities', [AuthController::class, 'getCities']);
Route::post('/save/user/status', [AuthController::class, 'saveUserStatus']);

Route::post('forgot-password', [AuthController::class, 'forgotPassword']);

Route::get('get/subcategories',[CategoryController::class,'getSubCategories']);
Route::get('get-categories/{lang}',[CategoryController::class,'getCategories']);
Route::get('get/products',[ProductController::class,'getProducts']);
Route::get('get-offer-products/{lang}',[ProductController::class,'getOfferProducts']);
Route::post('single/product',[ProductController::class,'getSingleProduct']);
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('campaign', CampaignController::class);
Route::middleware('auth:api')->group( function () {

Route::post('update/product',[ProductController::class,'updateProduct']);
Route::post('delete/product',[ProductController::class,'deleteRecord']);





Route::resource('subcategoryfinal', LeveltwosubcategoryController::class);
Route::post('/subcategories/level/one', [LeveltwosubcategoryController::class, 'fetchSubcategory']);
Route::post('delete/subcategory/level/two', [LeveltwosubcategoryController::class, 'deleteRecordFinal']);

Route::resource('recipes', ArticleController::class); 
Route::post('recipe/detail',[ArticleController::class,'recipeDetail']); 
Route::resource('pages', PageController::class);
Route::post('/logout', [AuthController::class, 'logout']);

});