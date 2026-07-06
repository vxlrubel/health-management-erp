<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'company_name', 'group' => 'general', 'name' => 'Company Name', 'value' => 'Health Management ERP', 'type' => 'text', 'is_public' => true],
            ['key' => 'company_email', 'group' => 'general', 'name' => 'Company Email', 'value' => 'info@hmerp.example.com', 'type' => 'text', 'is_public' => true],
            ['key' => 'company_phone', 'group' => 'general', 'name' => 'Company Phone', 'value' => '020 1234 5678', 'type' => 'text', 'is_public' => true],
            ['key' => 'default_currency', 'group' => 'finance', 'name' => 'Default Currency', 'value' => 'GBP', 'type' => 'text', 'is_public' => true],
            ['key' => 'vat_rate', 'group' => 'finance', 'name' => 'VAT Rate', 'value' => '20', 'type' => 'number', 'is_public' => true],
            ['key' => 'invoice_prefix', 'group' => 'finance', 'name' => 'Invoice Prefix', 'value' => 'INV-', 'type' => 'text', 'is_public' => false],
            ['key' => 'default_hourly_rate', 'group' => 'payroll', 'name' => 'Default Hourly Rate', 'value' => '15.00', 'type' => 'number', 'is_public' => false],
            ['key' => 'overtime_rate_multiplier', 'group' => 'payroll', 'name' => 'Overtime Rate Multiplier', 'value' => '1.5', 'type' => 'number', 'is_public' => false],
            ['key' => 'timezone', 'group' => 'regional', 'name' => 'Timezone', 'value' => 'Europe/London', 'type' => 'text', 'is_public' => true],
            ['key' => 'date_format', 'group' => 'regional', 'name' => 'Date Format', 'value' => 'd/m/Y', 'type' => 'text', 'is_public' => true],
        ];

        foreach ($settings as $data) {
            Setting::firstOrCreate(
                ['key' => $data['key']],
                $data
            );
        }

        $this->command->info('Settings seeded successfully.');
    }
}
