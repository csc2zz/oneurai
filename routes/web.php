<?php

use App\Http\Controllers\GoogleAuthController;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Dashboard\Models\ModelView;
use App\Livewire\Dashboard\Models\UploadModel;
use App\Livewire\Dashboard\Profile;
use App\Livewire\Dashboard\Projects\Create as ProjectCreate;
use App\Livewire\Dashboard\Projects\Show as ProjectShow;
use App\Livewire\Dashboard\Projects\ViewFile;
use App\Livewire\HomePage;
use App\Livewire\ExploreProjects;
use App\Livewire\Dashboard\Home as DashboardHome;
use App\Livewire\Dashboard\Repos\Index as ReposIndex;
use App\Livewire\Dashboard\Models\Index as ModelsDash;
use App\Livewire\Dashboard\Dataset\Index as DatasetsIndex;
use App\Livewire\Dashboard\Dataset\Create as DatasetCreate;
use App\Livewire\Dashboard\Dataset\Show as DatasetShow;
use App\Livewire\Profile\OverviewTab;
use App\Livewire\Profile\RepositoriesTab;
use App\Livewire\Profile\ModelsTab;
use App\Livewire\Profile\DatasetsTab;
use App\Livewire\Projects\Show;
use App\Livewire\Models\ModelsIndex;
use App\Livewire\Models\ShowModel;     // صفحة البطاقة (الرئيسية)
use App\Livewire\Models\ModelFiles;    // صفحة الملفات
use App\Livewire\Models\ModelCommunity;// صفحة المجتمع
use App\Livewire\Models\ModelSettings; // صفحة الإعدادات
use App\Livewire\Developers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File; // يجب إضافة هذا في بداية الملف
use App\Livewire\Datasets\Index as PublicDatasetsIndex;
use App\Livewire\Games\Index as GamesIndex; // انتبه للمسار الجديد
use App\Livewire\Games\Show as GamesShow;
use App\Livewire\Datasets\Show as PublicDatasetShow;
use App\Livewire\Dashboard\Chat\Index as ChatIndex;
use App\Livewire\Auth\VerifyEmail;
use App\Http\Controllers\Api\UniversalController;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', HomePage::class)->name('home')->middleware('otp.check');

Route::get('/search', \App\Livewire\Search\SearchPage::class)->name('search')->middleware('otp.check');

Route::get('/direct-download/{type}/{username}/{repo_name}/{filename}', [UniversalController::class, 'download'])
->whereIn('type', ['repos', 'models', 'datasets']) // يجب أن تكون models موجودة هنا
    ->name('api.universal.download')->middleware('otp.check');

Route::view('/about', 'pages.about')->name('pages.about')->middleware('otp.check');
Route::view('/careers', 'pages.careers')->name('pages.careers')->middleware('otp.check');
Route::view('/contact', 'pages.contact')->name('pages.contact')->middleware('otp.check');
Route::view('/privacy', 'pages.privacy')->name('pages.privacy')->middleware('otp.check');
Route::view('/terms', 'pages.terms')->name('pages.terms')->middleware('otp.check');
Route::view('/docs', 'pages.docs')->name('pages.docs')->middleware('otp.check');
Route::view('/api-reference', 'pages.api')->name('pages.api')->middleware('otp.check');
Route::view('/community-guidelines', 'pages.community')->name('pages.community')->middleware('otp.check');
Route::view('/blog', 'pages.blog')->name('pages.blog')->middleware('otp.check');

Route::get('/blog/{slug}', \App\Livewire\PostShow::class)->name('post.show')->middleware('otp.check');

Route::get('/explore', ExploreProjects::class)->name('explore')->middleware('otp.check');

Route::get('/models', ModelsIndex::class)->name('models')->middleware('otp.check');

Route::get('/developers', Developers::class)->name('developers.index')->middleware('otp.check');

Route::get('/project/{username}/{slug}', Show::class)->name('project.showing')->middleware('otp.check');

Route::get('/datasets', PublicDatasetsIndex::class)->name('datasets.public.index')->middleware('otp.check');

Route::get('/datasets/{username}/{slug}', PublicDatasetShow::class)->name('datasets.public.show')->middleware('otp.check');

