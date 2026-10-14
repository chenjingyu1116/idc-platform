<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\KbController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Client\ServiceController as CService;
use App\Http\Controllers\Client\RechargeController as CRecharge;
use App\Http\Controllers\Client\TicketController as CTicket;
use App\Http\Controllers\Client\NotificationController as CNotif;
use App\Http\Controllers\Client\AgentController as CAgent;
use App\Http\Controllers\Client\CouponController as CCoupon;
use App\Http\Controllers\Admin\DashboardController as ADash;
use App\Http\Controllers\Admin\ServiceController as AService;
use App\Http\Controllers\Admin\RechargeController as ARecharge;
use App\Http\Controllers\Admin\ProviderController as AProvider;
use App\Http\Controllers\Admin\TicketController as ATicket;
use App\Http\Controllers\Admin\UserController as AUser;
use App\Http\Controllers\Admin\AnnouncementController as AAnn;
use App\Http\Controllers\Admin\KbController as AKb;
use App\Http\Controllers\Admin\AgentController as AAgent;
use App\Http\Controllers\Admin\CouponController as ACoupon;
use App\Http\Controllers\Admin\MemberLevelController as AMember;
use App\Http\Controllers\Admin\PaymentConfigController as APayment;
use App\Http\Controllers\Admin\ProductMappingController as AMapping;
use App\Http\Controllers\Admin\ProvisionLogController as ALog;
use App\Http\Controllers\Admin\SettingController as ASetting;
use App\Http\Controllers\Admin\ReportController as AReport;
use App\Http\Controllers\Admin\MonitorController as AMonitor;
use Illuminate\Support\Facades\Route;

/* ═══ 首页 ═══ */
Route::get('/', function () {
    return auth()->check() ? redirect()->route('orders.index') : view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('orders.index');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

/* ═══ 公开页面 ═══ */
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
Route::get('/kb', [KbController::class, 'index'])->name('kb.index');
Route::get('/kb/category/{category}', [KbController::class, 'category'])->name('kb.category');
Route::get('/kb/article/{article}', [KbController::class, 'show'])->name('kb.show');
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

/* ═══ 需要登录 ═══ */
Route::middleware(['auth'])->group(function () {

    Route::get('/products', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/client/services', [CService::class, 'index'])->name('client.services.index');
    Route::get('/client/services/{service}', [CService::class, 'show'])->name('client.services.show');

    Route::get('/client/recharge', [CRecharge::class, 'index'])->name('client.recharge.index');
    Route::post('/client/recharge', [CRecharge::class, 'store'])->name('client.recharge.store');

    Route::get('/client/tickets', [CTicket::class, 'index'])->name('client.tickets.index');
    Route::get('/client/tickets/create', [CTicket::class, 'create'])->name('client.tickets.create');
    Route::post('/client/tickets', [CTicket::class, 'store'])->name('client.tickets.store');
    Route::get('/client/tickets/{ticket}', [CTicket::class, 'show'])->name('client.tickets.show');

    Route::get('/client/notifications', [CNotif::class, 'index'])->name('client.notifications.index');
    Route::get('/client/notifications/{id}/read', [CNotif::class, 'markRead'])->name('client.notifications.read');
    Route::post('/client/notifications/read-all', [CNotif::class, 'markAllRead'])->name('client.notifications.readAll');

    Route::get('/client/agent', [CAgent::class, 'index'])->name('client.agent.index');
    Route::get('/client/coupons', [CCoupon::class, 'index'])->name('client.coupons.index');

    /* ═══ 管理员 ═══ */
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [ADash::class, 'index'])->name('dashboard');

        Route::get('/services', [AService::class, 'index'])->name('services.index');
        Route::get('/services/{service}/edit', [AService::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [AService::class, 'update'])->name('services.update');

        Route::get('/provision-logs', [ALog::class, 'index'])->name('provision-logs.index');

        Route::get('/recharges', [ARecharge::class, 'index'])->name('recharges.index');
        Route::post('/recharges/{recharge}/approve', [ARecharge::class, 'approve'])->name('recharges.approve');

        Route::get('/providers', [AProvider::class, 'index'])->name('providers.index');
        Route::get('/providers/create', [AProvider::class, 'create'])->name('providers.create');
        Route::post('/providers', [AProvider::class, 'store'])->name('providers.store');
        Route::get('/providers/{provider}/edit', [AProvider::class, 'edit'])->name('providers.edit');
        Route::put('/providers/{provider}', [AProvider::class, 'update'])->name('providers.update');
        Route::delete('/providers/{provider}', [AProvider::class, 'destroy'])->name('providers.destroy');

        Route::get('/product-mappings', [AMapping::class, 'index'])->name('product-mappings.index');

        Route::get('/payment-configs', [APayment::class, 'index'])->name('payment-configs.index');
        Route::get('/payment-configs/{id}/edit', [APayment::class, 'edit'])->name('payment-configs.edit');
        Route::put('/payment-configs/{id}', [APayment::class, 'update'])->name('payment-configs.update');

        Route::get('/tickets', [ATicket::class, 'index'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [ATicket::class, 'show'])->name('tickets.show');
        Route::post('/tickets/{ticket}/reply', [ATicket::class, 'reply'])->name('tickets.reply');

        Route::get('/users', [AUser::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [AUser::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AUser::class, 'update'])->name('users.update');

        Route::get('/announcements', [AAnn::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create', [AAnn::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [AAnn::class, 'store'])->name('announcements.store');
        Route::delete('/announcements/{announcement}', [AAnn::class, 'destroy'])->name('announcements.destroy');

        Route::get('/kb', [AKb::class, 'index'])->name('kb.index');
        Route::get('/agents', [AAgent::class, 'index'])->name('agents.index');
        Route::get('/coupons', [ACoupon::class, 'index'])->name('coupons.index');
        Route::get('/member-levels', [AMember::class, 'index'])->name('member-levels.index');

        Route::get('/reports', [AReport::class, 'index'])->name('reports.index');
        Route::get('/monitor', [AMonitor::class, 'index'])->name('monitor.index');
        Route::get('/settings', [ASetting::class, 'index'])->name('settings.index');
        Route::post('/settings', [ASetting::class, 'update'])->name('settings.update');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* ═══ B8 新增路由 ═══ */
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\PageController;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [RobotsController::class, 'index'])->name('robots');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/help', [HelpController::class, 'index'])->name('help.index');
Route::get('/help/category/{category}', [HelpController::class, 'category'])->name('help.category');
Route::get('/help/article/{article}', [HelpController::class, 'article'])->name('help.article');
Route::get('/about', [PageController::class, 'about'])->name('page.about');
Route::get('/terms', [PageController::class, 'terms'])->name('page.terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('page.privacy');
Route::get('/contact', [PageController::class, 'contact'])->name('page.contact');
