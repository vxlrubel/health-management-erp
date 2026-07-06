<?php

namespace Database\Seeders;

use App\Models\SystemConfiguration;
use Illuminate\Database\Seeder;

class SystemConfigurationSeeder extends Seeder
{
    public function run(): void
    {
        $configs = [
            ['key' => 'app_maintenance_mode', 'value' => 'false', 'description' => 'Put the application in maintenance mode', 'type' => 'boolean', 'group' => 'system'],
            ['key' => 'max_upload_size', 'value' => '10240', 'description' => 'Maximum file upload size in KB', 'type' => 'number', 'group' => 'system'],
            ['key' => 'allowed_file_types', 'value' => 'pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'description' => 'Comma-separated list of allowed file extensions', 'type' => 'text', 'group' => 'system'],
            ['key' => 'session_lifetime', 'value' => '120', 'description' => 'Session lifetime in minutes', 'type' => 'number', 'group' => 'security'],
            ['key' => 'max_login_attempts', 'value' => '5', 'description' => 'Maximum login attempts before lockout', 'type' => 'number', 'group' => 'security'],
            ['key' => 'password_expiry_days', 'value' => '90', 'description' => 'Password expiry in days', 'type' => 'number', 'group' => 'security'],
            ['key' => 'enable_audit_log', 'value' => 'true', 'description' => 'Enable audit logging for all modules', 'type' => 'boolean', 'group' => 'audit'],
            ['key' => 'retain_activity_log_days', 'value' => '365', 'description' => 'Number of days to retain activity logs', 'type' => 'number', 'group' => 'audit'],
            ['key' => 'pagination_per_page', 'value' => '15', 'description' => 'Default pagination per page', 'type' => 'number', 'group' => 'system'],
            ['key' => 'enable_notifications', 'value' => 'true', 'description' => 'Enable push/email notifications', 'type' => 'boolean', 'group' => 'notifications'],
        ];

        foreach ($configs as $data) {
            SystemConfiguration::firstOrCreate(
                ['key' => $data['key']],
                $data
            );
        }

        $this->command->info('System configurations seeded successfully.');
    }
}
