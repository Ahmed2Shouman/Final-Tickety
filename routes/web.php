<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Auth\LoginController,
    Auth\LogoutController,
    Auth\RegisterController,
    AdminController,
    BookingController,
    CinemaController,
    CompanyController,
    HallController,
    MovieController,
    PaymentController,
    RoleController,
    SeatController,
    ShowtimeController,
    StaffController,
    SuperAdminController,
    UserController,
    Controller,

};


// Homepage
Route::get('/', fn() => view('layouts.home'))->name('home');

Route::get('/About', fn() => view('layouts.about'))->name('about');
Route::get('/Contact-Us', fn() => view('layouts.contactus'))->name('contactus');
Route::get('/Help', fn() => view('layouts.help'))->name('help');

//Authentication Routes (for guests only)
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showloginform'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

});






// Logout Route (for authenticated users)
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');


// Global Resource Routes (protected)
Route::middleware(['auth'])->group(function () {
    Route::resources([
        'movies'    => MovieController::class,
        'cinemas'   => CinemaController::class,
        'halls'     => HallController::class,
        'roles'     => RoleController::class,
        'showtimes' => ShowtimeController::class,
        'seats'     => SeatController::class,
        'bookings'  => BookingController::class,
        'companies' => CompanyController::class,
        'payments'  => PaymentController::class,
    ]);

    Route::get('/halls/{hall}/seats', [HallController::class, 'viewSeats'])->name('halls.view_seats');
    Route::put('/seats/update-bulk/{hall}', [SeatController::class, 'updateBulk'])->name('seats.update_bulk');
});


//////////////////////////!

// Super Admin Routes
Route::middleware(['auth', 'issuperadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    
    // Dashboard Route
    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');

    //manage admin
    Route::get('/create-admin', [SuperAdminController::class, 'createAdminForm'])->name('manage_admins.create');
    Route::post('/create-admin', [SuperAdminController::class, 'storeAdmin'])->name('store_admin');
    Route::get('/view-admins', [SuperAdminController::class, 'viewAdmins'])->name('manage_admins.index');
    Route::get('/edit-admin/{id}', [SuperAdminController::class, 'editAdmin'])->name('manage_admins.edit'); // Pass admin ID
    Route::post('/update-admin/{id}', [SuperAdminController::class, 'updateAdmin'])->name('manage_admins.update'); // Pass admin ID
    Route::delete('/delete-admin/{id}', [SuperAdminController::class, 'deleteAdmin'])->name('manage_admins.delete'); // Pass admin ID

    // User Management Routes
    Route::get('/view-users', [SuperAdminController::class, 'viewUsers'])->name('manage_users.index');  // View All Users
    Route::get('/users/profile/{id}', [UserController::class, 'viewProfile'])->name('users.profile');  // View Specific User Profile

    // Payments and Bookings Management Routes
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');  // View All Payments
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');  // View All Bookings

    // Super Admin Profile Routes
    Route::get('/profile', [SuperAdminController::class, 'profile'])->name('profile');  // View Super Admin Profile
    Route::put('/profile/{id}', [SuperAdminController::class, 'updateProfile'])->name('update_profile'); // Make sure the name is 'admin.update_profile'

    // Subscription Settings Route
    Route::get('/subscription-settings', [SuperAdminController::class, 'subscriptionSettings'])->name('subscription_settings');
    Route::post('/subscription-settings', [SuperAdminController::class, 'updateSubscription'])->name('update_subscription');
    // Route to show the payment view
    Route::get('/payment/{planId}', [SuperAdminController::class, 'showPaymentView'])->name('payment');
 Route::post('/checkout/{planId}', [SuperAdminController::class, 'checkout'])->name('checkout');

    

    Route::get('/checkout-success', [SuperAdminController::class, 'checkoutSuccess'])->name('checkout_success');

    Route::get('/checkout-cancel', [SuperAdminController::class, 'checkoutCancel'])->name('checkout_cancel');



    Route::get('/report/subscription', [SuperAdminController::class, 'subscriptionReport'])->name('report.subscription');
    Route::get('/report/revenue', [SuperAdminController::class, 'revenueReport'])->name('report.revenue');
    Route::get('/report/usage', [SuperAdminController::class, 'usageReport'])->name('report.usage');

    Route::get('/report/user-purchases', [SuperAdminController::class, 'userPurchasesReport'])->name('report.user_purchases');


});



