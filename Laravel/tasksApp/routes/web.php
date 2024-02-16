<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// si l'utilisateur n'est pas authentifier il ne pouras pas avoire acces à cette route
Route::get('/', function () {
    return view('home');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




// Route::prefix('admin')
// ->controller(UserController::class)
// ->name('admin.users.')
// ->middleware('can::admin');
// ->group(function(){

//     Route::get('/users','index')->name('index');
//     Route::get('/users/edit/{user}','edit')->name('edit');
//     Route::get('/users/edit/{user}','update')->name('update');

// } );


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('admin/profile/modifier mot de passe', [ProfileController::class, 'editedPassword'])->name('editedPassword');
    Route::get('admin/profile/information personnelle', [ProfileController::class, 'edited'])->name('edited');
    Route::get('admin/profile/moidifier information personnelle', [ProfileController::class, 'updated'])->name('updated');
});





Route::post('/enregistremen/{id}', [RegisteredUserController::class, 'approveRegistration'])->name('approveRegistration');

Route::get('/approve-registration/{id}', [RegisteredUserController::class, 'showApproveRegistrationForm'])->name('showApproveRegistrationForm');

Route::post('/reject-registration/{id}', [RegisteredUserController::class, 'rejectRegistration'])->name('rejectRegistration');







Route::prefix('admin')
    ->controller(UserController::class)
    ->name('admin.users.')
    //  ->middleware('can::admin')
    ->middleware('auth')
    ->group(function () {

        Route::get('/users', 'index')->name('index');
        Route::get('/users/edit/{user}', 'edit')->name('edit');
        Route::post('/users/update/{user}', 'update')->name('update');
        Route::get('/users/delete/{user}', 'delete')->name('delete');
    });



Route::prefix('task')
    ->controller(TaskController::class)
    ->name('task.')
    //->middleware('can::admin')
    ->middleware('auth')
    ->group(function () {

        Route::get('/', 'index')->name('index');
        Route::get('/assigned', 'MyTask')->name('MyTask');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{task}', 'edit')->name('edit');
        Route::post('/create', 'store')->name('store');
        Route::post('/update/{task}', 'update')->name('update');
        Route::get('/delete/{task}', 'remove')->name('remove');





        Route::get('/assignerTache/{task}', 'assignedView')->name('assignedView');
        Route::post('/assign/{task}', 'assign')->name('assign');








        Route::get('/task/{task}', 'show')->name('show');
        Route::get('/unassign/{task}', 'unassign')->name('unassign');

        Route::get('/unassigned/{task}', 'unassigned')->name('unassigned');


        Route::get('/assignedViews/{task}', 'assignedViews')->name('assignedViews');

        Route::post('/allassigned', 'assigned')->name('assigned');



        Route::get('/alltasks', 'alltasks')->name('alltasks');
        Route::get('/alltasks/delete/{task}', 'removed')->name('removed');
        Route::post('/alltasks/update/{task}', 'updated')->name('updated');



        Route::post('/alltasks/assign/{task}', 'assigned')->name('assigned');

        Route::get('/tasks/{task}', 'showed')->name('showed');


        // Exemple de route dans web.php
        // Route::post('/update-task/{taskId}', 'updateStatus')->name('updateStatus');
        //Pour le boutton marquer comme terminer
        // Route::post('/updated-task/{taskId}', 'updatedStatus')->name('updatedStatus');

        Route::post('/startTask/{task}', 'startTask')->name('startTask');

        Route::post('/maskAsTermined/{task}', 'maskAsTermined')->name('maskAsTermined');
        Route::post('/deleteTask/{task}', 'deleteTask')->name('deleteTask');
    });


Route::prefix('histories')
    ->controller(HistoryController::class)
    ->name('histories.')
    //->middleware('can::admin')
    ->middleware('auth')
    ->group(function () {

        Route::get('/historyIndex', 'historyIndex')->name('historyIndex');
        // Route::get('/show', 'show')->name('show');
        Route::get('/destroyHistory', 'destroyHistory')->name('destroyHistory');
        Route::get('/bilan', 'documentPdf')->name('documentPdf');
        Route::get('/mensuel', 'documentPdf')->name('balanceSheet');
        Route::get('/bilan/{history}', 'show')->name('show');
    });




    Route::prefix('stocks')
    ->middleware(['auth'])
    ->name('stocks.')
    ->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('index');
        Route::get('/create', [StockController::class, 'create'])->name('create');
        Route::post('/azert', [StockController::class, 'store'])->name('store');
        Route::get('/erty/{id}', [StockController::class, 'show'])->name('show');
        Route::get('eeee/{id}', [StockController::class, 'edit'])->name('edit');
        Route::post('/rrrrrr/{id}', [StockController::class, 'update'])->name('update');
        Route::get('/zzzzz/{id}', [StockController::class, 'destroy'])->name('destroy');
    });



    Route::prefix('transactions')
    ->middleware(['auth'])
    ->name('transactions.')
    ->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/create', [TransactionController::class, 'create'])->name('create');
        Route::post('/azert', [TransactionController::class, 'store'])->name('store');
        Route::get('/erty/{id}', [TransactionController::class, 'show'])->name('show');
        Route::get('eeee/{id}', [TransactionController::class, 'edit'])->name('edit');
        Route::post('/rrrrrr/{id}', [TransactionController::class, 'update'])->name('update');
        Route::get('/zzzzz/{id}', [TransactionController::class, 'destroy'])->name('destroy');
    });










    // Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    // Route::get('/stocks/create', [StockController::class, 'create'])->name('stocks.create');
    // Route::post('/stocks', [StockController::class, 'store'])->name('stocks.store');
    // Route::get('/stocks/{id}', [StockController::class, 'show'])->name('stocks.show');
    // Route::get('/stocks/{id}/edit', [StockController::class, 'edit'])->name('stocks.edit');
    // Route::put('/stocks/{id}', [StockController::class, 'update'])->name('stocks.update');
    // Route::delete('/stocks/{id}', [StockController::class, 'destroy'])->name('stocks.destroy');








require __DIR__ . '/auth.php';
