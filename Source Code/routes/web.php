<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Parent\ParentDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Hospital\HospitalDashboardController;
use App\Http\Controllers\CertificateController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/index.php', function () {
    return redirect()->route('home');
});

Route::get('/vaccines', [HomeController::class, 'vaccines'])->name('home.vaccines');
Route::get('/Vaccines.php', [HomeController::class, 'vaccines']);

Route::get('/appointment', [HomeController::class, 'appointment'])->name('appointment');
Route::get('/appointment.php', [HomeController::class, 'appointment']);
Route::post('/appointment', [HomeController::class, 'storeAppointment'])->name('appointment.store');
Route::post('/appointment.php', [HomeController::class, 'storeAppointment']);

Route::get('/signin', [AuthController::class, 'showSignIn'])->name('signin');
Route::get('/signin.php', [AuthController::class, 'showSignIn']);
Route::post('/signin', [AuthController::class, 'postSignIn'])->name('signin.post');
Route::post('/signin.php', [AuthController::class, 'postSignIn']);

Route::get('/register-select', [AuthController::class, 'showRegisterSelect'])->name('register.select');
Route::get('/register-select.php', [AuthController::class, 'showRegisterSelect']);

Route::get('/register', [AuthController::class, 'showRegisterParent'])->name('register.parent');
Route::get('/Register.php', [AuthController::class, 'showRegisterParent']);
Route::post('/register', [AuthController::class, 'postRegisterParent'])->name('register.parent.post');
Route::post('/Register.php', [AuthController::class, 'postRegisterParent']);

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
Route::match(['get', 'post'], '/logout.php', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| Parent Portal Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['role.parent'])->prefix('parent')->group(function () {
    Route::get('/dashboard', [ParentDashboardController::class, 'dashboard'])->name('parent.dashboard');
    Route::get('/profile', [ParentDashboardController::class, 'profile'])->name('parent.profile');
    Route::get('/edit-profile', [ParentDashboardController::class, 'editProfile'])->name('parent.edit-profile');
    Route::post('/edit-profile', [ParentDashboardController::class, 'updateProfile'])->name('parent.update-profile');

    Route::get('/my-children', [ParentDashboardController::class, 'children'])->name('parent.children');
    Route::post('/my-children', [ParentDashboardController::class, 'storeChild'])->name('parent.store-child');
    Route::post('/children/store', [ParentDashboardController::class, 'storeChild'])->name('parent.children.store');
    Route::post('/update-child', [ParentDashboardController::class, 'updateChild'])->name('parent.update-child');
    Route::post('/delete-child', [ParentDashboardController::class, 'destroyChild'])->name('parent.delete-child');
    Route::match(['post', 'delete'], '/delete-child/{id}', [ParentDashboardController::class, 'destroyChild'])->name('parent.children.destroy');

    Route::get('/edit-child/{id}', [ParentDashboardController::class, 'editChild'])->name('parent.edit-child');
    Route::match(['post', 'put'], '/edit-child/{id}', [ParentDashboardController::class, 'updateChild'])->name('parent.children.update');
    Route::post('/edit-child/{id}', [ParentDashboardController::class, 'updateChild'])->name('parent.update-child-form');

    Route::get('/vaccination-schedule', [ParentDashboardController::class, 'schedule'])->name('parent.schedule');
    Route::get('/book-hospital', [ParentDashboardController::class, 'bookHospital'])->name('parent.book-hospital');
    Route::post('/book-hospital', [ParentDashboardController::class, 'storeBookHospital'])->name('parent.store-book-hospital');

    Route::get('/request-hospital', [ParentDashboardController::class, 'requests'])->name('parent.requests');
    Route::get('/vaccination-report', [ParentDashboardController::class, 'report'])->name('parent.report');
    Route::get('/certificate/{childId}', [CertificateController::class, 'downloadForParent'])->name('parent.certificate.download');
});