//////////////////////////!

Route::middleware(['auth', 'isadmin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Create Staff Routes
    Route::get('/view-staff', [AdminController::class, 'viewStaff'])->name('manage_staff.viewStaff');
    Route::get('/create-staff', [AdminController::class, 'createStaffForm'])->name('manage_staff.createStaffForm');
    Route::post('/store-staff', [AdminController::class, 'store'])->name('storeStaff');
    
    // Edit Staff Routes
    Route::get('/edit-staff/{id}', [AdminController::class, 'edit'])->name('manage_staff.edit');
    Route::post('/update-staff/{id}', [AdminController::class, 'update'])->name('manage_staff.updateStaff');
    
    // Delete Staff Routes
    Route::delete('/delete-staff/{id}', [AdminController::class, 'delete'])->name('manage_staff.delete');

    // Task Assignment Routes
    Route::get('/manage-staff/assign-task', [AdminController::class, 'assignTaskForm'])->name('manage_staff.assignTaskForm');
    Route::post('/manage-staff/assign-task', [AdminController::class, 'assignTask'])->name('manage_staff.assignTask');
    
// Route to view assignments of a staff member
    Route::get('/admin/staff/{staff_id}/assignments', [AdminController::class, 'viewAssignments'])->name('manage_staff.viewAssignments');
  



    Route::get('/profile', [AdminController::class, 'profile'])->name('profile'); // Corrected route definition for profile
    Route::put('/profile/{id}', [AdminController::class, 'updateProfile'])->name('update_profile'); // Make sure the name is 'admin.update_profile'


});




Route::middleware(['auth', 'isstaff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'index'])->name('dashboard');
    
    // Handle task completion
        Route::post('/complete-task/{id}', [StaffController::class, 'completeTask'])->name('completeTask');


    Route::get('/profile', [StaffController::class, 'profile'])->name('profile'); // Display profile
    Route::put('/profile/{id}', [StaffController::class, 'updateProfile'])->name('update_profile'); // Update profile

    // Assigned Tasks route
    Route::get('/tasks', [StaffController::class, 'assignedTasks'])->name('tasks');

        Route::get('/todays-showtimes', [StaffController::class, 'todaysShowtimes'])->name('todaysShowtimes');

});




    Route::get('/user/movies', [UserController::class, 'moviesIndex'])->name('user.movies.index');
// User Routes
// User Routes
Route::middleware(['auth', 'isuser'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard'); // Fixed route
    Route::get('/bookings', [UserController::class, 'bookingIndex'])->name('bookings.index');
    Route::get('/bookings/choose_seat/{movieId}/{showtimeId}', [UserController::class, 'chooseSeat'])->name('bookings.choose_seat');
    Route::get('/bookings/payment', [UserController::class, 'pay'])->name('bookings.pay');
    Route::post('/bookings/stripe-payment', [UserController::class, 'Stripe'])->name('bookings.stripe');
    Route::get('/bookings/ticket', [UserController::class, 'Ticket'])->name('bookings.ticket');

    Route::get('/movies/movie_details/{movie}', [UserController::class, 'showMovie'])->name('movies.show');

    // Profile page (for user themselves)
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile/{id}', [UserController::class, 'updateProfile'])->name('update_profile'); 
});




Route::middleware(['auth', 'developer'])->prefix('developer')->group(function () {

    // Developer Dashboard
    Route::get('/dashboard', [Controller::class, 'devDashboard'])->name('developer.index');

    // Create Super Admin
    Route::get('/create-super-admin', [Controller::class, 'showCreateForm'])->name('create_super_admin');
    Route::post('/create-super-admin', [Controller::class, 'storeSuperAdmin'])->name('store_super_admin');

});
