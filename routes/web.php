<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/clear-cache', function () {
	Artisan::call('cache:clear');
	return "Cache is cleared";
});
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CustomAuth2Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\PostalCodeController;
use App\Http\Controllers\FormConfigController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\Rider;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\AccountClassificationController;
use App\Http\Controllers\AccountUpgradationController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\VehicleClassificationController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\AutoAssignRuleController;
use App\Http\Controllers\DispatcherController;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\LoginConfigController;
use App\Http\Controllers\MyTestMail;
use App\Http\Controllers\ThemeCustomizeController;
// use Redirect;
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

Route::get('google-autocomplete', [GoogleController::class, 'index']);

// Root route - redirect to login for localhost
Route::get('/', function () {
	return redirect()->route('login');
});

Route::get('/clear-cache', function () {
	Artisan::call('cache:clear');
	dd("cache clear all");
});
Route::get('/dump', function () {
	exec('composer dump-autoload');
	dd("auto load");
});
// Route::group(['domain' => 'my.zyco.nl'],function(){
Route::group(['middleware' => 'driver'], function () {
	Route::post('commonUpdate', [HelperController::class, 'commonUpdate'])->name('commonUpdate');
	// Route::get('/my_profile', [DispatcherController::class, 'my_profile'])->name('my_profile');
	Route::get('user-my-profile', [DispatcherController::class, 'my_profile'])->name('my_profile');
	Route::get('user-autocomplete', [ProfileController::class, 'autocomplete'])->name('autocomplete');
	Route::post('user-searchResult', [ProfileController::class, 'searchResult'])->name('searchResult');
	Route::get('user-others-profile/{others_id}', [ProfileController::class, 'others_profile'])->name('others_profile');
	Route::get('user-upgrade-profile-packages', [AccountUpgradationController::class, 'upgrade_profile_packages'])->name('upgrade_profile_packages');
	Route::get('user-profileUpdate', [ProfileController::class, 'profileUpdate'])->name('profileUpdate');
	Route::post('user-updatePersonal', [ProfileController::class, 'updatePersonal'])->name('updatePersonal');
	Route::get('user-updateBasicInfoForm', [ProfileController::class, 'updateBasicInfoForm'])->name('updateBasicInfoForm');
	Route::post('user-updateBasicInfo', [ProfileController::class, 'updateBasicInfo'])->name('updateBasicInfo');
	Route::post('user-updateBank', [ProfileController::class, 'updateBank'])->name('updateBank');
	Route::get('user-document', [DocumentController::class, 'index'])->name('document');
	Route::match(array('GET', 'POST'), 'user-add-document', [DocumentController::class, 'add'])->name('add_document');
	Route::match(array('GET', 'POST'), 'user-edit-document/{id}', [DocumentController::class, 'update'])->where('id', '[0-9]+')->name('edit_document');
	Route::get('user-delete_document/{id}', [DocumentController::class, 'delete'])->where('id', '[0-9]+')->name('delete_document');
	Route::get('user-dashboard', [CustomAuthController::class, 'dashboard'])->name('driver.dashboard');
	Route::get('user-vehicle', [VehicleController::class, 'index'])->name('vehicle_list');
	Route::match(array('GET', 'POST'), 'user-add-vehicle', [VehicleController::class, 'add'])->name('add_vehicle');
	Route::match(array('GET', 'POST'), 'user-add-vehicle2', [VehicleController::class, 'add2'])->name('add_vehicle2');
	Route::match(array('GET', 'POST'), 'user-edit-vehicle/{id}', [VehicleController::class, 'update'])->where('id', '[0-9]+')->name('edit_vehicle');
	Route::get('user-delete_vehicle/{id}', [VehicleController::class, 'delete'])->where('id', '[0-9]+')->name('delete_vehicle');
	Route::match(array('GET', 'POST'), 'user-vehicle-check', [VehicleController::class, 'vehicle_check'])->name('vehicle_check');
	Route::get('user-company', [CompanyController::class, 'index'])->name('company');
	Route::match(array('GET', 'POST'), 'user-add-company', [CompanyController::class, 'add'])->name('add_company');
	Route::match(array('GET', 'POST'), 'user-add-company2', [CompanyController::class, 'add2'])->name('add_company2');
	Route::match(array('GET', 'POST'), 'user-edit-company/{id}', [CompanyController::class, 'update'])->where('id', '[0-9]+')->name('edit_company');
	Route::get('user-delete_company/{id}', [CompanyController::class, 'delete'])->where('id', '[0-9]+')->name('delete_company');
	Route::match(array('GET', 'POST'), 'user-vat-check', [CompanyController::class, 'vat_check'])->name('vat_check');
	Route::match(array('GET', 'POST'), 'user-vat-check2', [CompanyController::class, 'vat_check2'])->name('vat_check2');
	Route::get('user-vat-list', [CompanyController::class, 'vat_list'])->name('vat_list');
	Route::match(array('GET', 'POST'), 'user-edit-vat/{id}', [CompanyController::class, 'vat_update'])->where('id', '[0-9]+')->name('edit_vat');
	Route::get('user-delete-vat/{id}', [CompanyController::class, 'delete_vat'])->name('delete_vat');
	Route::get('user-postal', [PostalCodeController::class, 'index'])->name('postal_list');
	Route::match(array('GET', 'POST'), 'user-add-postal', [PostalCodeController::class, 'add'])->name('add_postal');
	Route::match(array('GET', 'POST'), 'user-add-postal2', [PostalCodeController::class, 'add2'])->name('add_postal2');
	Route::match(array('GET', 'POST'), 'user-edit-postal/{id}', [PostalCodeController::class, 'update'])->where('id', '[0-9]+')->name('edit_postal');
	Route::get('user-delete-postal/{id}', [PostalCodeController::class, 'delete'])->name('delete_postal');
	Route::get('user-group', [GroupController::class, 'index'])->name('group');
	Route::match(array('GET', 'POST'), 'user-add-group', [GroupController::class, 'add'])->name('add_group');
	Route::match(array('GET', 'POST'), 'user-edit-group/{id}', [GroupController::class, 'update'])->where('id', '[0-9]+')->name('edit_group');
	Route::get('user-delete-group/{id}', [GroupController::class, 'delete'])->where('id', '[0-9]+')->name('delete_group');
	Route::get('user-group-member/{id}', [GroupController::class, 'member'])->name('group_member');
	Route::get('user-pending-member/{id}', [GroupController::class, 'pending_member'])->name('pending_group_member');
	Route::get('user-rejected-member/{id}', [GroupController::class, 'rejected_member'])->name('rejected_group_member');
	Route::match(array('GET', 'POST'), 'user-add-group_member', [GroupController::class, 'add_member'])->name('add_group_member');
	Route::match(array('GET', 'POST'), 'user-edit-group-member/{id}', [GroupController::class, 'update_member'])->where('id', '[0-9]+')->name('edit_group_member');
	Route::get('user-delete-group-member/{id}', [GroupController::class, 'delete_member'])->where('id', '[0-9]+')->name('delete_member');
	Route::get('user-group-request', [GroupController::class, 'group_request'])->name('group_request');
	Route::get('user-mygroup', [GroupController::class, 'mygroup'])->name('mygroup');
	Route::get('group-have-joined', [GroupController::class, 'group_have_joined'])->name('group_have_joined');
	Route::match(array('GET', 'POST'), 'user-auto-assign-rule', [AutoAssignRuleController::class, 'add'])->name('auto_assign_rule');
	Route::get('user-dispatch-form', [DispatcherController::class, 'dispatch_form'])->name('dispatch_form');
	Route::get('user-dispatch-map', [DispatcherController::class, 'dispatch_map'])->name('dispatch_map');
	Route::get('user-dispatch-list', [DispatcherController::class, 'dispatch_list'])->name('dispatch_list');
	Route::match(array('GET', 'POST'), 'user-dispatch-create', [DispatcherController::class, 'add'])->name('dispatch_create');
	Route::get('user-list', [UserListController::class, 'index'])->name('user_list');
	Route::get('make-favorite/{id}', [UserListController::class, 'make_favorite'])->name('make_favorite');
	Route::get('remove-favorite/{id}', [UserListController::class, 'remove_favorite'])->name('remove_favorite');
	Route::post('theme-customize', [ThemeCustomizeController::class, 'theme_customize'])->name('theme_customize');
	Route::get('my-wallet', [WalletController::class, 'my_wallet'])->name('my_wallet');
	Route::get('fee-calculate', [WalletController::class, 'feeCalculate'])->name('feeCalculate');
	Route::post('topup', [WalletController::class, 'topup'])->name('topup');
	Route::get('topup_success', [WalletController::class, 'topup_success'])->name('topup_success');
	// Route::post('withdraw', [WalletController::class, 'withdraw'])->name('withdraw');  
	// Route::get('latest-debit', [WalletController::class, 'latest_debit'])->name('latest_debit');  
	// Route::get('latest-credit', [WalletController::class, 'latest_credit'])->name('latest_credit');  
	//test
	Route::get('create', [WalletController::class, 'create'])->name('create');
	Route::post('create_checkout', [WalletController::class, 'create_checkout'])->name('create-checkout');
	// Route::get('wallet_create', [WalletController::class, 'wallet_create'])->name('wallet.create');
	// Route::post('order-post', [WalletController::class, 'orderPost'])->name('order-post');			
});
// });
Route::get('/getUsers', [HelperController::class, 'getUsers'])->name('getUsers');
Route::post('/updateSingleData', [HelperController::class, 'updateSingleData'])->name('updateSingleData');
Route::post('/updateSingleArrayData', [HelperController::class, 'updateSingleArrayData'])->name('updateSingleArrayData');
Route::post('/deleteSingleData', [HelperController::class, 'deleteSingleData'])->name('deleteSingleData');
Route::post('/setCheckData', [HelperController::class, 'setCheckData'])->name('setCheckData');
Route::post('/setConfigData', [FormConfigController::class, 'setConfigData'])->name('setConfigData');
Route::post('/imageChange', [HelperController::class, 'imageChange'])->name('imageChange');
Route::get('/getDetails', [HelperController::class, 'getDetails'])->name('getDetails');
Route::get('otp', [FirebaseController::class, 'otp'])->name('otp');
Route::group(['prefix' => 'Rider', 'middleware' => 'rider'], function () {
	Route::get('/dashboard', [CustomAuthController::class, 'dashboard'])->name('rider.dashboard');
});
Route::prefix('/adminManage')->middleware('admin')->group(__DIR__ . '/admin/adminManage.php');
Route::prefix('/vehicleMange')->group(__DIR__ . '/admin/vehicleMange.php');
// Route::group(['domain' => 'admin.zyco.nl'],function(){
Route::get('admin-login', [AdminController::class, 'adminLoginForm'])->name('adminLoginForm');
Route::post('authenticate', [AdminController::class, 'authenticate'])->name('adminLogin');
Route::get('admin-forget-password', [AdminController::class, 'forget_password_admin'])->name('forget_password_admin');
Route::get('admin-forget-email', [AdminController::class, 'forget_email_admin'])->name('forget_email_admin');
Route::get('admin-signin-option', [AdminController::class, 'signin_option_admin'])->name('signin_option_admin');

