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

use App\Http\Controllers\Producer\ChangePasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Producer\LoginController;
use App\Http\Controllers\Producer\DashboardController;
use App\Http\Controllers\Producer\ProfileController;
use App\Http\Controllers\Producer\ChannelController;
use App\Http\Controllers\Producer\ChannelTVShowController;
use App\Http\Controllers\Producer\ChannelVideoController;
use App\Http\Controllers\Producer\VideoController;
use App\Http\Controllers\Producer\TVShowController;
use App\Http\Controllers\Producer\UpcomingTVShowController;
use App\Http\Controllers\Producer\UpcomingVideoController;
use App\Http\Controllers\Producer\KidsTVShowController;
use App\Http\Controllers\Producer\KidsVideoController;

Route::group(['middleware' => 'installation'], function () {

    // Login-Logout
    Route::get('login', [LoginController::class, 'login'])->name('producer.login')->middleware('purchasecodeverify');
    Route::post('login', [LoginController::class, 'save_login'])->name('producer.save.login');
    Route::get('logout', [LoginController::class, 'logout'])->name('producer.logout');

    Route::group(['middleware' => 'authproducer'], function () {

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('producer.dashboard');
        // Profile
        Route::resource('pprofile', ProfileController::class)->only(['index', 'update']);
        // Change Password
        Route::resource('pchangepassword', ChangePasswordController::class)->only(['index', 'update']);
        // Video
        Route::resource('pvideo', VideoController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        Route::get('pvideo/details/{id}', [VideoController::class, 'videoDetails'])->name('pvideo.details');
        Route::post('pvideo/serachname/{txtVal}', [VideoController::class, 'SerachName'])->name('pvideo.serach.name');
        Route::post('pvideo/getdata/{id}', [VideoController::class, 'GetData'])->name('pvideo.getdata');
        // TVShow
        Route::resource('ptvshow', TVShowController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        Route::get('ptvshow/details/{id}', [TVShowController::class, 'tvshowDetails'])->name('ptvshow.details');
        Route::post('ptvshow/serachname/{txtVal}', [TVShowController::class, 'SerachName'])->name('ptvshow.serach.name');
        Route::post('ptvshow/getdata/{id}', [TVShowController::class, 'GetData'])->name('ptvshow.getdata');
        Route::get('ptvshowepisode/{id}', [TVShowController::class, 'TVShowIndex'])->name('ptvshow.episode.index');
        Route::get('ptvshowepisode/add/{id}', [TVShowController::class, 'TVShowAdd'])->name('ptvshow.episode.add');
        Route::post('ptvshowepisode/save', [TVShowController::class, 'TVShowSave'])->name('ptvshow.episode.save');
        Route::get('ptvshowepisode/edit/{tvshow_id}/{id}', [TVShowController::class, 'TVShowEdit'])->name('ptvshow.episode.edit');
        Route::post('ptvshowepisode/update/{tvshow_id}/{id}', [TVShowController::class, 'TVShowUpdate'])->name('ptvshow.episode.update');
        Route::post('ptvshowepisode/sortable', [TVShowController::class, 'TVShowSortable'])->name('ptvshow.episode.sortable');
        // Upcoming Video
        Route::resource('pupcomingvideo', UpcomingVideoController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        Route::get('pupcomingvideo/details/{id}', [UpcomingVideoController::class, 'upcomingVideoDetails'])->name('pupcomingvideo.details');
        Route::post('pupcomingvideoreleases', [UpcomingVideoController::class, 'videoReleases'])->name('pupcomingvideo.releases');
        // Upcoming TVShow
        Route::resource('pupcomingtvshow', UpcomingTVShowController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        Route::get('pupcomingtvshow/details/{id}', [UpcomingTVShowController::class, 'upcomingTVShowDetails'])->name('pupcomingtvshow.details');
        Route::post('pupcomingtvshowreleases', [UpcomingTVShowController::class, 'showReleases'])->name('pupcomingtvshow.releases');
        Route::get('pupcomingtvshowepisode/{id}', [UpcomingTVShowController::class, 'TVShowIndex'])->name('pupcomingtvshow.episode.index');
        Route::get('pupcomingtvshowepisode/add/{id}', [UpcomingTVShowController::class, 'TVShowAdd'])->name('pupcomingtvshow.episode.add');
        Route::post('pupcomingtvshowepisode/save', [UpcomingTVShowController::class, 'TVShowSave'])->name('pupcomingtvshow.episode.save');
        Route::get('pupcomingtvshowepisode/edit/{tvshow_id}/{id}', [UpcomingTVShowController::class, 'TVShowEdit'])->name('pupcomingtvshow.episode.edit');
        Route::post('pupcomingtvshowepisode/update/{tvshow_id}/{id}', [UpcomingTVShowController::class, 'TVShowUpdate'])->name('pupcomingtvshow.episode.update');
        Route::post('pupcomingtvshowepisode/sortable', [UpcomingTVShowController::class, 'TVShowSortable'])->name('pupcomingtvshow.episode.sortable');
        // Channel
        Route::resource('pchannel', ChannelController::class)->only(['index']);
        // Channel Video
        Route::resource('pch_video', ChannelVideoController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        Route::get('pch_video/details/{id}', [ChannelVideoController::class, 'channelVideoDetails'])->name('pch_video.details');
        // Channel TVShow
        Route::resource('pch_tvshow', ChannelTVShowController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        Route::get('pch_tvshow/details/{id}', [ChannelTVShowController::class, 'channelTVShowDetails'])->name('pch_tvshow.details');
        Route::get('pch_tvshowepisode/{id}', [ChannelTVShowController::class, 'TVShowIndex'])->name('pch_tvshow.episode.index');
        Route::get('pch_tvshowepisode/add/{id}', [ChannelTVShowController::class, 'TVShowAdd'])->name('pch_tvshow.episode.add');
        Route::post('pch_tvshowepisode/save', [ChannelTVShowController::class, 'TVShowSave'])->name('pch_tvshow.episode.save');
        Route::get('pch_tvshowepisode/edit/{tvshow_id}/{id}', [ChannelTVShowController::class, 'TVShowEdit'])->name('pch_tvshow.episode.edit');
        Route::post('pch_tvshowepisode/update/{tvshow_id}/{id}', [ChannelTVShowController::class, 'TVShowUpdate'])->name('pch_tvshow.episode.update');
        Route::post('pch_tvshowepisode/sortable', [ChannelTVShowController::class, 'TVShowSortable'])->name('pch_tvshow.episode.sortable');
        // Kids Video
        Route::resource('pkidsvideo', KidsVideoController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        Route::get('pkidsvideo/details/{id}', [KidsVideoController::class, 'kidsVideoDetails'])->name('pkidsvideo.details');
        // Kids TVShow
        Route::resource('pkidstvshow', KidsTVShowController::class)->only(['index', 'create', 'edit', 'store', 'update']);
        Route::get('pkidstvshow/details/{id}', [KidsTVShowController::class, 'kidsTVShowDetails'])->name('pkidstvshow.details');
        Route::get('pkidstvshowepisode/{id}', [KidsTVShowController::class, 'TVShowIndex'])->name('pkidstvshow.episode.index');
        Route::get('pkidstvshowepisode/add/{id}', [KidsTVShowController::class, 'TVShowAdd'])->name('pkidstvshow.episode.add');
        Route::post('pkidstvshowepisode/save', [KidsTVShowController::class, 'TVShowSave'])->name('pkidstvshow.episode.save');
        Route::get('pkidstvshowepisode/edit/{tvshow_id}/{id}', [KidsTVShowController::class, 'TVShowEdit'])->name('pkidstvshow.episode.edit');
        Route::post('pkidstvshowepisode/update/{tvshow_id}/{id}', [KidsTVShowController::class, 'TVShowUpdate'])->name('pkidstvshow.episode.update');
        Route::post('pkidstvshowepisode/sortable', [KidsTVShowController::class, 'TVShowSortable'])->name('pkidstvshow.episode.sortable');

        Route::group(['middleware' => 'checkadmin'], function () {

            // Video
            Route::resource('pvideo', VideoController::class)->only(['show']);
            // TVShow
            Route::resource('ptvshow', TVShowController::class)->only(['destroy']);
            Route::get('ptvshowepisode/delete/{tvshow_id}/{id}', [TVShowController::class, 'TVShowDelete'])->name('ptvshow.episode.delete');
            // Upcoming Video
            Route::resource('pupcomingvideo', UpcomingVideoController::class)->only(['show']);
            // Upcoming TVShow
            Route::resource('pupcomingtvshow', UpcomingTVShowController::class)->only(['destroy']);
            Route::get('pupcomingtvshowepisode/delete/{tvshow_id}/{id}', [UpcomingTVShowController::class, 'TVShowDelete'])->name('pupcomingtvshow.episode.delete');
            // Channel Video
            Route::resource('pch_video', ChannelVideoController::class)->only(['show']);
            // Channel TVShow
            Route::resource('pch_tvshow', ChannelTVShowController::class)->only(['destroy']);
            Route::get('pch_tvshowepisode/delete/{tvshow_id}/{id}', [ChannelTVShowController::class, 'TVShowDelete'])->name('pch_tvshow.episode.delete');
            // Kids Video
            Route::resource('pkidsvideo', KidsVideoController::class)->only(['show']);
            // Kids TVShow
            Route::resource('pkidstvshow', KidsTVShowController::class)->only(['destroy']);
            Route::get('pkidstvshowepisode/delete/{tvshow_id}/{id}', [KidsTVShowController::class, 'TVShowDelete'])->name('pkidstvshow.episode.delete');
        });
    });
});
