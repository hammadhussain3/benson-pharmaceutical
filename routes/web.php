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
    RoleController,
    PermissionController,
    SalarySlipController,
    SalaryTaxSlabController,
    SupplierController,
    FranchiseController,
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
    Route::get('countries/view/{id}', [CountryController::class, 'view'])->name('countries.view');
    Route::resource('cities', CityController::class);
    Route::get('cities/view/{id}', [CityController::class, 'view'])->name('cities.view');
    Route::resource('companies', CompanyController::class);
    Route::get('companies/view/{id}', [CompanyController::class, 'view'])->name('companies.view');
    Route::resource('branches', BranchController::class);
    Route::get('branches/view/{id}', [BranchController::class, 'view'])->name('branches.view');
    Route::resource('departments', DepartmentController::class);
    Route::get('departments/view/{id}', [DepartmentController::class, 'view'])->name('departments.view');
    Route::resource('designations', DesignationController::class);
    Route::get('designations/view/{id}', [DesignationController::class, 'view'])->name('designations.view');
    Route::resource('employees', EmployeeController::class);
    Route::get('employees/view/{id}', [EmployeeController::class, 'view'])->name('employees.view');
    Route::resource('tax-slabs', SalaryTaxSlabController::class);
    Route::get('tax-slabs/view/{id}', [SalaryTaxSlabController::class, 'view'])->name('tax-slabs.view');
    Route::resource('leaves', LeaveController::class);
    Route::get('leaves/view/{id}', [LeaveController::class, 'view'])->name('leaves.view');
    Route::resource('leave_types', LeaveTypeController::class);
    Route::get('leave_types/view/{id}', [LeaveTypeController::class, 'view'])->name('leave_types.view');
    Route::resource('payment_types', PaymentTypeController::class);
    Route::get('payment_types/view/{id}', [PaymentTypeController::class, 'view'])->name('payment_types.view');
    Route::resource('chart_of_accounts', ChartOfAccountController::class);
    Route::get('chart_of_accounts/view/{id}', [ChartOfAccountController::class, 'view'])->name('chart_of_accounts.view');
    Route::resource('banks', BankController::class);
    Route::get('banks/view/{id}', [BankController::class, 'view'])->name('banks.view');
    Route::resource('salary_slips', SalarySlipController::class);
    Route::resource('loans', LoanController::class);
    Route::get('loans/view/{id}', [LoanController::class, 'view'])->name('loans.view');
    Route::resource('parties', PartyController::class);
    Route::get('parties/view/{id}', [PartyController::class, 'view'])->name('parties.view');
    Route::resource('roles', RoleController::class);
    Route::get('roles/view/{id}', [RoleController::class, 'view'])->name('roles.view');
    Route::resource('suppliers', SupplierController::class);
    Route::resource('franchises', FranchiseController::class);

    Route::get('/companies/{companyId}/branches', [BranchController::class, 'getBranchesByCompany']);
    Route::get('/companies/{companyId}/departments', [DepartmentController::class, 'getDepartmentsByCompany']);
    Route::get('/companies/{companyId}/designations', [DesignationController::class, 'getDesignationsByCompany']);
    Route::get('/companies/{companyId}/employees', [EmployeeController::class, 'getEmployeesByCompany']);
    Route::get('/companies/{companyId}/employee-code', [EmployeeController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/supplier-code', [SupplierController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/franchise-code', [FranchiseController::class, 'createCodeByCompany']);
    Route::get('/countries/{countryId}/cities', [CityController::class, 'getCitiesByCountry']);
    Route::get('/getcompany/{employeeId}', [EmployeeController::class, 'getCompanyByEmployee']);
    Route::get('/getemployee/{employeeId}', [EmployeeController::class, 'getEmployeeDetails']);
    Route::get('/getloan/{employeeId}', [LoanController::class, 'getLoansByEmployee']);
    Route::get('/getincometax/{employeeId}', [SalaryTaxSlabController::class, 'getIncomeTaxByEmployee']);
    Route::get('/getapprovedleaves/{employeeId}', [LeaveController::class, 'getApprovedLeavesByEmployee']);
    Route::get('/getunauthleaves/{employeeId}', [LeaveController::class, 'getUnauthorizedLeavesByEmployee']);
    Route::get('/getapprovedpayleaves/{employeeId}', [LeaveController::class, 'getApprovedWithPayLeavesByEmployee']);
    Route::get('/getleaves/{employeeId}', [LeaveController::class, 'getLeavesByEmployee']);
    Route::get('/branches/{branchId}/departments', [DepartmentController::class, 'getDepartmentsByBranch']);

    Route::get('salary-sheet', [SalarySheetController::class, 'index'])->name('salary.sheet.index');
    Route::get('salary-sheet/generate', [SalarySheetController::class, 'showSalarySheet'])->name('salary.sheet.show');
});

require __DIR__ . '/auth.php';