Route::get('/games', GamesIndex::class)->name('games');

Route::get('/games/{slug}', GamesShow::class)->name('games.show');

Route::group(['prefix' => '/model/{username}/{slug}'], function () {
    Route::get('/', ShowModel::class)->name('models.show')->middleware('otp.check');
    Route::get('/files', ModelFiles::class)->name('models.files')->middleware('otp.check');
    Route::get('/community', ModelCommunity::class)->name('models.community')->middleware('otp.check');
    Route::get('/settings', ModelSettings::class)->name('models.settings')->middleware('otp.check');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');

    Route::get('/register', RegisterPage::class)->name('register');

    Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
});



    Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', VerifyEmail::class)->name('verification.notice');
});

Route::middleware(['auth', 'otp.check'])->group(function () {
Route::get('/dashboard', DashboardHome::class)
    ->name('dashboard');
    Route::get('/app/download/windows', function () {
    $filePath = public_path('downloads/oneurai.zip');
    $fileName = 'oneurai.zip';

    // يجب التأكد من وجود الملف في المسار: /public/downloads/oneurai-windows-setup.exe
    if (File::exists($filePath)) {
        return response()->download($filePath, $fileName);
    }

    // في حال لم يتم العثور على الملف
    abort(404, 'ملف التنزيل غير موجود حاليًا.');

})->name('app.download.windows');

    Route::get('/dashboard/tickets', \App\Livewire\Dashboard\Tickets\Index::class)->name('dashboard.tickets');
        Route::get('/dashboard/ticket/create', \App\Livewire\Dashboard\Tickets\Create::class)->name('dashboard.tickets.create');
        Route::get('/dashboard/ticket/{ticket}', \App\Livewire\Dashboard\Tickets\Show::class)->name('dashboard.tickets.show');
        
        Route::get('/dashboard/help', \App\Livewire\Dashboard\Help\Index::class)->name('dashboard.help');
        
    Route::get('/dashboard/games', \App\Livewire\Dashboard\Games\Index::class)->name('dashboard.games');
    
    Route::get('/dashboard/games/create', \App\Livewire\Dashboard\Games\Create::class)->name('dashboard.games.create');
    
    Route::get('/dashboard/games/{game}/edit', \App\Livewire\Dashboard\Games\Edit::class)->name('dashboard.games.edit');

    Route::get('/dashboard/repos', ReposIndex::class)->name('dashboard.repos');

    Route::get('/dashboard/models', ModelsDash::class)->name('dashboard.models');

    Route::get('/dashboard/datasets', DatasetsIndex::class)->name('dashboard.datasets');

    Route::get('/dashboard/chat', ChatIndex::class)->name('dashboard.chat');

    Route::get('/dashboard/dataset/create', DatasetCreate::class)->name('dashboard.dataset.create');

    Route::get('/dashboard/datasets/{id}', DatasetShow::class)->name('dashboard.dataset.show');

    Route::get('/dashboard/models/{username}/{slug}', ModelView::class)
    ->name('dashboard.models.view');

    Route::get('/dashboard/models/upload', UploadModel::class)->name('dashboard.models.upload');

    Route::get('/dashboard/profile', Profile::class)->name('dashboard.profile');

    Route::get('/projects/new', ProjectCreate::class)->name('projects.create');

    Route::get('/{username}/{slug}', ProjectShow::class)
    ->where('username', '@?[a-zA-Z0-9_]+') // يقبل يوزرنيم
    ->name('projects.show');


});

Route::get('/@{username}', OverviewTab::class)->name('profile.show')->middleware('otp.check');

Route::get('/@{username}/all/repositories', RepositoriesTab::class)->name('profile.repositories')->middleware('otp.check');

Route::get('/@{username}/all/models', ModelsTab::class)->name('profile.models')->middleware('otp.check');

Route::get('/@{username}/all//datasets', action: DatasetsTab::class)->name('profile.datasets')->middleware('otp.check');

// لاحظ إضافة :slug
Route::get('/edit/{project:slug}/files/{file}', ViewFile::class)
    ->name('dashboard.files.view')
    ->middleware('auth', 'otp.check');
