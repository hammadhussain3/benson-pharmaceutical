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
    SalarySlipController,
    SalaryTaxSlabController,
    SupplierController,
    FranchiseController,
    CategoryController,
    PackingTypesController,
    PackSizeController,
    TaxController,
    DosageFormController,
    ProductGroupController,
    PackFormController,
    ProductController,
    ProductVariationController,
    BatchController,
    PurchaseInvoiceController,
    SaleInvoiceController,
    RawMaterialItemController,
    StockController,
    PurchaseRequisitionController,
    GoodsReceivingController,
    FinishedGoodsReceivingController,
    StoreIssueRequisitionController,
    RejectionReturnNoteController,
    LeftOverNoteController,
    SalesReturnController,
    PaymentVoucherController,
    ReceiptVoucherController,
    CreditNoteController,
    ReportController,
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
    Route::resource('categories', CategoryController::class);
    Route::get('categories/view/{id}', [CategoryController::class, 'view'])->name('categories.view');
    Route::resource('packingtypes', PackingTypesController::class);
    Route::get('packingtypes/view/{id}', [PackingTypesController::class, 'view'])->name('packingtypes.view');
    Route::resource('pack_size', PackSizeController::class);
    Route::get('pack_size/view/{id}', [PackSizeController::class, 'view'])->name('pack_size.view');
    Route::resource('taxes', TaxController::class);
    Route::resource('dosage-forms', DosageFormController::class);
    Route::resource('product-groups', ProductGroupController::class);
    Route::resource('pack-forms', PackFormController::class);
    Route::resource('products', ProductController::class);
    Route::resource('product-variations', ProductVariationController::class);
    Route::resource('batches', BatchController::class);
    Route::resource('raw-material-items', RawMaterialItemController::class);
    Route::resource('stocks', StockController::class);
    Route::resource('purchase-requisitions', PurchaseRequisitionController::class);
    Route::resource('purchase-invoices', PurchaseInvoiceController::class);
    Route::resource('sale-invoices', SaleInvoiceController::class);
    Route::resource('goods-receivings', GoodsReceivingController::class);
    Route::resource('finished-goods-receivings', FinishedGoodsReceivingController::class);
    Route::resource('store-issue-requisitions', StoreIssueRequisitionController::class);
    Route::get('store-issue-requisitions/production/create', [StoreIssueRequisitionController::class, 'productionCreate'])->name('store-issue-requisitions.production.create');
    Route::resource('rejection-return-notes', RejectionReturnNoteController::class);
    Route::resource('left-over-notes', LeftOverNoteController::class);
    Route::get('sale-warranties', [SaleInvoiceController::class, 'saleWarranties'])->name('sale-warranties.index');
    Route::get('sale-warranties/{id}/show', [SaleInvoiceController::class, 'warranty'])->name('sale-warranties.show');
    Route::resource('sales-returns', SalesReturnController::class);
    Route::resource('payment-vouchers', PaymentVoucherController::class);
    Route::resource('receipt-vouchers', ReceiptVoucherController::class);
    Route::resource('credit-notes', CreditNoteController::class);
    Route::get('report/balance-report', [ReportController::class, 'balanceReport'])->name('reports.balance-report');
    Route::get('report/purchase-items', [ReportController::class, 'purchaseItems'])->name('reports.purchase-items');
    Route::get('report/purchase-requisition', [ReportController::class, 'purchaseRequisitions'])->name('reports.purchase-requisitions');
    Route::get('report/requirement-report', [ReportController::class, 'requirementReport'])->name('reports.requirement-report');
    Route::get('report/production-report', [ReportController::class, 'productionReport'])->name('reports.production-report');
    Route::get('report/consumption-report', [ReportController::class, 'consumptionReport'])->name('reports.consumption-report');
    Route::get('report/batch-balance-report', [ReportController::class, 'batchBalanceReport'])->name('reports.batch-balance-report');
    Route::get('report/batch-track-report/{id}', [ReportController::class, 'batchTrackReport'])->name('reports.batch-track-report');
    Route::get('report/costing-voucher/{id}', [ReportController::class, 'costingVoucher'])->name('reports.costing-voucher');
    Route::get('product-variations/bin-card/{id}', [ReportController::class, 'stockBinCardForFinalProduct'])->name('product-variations.reports.bin-card');
    Route::get('raw-material-items/bin-card/{id}', [ReportController::class, 'stockBinCardForRawMaterial'])->name('raw-material-items.reports.bin-card');
    Route::get('products/bin-card/{id}', [ReportController::class, 'stockBinCardForProducts'])->name('products.reports.bin-card');
    Route::get('product-variations/batch-report/{id}', [ReportController::class, 'batchReport'])->name('product-variations.reports.product-variant-batch-report');

    Route::get('/companies/{companyId}/branches', [BranchController::class, 'getBranchesByCompany']);
    Route::get('/companies/{companyId}/departments', [DepartmentController::class, 'getDepartmentsByCompany']);
    Route::get('/companies/{companyId}/designations', [DesignationController::class, 'getDesignationsByCompany']);
    Route::get('/companies/{companyId}/employees', [EmployeeController::class, 'getEmployeesByCompany']);
    Route::get('/companies/{companyId}/product-groups', [ProductGroupController::class, 'getProductGroupsByCompany']);
    Route::get('/companies/{companyId}/product-variations', [ProductVariationController::class, 'getProductVariationsByComapny']);
    Route::get('/companies/{companyId}/products', [ProductController::class, 'getProductsByCompany']);
    Route::get('/companies/{companyId}/products-and-raw-materials', [ProductController::class, 'getProdAndRMByCompany']);
    Route::get('/companies/{companyId}/all-products', [ProductController::class, 'getAllTypeProductByCompany']);
    Route::get('/companies/{companyId}/dosage-forms', [DosageFormController::class, 'getDosageFormsByCompany']);
    Route::get('/companies/{companyId}/pack-forms', [PackFormController::class, 'getPackFormsByCompany']);
    Route::get('/companies/{companyId}/pack-sizes', [PackSizeController::class, 'getPackSizesByCompany']);
    Route::get('/companies/{companyId}/packing-types', [PackingTypesController::class, 'getPackingTypesByCompany']);
    Route::get('/companies/{companyId}/parties', [PartyController::class, 'getPartiesByCompany']);
    Route::get('/companies/{companyId}/raw-material-items', [RawMaterialItemController::class, 'getRawMaterialItemsByCompany']);
    Route::get('/companies/{companyId}/suppliers', [SupplierController::class, 'getSuppliersByCompany']);
    Route::get('/companies/{companyId}/franchisers', [FranchiseController::class, 'getFranchisersByCompany']);
    Route::get('/companies/{companyId}/chart-of-accounts', [ChartOfAccountController::class, 'getChartOfAccountsByCompany']);
    Route::get('/companies/{companyId}/general-store-requisitions', [StoreIssueRequisitionController::class, 'getGeneralStoreRequisitionsByCompany']);
    Route::get('/companies/{companyId}/production-store-requisitions', [StoreIssueRequisitionController::class, 'getProductionStoreRequisitionsByCompany']);
    Route::get('/companies/{companyId}/employee-code', [EmployeeController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/supplier-code', [SupplierController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/franchise-code', [FranchiseController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/product-code', [ProductController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/raw-material-item-code', [RawMaterialItemController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/purchase-requisition-code', [PurchaseRequisitionController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/goods-receivings-code', [GoodsReceivingController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/store-requisition-code', [StoreIssueRequisitionController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/finished-goods-code', [FinishedGoodsReceivingController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/left-over-note-code', [LeftOverNoteController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/rejection-return-note-code', [RejectionReturnNoteController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/purchase-invoice-code', [PurchaseInvoiceController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/sale-invoice-code', [SaleInvoiceController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/chart-of-account', [ChartOfAccountController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/payment-voucher', [PaymentVoucherController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/receipt-voucher', [ReceiptVoucherController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/credit-note', [CreditNoteController::class, 'createCodeByCompany']);
    Route::get('/companies/{companyId}/sales-return', [SalesReturnController::class, 'createCodeByCompany']);
    Route::get('/countries/{countryId}/cities', [CityController::class, 'getCitiesByCountry']);
    Route::get('/companies/{companyId}/invoices', [PurchaseInvoiceController::class, 'getInvoicesByCompany']);
    Route::get('/getcompany/{employeeId}', [EmployeeController::class, 'getCompanyByEmployee']);
    Route::get('/getemployee/{employeeId}', [EmployeeController::class, 'getEmployeeDetails']);
    Route::get('/getloan/{employeeId}', [LoanController::class, 'getLoansByEmployee']);
    Route::get('/getincometax/{employeeId}', [SalaryTaxSlabController::class, 'getIncomeTaxByEmployee']);
    Route::get('/getapprovedleaves/{employeeId}', [LeaveController::class, 'getApprovedLeavesByEmployee']);
    Route::get('/getunauthleaves/{employeeId}', [LeaveController::class, 'getUnauthorizedLeavesByEmployee']);
    Route::get('/getapprovedpayleaves/{employeeId}', [LeaveController::class, 'getApprovedWithPayLeavesByEmployee']);
    Route::get('/getleaves/{employeeId}', [LeaveController::class, 'getLeavesByEmployee']);
    Route::get('/invoices/{invoiceId}/details', [PurchaseInvoiceController::class, 'getInvoiceDetailsById']);
    Route::get('/invoices/{invoiceId}/supplier', [SupplierController::class, 'getSupplierByInvoice']);
    Route::get('/invoices/{invoiceId}/goods-receivings', [GoodsReceivingController::class, 'getGoodReceivingsByInvoice']);
    Route::get('/products/{productId}/product-variations', [ProductVariationController::class, 'getProductVariationsByProduct']);
    Route::get('/products/{productId}/batches', [BatchController::class, 'getBatchesByProductId']);
    Route::get('/product-variations/{productVariationId}/batches', [BatchController::class, 'getBatchesByProductVariationId']);
    Route::get('/store-requisitions/{requisitionId}/general-details', [StoreIssueRequisitionController::class, 'getGeneralStoreRequisitionDetailsById']);
    Route::get('/store-requisitions/{requisitionId}/production-details', [StoreIssueRequisitionController::class, 'getProductionStoreRequisitionDetailsById']);
    Route::get('/branches/{branchId}/departments', [DepartmentController::class, 'getDepartmentsByBranch']);
    Route::get('/parties/{partyId}/supplier_code', [PartyController::class, 'getSupplierCodeByPartyId']);

    Route::get('salary-sheet', [SalarySheetController::class, 'index'])->name('salary.sheet.index');
    Route::get('salary-sheet/generate', [SalarySheetController::class, 'showSalarySheet'])->name('salary.sheet.show');
});

require __DIR__ . '/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
