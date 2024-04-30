<?php

namespace App\Console;

use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule as Scheduler;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Notifications\ServiceReminderNotification;
use App\Models\Allocation;
use App\Models\Schedule as ServiceSchedule;
use App\Notifications\MaintenanceReminderNotification;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Scheduler $schedule)
    {
        $schedule->call(function () {
            Log::info("Starting to send notifications for service appointments.");
            $tomorrow = now()->addDay()->startOfDay();
            $allocations = Allocation::whereDate('ServiceDate', $tomorrow)->get();
            foreach ($allocations as $allocation) {
                $staff = \App\Models\Staff::find($allocation->AssignId);
                if ($staff) {
                    Log::info("Sending notification to staff: " . $staff->StaffName);
                    $staff->notify(new ServiceReminderNotification($allocation));
                } else {
                    Log::error("No staff found for allocation ID: " . $allocation->AllocationId);
                }
            }
        })->daily();

        $schedule->call(function () {
            Log::info("Starting to send notifications for service appointments.");
            $tomorrow = now()->addDay()->startOfDay();
            $schedules = ServiceSchedule::whereDate('ServiceDate', $tomorrow)->get();
            Log::info("Starting to send maintenance notifications ");
            foreach ($schedules as $serviceSchedule) {
                Log::info("Sending maintenance notification to staff");
                $serviceSchedule->staff->notify(new MaintenanceReminderNotification($serviceSchedule));
            }
        })->daily();
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
