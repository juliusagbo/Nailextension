<?php

namespace App\Console\Commands;

use App\Models\Settings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ShowSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:show {--raw : Show raw database values}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display all current settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('raw')) {
            $this->showRawSettings();
        } else {
            $this->showFormattedSettings();
        }
        
        return Command::SUCCESS;
    }
    
    /**
     * Show formatted settings using the model
     */
    protected function showFormattedSettings()
    {
        $this->info('=== Current Settings ===');
        $this->newLine();
        
        // Business Information
        $this->line('<fg=cyan>Business Information:</>');
        $businessInfo = Settings::getBusinessInfo();
        $this->table(
            ['Setting', 'Value'],
            [
                ['Business Name', $businessInfo['business_name']],
                ['Contact Email', $businessInfo['contact_email']],
                ['Phone Number', $businessInfo['phone_number']],
                ['Business Address', $businessInfo['business_address']],
            ]
        );
        
        // Business Hours
        $this->newLine();
        $this->line('<fg=cyan>Business Hours:</>');
        $businessHours = Settings::getBusinessHours();
        $hoursData = [];
        foreach ($businessHours as $day => $hours) {
            $status = $hours['closed'] ? '<fg=red>Closed</>' : '<fg=green>' . $hours['open'] . ' - ' . $hours['close'] . '</>';
            $hoursData[] = [ucfirst($day), $status];
        }
        $this->table(['Day', 'Hours'], $hoursData);
        
        // Security Settings
        $this->newLine();
        $this->line('<fg=cyan>Security Settings:</>');
        $securitySettings = Settings::getSecuritySettings();
        $this->table(
            ['Setting', 'Value'],
            [
                ['Two-Factor Authentication', $securitySettings['two_factor_enabled'] ? '<fg=green>Enabled</>' : '<fg=red>Disabled</>'],
                ['Password Minimum Length', $securitySettings['password_min_length'] . ' characters'],
                ['Session Timeout', $securitySettings['session_timeout'] . ' minutes'],
            ]
        );
    }
    
    /**
     * Show raw database values
     */
    protected function showRawSettings()
    {
        $this->info('=== Raw Database Settings ===');
        $this->newLine();
        
        $settings = DB::table('settings')->get();
        $data = [];
        
        foreach ($settings as $setting) {
            $value = $setting->value;
            if (strlen($value) > 50) {
                $value = substr($value, 0, 50) . '...';
            }
            $data[] = [
                $setting->id,
                $setting->key,
                $value,
                $setting->type,
            ];
        }
        
        $this->table(
            ['ID', 'Key', 'Value', 'Type'],
            $data
        );
    }
}