// Legacy root parent routes compatibility
Route::middleware(['role.parent'])->group(function () {
    Route::get('/parent_dashboard.php', [ParentDashboardController::class, 'dashboard']);
    Route::get('/parent-profile.php', [ParentDashboardController::class, 'profile']);
    Route::get('/edit-parent-profile.php', [ParentDashboardController::class, 'editProfile']);
    Route::post('/edit-parent-profile.php', [ParentDashboardController::class, 'updateProfile']);
    Route::get('/my-children.php', [ParentDashboardController::class, 'children']);
    Route::post('/my-children.php', function (\Illuminate\Http\Request $request) {
        if ($request->has('delete_child')) {
            return app(ParentDashboardController::class)->destroyChild($request);
        }
        if ($request->input('child_action') === 'update') {
            return app(ParentDashboardController::class)->updateChild($request);
        }
        return app(ParentDashboardController::class)->storeChild($request);
    });
    Route::get('/edit-child.php', function (\Illuminate\Http\Request $request) {
        return app(ParentDashboardController::class)->editChild($request->query('id'));
    });
    Route::post('/edit-child.php', function (\Illuminate\Http\Request $request) {
        return app(ParentDashboardController::class)->updateChild($request, $request->query('id'));
    });
    Route::get('/vaccination-schedule.php', [ParentDashboardController::class, 'schedule']);
    Route::get('/book-hospital.php', [ParentDashboardController::class, 'bookHospital']);
    Route::post('/book-hospital.php', [ParentDashboardController::class, 'storeBookHospital']);
    Route::get('/request-hospital.php', [ParentDashboardController::class, 'requests']);
    Route::get('/vaccination-report.php', [ParentDashboardController::class, 'report']);
});

