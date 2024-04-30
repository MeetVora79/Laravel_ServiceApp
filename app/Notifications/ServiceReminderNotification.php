<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $allocation;

    /**
     * Create a new notification instance.
     */
    public function __construct($allocation)
    {
        $this->allocation = $allocation;
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
            ->subject('Service Appointment Reminder!')
            ->from('serviceapp@support.com', 'Service App')
            ->greeting('Hello, ' . $notifiable->StaffName . '!')
            ->line('You have a service appointment scheduled for tomorrow.')
            ->line('The following are the details of service appointment:')
            ->line('Ticket ID: ' . $this->allocation->TicketId)
            ->line('Ticket Issuer: ' . $this->allocation->ticket->customer->firstname.' '.$this->allocation->ticket->customer->lastname)
            ->line('Ticket Subject: ' . $this->allocation->ticket->TicketSubject)
            ->line('Asset Name: ' . $this->allocation->ticket->asset->AssetName)
            ->line('Service Date: ' . $this->allocation->ServiceDate)
            ->line('Time: ' . $this->allocation->TimeSlot)
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
