<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MaintenanceReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $serviceSchedule;

    /**
     * Create a new notification instance.
     */
    public function __construct($serviceSchedule)
    {
        $this->serviceSchedule = $serviceSchedule;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Maintenance Service Reminder!')
            ->from('serviceapp@support.com', 'Service App')
            ->greeting('Hello, ' . $notifiable->StaffName . '!')
            ->line('You have a maintenance service scheduled for tomorrow.')
            ->line('The following are the details of maintenance service:')
            ->line('Asset ID: ' . $this->serviceSchedule->AssetId)
            ->line('Asset Name: ' . $this->serviceSchedule->asset->AssetName)
            ->line('Customer Name: ' . $this->serviceSchedule->asset->customer->firstname.' '.$this->serviceSchedule->asset->customer->lastname)
            ->line('Service Date: ' . $this->serviceSchedule->ServiceDate)
            ->line('Thank You!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
