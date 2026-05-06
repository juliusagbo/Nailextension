<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RefreshAnalyticsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:refresh {--keep-users : Keep existing users and only regenerate appointments}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh analytics data with new sample appointments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Refreshing Analytics Data...');
        $this->newLine();

        if ($this->option('keep-users')) {
            // Only regenerate appointments
            $this->warn('⚠️  This will delete all existing appointments but keep users and services.');
            
            if (!$this->confirm('Do you want to continue?', true)) {
                $this->info('Operation cancelled.');
                return 0;
            }

            $this->info('Deleting existing appointments...');
            \App\Models\Appointment::truncate();
            
            $this->info('Generating new appointments...');
            Artisan::call('db:seed', ['--class' => 'AppointmentSeeder']);
            
        } else {
            // Full refresh
            $this->warn('⚠️  This will DELETE ALL DATA and create fresh sample data.');
            $this->warn('    - All users (except admin)');
            $this->warn('    - All appointments');
            $this->warn('    - All services will be reset');
            $this->newLine();
            
            if (!$this->confirm('Do you want to continue?', false)) {
                $this->info('Operation cancelled.');
                return 0;
            }

            $this->info('Running fresh migrations and seeders...');
            Artisan::call('migrate:fresh', ['--seed' => true]);
        }

        $this->newLine();
        $this->info('✅ Analytics data refreshed successfully!');
        $this->newLine();
        
        $this->line('📊 <fg=cyan>Analytics Summary:</>');
        $this->line('   - Admin: admin@nailedbyvia.com / admin123');
        $this->line('   - Customers: 20 sample customers created');
        $this->line('   - Services: 5 different nail services');
        $this->line('   - Appointments: ~120-180 spanning 6 months');
        $this->newLine();
        
        $this->info('🚀 Access analytics at: http://localhost:8000/admin/reports');
        
        return 0;
    }
}