Route::group(['middleware' => 'admin'], function () {
	Route::get('login-config', [LoginConfigController::class, 'index'])->name('login_config');
	Route::get('admin-my-profile', [DispatcherController::class, 'my_profile'])->name('admin_profile');
	Route::get('admin-all-vehicles', [VehicleController::class, 'indexadmin'])->name('all_vehicle_list');
	Route::get('admin-country', [CountryController::class, 'index'])->name('country');
	Route::match(array('GET', 'POST'), 'admin-add-country', [CountryController::class, 'add'])->name('add_country');
	Route::match(array('GET', 'POST'), 'admin-edit-country/{id}', [CountryController::class, 'update'])->where('id', '[0-9]+')->name('edit_country');
	Route::get('admin-delete-country', [CountryController::class, 'delete'])->where('id', '[0-9]+')->name('delete_country');
	Route::get('admin-account-upgradation-application', [AccountUpgradationController::class, 'index'])->name('account_upgradation_application');
	Route::match(array('GET', 'POST'), 'admin-add-account-upgradation-application', [AccountUpgradationController::class, 'add'])->name('add_account_upgradation_application');
	Route::match(array('GET', 'POST'), 'admin-edit-account-upgradation-application/{id}', [AccountUpgradationController::class, 'update'])->where('id', '[0-9]+')->name('edit_account_upgradation_application');
	Route::get('admin-delete-account-upgradation-application', [AccountUpgradationController::class, 'delete'])->where('id', '[0-9]+')->name('delete_account_upgradation_application');
	Route::get('admin-account-classification-package', [AccountClassificationController::class, 'index'])->name('account_classification_package');;
	Route::match(array('GET', 'POST'), 'admin-add-account-classification-package', [AccountClassificationController::class, 'add'])->name('add_account_classification_package');
	Route::match(array('GET', 'POST'), 'admin-edit-account-classification-package/{id}', [AccountClassificationController::class, 'update'])->where('id', '[0-9]+')->name('edit_account_classification_package');
	Route::get('admin-delete-account-classification-package', [AccountClassificationController::class, 'delete'])->where('id', '[0-9]+')->name('delete_account_classification_package');
	// common functions
	// Route::post('/updateSingleData', [VehicleController::class, 'updateSingleData'])->name('updateSingleData'); 
	// Route::post('/singleValueChange', [VehicleController::class, 'singleValueChange'])->name('singleValueChange'); 
	//currency
	Route::get('admin-currency', [CurrencyController::class, 'index'])->name('currency');
	Route::match(array('GET', 'POST'), 'admin-add-currency', [CurrencyController::class, 'add'])->name('add_currency');
	Route::match(array('GET', 'POST'), 'admin-edit-currency/{id}', [CurrencyController::class, 'update'])->where('id', '[0-9]+')->name('edit_currency');
	Route::get('admin-delete-currency', [CurrencyController::class, 'delete'])->where('id', '[0-9]+')->name('delete_currency');
	//fees
	Route::get('admin-fees', [FeesController::class, 'index'])->name('fees');
	Route::match(array('GET', 'POST'), 'admin-add-fee', [FeesController::class, 'add'])->name('add_fee');
	Route::match(array('GET', 'POST'), 'admin-edit-fee/{id}', [FeesController::class, 'update'])->where('id', '[0-9]+')->name('edit_fee');
	Route::get('admin-delete-fee', [FeesController::class, 'delete'])->where('id', '[0-9]+')->name('delete_fee');
	//payment gateway
	Route::get('admin-payment-gateway', [PaymentGatewayController::class, 'index'])->name('payment_gateway');
	Route::match(array('GET', 'POST'), 'admin-add-payment-gateway', [PaymentGatewayController::class, 'add'])->name('add_payment_gateway');
	Route::match(array('GET', 'POST'), 'admin-edit-payment-gateway/{id}', [PaymentGatewayController::class, 'update'])->where('id', '[0-9]+')->name('edit_payment_gateway');
	Route::get('admin-delete-payment-gateway', [PaymentGatewayController::class, 'delete'])->where('id', '[0-9]+')->name('delete_payment_gateway');
	//payment methods
	Route::get('admin-payment-method', [PaymentMethodController::class, 'index'])->name('payment_method');
	Route::match(array('GET', 'POST'), 'admin-add-payment-method', [PaymentMethodController::class, 'add'])->name('add_payment_method');
	Route::match(array('GET', 'POST'), 'admin-edit-payment-method/{id}', [PaymentMethodController::class, 'update'])->where('id', '[0-9]+')->name('edit_payment_method');
	Route::get('admin-delete-payment-method', [PaymentMethodController::class, 'delete'])->where('id', '[0-9]+')->name('delete_payment_method');
	//language
	Route::get('admin-language', [LanguageController::class, 'index'])->name('language');
	Route::match(array('GET', 'POST'), 'admin-add-language', [LanguageController::class, 'add'])->name('add_language');
	Route::match(array('GET', 'POST'), 'admin-edit-language/{id}', [LanguageController::class, 'update'])->where('id', '[0-9]+')->name('edit_language');
	Route::get('admin-delete-language', [LanguageController::class, 'delete'])->where('id', '[0-9]+')->name('delete_language');
	//language
	Route::get('admin-vehicle-classification', [VehicleClassificationController::class, 'index'])->name('vehicle_classification');
	Route::match(array('GET', 'POST'), 'admin-add-vehicle-classification', [VehicleClassificationController::class, 'add'])->name('add_vehicle_classification');
	Route::match(array('GET', 'POST'), 'admin-edit-vehicle-classification/{id}', [VehicleClassificationController::class, 'update'])->where('id', '[0-9]+')->name('edit_vehicle_classification.{id}');
	Route::get('admin-delete-vehicle-classification/{id}', [VehicleClassificationController::class, 'delete'])->where('id', '[0-9]+')->name('delete_vehicle_classification');
	Route::get('admin-vehicle', [VehicleController::class, 'vehicle_setup'])->name('vehicle_setup');
	//Form Configuration
	Route::match(array('GET', 'POST'), 'siteConfig', [FormConfigController::class, 'siteConfig'])->name('siteConfig');
	Route::match(array('GET', 'POST'), 'vehicleConfig', [FormConfigController::class, 'vehicleConfig'])->name('vehicleConfig');
	Route::match(array('GET', 'POST'), 'companyConfig', [FormConfigController::class, 'companyConfig'])->name('companyConfig');
	Route::match(array('GET', 'POST'), 'vatConfig', [FormConfigController::class, 'vatConfig'])->name('vatConfig');
	Route::match(array('GET', 'POST'), 'groupConfig', [FormConfigController::class, 'groupConfig'])->name('groupConfig');
	Route::match(array('GET', 'POST'), 'postalConfig', [FormConfigController::class, 'postalConfig'])->name('postalConfig');
	Route::match(array('GET', 'POST'), 'documentConfig', [FormConfigController::class, 'documentConfig'])->name('documentConfig');
	Route::match(array('GET', 'POST'), 'personalConfig', [FormConfigController::class, 'personalConfig'])->name('personalConfig');
	Route::match(array('GET', 'POST'), 'basicConfig', [FormConfigController::class, 'basicConfig'])->name('basicConfig');
	Route::match(array('GET', 'POST'), 'bankConfig', [FormConfigController::class, 'bankConfig'])->name('bankConfig');
	// Manage Template
	Route::get('template-type', [TemplateController::class, 'templateType'])->name('template-type');
	Route::match(array('GET', 'POST'), 'template-type-add', [TemplateController::class, 'templateTypeAdd'])->name('template-type-add');
	Route::match(array('GET', 'POST'), 'template-type-edit/{id}', [TemplateController::class, 'templateTypeEdit'])->where('id', '[0-9]+')->name('template-type-edit');
	Route::get('template-type-delete', [TemplateController::class, 'templateTypeDelete'])->where('id', '[0-9]+')->name('template-type-delete');
	Route::get('template-email', [TemplateController::class, 'templateEmail'])->name('template-email');
	Route::get('template-sms', [TemplateController::class, 'templateSms'])->name('template-sms');
	Route::match(array('GET', 'POST'), 'template-email-edit/{id}', [TemplateController::class, 'templateEmailEdit'])->where('id', '[0-9]+')->name('template-email-edit');
	Route::match(array('GET', 'POST'), 'template-sms-edit/{id}', [TemplateController::class, 'templateSmsEdit'])->where('id', '[0-9]+')->name('template-sms-edit');
	Route::match(array('GET', 'POST'), 'send-email', [TemplateController::class, 'sendEmail'])->name('send-email');
	Route::get('/test_email', [TemplateController::class, 'sendMail']);

	// Route::match(array('GET', 'POST'), 'edit_vehicle_type/{id}', 'VehicleTypeController@update');
	// Route::match(array('GET', 'POST'), 'delete_vehicle_type/{id}', 'VehicleTypeController@delete');
	// Manage Vehicle
	// Route::get('vehicle', 'VehicleController@index');
	// Route::match(array('GET', 'POST'), 'add_vehicle', 'VehicleController@add');
	// Route::post('manage_vehicle/{company_id}/get_driver', 'VehicleController@get_driver')->name('admin.get_driver');
	// Route::match(array('GET', 'POST'), 'edit_vehicle/{id}', 'VehicleController@update');
	// Route::match(array('GET', 'POST'), 'delete_vehicle/{id}', 'VehicleController@delete');
	// Route::match(array('GET', 'POST'), 'validate_vehicle_number','VehicleController@validate_vehicle_number');
	// Route::match(array('GET', 'POST'), 'check_default','VehicleController@check_default');
});
// });
// Route::group(['domain' => 'accounts.zyco.nl'],function(){
Route::get('/login', [CustomAuthController::class, 'index'])->name('login');
Route::post('user-custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('user-login2', [CustomAuth2Controller::class, 'index'])->name('login2');
Route::post('user-custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('user-user_registration', [CustomAuthController::class, 'user_registration'])->name('user_registration');
Route::get('user-forget_password', [CustomAuthController::class, 'forget_password'])->name('forget_password');
Route::get('user-forget_email', [CustomAuthController::class, 'forget_email'])->name('forget_email');
Route::get('user-signin_option', [CustomAuthController::class, 'signin_option'])->name('signin_option');
Route::get('user-Emailrecovery', [MyTestMail::class, 'Emailrecovery'])->name('Emailrecovery');
Route::get('user-Passwordrecovery', [MyTestMail::class, 'Passwordrecovery'])->name('Passwordrecovery');
// });
// Route::get('login', [CustomAuthController::class, 'index'])->name('login');
// Route::get('login2', [CustomAuth2Controller::class, 'index'])->name('login2');
// Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
// Route::get('user_registration', [CustomAuthController::class, 'user_registration'])->name('user_registration');
// Route::get('forget_password', [CustomAuthController::class, 'forget_password'])->name('forget_password');
// Route::get('forget_email', [CustomAuthController::class, 'forget_email'])->name('forget_email');
// Route::get('signin_option', [CustomAuthController::class, 'signin_option'])->name('signin_option');

// Route::get('EmailrecoveryAdmin', [MyTestMail::class, 'EmailrecoveryAdmin'])->name('EmailrecoveryAdmin');
Route::get('registration-complete-email', [MyTestMail::class, 'RegistrationComplete'])->name('RegistrationComplete');
Route::post('checkEmail', [CustomAuthController::class, 'checkEmail'])->name('checkEmail');
Route::post('checkMobileNumber', [CustomAuthController::class, 'checkMobileNumber'])->name('checkMobileNumber');
Route::get('check-user-exist', [CustomAuthController::class, 'check_user_exist'])->name('check_user_exist');
Route::get('check-user-exist2', [CustomAuthController::class, 'check_user_exist2'])->name('check_user_exist2');
Route::get('check-user-exist3', [CustomAuthController::class, 'check_user_exist3'])->name('check_user_exist3');
Route::get('check-data-exist', [CustomAuthController::class, 'check_data_exist'])->name('check_data_exist');
Route::get('check-data-exist2', [CustomAuthController::class, 'check_data_exist2'])->name('check_data_exist2');
Route::post('updateAuthData', [CustomAuthController::class, 'updateAuthData'])->name('updateAuthData');
Route::post('updateAuthData', [CustomAuthController::class, 'updateAuthData'])->name('updateAuthData');
// 0ujRoute::get('sendbasicemail','MailController@basic_email');
// Route::get('sendhtmlemail','MailController@html_email');
// Route::get('sendattachmentemail','MailController@attachment_email');

Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');