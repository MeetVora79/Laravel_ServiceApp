<?php

namespace App\Console\Commands;

use App\Models\Allocation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;;
use Illuminate\Support\Facades\Log;

class ServiceCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cron';

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
        $allocations = Allocation::whereDate('ServiceDate', $tomorrow)->get();
        foreach ($allocations as $allocation) {
            if ($allocation->staff && $allocation->ticket) {
                $to_email = 'meetvora792@gmail.com';

                $data = [
                    'name' => $allocation->staff->StaffName,
                    'id' => $allocation->TicketId,
                    'subject' => $allocation->ticket->TicketSubject,
                    'description' => $allocation->ticket->TicketDescription,
                    'servicedate' => $allocation->ServiceDate,
                    'time' => $allocation->TimeSlot,
                    'instruction' => $allocation->Instruction,
                    'body' => "You have a service appointment scheduled for tomorrow and the following are the details of service appointment:"
                ];

                Mail::send('mailAllocation', $data, function ($message) use ($to_email) {
                    $message->from('serviceapp@support.com', 'Service App');
                    $message->to($to_email)->subject("Service Appointment Reminder!");
                });
            } else {
                Log::error("Allocation with ID {$allocation->AllocationId} is missing staff or ticket details.");
            }
        }
    }


}