/*
|--------------------------------------------------------------------------
| Admin Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminDashboardController::class, 'showLogin'])->name('admin.login');
    Route::get('/admin-login.php', [AdminDashboardController::class, 'showLogin']);
    Route::post('/login', [AdminDashboardController::class, 'postLogin'])->name('admin.login.post');
    Route::post('/admin-login.php', [AdminDashboardController::class, 'postLogin']);

    Route::get('/create-admin', [AdminDashboardController::class, 'showCreateAdmin'])->name('admin.create-admin');
    Route::get('/admin-create.php', [AdminDashboardController::class, 'showCreateAdmin']);
    Route::get('/create-admin.php', [AdminDashboardController::class, 'showCreateAdmin']);
    Route::post('/create-admin', [AdminDashboardController::class, 'postCreateAdmin'])->name('admin.create-admin.post');
    Route::post('/admin-create.php', [AdminDashboardController::class, 'postCreateAdmin']);
    Route::post('/create-admin.php', [AdminDashboardController::class, 'postCreateAdmin']);

    Route::middleware(['role.admin'])->group(function () {
        Route::match(['get', 'post'], '/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::match(['get', 'post'], '/admin-dashboard.php', [AdminDashboardController::class, 'dashboard']);

        Route::get('/profile', [AdminDashboardController::class, 'profile'])->name('admin.profile');
        Route::get('/admin-profile.php', [AdminDashboardController::class, 'profile']);
        Route::get('/edit-profile', [AdminDashboardController::class, 'editProfile'])->name('admin.edit-profile');
        Route::get('/edit-admin-profile.php', [AdminDashboardController::class, 'editProfile']);
        Route::post('/edit-profile', [AdminDashboardController::class, 'updateProfile'])->name('admin.update-profile');
        Route::post('/edit-admin-profile.php', [AdminDashboardController::class, 'updateProfile']);

        Route::get('/children', [AdminDashboardController::class, 'children'])->name('admin.children');
        Route::post('/children/store', [AdminDashboardController::class, 'storeChild'])->name('admin.children.store');
        Route::post('/children/update/{id}', [AdminDashboardController::class, 'updateChild'])->name('admin.children.update');
        Route::post('/children/delete/{id}', [AdminDashboardController::class, 'destroyChild'])->name('admin.children.destroy');
        Route::get('/admin-children.php', [AdminDashboardController::class, 'children']);
        Route::get('/child-details/{id}', [AdminDashboardController::class, 'childDetails'])->name('admin.child-details');
        Route::get('/admin-child-details.php', function (\Illuminate\Http\Request $request) {
            return app(AdminDashboardController::class)->childDetails($request->query('id'));
        });

        Route::get('/hospitals', [AdminDashboardController::class, 'hospitals'])->name('admin.hospital-list');
        Route::get('/hospital-list.php', [AdminDashboardController::class, 'hospitals']);
        Route::get('/add-hospital', [AdminDashboardController::class, 'createHospital'])->name('admin.add-hospital');
        Route::get('/add-hospital.php', [AdminDashboardController::class, 'createHospital']);
        Route::post('/add-hospital', [AdminDashboardController::class, 'storeHospital'])->name('admin.store-hospital');
        Route::post('/add-hospital.php', [AdminDashboardController::class, 'storeHospital']);

        Route::get('/view-hospital/{id}', [AdminDashboardController::class, 'showHospital'])->name('admin.view-hospital');
        Route::get('/view-hospital.php', function (\Illuminate\Http\Request $request) {
            return app(AdminDashboardController::class)->showHospital($request->query('id'));
        });

        Route::get('/edit-hospital/{id}', [AdminDashboardController::class, 'editHospital'])->name('admin.edit-hospital');
        Route::get('/edit-hospital.php', function (\Illuminate\Http\Request $request) {
            return app(AdminDashboardController::class)->editHospital($request->query('id'));
        });
        Route::post('/edit-hospital/{id}', [AdminDashboardController::class, 'updateHospital'])->name('admin.update-hospital');
        Route::post('/edit-hospital.php', function (\Illuminate\Http\Request $request) {
            return app(AdminDashboardController::class)->updateHospital($request, $request->query('id'));
        });

        Route::post('/delete-hospital', [AdminDashboardController::class, 'destroyHospital'])->name('admin.delete-hospital');
        Route::post('/delete-hospital.php', [AdminDashboardController::class, 'destroyHospital']);

        Route::get('/vaccines', [AdminDashboardController::class, 'vaccines'])->name('admin.vaccine-list');
        Route::post('/vaccines/store', [AdminDashboardController::class, 'storeVaccine'])->name('admin.vaccines.store');
        Route::post('/vaccines/update/{id}', [AdminDashboardController::class, 'updateVaccine'])->name('admin.vaccines.update');
        Route::post('/vaccines/delete/{id}', [AdminDashboardController::class, 'destroyVaccine'])->name('admin.vaccines.destroy');
        Route::get('/vaccine-list', [AdminDashboardController::class, 'vaccines']);
        Route::get('/vaccine-list.php', [AdminDashboardController::class, 'vaccines']);

        Route::get('/parent-requests', [AdminDashboardController::class, 'parentRequests'])->name('admin.parent-requests');
        Route::get('/parent-requests.php', [AdminDashboardController::class, 'parentRequests']);
        Route::post('/parent-requests', [AdminDashboardController::class, 'processParentRequest'])->name('admin.process-parent-request');
        Route::post('/parent-requests.php', [AdminDashboardController::class, 'processParentRequest']);

        Route::get('/booking-details', [AdminDashboardController::class, 'bookingDetails'])->name('admin.booking-details');
        Route::get('/booking-details.php', [AdminDashboardController::class, 'bookingDetails']);

        Route::get('/vaccinations-date', [AdminDashboardController::class, 'vaccinationsDate'])->name('admin.vaccinations-date');
        Route::post('/vaccinations-date', [AdminDashboardController::class, 'storeSchedule'])->name('admin.vaccinations-date.store');
        Route::get('/admin-vaccinations-date.php', [AdminDashboardController::class, 'vaccinationsDate']);

        Route::get('/vaccination-report', [AdminDashboardController::class, 'vaccinationReport'])->name('admin.vaccination-report');
        Route::get('/admin-vaccination-report.php', [AdminDashboardController::class, 'vaccinationReport']);

        Route::get('/certificate/{childId}', [CertificateController::class, 'downloadForAdmin'])->name('admin.certificate.download');

        // Admin Export Routes
        Route::get('/export/vaccinations', [AdminDashboardController::class, 'exportVaccinations'])->name('admin.export.vaccinations');
        Route::get('/export/children', [AdminDashboardController::class, 'exportChildren'])->name('admin.export.children');
        Route::get('/export/hospitals', [AdminDashboardController::class, 'exportHospitals'])->name('admin.export.hospitals');
        Route::get('/export/bookings', [AdminDashboardController::class, 'exportBookings'])->name('admin.export.bookings');
    });
});

/*
|--------------------------------------------------------------------------
| Hospital Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('hospital')->group(function () {
    Route::get('/login', [HospitalDashboardController::class, 'showLogin'])->name('hospital.login');
    Route::get('/hospital-login.php', [HospitalDashboardController::class, 'showLogin']);
    Route::post('/login', [HospitalDashboardController::class, 'postLogin'])->name('hospital.login.post');
    Route::post('/hospital-login.php', [HospitalDashboardController::class, 'postLogin']);

    Route::get('/register', [HospitalDashboardController::class, 'showRegister'])->name('hospital.register');
    Route::get('/hospital-register.php', [HospitalDashboardController::class, 'showRegister']);
    Route::post('/register', [HospitalDashboardController::class, 'postRegister'])->name('hospital.register.post');
    Route::post('/hospital-register.php', [HospitalDashboardController::class, 'postRegister']);

    Route::middleware(['role.hospital'])->group(function () {
        Route::get('/dashboard', [HospitalDashboardController::class, 'dashboard'])->name('hospital.dashboard');
        Route::get('/hospital-dashboard.php', [HospitalDashboardController::class, 'dashboard']);

        Route::get('/profile', [HospitalDashboardController::class, 'profile'])->name('hospital.profile');
        Route::get('/hospital-profile.php', [HospitalDashboardController::class, 'profile']);
        Route::get('/edit-profile', [HospitalDashboardController::class, 'editProfile'])->name('hospital.edit-profile');
        Route::get('/hospital-edit-profile.php', [HospitalDashboardController::class, 'editProfile']);
        Route::post('/edit-profile', [HospitalDashboardController::class, 'updateProfile'])->name('hospital.update-profile');
        Route::post('/hospital-edit-profile.php', [HospitalDashboardController::class, 'updateProfile']);

        Route::match(['get', 'post'], '/appointments', [HospitalDashboardController::class, 'appointments'])->name('hospital.appointments');
        Route::match(['get', 'post'], '/hospital-appointments.php', [HospitalDashboardController::class, 'appointments']);

        Route::match(['get', 'post'], '/vaccine-status', [HospitalDashboardController::class, 'vaccineStatus'])->name('hospital.vaccine-status');
        Route::match(['get', 'post'], '/vaccine-status.php', [HospitalDashboardController::class, 'vaccineStatus']);

        Route::get('/add-vaccine', [HospitalDashboardController::class, 'vaccines'])->name('hospital.add-vaccine');
        Route::get('/add-vaccine.php', [HospitalDashboardController::class, 'vaccines']);
        Route::post('/add-vaccine', function (\Illuminate\Http\Request $request) {
            if ($request->has('delete_vaccine')) {
                return app(HospitalDashboardController::class)->destroyVaccine($request);
            }
            if ($request->has('update_vaccine')) {
                return app(HospitalDashboardController::class)->updateVaccine($request);
            }
            return app(HospitalDashboardController::class)->storeVaccine($request);
        })->name('hospital.manage-vaccine');
        Route::post('/add-vaccine.php', function (\Illuminate\Http\Request $request) {
            if ($request->has('delete_vaccine')) {
                return app(HospitalDashboardController::class)->destroyVaccine($request);
            }
            if ($request->has('update_vaccine')) {
                return app(HospitalDashboardController::class)->updateVaccine($request);
            }
            return app(HospitalDashboardController::class)->storeVaccine($request);
        });

        Route::get('/all-vaccines', [HospitalDashboardController::class, 'allVaccines'])->name('hospital.all-vaccines');
        Route::get('/all-vaccines.php', [HospitalDashboardController::class, 'allVaccines']);

        Route::match(['get', 'post'], '/vaccinators', [HospitalDashboardController::class, 'vaccinators'])->name('hospital.vaccinators');
        Route::match(['get', 'post'], '/hospital-vaccinators.php', [HospitalDashboardController::class, 'vaccinators']);
    });
});

/*
|--------------------------------------------------------------------------
| Public Certificate Verification
|--------------------------------------------------------------------------
*/
Route::get('/verify-certificate/{token}', [CertificateController::class, 'verify'])->name('certificate.verify');
Route::get('/verify-certificate/{token}/download', [CertificateController::class, 'downloadPublic'])->name('certificate.download.public');

