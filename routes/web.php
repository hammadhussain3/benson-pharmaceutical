<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    BankController,
    CountryController,
    CityController,
    CompanyController,
    BranchController,
    ChartOfAccountController,
    DepartmentController,
    DesignationController,
    EmployeeController,
    LeaveController,
    LeaveTypeController,
    LoanController,
    PartyController,
    PaymentTypeController,
    SalarySlipController,
    SalaryTaxSlabController,
};
use App\Http\Controllers\SalarySheetController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('countries', CountryController::class);
    Route::resource('cities', CityController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('designations', DesignationController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('tax-slabs', SalaryTaxSlabController::class);
    Route::resource('leaves', LeaveController::class);
    Route::resource('leave_types', LeaveTypeController::class);
    Route::resource('payment_types', PaymentTypeController::class);
    Route::resource('chart_of_accounts', ChartOfAccountController::class);
    Route::resource('banks', BankController::class);
    Route::resource('salary_slips', SalarySlipController::class);
    Route::resource('loans', LoanController::class);
    Route::resource('parties', PartyController::class);

    Route::get('/countries/{countryId}/cities', [CityController::class, 'getCitiesByCountry']);








    Route::get('salary-sheet', [SalarySheetController::class, 'index'])->name('salary.sheet.index');
    Route::post('salary-sheet', [SalarySheetController::class, 'showSalarySheet'])->name('salary.sheet.show');
});

require __DIR__ . '/auth.php';
