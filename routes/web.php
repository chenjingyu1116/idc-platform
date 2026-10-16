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
    if (!auth()->check()) {
        return view('welcome');
    }
    return auth()->user()->is_admin
        ? redirect()->route('admin.dashboard')
        : redirect()->route('orders.index');
})->name('home');

// 官网首页（无论是否登录都可以看）
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');
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
    Route::get('/product/{product}', [\App\Http\Controllers\Client\ProductController::class, 'show'])->name('product.show');
    Route::get('/products/compare', [\App\Http\Controllers\Client\ProductController::class, 'compare'])->name('products.compare');

    // 购物车
    Route::get('/cart', [\App\Http\Controllers\Client\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [\App\Http\Controllers\Client\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [\App\Http\Controllers\Client\CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [\App\Http\Controllers\Client\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [\App\Http\Controllers\Client\CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/checkout', [\App\Http\Controllers\Client\CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/apply-coupon', [\App\Http\Controllers\Client\CartController::class, 'applyCoupon'])->name('cart.apply-coupon');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/client/services', [CService::class, 'index'])->name('client.services.index');
    Route::get('/client/services/{service}', [CService::class, 'show'])->name('client.services.show');

    Route::get('/client/recharge', [CRecharge::class, 'index'])->name('client.recharge.index');
    Route::post('/client/recharge', [CRecharge::class, 'store'])->name('client.recharge.store');

    Route::get('/client/tickets', [CTicket::class, 'index'])->name('client.tickets.index');
    Route::get('/client/tickets/create', [CTicket::class, 'create'])->name('client.tickets.create');
    Route::post('/client/tickets', [CTicket::class, 'store'])->name('client.tickets.store');
    Route::get('/client/tickets/{ticket}', [CTicket::class, 'show'])->name('client.tickets.show');
    Route::post('/client/tickets/{ticket}/reply', [CTicket::class, 'reply'])->name('client.tickets.reply');

    Route::get('/client/notifications', [CNotif::class, 'index'])->name('client.notifications.index');
    Route::get('/client/notifications/{id}/read', [CNotif::class, 'markRead'])->name('client.notifications.read');
    Route::post('/client/notifications/read-all', [CNotif::class, 'markAllRead'])->name('client.notifications.readAll');

    Route::get('/client/agent', [CAgent::class, 'index'])->name('client.agent.index');
    Route::get('/client/coupons', [CCoupon::class, 'index'])->name('client.coupons.index');

    /* ═══ 管理员 ═══ */
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        
Route::get('/dashboard', [ADash::class, 'index'])->name('dashboard');
        Route::get('/orders/export', [\App\Http\Controllers\Admin\OrderController::class, 'export'])->name('orders.export');
        Route::get('/users/export', [\App\Http\Controllers\Admin\UserController::class, 'export'])->name('users.export');
        Route::post('/users/{user}/adjust-balance', [\App\Http\Controllers\Admin\UserController::class, 'adjustBalance'])->name('users.adjust-balance');
        Route::post('/users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::post('/services/{service}/suspend', [\App\Http\Controllers\Admin\ServiceController::class, 'suspend'])->name('services.suspend');
        Route::post('/services/{service}/unsuspend', [\App\Http\Controllers\Admin\ServiceController::class, 'unsuspend'])->name('services.unsuspend');
        Route::post('/services/{service}/terminate', [\App\Http\Controllers\Admin\ServiceController::class, 'terminate'])->name('services.terminate');
        Route::post('/recharges/{recharge}/reject', [\App\Http\Controllers\Admin\RechargeController::class, 'reject'])->name('recharges.reject');
        Route::post('/recharges/batch-approve', [\App\Http\Controllers\Admin\RechargeController::class, 'batchApprove'])->name('recharges.batch-approve');

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
        Route::get('/product-mappings/create', [AMapping::class, 'create'])->name('product-mappings.create');
        Route::post('/product-mappings', [AMapping::class, 'store'])->name('product-mappings.store');
        Route::delete('/product-mappings/{productMapping}', [AMapping::class, 'destroy'])->name('product-mappings.destroy');

        Route::get('/payment-configs', [APayment::class, 'index'])->name('payment-configs.index');
        Route::get('/payment-configs/create', [APayment::class, 'create'])->name('payment-configs.create');
        Route::post('/payment-configs', [APayment::class, 'store'])->name('payment-configs.store');
        Route::get('/payment-configs/{id}/edit', [APayment::class, 'edit'])->name('payment-configs.edit');
        Route::put('/payment-configs/{id}', [APayment::class, 'update'])->name('payment-configs.update');
        Route::delete('/payment-configs/{id}', [APayment::class, 'destroy'])->name('payment-configs.destroy');
        Route::get('/payment-configs/{id}/edit', [APayment::class, 'edit'])->name('payment-configs.edit');
        Route::put('/payment-configs/{id}', [APayment::class, 'update'])->name('payment-configs.update');

        Route::get('/tickets', [ATicket::class, 'index'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [ATicket::class, 'show'])->name('tickets.show');
        Route::post('/tickets/{ticket}/reply', [ATicket::class, 'reply'])->name('tickets.reply');
        Route::post('/tickets/{ticket}/close', [ATicket::class, 'close'])->name('tickets.close');

        Route::get('/users', [AUser::class, 'index'])->name('users.index');
        Route::get('/users/export', [AUser::class, 'export'])->name('users.export');
        Route::get('/orders/export', [\App\Http\Controllers\Admin\OrderController::class, 'export'])->name('orders.export');
        Route::post('/recharges/batch-approve', [ARecharge::class, 'batchApprove'])->name('recharges.batchApprove');
        Route::get('/users/{user}/edit', [AUser::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AUser::class, 'update'])->name('users.update');

        Route::get('/announcements', [AAnn::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create', [AAnn::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [AAnn::class, 'store'])->name('announcements.store');
        Route::delete('/announcements/{announcement}', [AAnn::class, 'destroy'])->name('announcements.destroy');

        Route::get('/kb', [AKb::class, 'index'])->name('kb.index');
        Route::get('/kb/category/create', [AKb::class, 'createCategory'])->name('kb.createCategory');
        Route::post('/kb/category', [AKb::class, 'storeCategory'])->name('kb.storeCategory');
        Route::get('/kb/article/create', [AKb::class, 'createArticle'])->name('kb.createArticle');
        Route::post('/kb/article', [AKb::class, 'storeArticle'])->name('kb.storeArticle');
        Route::delete('/kb/article/{article}', [AKb::class, 'destroyArticle'])->name('kb.destroyArticle');

        // KB 完整 CRUD
        Route::get('/agents', [AAgent::class, 'index'])->name('agents.index');
        Route::get('/agents/create', [AAgent::class, 'create'])->name('agents.create');
        Route::post('/agents', [AAgent::class, 'store'])->name('agents.store');
        Route::get('/coupons', [ACoupon::class, 'index'])->name('coupons.index');

        // 优惠券完整 CRUD
        Route::get('/coupons/create', [ACoupon::class, 'create'])->name('coupons.create');
        Route::post('/coupons', [ACoupon::class, 'store'])->name('coupons.store');
        Route::delete('/coupons/{coupon}', [ACoupon::class, 'destroy'])->name('coupons.destroy');
        Route::get('/coupons/{coupon}/distribute', [ACoupon::class, 'distribute'])->name('coupons.distribute');
        Route::post('/coupons/{coupon}/distribute', [ACoupon::class, 'doDistribute'])->name('coupons.doDistribute');

        // 知识库完整 CRUD

        // 代理提现管理
        Route::get('/agents/withdrawals', [AAgent::class, 'withdrawals'])->name('agents.withdrawals');
        Route::post('/agents/withdrawals/{withdrawal}/approve', [AAgent::class, 'approveWithdrawal'])->name('agents.withdrawals.approve');
        Route::post('/agents/withdrawals/{withdrawal}/reject', [AAgent::class, 'rejectWithdrawal'])->name('agents.withdrawals.reject');
        Route::get('/member-levels', [AMember::class, 'index'])->name('member-levels.index');
        // 审计日志
        Route::get('/audit-logs', [\App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('/audit-logs/login', [\App\Http\Controllers\Admin\AuditLogController::class, 'login'])->name('audit-logs.login');

        // 财务管理
        Route::get('/finance', [\App\Http\Controllers\Admin\FinanceController::class, 'index'])->name('finance.index');

        // 管理员账号
        Route::get('/admins', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('admins.index');
        // 提现审核
        Route::get('/withdrawals', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::post('/withdrawals/{withdrawal}/approve', [\App\Http\Controllers\Admin\WithdrawalController::class, 'approve'])->name('withdrawals.approve');
        Route::post('/withdrawals/{withdrawal}/reject', [\App\Http\Controllers\Admin\WithdrawalController::class, 'reject'])->name('withdrawals.reject');

        Route::get('/reports', [AReport::class, 'index'])->name('reports.index');
        Route::get('/monitor', [AMonitor::class, 'index'])->name('monitor.index');
        Route::get('/settings', [ASetting::class, 'index'])->name('settings.index');
        Route::post('/settings', [ASetting::class, 'update'])->name('settings.update');

        // ─── 审计日志 ───

        // ─── 提现审核 ───

        // ─── 财务管理 ───

        // ─── 管理员账号 ───


        // 支付配置路由别名（兼容视图中的 admin.payments.* 引用）
        Route::get('/payments', [APayment::class, 'index'])->name('payments.index');
        Route::post('/payments', [APayment::class, 'store'])->name('payments.store');
        Route::put('/payments/{id}', [APayment::class, 'update'])->name('payments.update');

        Route::post('/product-mappings', [AMapping::class, 'store'])->name('product-mappings.store');
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

/* ═══ B9 后台增强：产品/订单/用户/公告 ═══ */
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // 产品
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

    // 订单
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

    // 用户增强
    Route::get('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/adjust-balance', [\App\Http\Controllers\Admin\UserController::class, 'adjustBalance'])->name('users.adjust-balance');
    Route::post('/users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // 公告完整 CRUD
    Route::get('/announcements/{announcement}/edit', [\App\Http\Controllers\Admin\AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'update'])->name('announcements.update');
});

    // ─── 审计日志 ───
    Route::get("/audit-logs", [\App\Http\Controllers\Admin\AuditLogController::class, "index"])->name("audit-logs.index");
    Route::get("/audit-logs/login", [\App\Http\Controllers\Admin\AuditLogController::class, "login"])->name("audit-logs.login");

    // ─── 提现审核 ───
    Route::get("/withdrawals", [\App\Http\Controllers\Admin\WithdrawalController::class, "index"])->name("withdrawals.index");
    Route::post("/withdrawals/{withdrawal}/approve", [\App\Http\Controllers\Admin\WithdrawalController::class, "approve"])->name("withdrawals.approve");
    Route::post("/withdrawals/{withdrawal}/reject", [\App\Http\Controllers\Admin\WithdrawalController::class, "reject"])->name("withdrawals.reject");

    // ─── 财务 ───
    Route::get("/finance", [\App\Http\Controllers\Admin\FinanceController::class, "index"])->name("finance.index");

    // ─── 管理员账号 ───
    Route::get("/admins", [\App\Http\Controllers\Admin\AdminUserController::class, "index"])->name("admins.index");

/* ═══ 支付 ═══ */
Route::middleware(['auth'])->group(function () {
    Route::get('/payment/checkout/{order}', [\App\Http\Controllers\Payment\PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/payment/pay/{order}', [\App\Http\Controllers\Payment\PaymentController::class, 'pay'])->name('payment.pay');
});

// 回调路由（无需登录、无需 CSRF）
Route::post('/payment/notify', [\App\Http\Controllers\Payment\PaymentController::class, 'notify'])->name('payment.notify');
Route::get('/payment/return', [\App\Http\Controllers\Payment\PaymentController::class, 'return'])->name('payment.return');