    <?php

    use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
    use App\Http\Controllers\admin\Form as AdminForm;
    use App\Http\Controllers\admin\LoginController as AdminLoginController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\Form;
    use App\Http\Controllers\History;
    use App\Http\Controllers\LoginController;
    use Illuminate\Support\Facades\Route;

    // Route::get('/', function () {
    //     return view('welcome');
    // });

    Route::group(['prefix' => 'account'], function () {
        Route::group(['middleware' => 'guest'], function () {
            Route::get('login', [LoginController::class, 'index'])->name('account.login');
            Route::get('register', [LoginController::class, 'register'])->name('account.register');
            Route::post('process-register', [LoginController::class, 'processRegister'])->name('account.processRegister');
            Route::post('authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
        });

        Route::group(['middleware' => 'auth'], function () {
            Route::get('logout', [LoginController::class, 'logout'])->name('account.logout');
            Route::get('dashboard', [Form::class, 'index'])->name('account.dashboard');
            Route::get('form', [Form::class, 'create'])->name('account.form.create');
            Route::post('form', [Form::class, 'store'])->name('account.form.store');
            Route::get('form/{id}', [Form::class, 'show'])->name('account.form.show');
            Route::get('/form/{id}/edit', [Form::class, 'edit'])->name('account.form.edit');
            Route::post('/form/{id}/update', [Form::class, 'update'])->name('account.form.update');
            Route::delete('/form/{id}', [Form::class, 'destroy'])->name('account.form.destroy');
            Route::get('history', [History::class, 'index'])->name('account.history');
            Route::get('history/{id}', [History::class, 'show'])->name('account.history.show');
            Route::get('/history/{id}/edit', [History::class, 'edit'])->name('account.history.edit');
            Route::post('/history/{id}/update', [History::class, 'update'])->name('account.history.update');
            Route::delete('/history/{id}', [History::class, 'destroy'])->name('account.history.destroy');
        });
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::group(['middleware' => 'admin.guest'], function () {
            Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
            Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
        });

        Route::group(['middleware' => 'admin.auth'], function () {
            Route::get('dashboard', [AdminForm::class, 'index'])->name('admin.dashboard');
            Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
            Route::get('form/{id}', [AdminForm::class, 'show'])->name('admin.form.show');
            Route::delete('/form/{id}', [AdminForm::class, 'destroy'])->name('admin.form.destroy');
            Route::patch('/admin/form/{id}/update-status', [AdminForm::class, 'updateStatus'])->name('admin.form.updateStatus');
        });
    });
