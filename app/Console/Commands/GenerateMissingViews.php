<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateMissingViews extends Command
{
    protected $signature = 'views:generate-missing';
    protected $description = 'Generate missing view files with proper layouts';

    public function handle()
    {
        $viewsToCreate = [
            'backend/document/index.blade.php' => 'backend.web_admin',
            'backend/document/add.blade.php' => 'backend.web_admin',
            'backend/document/edit.blade.php' => 'backend.web_admin',
            'backend/admin/adminList.blade.php' => 'backend.web_admin',
            'backend/admin/adminEditForm.blade.php' => 'backend.web_admin',
            'backend/country/index.blade.php' => 'backend.web_admin',
            'backend/country/add.blade.php' => 'backend.web_admin',
            'backend/country/edit.blade.php' => 'backend.web_admin',
            'backend/dispatcher/dispatch_form.blade.php' => 'backend.web_admin',
            'backend/dispatcher/dispatch_map.blade.php' => 'backend.web_admin',
            'backend/dispatcher/dispatch_list.blade.php' => 'backend.web_admin',
            'backend/dispatcher/add.blade.php' => 'backend.web_admin',
            'backend/menu.blade.php' => 'backend.web_admin',
            'backend/menu_sub.blade.php' => 'backend.web_admin',
            'backend/menu_child.blade.php' => 'backend.web_admin',
            'backend/pages.blade.php' => 'backend.web_admin',
            'backend/pages_edit.blade.php' => 'backend.web_admin',
            'backend/postalCode/index.blade.php' => 'backend.web_admin',
            'backend/postalCode/add.blade.php' => 'backend.web_admin',
            'backend/postalCode/add2.blade.php' => 'backend.web_admin',
            'backend/postalCode/edit.blade.php' => 'backend.web_admin',
            'backend/user_list/index.blade.php' => 'backend.web_admin',
            'backend/drivers_vehicle/indexForAdmin.blade.php' => 'backend.web_admin',
            'backend/drivers_vehicle/add.blade.php' => 'backend.web_admin',
            'backend/drivers_vehicle/edit.blade.php' => 'backend.web_admin',
            'backend/drivers_vehicle/vehicle_check.blade.php' => 'backend.web_admin',
            'backend/drivers_vehicle/vat_check.blade.php' => 'backend.web_admin',
            'backend/drivers_vehicle/vat_list.blade.php' => 'backend.web_admin',
            'backend/company/index.blade.php' => 'backend.web_admin',
            'backend/company/add.blade.php' => 'backend.web_admin',
            'backend/company/add2.blade.php' => 'backend.web_admin',
            'backend/company/edit.blade.php' => 'backend.web_admin',
            'backend/company/vat_check.blade.php' => 'backend.web_admin',
            'backend/company/vat_check2.blade.php' => 'backend.web_admin',
            'backend/company/vat_edit.blade.php' => 'backend.web_admin',
            'backend/company/vat_list.blade.php' => 'backend.web_admin',
            'backend/fees/index.blade.php' => 'backend.web_admin',
            'backend/fees/add.blade.php' => 'backend.web_admin',
            'backend/fees/edit.blade.php' => 'backend.web_admin',
            'backend/currency/index.blade.php' => 'backend.web_admin',
            'backend/currency/add.blade.php' => 'backend.web_admin',
            'backend/currency/edit.blade.php' => 'backend.web_admin',
            'backend/language/index.blade.php' => 'backend.web_admin',
            'backend/language/add.blade.php' => 'backend.web_admin',
            'backend/language/edit.blade.php' => 'backend.web_admin',
            'backend/vehicle/vehicle_make.blade.php' => 'backend.web_admin',
            'backend/vehicle/vehicle_make_form.blade.php' => 'backend.web_admin',
            'backend/vehicle/vehicle_make_edit.blade.php' => 'backend.web_admin',
            'backend/vehicle/vehicle_type.blade.php' => 'backend.web_admin',
            'backend/vehicle/vehicle_type_form.blade.php' => 'backend.web_admin',
            'backend/vehicle/vehicle_type_edit.blade.php' => 'backend.web_admin',
            'backend/vehicle/vehicle_model.blade.php' => 'backend.web_admin',
            'backend/vehicle/vehicle_model_form.blade.php' => 'backend.web_admin',
            'backend/vehicle/vehicle_model_edit.blade.php' => 'backend.web_admin',
            'backend/profile/profile_search_result.blade.php' => 'backend.web_admin',
            'backend/common/others_profile.blade.php' => 'backend.web_admin',
            'admin/loginConfig/index.blade.php' => 'backend.web_admin',
            'admin/templateType/index.blade.php' => 'backend.web_admin',
            'admin/templateEmail/index.blade.php' => 'backend.web_admin',
            'admin/templateEmail/edit.blade.php' => 'backend.web_admin',
            'admin/templateSms/index.blade.php' => 'backend.web_admin',
            'admin/templateSms/edit.blade.php' => 'backend.web_admin',
            'admin/formConfig/site_config.blade.php' => 'backend.web_admin',
            'admin/formConfig/bankp.blade.php' => 'backend.web_admin',
            'admin/formConfig/vehiclep.blade.php' => 'backend.web_admin',
            'admin/formConfig/groupp.blade.php' => 'backend.web_admin',
            'admin/formConfig/companyp.blade.php' => 'backend.web_admin',
            'admin/formConfig/vatp.blade.php' => 'backend.web_admin',
            'admin/formConfig/postalp.blade.php' => 'backend.web_admin',
            'admin/formConfig/documentp.blade.php' => 'backend.web_admin',
            'admin/formConfig/personalp.blade.php' => 'backend.web_admin',
            'admin/formConfig/basicp.blade.php' => 'backend.web_admin',
            'google-autocomplete.blade.php' => 'app',
        ];

        $created = 0;
        $skipped = 0;

        foreach ($viewsToCreate as $viewPath => $layout) {
            $fullPath = resource_path('views/' . $viewPath);
            
            if (File::exists($fullPath)) {
                $skipped++;
                continue;
            }

            $directory = dirname($fullPath);
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $title = $this->generateTitle($viewPath);
            $content = $this->generateViewContent($layout, $title);
            
            File::put($fullPath, $content);
            $created++;
            $this->info("Created: $viewPath");
        }

        $this->info("\nSummary:");
        $this->info("Created: $created views");
        $this->info("Skipped (already exist): $skipped views");
        
        return 0;
    }

    private function generateTitle($viewPath)
    {
        $name = basename($viewPath, '.blade.php');
        $name = str_replace(['_', '-'], ' ', $name);
        return ucwords($name);
    }

    private function generateViewContent($layout, $title)
    {
        return <<<BLADE
@extends('$layout')

@section('title', '$title')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">$title</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">$title</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">$title</h3>
                </div>
                <div class="card-body">
                    <p>This view is under construction. Please implement the required functionality.</p>
                    <!-- TODO: Add your content here -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
BLADE;
    }
}

