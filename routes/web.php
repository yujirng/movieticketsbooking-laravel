<?php

use App\Http\Controllers\ActorsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ScreenController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DirectorsController;
use App\Http\Middleware\ShareGenres;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/login', [AdminController::class, 'create'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'store']);
Route::post('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

    Route::redirect('/', '/admin/dashboard')->name('index');
    // Route::get('/', [GenreController::class, 'index'])->name('index');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('genres', GenreController::class);
    Route::get('genres/{genre}/delete', [GenreController::class, 'delete'])->name('genres.delete');

    Route::resource('movies', MovieController::class);
    Route::resource('theaters', TheaterController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('screens', ScreenController::class);
    Route::resource('showtimes', controller: ShowtimeController::class);
    Route::resource('bookings', controller: BookingController::class);
    Route::resource('actors', controller: ActorsController::class);
    Route::resource('directors', controller: DirectorsController::class);
    Route::resource('users', controller: UserController::class);

    Route::get('statistical', [AdminController::class, 'statistical'])->name('statistical');

    Route::get('slider', [AdminController::class, 'slider'])->name('slider');

    Route::prefix('feedbacks')->group(function () {
        Route::get('/', [FeedbackController::class, 'index'])->name('feedbacks.index');
        Route::delete('{feedback}', [FeedbackController::class, 'destroy'])->name('feedbacks.destroy');
    });
});

Route::get('/', [MovieController::class, 'indexMovie'])->name('app.index');
Route::get('/details/{id}', [MovieController::class, 'detailMovie'])->name('movie.details');
Route::get('/allmovies', [MovieController::class, 'allMovies'])->name('app.movies.all');
Route::get('/about', [AppController::class, 'about'])->name('app.about');
Route::get('/contacts', [AppController::class, 'contacts'])->name('app.contacts');
Route::get('/feedback', [AppController::class, 'feedback'])->name('app.feedback');

Route::middleware([ShareGenres::class])->group(function () {
    Route::get('/', [MovieController::class, 'indexMovie'])->name('app.index');
    Route::get('/details/{id}', [MovieController::class, 'detailMovie'])->name('movie.details');
    Route::get('/allmovies', [MovieController::class, 'allMovies'])->name('app.movies.all');
    Route::get('/about', [AppController::class, 'about'])->name('app.about');
    Route::get('/contacts', [AppController::class, 'contacts'])->name('app.contacts');
    Route::get('/feedback', [AppController::class, 'feedback'])->name('app.feedback');
});

Route::get('/movies/fetch', [MovieController::class, 'fetch'])->name('movies.fetch');
Route::get('/showtimes/fetch', [ShowtimeController::class, 'getShowtimes'])->name('showtimes.fetch');

Route::middleware('auth')->group(function () {
    Route::get('/seatbooking', [AppController::class, 'seatbooking'])->name('seatbooking');
    Route::post('/payment', [AppController::class, 'showBookingSummary'])->name('payment');
    Route::post('/payment/process', [BookingController::class, 'paymentProcess'])->name('payment.process');
    Route::post('/ticket_show', [AppController::class, 'vnpayPayment'])->name('payment.vnpay');
    Route::post('/showticket', [AppController::class, 'showTicket'])->name('showticket');
    // VNPAY
    Route::post('/payment/vnpay', [BookingController::class, 'createPayment'])->name('payment.vnpay');
    Route::get("/vnpay/return", [BookingController::class, 'vnpayReturn'])->name('vnpay.return');
    // MOMO
    Route::post("/payment/momo", [BookingController::class, 'momoPayment'])->name('payment.momo');
    Route::get("/payment/momo/checkout", [BookingController::class, 'momoPaymentCheckout'])->name('payment.momo.checkout');
});

// Route::get('/login', [AppController::class, 'seatbooking'])->name('login');

require __DIR__ . '/auth.php';

Route::get('/user-information', [AppController::class, 'showUserInformation'])->name('user.information');
Route::get('/booking-history', [AppController::class, 'bookingHistory'])->name('user.booking.history');
Route::post('/user-information/update', [AppController::class, 'updateUserInformation'])->name('user.information.update');
Route::post('/change-password', [AppController::class, 'changePassword'])->name('user.changepassword');

Route::get('/notifications', [AppController::class, 'showUserNotifications'])->name('user.notifications');
Route::get('/gifts', [AppController::class, 'showUserGifts'])->name('user.gifts');

Route::post('/set-timezone', [AppController::class, 'setTimezone'])->name('set-timezone');
