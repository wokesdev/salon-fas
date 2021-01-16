<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login', 308);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
});

Route::middleware(['auth.one', 'auth'])->group(function () {
    Route::resource('account', 'AccountController')->except('create', 'show', 'update');
    Route::resource('account-detail', 'AccountDetailController')->except('create', 'show', 'update');
    Route::resource('user', 'UserController')->except('create', 'show', 'update');
    Route::resource('role', 'RoleController')->except('create', 'show', 'update');
    Route::resource('customer', 'CustomerController')->except('create', 'show', 'update');
    Route::resource('supplier', 'SupplierController')->except('create', 'show', 'update');
    Route::resource('service', 'ServiceController')->except('create', 'show', 'update');
    Route::resource('item', 'ItemController')->except('create', 'show', 'update');

    Route::post('account/update', 'AccountController@update')->name('account.update');
    Route::post('account-detail/update', 'AccountDetailController@update')->name('account-detail.update');
    Route::post('user/update', 'UserController@update')->name('user.update');
    Route::post('role/update', 'RoleController@update')->name('role.update');
    Route::post('customer/update', 'CustomerController@update')->name('customer.update');
    Route::post('supplier/update', 'SupplierController@update')->name('supplier.update');
    Route::post('service/update', 'ServiceController@update')->name('service.update');
    Route::post('item/update', 'ItemController@update')->name('item.update');
});

Route::middleware(['auth.two', 'auth'])->group(function () {
    Route::resource('purchase', 'PurchaseController')->except('create', 'update');
    Route::resource('purchase-detail', 'PurchaseDetailController')->except('index', 'create', 'show', 'update');
    Route::resource('sale', 'SaleController')->except('create', 'update');
    Route::resource('sale-detail', 'SaleDetailController')->except('index', 'create', 'show', 'update');
    Route::resource('cash-payment', 'CashPaymentController')->except('create', 'show', 'update');
    Route::resource('cash-receipt', 'CashReceiptController')->except('create', 'show', 'update');

    Route::post('purchase/update', 'PurchaseController@update')->name('purchase.update');
    Route::post('purchase-detail/update', 'PurchaseDetailController@update')->name('purchase-detail.update');
    Route::post('sale/update', 'SaleController@update')->name('sale.update');
    Route::post('sale-detail/update', 'SaleDetailController@update')->name('sale-detail.update');
    Route::post('cash-payment/update', 'CashPaymentController@update')->name('cash-payment.update');
    Route::post('cash-receipt/update', 'CashReceiptController@update')->name('cash-receipt.update');

    Route::post('purchase/getBarang', 'PurchaseController@getBarang')->name('purchase.getBarang');
    Route::get('purchase/{item}/getBarangById', 'PurchaseController@getBarangById')->name('purchase.getBarangById');

    Route::post('purchase/getServis', 'PurchaseController@getServis')->name('purchase.getServis');
    Route::get('purchase/{service}/getServisById', 'PurchaseController@getServisById')->name('purchase.getServisById');
});

Route::middleware(['auth.three', 'auth'])->group(function () {
    Route::resource('general-entry', 'GeneralEntryController')->except('create', 'store', 'show', 'edit', 'update', 'destroy');
    Route::resource('ledger', 'LedgerController')->except('create', 'store', 'show', 'edit', 'update', 'destroy');
    Route::resource('purchase-report', 'PurchaseReportController')->except('create', 'store', 'show', 'edit', 'update', 'destroy');
    Route::resource('sale-report', 'SaleReportController')->except('create', 'store', 'show', 'edit', 'update', 'destroy');
    Route::resource('trial-balance', 'TrialBalanceController')->except('create', 'store', 'show', 'edit', 'update', 'destroy');
    Route::resource('income-statement', 'IncomeStatementController')->except('create', 'store', 'show', 'edit', 'update', 'destroy');
    Route::resource('statement-of-financial-position', 'StatementOfFinancialPositionController')->except('create', 'store', 'show', 'edit', 'update', 'destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard-data-supplier', 'DashboardDataController@supplier')->name('dashboard-data.supplier');
    Route::get('dashboard-data-customer', 'DashboardDataController@customer')->name('dashboard-data.customer');
    Route::get('dashboard-data-purchase', 'DashboardDataController@purchase')->name('dashboard-data.purchase');
    Route::get('dashboard-data-sale', 'DashboardDataController@sale')->name('dashboard-data.sale');
    Route::get('dashboard-data-cash-payment', 'DashboardDataController@cash_payment')->name('dashboard-data.cash-payment');
    Route::get('dashboard-data-cash-receipt', 'DashboardDataController@cash_receipt')->name('dashboard-data.cash-receipt');
});
