<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MaintenanceServiceCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = now()->addDay()->startOfDay();
        $schedules = Schedule::whereDate('ServiceDate', $tomorrow)->get();
        foreach ($schedules as $schedule) {
            if ($schedule->staff) {
                $to_email = 'meetvora792@gmail.com';

				$data = [
					'name' => $schedule->staff->StaffName,
					'id' => $schedule->AssetId,
					'assetname' => $schedule->asset->AssetName,
					'description' => $schedule->asset->AssetDescription,
					'location' => $schedule->asset->AssetLocation,
					'servicedate' => $schedule->ServiceDate,
					'instruction' => $schedule->Instruction,
					'body' => "You have a maintenance service scheduled for tomorrow and the following are the details of maintenance service:"
				];
		
				Mail::send('mailMaintenance', $data, function ($message) use ($to_email) {
					$message->from('serviceapp@support.com', 'Service App');
					$message->to($to_email)->subject("Maintenance Service Reminder!");
				});
            } else {
                Log::error("Maintenance Schedule with ID {$schedule->ScheduleId} is missing staff or ticket details.");
            }
        }
    }


}
