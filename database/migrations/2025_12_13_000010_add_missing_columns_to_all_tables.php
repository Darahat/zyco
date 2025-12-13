<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix site_config table - add missing columns
        if (Schema::hasTable('site_config')) {
            Schema::table('site_config', function (Blueprint $table) {
                if (!Schema::hasColumn('site_config', 'support_email')) {
                    $table->string('support_email')->nullable()->after('invoice_email');
                }
                if (!Schema::hasColumn('site_config', 'registration_number')) {
                    $table->string('registration_number')->nullable()->after('support_email');
                }
                if (!Schema::hasColumn('site_config', 'telephone')) {
                    $table->string('telephone')->nullable()->after('registration_number');
                }
                if (!Schema::hasColumn('site_config', 'vat_number')) {
                    $table->string('vat_number')->nullable()->after('telephone');
                }
                if (!Schema::hasColumn('site_config', 'site_logo')) {
                    $table->string('site_logo')->nullable()->after('logo_path');
                }
            });
        }

        // Fix users table - add missing columns
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'username')) {
                    $table->string('username')->nullable()->after('name');
                }
                if (!Schema::hasColumn('users', 'alt_email')) {
                    $table->string('alt_email')->nullable()->after('email');
                }
                if (!Schema::hasColumn('users', 'can_speak')) {
                    $table->text('can_speak')->nullable()->after('mobile_number');
                }
                if (!Schema::hasColumn('users', 'time_zone')) {
                    $table->string('time_zone')->nullable()->after('base_city');
                }
                if (!Schema::hasColumn('users', 'language')) {
                    $table->string('language')->nullable()->after('time_zone');
                }
                if (!Schema::hasColumn('users', 'profile_picture')) {
                    $table->string('profile_picture')->nullable()->after('language');
                }
                if (!Schema::hasColumn('users', 'favorites')) {
                    $table->text('favorites')->nullable()->comment('Comma-separated user IDs');
                }
            });
        }

        // Fix users_personalinfo table - add missing columns
        if (Schema::hasTable('users_personalinfo')) {
            Schema::table('users_personalinfo', function (Blueprint $table) {
                if (!Schema::hasColumn('users_personalinfo', 'name_title')) {
                    $table->string('name_title')->nullable()->after('user_id');
                }
                if (!Schema::hasColumn('users_personalinfo', 'sex')) {
                    $table->enum('sex', ['Male', 'Female', 'Other'])->nullable()->after('name_title');
                }
                if (!Schema::hasColumn('users_personalinfo', 'street_name')) {
                    $table->string('street_name')->nullable()->after('address');
                }
                if (!Schema::hasColumn('users_personalinfo', 'personal_number')) {
                    $table->string('personal_number')->nullable()->after('phone');
                }
                if (!Schema::hasColumn('users_personalinfo', 'personal_email')) {
                    $table->string('personal_email')->nullable()->after('personal_number');
                }
                if (!Schema::hasColumn('users_personalinfo', 'emergency_number')) {
                    $table->string('emergency_number')->nullable()->after('personal_email');
                }
                if (!Schema::hasColumn('users_personalinfo', 'note_area')) {
                    $table->text('note_area')->nullable();
                }
                if (!Schema::hasColumn('users_personalinfo', 'driving_license')) {
                    $table->string('driving_license')->nullable()->comment('Driving license file path');
                }
            });
        }

        // Fix users_bankinfo table - add missing columns and rename
        if (Schema::hasTable('users_bankinfo')) {
            Schema::table('users_bankinfo', function (Blueprint $table) {
                if (!Schema::hasColumn('users_bankinfo', 'IBAN')) {
                    $table->string('IBAN')->nullable()->after('user_id');
                }
                if (!Schema::hasColumn('users_bankinfo', 'BIC')) {
                    $table->string('BIC')->nullable()->after('IBAN');
                }
                if (!Schema::hasColumn('users_bankinfo', 'account_holder_name')) {
                    $table->string('account_holder_name')->nullable()->after('BIC');
                }
                if (!Schema::hasColumn('users_bankinfo', 'note_area')) {
                    $table->text('note_area')->nullable();
                }
            });
        }

        // Fix users_postalcode table - add missing columns
        if (Schema::hasTable('users_postalcode')) {
            Schema::table('users_postalcode', function (Blueprint $table) {
                if (!Schema::hasColumn('users_postalcode', 'postcode')) {
                    $table->string('postcode')->nullable()->after('user_id');
                }
                if (!Schema::hasColumn('users_postalcode', 'hnumber')) {
                    $table->string('hnumber')->nullable()->after('postcode');
                }
                if (!Schema::hasColumn('users_postalcode', 'street')) {
                    $table->string('street')->nullable()->after('hnumber');
                }
                if (!Schema::hasColumn('users_postalcode', 'municipality')) {
                    $table->string('municipality')->nullable()->after('city');
                }
                if (!Schema::hasColumn('users_postalcode', 'province')) {
                    $table->string('province')->nullable()->after('municipality');
                }
                if (!Schema::hasColumn('users_postalcode', 'geoLat')) {
                    $table->decimal('geoLat', 10, 8)->nullable()->comment('Latitude');
                }
                if (!Schema::hasColumn('users_postalcode', 'geoLon')) {
                    $table->decimal('geoLon', 11, 8)->nullable()->comment('Longitude');
                }
            });
        }

        // Fix users_companyinfo table - add all KVK API fields
        if (Schema::hasTable('users_companyinfo')) {
            Schema::table('users_companyinfo', function (Blueprint $table) {
                if (!Schema::hasColumn('users_companyinfo', 'indNonMailing')) {
                    $table->string('indNonMailing')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'uniqueCompanyId')) {
                    $table->string('uniqueCompanyId')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'formalRegistrationDate')) {
                    $table->string('formalRegistrationDate')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'commencementDate')) {
                    $table->string('commencementDate')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'totalEmployedPersons')) {
                    $table->integer('totalEmployedPersons')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'tradeName1')) {
                    $table->string('tradeName1')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'order1')) {
                    $table->integer('order1')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'tradeName2')) {
                    $table->string('tradeName2')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'order2')) {
                    $table->integer('order2')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'tradeName3')) {
                    $table->string('tradeName3')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'order3')) {
                    $table->integer('order3')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'tradeName4')) {
                    $table->string('tradeName4')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'order4')) {
                    $table->integer('order4')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'sbiCode1')) {
                    $table->string('sbiCode1')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'sbiDescription1')) {
                    $table->text('sbiDescription1')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'indMainActivity1')) {
                    $table->string('indMainActivity1')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'sbiCode2')) {
                    $table->string('sbiCode2')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'sbiDescription2')) {
                    $table->text('sbiDescription2')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'indMainActivity2')) {
                    $table->string('indMainActivity2')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'sbiCode3')) {
                    $table->string('sbiCode3')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'sbiDescription3')) {
                    $table->text('sbiDescription3')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'indMainActivity3')) {
                    $table->string('indMainActivity3')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'link_rel1')) {
                    $table->string('link_rel1')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'link_href1')) {
                    $table->text('link_href1')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'link_rel2')) {
                    $table->string('link_rel2')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'link_href2')) {
                    $table->text('link_href2')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'mainBranchLocationNumber')) {
                    $table->string('mainBranchLocationNumber')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'mainBranchkvkNumber')) {
                    $table->string('mainBranchkvkNumber')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'mainBranchFormalRegistrationDate')) {
                    $table->string('mainBranchFormalRegistrationDate')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'mainBranchStartDate')) {
                    $table->string('mainBranchStartDate')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'mainBranchFirstTradeName')) {
                    $table->string('mainBranchFirstTradeName')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'mainBranchIndHoofdLocation')) {
                    $table->string('mainBranchIndHoofdLocation')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'mainBranchIndCommercieleLocation')) {
                    $table->string('mainBranchIndCommercieleLocation')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'mainBranchTotalEmployedPersons')) {
                    $table->integer('mainBranchTotalEmployedPersons')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'addressType')) {
                    $table->string('addressType')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'addressIndProtected')) {
                    $table->string('addressIndProtected')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'addressFullAddress')) {
                    $table->text('addressFullAddress')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'addressStreetName')) {
                    $table->string('addressStreetName')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'addressHouseNumber')) {
                    $table->string('addressHouseNumber')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'addressHouseLetter')) {
                    $table->string('addressHouseLetter')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'addressPostalCode')) {
                    $table->string('addressPostalCode')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'addressCity')) {
                    $table->string('addressCity')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'addressCountry')) {
                    $table->string('addressCountry')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'geoDataAddressableObjectId')) {
                    $table->string('geoDataAddressableObjectId')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'geoDataNumberDesignationId')) {
                    $table->string('geoDataNumberDesignationId')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'geoDataGpsLatitude')) {
                    $table->decimal('geoDataGpsLatitude', 10, 8)->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'geoDataGpsLongitude')) {
                    $table->decimal('geoDataGpsLongitude', 11, 8)->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'geoDataReichtriangleX')) {
                    $table->decimal('geoDataReichtriangleX', 15, 4)->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'geoDataReichtriangleY')) {
                    $table->decimal('geoDataReichtriangleY', 15, 4)->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'geoDataReichtriangleZ')) {
                    $table->decimal('geoDataReichtriangleZ', 15, 4)->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'links_rel1')) {
                    $table->string('links_rel1')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'links_href1')) {
                    $table->text('links_href1')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'links_rel2')) {
                    $table->string('links_rel2')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'links_href2')) {
                    $table->text('links_href2')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'links_rel3')) {
                    $table->string('links_rel3')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'links_href3')) {
                    $table->text('links_href3')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'links_rel4')) {
                    $table->string('links_rel4')->nullable();
                }
                if (!Schema::hasColumn('users_companyinfo', 'links_href4')) {
                    $table->text('links_href4')->nullable();
                }
            });
        }

        // Fix users_vehicle table - add all RDW API fields
        if (Schema::hasTable('users_vehicle')) {
            Schema::table('users_vehicle', function (Blueprint $table) {
                if (!Schema::hasColumn('users_vehicle', 'vehicle_type')) {
                    $table->string('vehicle_type')->nullable()->comment('Text version for API data');
                }
                if (!Schema::hasColumn('users_vehicle', 'make')) {
                    $table->string('make')->nullable()->comment('Text version for API data');
                }
                if (!Schema::hasColumn('users_vehicle', 'date_name')) {
                    $table->string('date_name')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'second_color')) {
                    $table->string('second_color')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'mass_empty_vehicle')) {
                    $table->integer('mass_empty_vehicle')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'mass_roadworthy')) {
                    $table->integer('mass_roadworthy')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'date_first_admission')) {
                    $table->date('date_first_admission')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'date_first_name_in_the_netherlands')) {
                    $table->date('date_first_name_in_the_netherlands')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'waiting_for_approval')) {
                    $table->string('waiting_for_approval')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'wam_insured')) {
                    $table->string('wam_insured')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'number_wheels')) {
                    $table->integer('number_wheels')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'distance_center_link_to_rear_vehicle')) {
                    $table->integer('distance_center_link_to_rear_vehicle')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'distance_front_vehicle_to_centre_link')) {
                    $table->integer('distance_front_vehicle_to_centre_link')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'length')) {
                    $table->integer('length')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'width')) {
                    $table->integer('width')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'european_vehicle_category')) {
                    $table->string('european_vehicle_category')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'technical_max_mass_vehicle')) {
                    $table->integer('technical_max_mass_vehicle')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'sequential_number_change_eu_type_approval')) {
                    $table->string('sequential_number_change_eu_type_approval')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'power_mass_ready')) {
                    $table->decimal('power_mass_ready', 10, 2)->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'wheelbase')) {
                    $table->integer('wheelbase')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'export_indicator')) {
                    $table->string('export_indicator')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'pending_recall_indicator')) {
                    $table->string('pending_recall_indicator')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'taxi_indicator')) {
                    $table->string('taxi_indicator')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'maximum_mass_composition')) {
                    $table->integer('maximum_mass_composition')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'year_last_registration_counter_reading')) {
                    $table->integer('year_last_registration_counter_reading')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'counter_reading_judgment')) {
                    $table->string('counter_reading_judgment')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'code_explanation_counter_reading')) {
                    $table->string('code_explanation_counter_reading')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'name_possible')) {
                    $table->string('name_possible')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'date_name_dt')) {
                    $table->string('date_name_dt')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'date_first_admission_dt')) {
                    $table->string('date_first_admission_dt')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'date_first_name_in_nederland_dt')) {
                    $table->string('date_first_name_in_nederland_dt')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'api_gekentekende_mobielen_assen')) {
                    $table->text('api_gekentekende_mobielen_assen')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'api_gekentekende_mobielen_fuel')) {
                    $table->text('api_gekentekende_mobielen_fuel')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'api_gekentekende_mobielen_carrosserie')) {
                    $table->text('api_gekentekende_mobielen_carrosserie')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'api_gekentekende_mobielen_carrosserie_specific')) {
                    $table->text('api_gekentekende_mobielen_carrosserie_specific')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'api_gekentekende_mobielen_mobielklasse')) {
                    $table->text('api_gekentekende_mobielen_mobielklasse')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'vehicle_make_id')) {
                    $table->unsignedBigInteger('vehicle_make_id')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'vehicle_model_id')) {
                    $table->unsignedBigInteger('vehicle_model_id')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'vehicle_id')) {
                    $table->string('vehicle_id')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'vehicle_name')) {
                    $table->string('vehicle_name')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'color')) {
                    $table->string('color')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'vehicle_image')) {
                    $table->string('vehicle_image')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'registration_mark')) {
                    $table->string('registration_mark')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'mot')) {
                    $table->string('mot')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'mot_expire_date')) {
                    $table->date('mot_expire_date')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'vehicle_classification_id')) {
                    $table->unsignedBigInteger('vehicle_classification_id')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'reg_keeper_address')) {
                    $table->text('reg_keeper_address')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'body_type')) {
                    $table->string('body_type')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'passenger_capacity')) {
                    $table->integer('passenger_capacity')->nullable();
                }
                if (!Schema::hasColumn('users_vehicle', 'reg_keeper_name')) {
                    $table->string('reg_keeper_name')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert site_config
        if (Schema::hasTable('site_config')) {
            Schema::table('site_config', function (Blueprint $table) {
                $table->dropColumn(['support_email', 'registration_number', 'telephone', 'vat_number', 'site_logo']);
            });
        }

        // Revert users
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['username', 'alt_email', 'can_speak', 'time_zone', 'language', 'profile_picture', 'favorites']);
            });
        }

        // Revert users_personalinfo
        if (Schema::hasTable('users_personalinfo')) {
            Schema::table('users_personalinfo', function (Blueprint $table) {
                $table->dropColumn(['name_title', 'sex', 'street_name', 'personal_number', 'personal_email', 'emergency_number', 'note_area', 'driving_license']);
            });
        }

        // Revert users_bankinfo
        if (Schema::hasTable('users_bankinfo')) {
            Schema::table('users_bankinfo', function (Blueprint $table) {
                $table->dropColumn(['IBAN', 'BIC', 'account_holder_name', 'note_area']);
            });
        }

        // Revert users_postalcode
        if (Schema::hasTable('users_postalcode')) {
            Schema::table('users_postalcode', function (Blueprint $table) {
                $table->dropColumn(['postcode', 'hnumber', 'street', 'municipality', 'province', 'geoLat', 'geoLon']);
            });
        }

        // Revert users_companyinfo (70+ columns)
        if (Schema::hasTable('users_companyinfo')) {
            Schema::table('users_companyinfo', function (Blueprint $table) {
                $table->dropColumn([
                    'indNonMailing', 'uniqueCompanyId', 'name', 'formalRegistrationDate', 'commencementDate',
                    'totalEmployedPersons', 'tradeName1', 'order1', 'tradeName2', 'order2', 'tradeName3', 'order3',
                    'tradeName4', 'order4', 'sbiCode1', 'sbiDescription1', 'indMainActivity1', 'sbiCode2',
                    'sbiDescription2', 'indMainActivity2', 'sbiCode3', 'sbiDescription3', 'indMainActivity3',
                    'link_rel1', 'link_href1', 'link_rel2', 'link_href2', 'mainBranchLocationNumber',
                    'mainBranchkvkNumber', 'mainBranchFormalRegistrationDate', 'mainBranchStartDate',
                    'mainBranchFirstTradeName', 'mainBranchIndHoofdLocation', 'mainBranchIndCommercieleLocation',
                    'mainBranchTotalEmployedPersons', 'addressType', 'addressIndProtected', 'addressFullAddress',
                    'addressStreetName', 'addressHouseNumber', 'addressHouseLetter', 'addressPostalCode',
                    'addressCity', 'addressCountry', 'geoDataAddressableObjectId', 'geoDataNumberDesignationId',
                    'geoDataGpsLatitude', 'geoDataGpsLongitude', 'geoDataReichtriangleX', 'geoDataReichtriangleY',
                    'geoDataReichtriangleZ', 'links_rel1', 'links_href1', 'links_rel2', 'links_href2',
                    'links_rel3', 'links_href3', 'links_rel4', 'links_href4'
                ]);
            });
        }

        // Revert users_vehicle (50+ columns)
        if (Schema::hasTable('users_vehicle')) {
            Schema::table('users_vehicle', function (Blueprint $table) {
                $table->dropColumn([
                    'vehicle_type', 'make', 'date_name', 'second_color', 'mass_empty_vehicle', 'mass_roadworthy',
                    'date_first_admission', 'date_first_name_in_the_netherlands', 'waiting_for_approval',
                    'wam_insured', 'number_wheels', 'distance_center_link_to_rear_vehicle',
                    'distance_front_vehicle_to_centre_link', 'length', 'width', 'european_vehicle_category',
                    'technical_max_mass_vehicle', 'sequential_number_change_eu_type_approval', 'power_mass_ready',
                    'wheelbase', 'export_indicator', 'pending_recall_indicator', 'taxi_indicator',
                    'maximum_mass_composition', 'year_last_registration_counter_reading', 'counter_reading_judgment',
                    'code_explanation_counter_reading', 'name_possible', 'date_name_dt', 'date_first_admission_dt',
                    'date_first_name_in_nederland_dt', 'api_gekentekende_mobielen_assen', 'api_gekentekende_mobielen_fuel',
                    'api_gekentekende_mobielen_carrosserie', 'api_gekentekende_mobielen_carrosserie_specific',
                    'api_gekentekende_mobielen_mobielklasse', 'vehicle_make_id', 'vehicle_model_id', 'vehicle_id',
                    'vehicle_name', 'color', 'vehicle_image', 'registration_mark', 'mot', 'mot_expire_date',
                    'vehicle_classification_id', 'reg_keeper_address', 'body_type', 'passenger_capacity', 'reg_keeper_name'
                ]);
            });
        }
    }
};
