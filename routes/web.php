<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//notifiactions action routes
Route::get('notifications/clear/{noticeId?}', 'NotificationActionsController@clear')->name('notifications.clear');
// end notifiactions action routes

//nursig note types routes
Route::resource('nursing-note-types', NursingNoteTypeController::class);
Route::resource('nursing-note', NursingNoteController::class);
Route::post('nursing-note/new', 'NursingNoteController@new_note')->name('nursing-note.new');
Route::get('/contact', 'HomeController@index')->name('contact');
// Route::any('/update-user', 'HomeController@updateUser')->name('update-user');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {


    Route::get('/profile/{email}', 'Admin\UserController@profile')->name('profile');
    Route::put('users/updateAvatar/{id}', 'Admin\UserController@updateAvatar')->name('users.updateAvatar');

    Route::group(['middleware' => ['role:Users']], function () {
        // Creating and Listing Users
        Route::get('listUsers', 'Admin\UserController@listUsers')->name('listUsers');
        Route::resource('users', 'Admin\UserController');
    });

    Route::group(['middleware' => ['role:Roles']], function () {
        // Creating and Listing Roles
        Route::get('listRoles', 'Admin\RoleController@listRoles')->name('listRoles');
        Route::resource('roles', 'Admin\RoleController');
    });

    Route::group(['middleware' => ['role:Permissions']], function () {
        // Creating and Listing Permissions
        Route::get('listPermissions', 'Admin\PermissionController@listPermissions')->name('listPermissions');
        Route::resource('permissions', 'Admin\PermissionController');
    });

    Route::group(['middleware' => ['role:Products']], function () {
        // Route for Products and Product Listing
        Route::get('listProducts', 'Product\ProductController@listProducts')->name('listProducts');
    });

    // Route::group(['middleware' => ['role:Doctors']], function () {
        // Creating and Listing Users
        Route::get('listDoctors', 'Doctors\DoctorsController@listDoctors')->name('listDoctors');
        Route::resource('doctors', 'Doctors\DoctorsController');

        Route::resource('DoctorBooking', 'DoctorBookingController');

        Route::get('listAppointments', 'Doctors\AppointmentController@listAppointments')->name('listAppointments');
        Route::get('listMyAppointments/{id}', 'Doctors\AppointmentController@listMyAppointments')->name('listMyAppointments');
        Route::resource('appointments', 'Doctors\AppointmentController');

        // Route::get('listAppointments', 'Doctors\AppointmentController@listAppointments')->name('listAppointments');
        Route::get('listReturningPatients', 'Receptionists\ReceptionistController@listReturningPatients')->name('listReturningPatients');
        Route::resource('receptionists', 'Receptionists\ReceptionistController');

        Route::any('update-user', 'Nurses\VitalSignController@updateUser')->name('update-user');
        Route::any('saveWhoProcessed/{id}', 'Nurses\VitalSignController@saveWhoProcessed')->name('saveWhoProcessed');
        Route::any('saveVitalSignStatus/{id}', 'Nurses\VitalSignController@saveVitalSignStatus')->name('saveVitalSignStatus');
        Route::get('listVitalSigns', 'Nurses\VitalSignController@listVitalSigns')->name('listVitalSigns');
        Route::resource('vitalSign', 'Nurses\VitalSignController');
    // });

    //rotes for hmo
    Route::resource('hmos', 'HmoController');
    Route::get('listHmos', 'HmoController@listHmos')->name('listHmos');


    // Route::group(['middleware' => ['role:Requisition']], function () {
    // Route for Products and Product Listing


    Route::get('listRequestRequisition', 'HomeController@listRequestRequisition')->name('listRequestRequisition');
    Route::resource('requisitions', 'Requisition\RequisitionController');
    Route::get('showRequisitionReceipt/{id}', 'Requisition\RequisitionController@requisitionReceipt')->name('showRequisitionReceipt');
    Route::get('addItems', ['as' => 'addItems', 'uses' => 'Requisition\RequisitionController@addItems']);
    Route::post('saveAddItems', ['as' => 'saveAddItems', 'uses' => 'Requisition\RequisitionController@saveAddItems']);
    Route::get('myform/ajaxpriceAdd/{id}/{k}', array('as' => 'myform.ajaxpriceAdd', 'uses' => 'Requisition\RequisitionController@myformpriceAdd'));


    Route::resource('budget-year', 'Budget\BudgetYearController');
    Route::resource('budget', 'Budget\BudgetController');
    Route::get('listBudget', ['as' => 'listBudget', 'uses' => 'Budget\BudgetController@listBudget']);
    Route::get('listBudgetYear', ['as' => 'listBudgetYear', 'uses' => 'Budget\BudgetYearController@listBudgetYear']);
    Route::get('closedBudget/{id}', ['as' => 'closedBudget', 'uses' => 'Budget\BudgetYearController@closedBudget']);

    Route::get('myCategoryAjax/ajax/{id}', array('as' => 'myCategoryAjax.ajax', 'uses' => 'General\GeneralOptionController@myCategoryAjax'));
    Route::get('mystateAjax/ajax/{id}', array('as' => 'mystateAjax.ajax', 'uses' => 'General\GeneralOptionController@mystateAjax'));
    Route::get('mywardAjax/ajax/{id}', array('as' => 'mywardAjax.ajax', 'uses' => 'General\GeneralOptionController@mywardAjax'));


    Route::get('listDepartmentRequest/{id}', ['as' => 'listDepartmentRequest', 'uses' => 'Requisition\RequisitionController@listDepartmentRequest']);
    Route::get('listRequest', ['as' => 'listRequest', 'uses' => 'Requisition\RequisitionController@listRequest']);

    Route::get('newSale/{id}/{dependant_id?}', ['as' => 'newSale', 'uses' => 'Sales\SalesController@newSale']);

    Route::get('/destroyRequest/{id}', array('as' => 'destroyRequest', 'uses' => 'Requisition\RequisitionController@destroyRequest'));

    Route::get('/editRequest/{id}/{qt}', array('as' => 'editRequest', 'uses' => 'Requisition\RequisitionController@editRequest'));

    Route::resource('removed-request', 'Requisition\RequisitionController');
    Route::post('createSaleRequest', 'Requisition\RequisitionController@createSaleRequest')->name('createSaleRequest');
    // });

    Route::get('listSuppliers', 'Supplier\SupplierController@listSuppliers')->name('listSuppliers');
    Route::resource('suppliers', 'Supplier\SupplierController');


    Route::get('listPromotion', 'Promotion\PromotionController@listPromotion')->name('listPromotion');
    Route::get('listPromotionSales/{id}', ['as' => 'listPromotionSales', 'uses' => 'Promotion\PromotionController@listPromotionSales']);

    Route::get('listProductsTreasure', 'Product\TreasureController@listProductsTreasure')->name('listProductsTreasure');
    Route::resource('products', 'Product\ProductController');

    Route::get('listCategories', 'Category\CategoryController@listCategories')->name('listCategories');
    Route::resource('categories', 'Category\CategoryController');

    Route::resource('treasure', 'Product\TreasureController');
    //********************Healt******************

    Route::get('PendingConsultationlist', ['as' => 'PendingConsultationlist', 'uses' => 'MedicalReport\MedicalReportController@PendingConsultationlist'])->name('PendingConsultationlist');
    Route::get('allConsultationlist', ['as' => 'allConsultationlist', 'uses' => 'MedicalReport\MedicalReportController@allConsultationlist'])->name('allConsultationlist');
    Route::get('PreviousConsultationlist', 'MedicalReport\MedicalReportController@PreviousConsultationlist')->name('PreviousConsultationlist');
    Route::get('listAllConsultation', ['as' => 'listAllConsultation', 'uses' => 'MedicalReport\MedicalReportController@listAllConsultation']);
    Route::get('listPendingPatients', ['as' => 'listPendingPatients', 'uses' => 'MedicalReport\MedicalReportController@listPendingPatients']);
    Route::get('listPendingDependants', ['as' => 'listPendingDependants', 'uses' => 'MedicalReport\MedicalReportController@listPendingDependants']);
    Route::get('listPreviousPatients', ['as' => 'listPreviousPatients', 'uses' => 'MedicalReport\MedicalReportController@listPreviousPatients']);
    Route::get('AdmittedPatients', 'MedicalReport\MedicalReportController@AdmittedPatients')->name('AdmittedPatients');

    Route::get('DischargePatients/{id}', 'MedicalReport\MedicalReportController@DischargePatients')->name('DischargePatients');
    Route::get('ListAdmittedPatients', 'MedicalReport\MedicalReportController@ListAdmittedPatients');
    Route::get('ListBookedPatients', 'MedicalReport\MedicalReportController@ListBookedPatients');
    Route::get('listCurentRecord/{id}', ['as' => 'listCurentRecord', 'uses' => 'MedicalReport\MedicalReportController@listCurentRecord']);
    Route::get('AttendPendingConsultation/{id}/{dependant_id?}', ['as' => 'AttendPendingConsultation', 'uses' => 'MedicalReport\MedicalReportController@AttendPendingConsultation']);
    Route::get('viewConsultation/{id}/{dependant_id?}', ['as' => 'viewConsultation', 'uses' => 'MedicalReport\MedicalReportController@viewConsultation']);
    Route::post('addMedicalReport', 'MedicalReport\MedicalReportController@addMedicalReport')->name('addMedicalReport');
    //**********************new*****************
      Route::resource('nurse-services', 'Nurses\NurseController');
    Route::resource('hospital-receipts', 'HospitalReceipts\HospitalReceiptsController');
    Route::resource('patient-account', 'Payment\PatientAccountController');
    Route::post('patient-account/deposit', 'Payment\PatientAccountController@deposit')->name('patient-account.deposit');
    Route::get('noCharges/{id}/{dependant_id?}', ['as' => 'noCharges', 'uses' => 'Nurses\NurseController@noCharges']);
    Route::get('nurseServiceRequest', ['as' => 'nurseServiceRequest', 'uses' => 'Nurses\NurseController@nurseServiceRequest']);
    Route::get('nurseServiceRequestList', 'Nurses\NurseController@nurseServiceRequestList')->name('nurseServiceRequestList');
    Route::get('nurseServicePaymentRequest', ['as' => 'nurseServicePaymentRequest', 'uses' => 'Nurses\NurseController@nurseServicePaymentRequest']);
    Route::get('nurseServicePaymentRequestList', 'Nurses\NurseController@nurseServicePaymentRequestList')->name('nurseServicePaymentRequestList');
    Route::get('patientsAccountList', 'Payment\PatientAccountController@patientsAccountList')->name('patientsAccountList');
    Route::post('paidCharges', 'Payment\PaymentController@paidCharges')->name('paidCharges');
    Route::get('labServicesPaymentRequestList', ['as' => 'labServicesPaymentRequestList', 'uses' => 'Lab\LabServiceController@labServicesPaymentRequestList']);
    //********************2new ******************
    Route::get('listMedicalHistory/{id}/{dependant_id?}', 'MedicalReport\MedicalReportController@listMedicalHistory');
    Route::resource('medical-report', 'MedicalReport\MedicalReportController');

    Route::resource('wards', 'Ward\WardController');
    Route::resource('beds', 'Ward\BedController');
    Route::get('services_rendered', 'Patient\PatientController@services_rendered')->name('patient.services_rendered');
    Route::resource('patient', 'Patient\PatientController');
    Route::resource('payment', 'Payment\PaymentController');
    Route::resource('clinics', 'Clinic\ClinicController');
    Route::resource('payment-type', 'Payment\PaymentTypeController');
    Route::resource('payment-item', 'Payment\PaymentItemController');
    Route::resource('labs', 'Lab\LabController');
    Route::resource('lab-services', 'Lab\LabServiceController');
    Route::get('listNewPatients', 'Patient\PatientController@listNewPatients')->name('listNewPatients');
    Route::get('listClinics', 'Clinic\ClinicController@listClinics')->name('listClinics');
    Route::get('listWards', 'Ward\WardController@listWards')->name('listWards');
    Route::get('listLabs', 'Lab\LabController@listLabs')->name('listLabs');
    Route::get('NewRegistrationRequestList', 'Patient\PatientController@NewRegistrationRequestList')->name('NewRegistrationRequestList');
    Route::get('listPaymentTypes', 'Payment\PaymentTypeController@listPaymentTypes')->name('listPaymentTypes');
    Route::get('PaymentItemsList', 'Payment\PaymentItemController@PaymentItemsList')->name('PaymentItemsList');

    Route::get('listLabServices', ['as' => 'listLabServices', 'uses' => 'Lab\LabServiceController@listLabServices']);
    Route::get('listShowLabServices/{id}', ['as' => 'listShowLabServices', 'uses' => 'Lab\LabServiceController@listShowLabServices']);
    Route::get('showLabServices/{id}', ['as' => 'showLabServices', 'uses' => 'Lab\LabServiceController@ShowLabServices']);
    Route::get('listPaymentTypeItems/{id}', ['as' => 'listPaymentTypeItems', 'uses' => 'Payment\PaymentItemController@listPaymentTypeItems']);
    Route::get('showPaymentTypeItem/{id}', ['as' => 'showPaymentTypeItem', 'uses' => 'Payment\PaymentItemController@showPaymentTypeItem']);
     Route::post('patientsDetails', ['as' => 'patientsDetails', 'uses' => 'Patient\PatientController@store']);

    Route::get('newPatients', ['as' => 'newPatients', 'uses' => 'Patient\PatientController@newPatients']);

    Route::get('listReturningPatientsPayment', 'Patient\PatientController@listReturningPatientsPayment')->name('listReturningPatientsPayment');
    Route::post('returningPatientCardPayment', 'Payment\PaymentController@returningPatientCardPayment')->name('returningPatientCardPayment');
    Route::get('returningPatients', ['as' => 'returningPatients', 'uses' => 'Patient\PatientController@returningPatients']);
    Route::get('returningPatientFee/{id}/{dependant_id?}', ['as' => 'returningPatientFee', 'uses' => 'Payment\PaymentController@returningPatientFee']);

    Route::get('returningPatientsBooking', ['as' => 'returningPatientsBooking', 'uses' => 'Patient\PatientController@returningPatientsBooking']);
    Route::get('listReturningPatientsBookingPayment', 'Patient\PatientController@listReturningPatientsBookingPayment')->name('listReturningPatientsBookingPayment');
    Route::get('returningPatientBookingFee/{id}', 'Payment\PaymentController@returningPatientBookingFee')->name('returningPatientBookingFee');
    Route::post('returningPatientBookingPayment', 'Payment\PaymentController@returningPatientBookingPayment')->name('returningPatientBookingPayment');

    Route::get('newRegistrationFormRequestList', ['as' => 'newRegistrationFormRequestList', 'uses' => 'Patient\PatientController@newRegistrationFormRequestList']);
    Route::get('CurrentConsultationRequestlist', ['as' => 'CurrentConsultationRequestlist', 'uses' => 'Patient\PatientController@CurrentConsultationRequestlist']);
    Route::get('consultation/{id}/{dependant_id?}', ['as' => 'consultation', 'uses' => 'Patient\PatientController@Consultation']);
    Route::get('getNoteTemplate/{id}','Clinic\ClinicController@getNoteTemplate')->name('getNoteTemplate');
    Route::get('LabServicesPrice/{id}', ['as' => 'LabServicesPrice', 'uses' => 'Lab\LabServiceController@LabServicesPrice']);
    Route::get('allConsultationRequestList', ['as' => 'allConsultationRequestList', 'uses' => 'Patient\PatientController@ConsultationRequestList']);
    Route::get('allConsultationRequestListDependants','Patient\PatientController@ConsultationRequestListDependants')->name('ConsultationRequestListDependants');
    Route::get('BookedPatients', 'Patient\PatientController@BookedPatients')->name('BookedPatients');
    Route::get('BedRequests', 'Patient\PatientController@BedRequests')->name('BedRequests');
    Route::get('listBedRequests', 'Patient\PatientController@listBedRequests')->name('listBedRequests');
    Route::get('assignBed/{id}', 'Patient\PatientController@assignBed')->name('assignBed');
    Route::post('assignBed', 'Patient\PatientController@assignBedStore')->name('assignBedPost');
    Route::get('calenderDoctor/{id}', 'DoctorBookingController@calenderDoctor')->name('calenderDoctor');
    Route::get('ConsultationBookingList', 'Patient\PatientController@ConsultationBookingList')->name('ConsultationBookingList');


    // Pending Consultation By Doctor Routes
    Route::get('pendingConsultationRequestlist', 'Patient\PatientController@pendingConsultationRequestlist')->name('pendingConsultationRequestlist');

    Route::get('newRegistrationFee/{id}', ['as' => 'newRegistrationFee', 'uses' => 'Payment\PaymentController@newRegistrationFee']);
    Route::get('newRegistrationForm/{id}', ['as' => 'newRegistrationForm', 'uses' => 'Patient\PatientController@newRegistrationForm']);
    Route::get('myItem/ajaxprice/{id}', array('as' => 'myItem.ajaxprice', 'uses' => 'Payment\PaymentController@myItemprice'));
    Route::get('listWardBets/{id}', ['as' => 'listWardBets', 'uses' => 'Ward\BedController@ListWardBets']);
    Route::post('bedPrice', ['as' => 'bedPrice', 'uses' => 'Ward\BedController@bedPrice']);
    //*************************end health************************

    Route::resource('customers', 'Customer\CustomerController');
    Route::get('listCustomers', 'Customer\CustomerController@listCustomers')->name('listCustomers');
    Route::get('listcustomerTransaction/{id}', ['as' => 'listcustomerTransaction', 'uses' => 'Customer\CustomerController@listcustomerTransaction']);
    Route::get('listcustomerDateline', ['as' => 'listcustomerDateline', 'uses' => 'Customer\CustomerController@listcustomerDateline']);

    Route::resource('suppliers', 'Supplier\SupplierController');
    Route::get('listsupplierPayment/{id}', ['as' => 'listsupplierPayment', 'uses' => 'Supplier\SupplyAndPaymentController@listsupplierPayment']);
    Route::get('showListsupplierPayment/{id}', ['as' => 'showListsupplierPayment', 'uses' => 'Supplier\SupplyAndPaymentController@showListsupplierPayment']);
    Route::get('ryprintSupplierPayment/{id}', ['as' => 'ryprintSupplierPayment', 'uses' => 'Supplier\SupplyAndPaymentController@ryprintSupplierPayment']);


    Route::get('listSalesProduct/{id}', ['as' => 'listSalesProduct', 'uses' => 'Product\ProductController@listSalesProduct']);
    // Route::get('listTodaySalesProduct', 'Transactions\TransactionsController@listTodaySalesProduct')->name('listTodaySalesProduct');
    Route::get('listTodaySalesProduct/{id}', ['as' => 'listTodaySalesProduct', 'uses' => 'Transactions\TransactionsController@listTodaySalesProduct']);


    Route::get('listStoresProducts/{id}', 'Store\StoreStokesController@listStoresProducts')->name('listStoresProducts');
    Route::get('listProductslocations/{id}', 'Store\StoreStokesController@listProductslocations')->name('listProductslocations');
    Route::get('listStores', 'Store\StoreController@listStores')->name('listStores');


    Route::get('print_invoice/{id}', 'Invoice\InvoiceController@print_invoice')->name('print_invoice');
    Route::get('listInvoices', 'Invoice\InvoiceController@listInvoices')->name('listInvoices');
    Route::resource('invoices', 'Invoice\InvoiceController');

    Route::resource('stock-order', 'Invoice\StockOrderController');

    Route::resource('stores', 'Store\StoreController');
    Route::resource('stores-stokes', 'Store\StoreStokesController');

    Route::group(['middleware' => ['role_or_permission:Credit-Date-Line|credit-date-line']], function () {

        Route::resource('dateline', 'DateLineController');
    });
      Route::get('mystateAjax/ajax/{id}', array('as'=>'mystateAjax.ajax','uses'=>'General\GeneralOptionController@mystateAjax'));
      Route::get('getUsersByStatusCategory/{id}', array('as'=>'getUsersByStatusCategory','uses'=>'General\GeneralOptionController@getUsersBasedOnStatusCategory'));
    // Route::group(['middleware' => ['role_or_permission:Sales|sales|sale-create|sale-show|sale-edit|sale-delete']], function () {

    Route::get('getTransactions/{id}', 'Sales\SalesController@getTransactions')->name('getTransactions');
    Route::resource('sales', 'Sales\SalesController');
    // });

    Route::resource('move-stock', 'MoveStokeController');
    Route::resource('promotion', 'Promotion\PromotionController');

    Route::resource('removed-edit-sales', 'Sales\RemovedEditSalesProductController');



    Route::get('listShowTransactions/{id}', ['as' => 'listShowTransactions', 'uses' => 'Sales\SalesController@listShowTransactions']);
    Route::resource('stocks', 'Invoice\stockController');
    Route::resource('pay_supplier', 'Supplier\SupplyAndPaymentController');

    Route::get('listPrices', 'Price\PriceController@listPrices')->name('listPrices');
    Route::resource('prices', 'Price\PriceController');
    Route::resource('priceslist', 'Price\PriceController');


    Route::resource('backup', 'PricePriceViewsController');

    Route::resource('receipt', 'Sales\ReceiptContoller');
    Route::resource('customer-payment', 'Customer\CustomerPaymentController');

    // Route::group(['middleware' => ['role_or_permission:Expenses|expenses-create']], function () {

        // Expenses Route
        Route::get('listExpenses', 'Expenses\ExpensesController@listExpenses')->name('listExpenses');
        Route::resource('expenses', 'Expenses\ExpensesController');
    // });

    Route::group(['middleware' => ['role_or_permission:Borrow|borrow|borrow-create|borrow-show|borrow-edit|borrow-delete']], function () {

        // Borrow Route
        Route::resource('borrows', 'Customer\BorrowController');
    });

    // Route::group(['middleware' => ['role_or_permission:Transaction|transactions|transaction-create|transaction-show|transaction-edit|transaction-delete']], function () {
    // Transaction Routes
    Route::get('listTransactions', 'Transactions\TransactionsController@listTransactions')->name('listTransactions');
    Route::get('daylistTransactions', 'Transactions\TransactionsController@daylistTransactions')->name('daylistTransactions');
    Route::resource('transactions', 'Transactions\TransactionsController');
    Route::get('terminustSupply', 'Transactions\TransactionsController@terminustSupply')->name('terminustSupply');
    Route::get('listTerminustSupply', 'Transactions\TransactionsController@listTerminustSupply')->name('listTerminustSupply');
    // });

    Route::get('myform/ajaxprice/{id}', array('as' => 'myform.ajaxprice', 'uses' => 'Sales\SalesController@myformprice'));
    // Route::get('stock-data-stocks', ['as' => 'stock.data', 'uses' => 'Invoice/stockController@anyDataStockRequest']);
    // Route::get('my-datatables', 'Invoice\StockController@index');
    Route::get('/edit-quantity/{id}/{qt}', array('as' => 'edit-quantity', 'uses' => 'Sales\RemovedEditSalesProductController@EditQuantity'));
    Route::get('/sale-invoice/{$trans}', ['as' => 'sale-invoice', 'uses' => 'Sales\SalesController@mysaleinvoice']);
    // Route::get('backup', 'Backup\BackupController');

    // Route::group(['middleware' => ['role_or_permission:Ledger|ledgers|ledger-create|ledger-save|ledger-show|ledger-edit|ledger-delete']], function () {

        // Ledger Route
        Route::get('lisDayliStockLedge/{id}', ['as' => 'lisDayliStockLedge', 'uses' => 'Ledges\StockLedgeController@lisDayliStockLedge']);
        Route::get('viewIncoming/{id}', ['as' => 'viewIncoming', 'uses' => 'Ledges\StockLedgeController@viewIncoming']);
        Route::get('ListIncoming/{id}', ['as' => 'ListIncoming', 'uses' => 'Ledges\StockLedgeController@ListIncoming']);
        Route::get('viewOutgoing/{id}', ['as' => 'viewOutgoing', 'uses' => 'Ledges\StockLedgeController@viewOutgoing']);
        Route::get('ListOutgoing/{id}', ['as' => 'ListOutgoing', 'uses' => 'Ledges\StockLedgeController@ListOutgoing']);
        Route::any('findLedge', ['as' => 'findLedge', 'uses' => 'Ledges\StockLedgeController@findLedge']);
        Route::get('list-find-ledge/{id}', ['as' => 'list-find-ledge', 'uses' => 'Ledges\StockLedgeController@ListFindLedge']);
        Route::resource('stock-ledge', 'Ledges\StockLedgeController');
    // });

    // Route::group(['middleware' => ['role_or_permission:Product-Manager|product-managers|product-managers-create|product-managers-save|product-managers-show|product-managers-edit|product-managers-delete']], function () {

    // Product Manager Route
    Route::get('listProductsManager', 'Ledges\AssingProductManagerController@listProductsManager')->name('listProductsManager');
    Route::resource('products-managers', 'Ledges\AssingProductManagerController');

    // });

    // Route::group(['middleware' => ['role_or_permission:Supply|supplys|supply-create|supply-save|supply-show|supply-edit|supply-delete']], function () {

        // supply route
        Route::get('TotalUnsupplyStock', 'Supply\SupplyController@TotalUnsupplyStock')->name('TotalUnsupplyStock');
        Route::get('ListTotalUnsupplyStock', 'Supply\SupplyController@ListTotalUnsupplyStock')->name('ListTotalUnsupplyStock');
        Route::get('listUnsupplyTransactions', 'Supply\SupplyController@listUnsupplyTransactions')->name('listUnsupplyTransactions');
        Route::resource('supply', 'Supply\SupplyController');
    // });

    //********************Health******************

        Route::resource('lab-managers', 'Lab\LabManagersController');
        Route::get('labServicesPaymentRequest', ['as' => 'labServicesPaymentRequest', 'uses' => 'Lab\LabServiceController@labServicesPaymentRequest']);
        Route::get('takeSample/{med_rep_id}', ['as' => 'takeSampleShow', 'uses' => 'Lab\LabServiceController@takeSampleShow']);
        Route::post('takeSample', ['as' => 'takeSample', 'uses' => 'Lab\LabServiceController@takeSample']);
        Route::get('randerServices', ['as' => 'randerServices', 'uses' => 'Lab\LabServiceController@randerServices']);
        Route::post('createLabRequest', 'Lab\LabServiceController@createLabRequest')->name('createLabRequest');
        Route::get('randerServicesList', ['as' => 'randerServicesList', 'uses' => 'Lab\LabServiceController@randerServicesList']);
        Route::post('testResult', ['as' => 'testResult', 'uses' => 'Lab\LabServiceController@testResult']);
        Route::get('randerResult/{id?}', ['as' => 'randerResult', 'uses' => 'Lab\LabServiceController@randerResult']);
        Route::get('randerResultList', ['as' => 'randerResultList', 'uses' => 'Lab\LabServiceController@randerResultList']);
        Route::get('viewResult', ['as' => 'viewResult', 'uses' => 'Lab\LabServiceController@viewResult']);
        Route::get('viewResultList', ['as' => 'viewResultList', 'uses' => 'Lab\LabServiceController@viewResultList']);
        Route::get('labServicesPaymentRequestList', ['as' => 'labServicesPaymentRequestList', 'uses' => 'Lab\LabServiceController@labServicesPaymentRequestList']);

        Route::get('PatientlabServicesRequest/{id}/{dependant_id?}', ['as' => 'PatientlabServicesRequest', 'uses' => 'Lab\LabServiceController@PatientlabServicesRequest']);
        Route::get('PatientlabServicesRequestList/{id}', ['as' => 'PatientlabServicesRequestList', 'uses' => 'Lab\LabServiceController@PatientlabServicesRequestList']);

        Route::get('listLabStaffs/{id}', ['as' => 'listLabStaffs', 'uses' => 'Lab\LabManagersController@listLabStaffs']);
        Route::get('ShowLabStaffs/{id}', ['as' => 'ShowLabStaffs', 'uses' => 'Lab\LabManagersController@ShowLabStaffs']);
        Route::post('storePatientLabServices', ['as' => 'storePatientLabServices', 'uses' => 'Payment\PaymentController@storePatientLabServices']);
    //********************new**********************

    // dependants routes

    Route::resource('dependants', DependantController::class);
    Route::get('listPatients','Patient\PatientController@index')->name('listPatients');
    Route::get('patientsList','Patient\PatientController@patientsList')->name('patientsList');
    Route::get('listDependants','DependantController@listDependants')->name('listDependants');
    Route::get('dependantsList','DependantController@dependantsList')->name('dependantsList');
    Route::post('getMyDependants/{id}','DependantController@getMyDependants')->name('getMyDependants');

    //ward note Routes
    Route::resource('ward_note', WardNoteController::class);
    Route::get('listWardNotes', 'WardNoteController@listWardNotes')->name('listWardNotes');
});
