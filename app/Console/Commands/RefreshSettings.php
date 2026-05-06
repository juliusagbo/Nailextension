<?php

namespace App\Console\Commands;

use App\Models\Settings;
use Illuminate\Console\Command;

class RefreshSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh settings cache and reload from database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Refreshing settings cache...');
        
        // Clear the settings cache
        Settings::clearCache();
        
        $this->info('✓ Cache cleared');
        
        // Pre-load settings to warm up cache
        $businessInfo = Settings::getBusinessInfo();
        $businessHours = Settings::getBusinessHours();
        $securitySettings = Settings::getSecuritySettings();
        
        $this->info('✓ Settings cache warmed up');
        
        // Display current settings
        $this->newLine();
        $this->line('Current Settings:');
        $this->table(
            ['Setting', 'Value'],
            [
                ['Business Name', $businessInfo['business_name']],
                ['Contact Email', $businessInfo['contact_email']],
                ['Phone Number', $businessInfo['phone_number']],
                ['Session Timeout', $securitySettings['session_timeout'] . ' minutes'],
            ]
        );
        
        $this->newLine();
        $this->info('Business Hours:');
        foreach ($businessHours as $day => $hours) {
            $status = $hours['closed'] ? 'Closed' : $hours['open'] . ' - ' . $hours['close'];
            $this->line('  ' . ucfirst($day) . ': ' . $status);
        }
        
        $this->newLine();
        $this->info('Settings refreshed successfully!');
        
        return Command::SUCCESS;
    }
}
