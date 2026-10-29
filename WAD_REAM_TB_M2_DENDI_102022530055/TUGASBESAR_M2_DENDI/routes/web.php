    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\PenghuniController;

    Route::get('/', function () {
        return view('welcome');
    });

    Route::resource('penghuni', PenghuniController::class);