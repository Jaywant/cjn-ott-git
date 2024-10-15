<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AvatarController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CastController;
use App\Http\Controllers\Admin\ChannelController;
use App\Http\Controllers\Admin\ChannelTVShowController;
use App\Http\Controllers\Admin\ChannelVideoController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\RentTransactionController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\TVShowController;
use App\Http\Controllers\Admin\UpcomingTVShowController;
use App\Http\Controllers\Admin\UpcomingVideoController;
use App\Http\Controllers\Admin\AdmobSettingController;
use App\Http\Controllers\Admin\FaceBookAdsSettingController;
use App\Http\Controllers\Admin\KidsTVShowController;
use App\Http\Controllers\Admin\KidsVideoController;
use App\Http\Controllers\Admin\PanelSettingController;
use App\Http\Controllers\Admin\ProducerController;
use App\Http\Controllers\Admin\RentPriceListController;

// Artisan
Route::get('artisan', function () {

    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "<h1>All Config Cache Clear Successfully.</h1>";
});

// Version
Route::get('version', function () {
    return "<h1>
        <li>PHP : " . phpversion() . "</li>
        <li>Laravel : " . app()->version() . "</li>
    </h1>";
});

Route::group(['middleware' => 'installation'], function () {

    // Login-Logout
    Route::get('login', [LoginController::class, 'login'])->name('admin.login')->middleware('purchasecodeverify');
    Route::post('login', [LoginController::class, 'save_login'])->name('admin.save.login');
    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
    // Chunk
    Route::post('video/saveChunk', [VideoController::class, 'saveChunk']);

    Route::group(['middleware' => 'authadmin'], function () {

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        // Profile
        Route::resource('profile', ProfileController::class)->only(['index']);
        Route::resource('profile', ProfileController::class)->only(['store']);
        Route::post('profile/changepassword', [ProfileController::class, 'ChangePassword'])->name('profile.changepassword');
        // Type
        Route::resource('type', TypeController::class)->only(['index', 'store', 'update', 'show']);
        // Category
        Route::resource('category', CategoryController::class)->only(['index', 'store', 'update']);
        // Language
        Route::resource('language', LanguageController::class)->only(['index', 'store', 'update']);
        // Season
        Route::resource('season', SeasonController::class)->only(['index', 'store', 'update']);
        // Avatar
        Route::resource('avatar', AvatarController::class)->only(['index', 'store', 'update']);
        // Coupon
        Route::resource('coupon', CouponController::class)->only(['index', 'store', 'update']);
        // Pages
        Route::resource('page', PageController::class)->only(['index', 'store', 'edit', 'update']);
        // Producer
        Route::resource('producer', ProducerController::class)->only(['index', 'store', 'update']);
        // User
        Route::resource('user', UserController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        // Cast
        Route::resource('cast', CastController::class)->only(['index', 'store', 'update']);
        // Banner
        Route::resource('banner', BannerController::class)->only(['index', 'store', 'destroy']);
        Route::post('banner/typebyvideo', [BannerController::class, 'TypeByVideo'])->name('bannerTypeByVideo');
        Route::post('banner/list', [BannerController::class, 'BannerList'])->name('bannerList');
        // Section
        Route::resource('section', SectionController::class)->only(['index', 'store', 'update']);
        Route::post('section/data', [SectionController::class, 'GetSectionData'])->name('section.content.data');
        Route::post('section/edit', [SectionController::class, 'SectionDataEdit'])->name('section.content.edit');
        Route::post('section/sortable', [SectionController::class, 'SectionSortable'])->name('section.content.sortable');
        Route::post('section/sortable/save', [SectionController::class, 'SectionSortableSave'])->name('section.content.sortable.save');
        Route::get('sectionstatus', [SectionController::class, 'changeStatus'])->name('section.status');
        // Video
        Route::resource('video', VideoController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        Route::get('video/details/{id}', [VideoController::class, 'videoDetails'])->name('video.details');
        Route::post('video/serachname/{txtVal}', [VideoController::class, 'SerachName'])->name('video.serach.name');
        Route::post('video/getdata/{id}', [VideoController::class, 'GetData'])->name('video.getdata');
        Route::get('videostatus', [VideoController::class, 'changeStatus'])->name('video.status');
        // TVShow
        Route::resource('tvshow', TVShowController::class)->only(['index', 'create', 'edit', 'store', 'update', 'show']);
        Route::get('tvshow/details/{id}', [TVShowController::class, 'tvshowDetails'])->name('tvshow.details');
        Route::post('tvshow/serachname/{txtVal}', [TVShowController::class, 'SerachName'])->name('tvshow.serach.name');
        Route::post('tvshow/getdata/{id}', [TVShowController::class, 'GetData'])->name('tvshow.getdata');
        Route::get('tvshowepisode/{id}', [TVShowController::class, 'TVShowIndex'])->name('tvshow.episode.index');
        Route::get('tvshowepisode/add/{id}', [TVShowController::class, 'TVShowAdd'])->name('tvshow.episode.add');
        Route::post('tvshowepisode/save', [TVShowController::class, 'TVShowSave'])->name('tvshow.episode.save');
        Route::get('tvshowepisode/edit/{tvshow_id}/{id}', [TVShowController::class, 'TVShowEdit'])->name('tvshow.episode.edit');
        Route::post('tvshowepisode/update/{tvshow_id}/{id}', [TVShowController::class, 'TVShowUpdate'])->name('tvshow.episode.update');
        Route::post('tvshowepisode/sortable', [TVShowController::class, 'TVShowSortable'])->name('tvshow.episode.sortable');
        // Upcoming Video
        Route::resource('upcomingvideo', UpcomingVideoController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        Route::get('upcomingvideo/details/{id}', [UpcomingVideoController::class, 'upcomingVideoDetails'])->name('upcomingvideo.details');
        Route::get('upcomingvideostatus', [UpcomingVideoController::class, 'changeStatus'])->name('upcomingvideo.status');
        Route::post('upcomingvideoreleases', [UpcomingVideoController::class, 'videoReleases'])->name('upcomingvideo.releases');
        // Upcoming TVShow
        Route::resource('upcomingtvshow', UpcomingTVShowController::class)->only(['index', 'create', 'edit', 'store', 'update', 'show']);
        Route::get('upcomingtvshow/details/{id}', [UpcomingTVShowController::class, 'upcomingTVShowDetails'])->name('upcomingtvshow.details');
        Route::get('upcomingtvshowepisode/{id}', [UpcomingTVShowController::class, 'TVShowIndex'])->name('upcomingtvshow.episode.index');
        Route::get('upcomingtvshowepisode/add/{id}', [UpcomingTVShowController::class, 'TVShowAdd'])->name('upcomingtvshow.episode.add');
        Route::post('upcomingtvshowepisode/save', [UpcomingTVShowController::class, 'TVShowSave'])->name('upcomingtvshow.episode.save');
        Route::get('upcomingtvshowepisode/edit/{tvshow_id}/{id}', [UpcomingTVShowController::class, 'TVShowEdit'])->name('upcomingtvshow.episode.edit');
        Route::post('upcomingtvshowepisode/update/{tvshow_id}/{id}', [UpcomingTVShowController::class, 'TVShowUpdate'])->name('upcomingtvshow.episode.update');
        Route::post('upcomingtvshowepisode/sortable', [UpcomingTVShowController::class, 'TVShowSortable'])->name('upcomingtvshow.episode.sortable');
        Route::post('upcomingtvshowreleases', [UpcomingTVShowController::class, 'showReleases'])->name('upcomingtvshow.releases');
        // Channel
        Route::resource('channel', ChannelController::class)->only(['index', 'store', 'update']);
        // Channel Video
        Route::resource('ch_video', ChannelVideoController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        Route::get('ch_video/details/{id}', [ChannelVideoController::class, 'channelVideoDetails'])->name('ch_video.details');
        Route::get('ch_videostatus', [ChannelVideoController::class, 'changeStatus'])->name('ch_video.status');
        // Channel TVShow
        Route::resource('ch_tvshow', ChannelTVShowController::class)->only(['index', 'create', 'edit', 'store', 'update', 'show']);
        Route::get('ch_tvshow/details/{id}', [ChannelTVShowController::class, 'channelTVShowDetails'])->name('ch_tvshow.details');
        Route::get('ch_tvshowepisode/{id}', [ChannelTVShowController::class, 'TVShowIndex'])->name('ch_tvshow.episode.index');
        Route::get('ch_tvshowepisode/add/{id}', [ChannelTVShowController::class, 'TVShowAdd'])->name('ch_tvshow.episode.add');
        Route::post('ch_tvshowepisode/save', [ChannelTVShowController::class, 'TVShowSave'])->name('ch_tvshow.episode.save');
        Route::get('ch_tvshowepisode/edit/{tvshow_id}/{id}', [ChannelTVShowController::class, 'TVShowEdit'])->name('ch_tvshow.episode.edit');
        Route::post('ch_tvshowepisode/update/{tvshow_id}/{id}', [ChannelTVShowController::class, 'TVShowUpdate'])->name('ch_tvshow.episode.update');
        Route::post('ch_tvshowepisode/sortable', [ChannelTVShowController::class, 'TVShowSortable'])->name('ch_tvshow.episode.sortable');
        // Kids Video
        Route::resource('kidsvideo', KidsVideoController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        Route::get('kidsvideo/details/{id}', [KidsVideoController::class, 'kidsVideoDetails'])->name('kidsvideo.details');
        Route::get('kidsvideostatus', [KidsVideoController::class, 'changeStatus'])->name('kidsvideo.status');
        // Kids TVShow
        Route::resource('kidstvshow', KidsTVShowController::class)->only(['index', 'create', 'edit', 'store', 'update', 'show']);
        Route::get('kidstvshow/details/{id}', [KidsTVShowController::class, 'kidsTVShowDetails'])->name('kidstvshow.details');
        Route::get('kidstvshowepisode/{id}', [KidsTVShowController::class, 'TVShowIndex'])->name('kidstvshow.episode.index');
        Route::get('kidstvshowepisode/add/{id}', [KidsTVShowController::class, 'TVShowAdd'])->name('kidstvshow.episode.add');
        Route::post('kidstvshowepisode/save', [KidsTVShowController::class, 'TVShowSave'])->name('kidstvshow.episode.save');
        Route::get('kidstvshowepisode/edit/{tvshow_id}/{id}', [KidsTVShowController::class, 'TVShowEdit'])->name('kidstvshow.episode.edit');
        Route::post('kidstvshowepisode/update/{tvshow_id}/{id}', [KidsTVShowController::class, 'TVShowUpdate'])->name('kidstvshow.episode.update');
        Route::post('kidstvshowepisode/sortable', [KidsTVShowController::class, 'TVShowSortable'])->name('kidstvshow.episode.sortable');
        // Comment
        Route::resource('comment', CommentController::class)->only(['index', 'show']);
        // Notification
        Route::resource('notification', NotificationController::class)->only(['index', 'create', 'store']);
        // Rent Transaction
        Route::resource('renttransaction', RentTransactionController::class)->only(['index', 'create', 'store']);
        Route::any('rentsearchuser', [RentTransactionController::class, 'searchUser'])->name('rentSearchUser');
        // Package
        Route::resource('package', PackageController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        // Transaction
        Route::resource('transaction', TransactionController::class)->only(['index', 'create', 'store']);
        Route::any('search_user', [TransactionController::class, 'searchUser'])->name('searchUser');
        // Payment
        Route::resource('payment', PaymentController::class)->only(['index']);
        // Admob
        Route::resource('admob', AdmobSettingController::class)->only(['index']);
        Route::post('admob/android', [AdmobSettingController::class, 'admobAndroid'])->name('admob.android');
        Route::post('admob/ios', [AdmobSettingController::class, 'admobIos'])->name('admob.ios');
        // FaceBook Ads
        Route::resource('fbads', FaceBookAdsSettingController::class)->only(['index']);
        Route::post('fbads/android', [FaceBookAdsSettingController::class, 'facebookadAndroid'])->name('fbads.android');
        Route::post('fbads/ios', [FaceBookAdsSettingController::class, 'facebookadIos'])->name('fbads.ios');
        // App Setting
        Route::get('setting', [SettingController::class, 'index'])->name('setting');
        Route::post('setting/app', [SettingController::class, 'app'])->name('setting.app');
        Route::post('setting/tmdbkey', [SettingController::class, 'saveTmdbKey'])->name('setting.tmdbkey');
        Route::post('setting/currency', [SettingController::class, 'currency'])->name('setting.currency');
        Route::post('setting/basicconfigrations', [SettingController::class, 'saveBasicConfigrations'])->name('setting.basicconfigrations');
        Route::post('setting/smtp', [SettingController::class, 'smtpSave'])->name('smtp.save');
        Route::post('setting/sociallink', [SettingController::class, 'saveSocialLink'])->name('settingSocialLink');
        Route::post('setting/onboardingscreen', [SettingController::class, 'saveOnBoardingScreen'])->name('settingOnBoardingScreen');
        Route::post('setting/vapidkey', [SettingController::class, 'vapIdKey'])->name('setting.vapidkey');
        // System Setting
        Route::get('systemsetting', [SystemSettingController::class, 'index'])->name('system.setting.index');
        Route::post('systemsetting/cleardata', [SystemSettingController::class, 'ClearData'])->name('system.setting.cleardata');
        Route::post('systemsetting/dummydata', [SystemSettingController::class, 'DummyData'])->name('system.setting.dummydata');
        Route::post('systemsetting/cleandatabase', [SystemSettingController::class, 'CleanDatabase'])->name('system.setting.cleandatabase');
        // Panel Setting
        Route::get('panelsetting', [PanelSettingController::class, 'index'])->name('panel.setting.index');
        Route::post('panelsetting/save', [PanelSettingController::class, 'save'])->name('panel.setting.save');
        // Rent Price List
        Route::resource('rentpricelist', RentPriceListController::class)->only(['index', 'store', 'update']);

        Route::group(['middleware' => 'checkadmin'], function () {

            // Type
            Route::resource('type', TypeController::class)->only(['destroy']);
            // Category
            Route::resource('category', CategoryController::class)->only(['destroy']);
            // Language
            Route::resource('language', LanguageController::class)->only(['destroy']);
            // Season
            Route::resource('season', SeasonController::class)->only(['destroy']);
            // Avatar
            Route::resource('avatar', AvatarController::class)->only(['destroy']);
            // Coupon
            Route::resource('coupon', CouponController::class)->only(['destroy']);
            // Producer
            Route::resource('producer', ProducerController::class)->only(['destroy']);
            // User
            Route::resource('user', UserController::class)->only(['destroy']);
            // Cast
            Route::resource('cast', CastController::class)->only(['destroy']);
            // Section
            Route::resource('section', SectionController::class)->only(['show']);
            // Video
            Route::resource('video', VideoController::class)->only(['show']);
            // TVShow
            Route::resource('tvshow', TVShowController::class)->only(['destroy']);
            Route::get('tvshowepisode/delete/{tvshow_id}/{id}', [TVShowController::class, 'TVShowDelete'])->name('tvshow.episode.delete');
            // Upcoming Video
            Route::resource('upcomingvideo', UpcomingVideoController::class)->only(['show']);
            // Upcoming TVShow
            Route::resource('upcomingtvshow', UpcomingTVShowController::class)->only(['destroy']);
            Route::get('upcomingtvshowepisode/delete/{tvshow_id}/{id}', [UpcomingTVShowController::class, 'TVShowDelete'])->name('upcomingtvshow.episode.delete');
            // Channel
            Route::resource('channel', ChannelController::class)->only(['destroy']);
            // Channel Video
            Route::resource('ch_video', ChannelVideoController::class)->only(['show']);
            // Channel TVShow
            Route::resource('ch_tvshow', ChannelTVShowController::class)->only(['destroy']);
            Route::get('ch_tvshowepisode/delete/{tvshow_id}/{id}', [ChannelTVShowController::class, 'TVShowDelete'])->name('ch_tvshow.episode.delete');
            // Kids Video
            Route::resource('kidsvideo', KidsVideoController::class)->only(['show']);
            // Kids TVShow
            Route::resource('kidstvshow', KidsTVShowController::class)->only(['destroy']);
            Route::get('kidstvshowepisode/delete/{tvshow_id}/{id}', [KidsTVShowController::class, 'TVShowDelete'])->name('kidstvshow.episode.delete');
            // Notification
            Route::resource('notification', NotificationController::class)->only(['destroy']);
            Route::get('notifications/setting', [NotificationController::class, 'setting'])->name('notification.setting');
            Route::post('notifications/setting', [NotificationController::class, 'settingsave'])->name('notification.settingsave');
            // Rent Transaction
            Route::resource('renttransaction', RentTransactionController::class)->only(['destroy']);
            // Package
            Route::resource('package', PackageController::class)->only(['destroy']);
            // Transaction
            Route::resource('transaction', TransactionController::class)->only(['destroy']);
            // Payment
            Route::resource('payment', PaymentController::class)->only(['edit', 'update']);
            // System Setting
            Route::get('systemsetting/downloadsqlfile', [SystemSettingController::class, 'DownloadSqlFile'])->name('system.setting.downloadsqlfile');
            // Rent Price List
            Route::resource('rentpricelist', RentPriceListController::class)->only(['destroy']);
        });
    });
});
