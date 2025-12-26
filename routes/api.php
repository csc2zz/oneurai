<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UniversalController;
use App\Http\Controllers\Api\ModelController;

/*
|--------------------------------------------------------------------------
| Public Routes (متاح للعامة وكولاب)
|--------------------------------------------------------------------------
| هذا الرابط يجب أن يكون هنا في الخارج ليعمل wget في Colab
*/
Route::get('/download/{type}/{username}/{repo_name}/{filename}', [UniversalController::class, 'download'])
    ->name('api.universal.download');

/*
|--------------------------------------------------------------------------
| Optional: Public metadata endpoints (إذا بتستخدم ModelController)
|--------------------------------------------------------------------------
| مثال: GET /api/models/{username}/{repo_name}
*/
// Route::get('/models/{username}/{repo_name}', [ModelController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Protected Routes (يجب تسجيل دخول - للرفع فقط)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // الرفع يبقى محمياً (للمستخدم المسجل فقط)
    Route::post('/{type}/{username}/{repo_name}/upload', [UniversalController::class, 'upload'])
        ->whereIn('type', ['repos', 'models', 'datasets']); // ✅ تقييد النوع
});
