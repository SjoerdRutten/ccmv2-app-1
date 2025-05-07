<?php

use Illuminate\Support\Facades\Route;

Route::domain(config('app.url'))
    ->get('/', function () {
        return redirect()->route('ccm::dashboard');
    });

Route::middleware([
    'auth:sanctum',
    'verified',
    'web',
])
    ->group(function (): void {
        Route::prefix('admin')
            ->name('admin::')
            ->group(function (): void {
                Route::prefix('customers')
                    ->group(
                        function (): void {
                            Route::get('/add', \Sellvation\CCMV2\Ccm\Livewire\Admin\Customers\Edit::class)->name('customers::add');
                            Route::get('/{customer}', \Sellvation\CCMV2\Ccm\Livewire\Admin\Customers\Edit::class)->name('customers::edit');
                            Route::get('/', \Sellvation\CCMV2\Ccm\Livewire\Admin\Customers\Overview::class)->name('customers');
                        }
                    );

                Route::prefix('environments')
                    ->group(
                        function (): void {
                            Route::get('/new', \Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Edit::class)->name('environments::add');
                            Route::get('/{environment}', \Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Edit::class)->name('environments::edit');
                            Route::get('/', \Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Overview::class)->name('environments');
                        }
                    );

                Route::prefix('servers')
                    ->name('servers::')
                    ->group(
                        function (): void {
                            Route::get('/new', \Sellvation\CCMV2\Ccm\Livewire\Admin\Servers\Edit::class)->name('add');
                            Route::get('/{server}', \Sellvation\CCMV2\Ccm\Livewire\Admin\Servers\Edit::class)->name('edit');
                            Route::get('/', \Sellvation\CCMV2\Ccm\Livewire\Admin\Servers\Overview::class)->name('overview');
                        }
                    );

                Route::prefix('queues')
                    ->group(
                        function (): void {
                            Route::get('/', \Sellvation\CCMV2\Ccm\Livewire\Admin\Queues\Overview::class)->name('queues');
                            Route::get('/{queue}', \Sellvation\CCMV2\Ccm\Livewire\Admin\Queues\View::class)->name('queues::view');
                        }
                    );
            });

        Route::name('ccm::')
            ->group(function (): void {
                Route::get('/dashboard', \Sellvation\CCMV2\Ccm\Http\Controllers\DashboardController::class)->name('dashboard');
                Route::get('/notifications', \Sellvation\CCMV2\Ccm\Livewire\Notifications\Overview::class)->name('notifications');
                Route::get('/typesense/collection/{collectionName}', \Sellvation\CCMV2\Ccm\Livewire\Typesense\Collection::class)->name('typesense.collection');
                Route::get('/typesense/collection/{collectionName}/reindex', \Sellvation\CCMV2\Ccm\Controllers\TypesenseReindexCollectionController::class)->name('typesense.reindex');
            });

        Route::prefix('jsapi')
            ->name('jsapi::')
            ->group(function (): void {
                Route::get('/product/search', [\Sellvation\CCMV2\Ccm\Controllers\SearchProductsController::class, 'search'])->name('product.search');
                Route::get('/product/selected', [\Sellvation\CCMV2\Ccm\Controllers\SearchProductsController::class, 'selected'])->name('product.selected');
            });
    });
