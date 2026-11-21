<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VaccinationReminderNotification extends Notification
{
    use Queueable;

    public string $childName;
    public string $vaccineName;
    public string $dueDate;
    public string $hospitalName;

    public function __construct(string $childName, string $vaccineName, string $dueDate, string $hospitalName)
    {
        $this->childName = $childName;
        $this->vaccineName = $vaccineName;
        $this->dueDate = $dueDate;
        $this->hospitalName = $hospitalName;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("VacciCare Alert: Vaccination Due for {$this->childName}")
            ->greeting("Hello,")
            ->line("This is an automated reminder from the VacciCare Immunization Network.")
            ->line("Your child, **{$this->childName}**, has an upcoming vaccination scheduled:")
            ->line("**Vaccine:** {$this->vaccineName}")
            ->line("**Scheduled Date:** {$this->dueDate}")
            ->line("**Facility:** {$this->hospitalName}")
            ->action('View Vaccination Schedule', url('/parent/vaccination-schedule'))
            ->line('Please ensure your child receives their dose on time for uninterrupted disease protection.');
    }
}
