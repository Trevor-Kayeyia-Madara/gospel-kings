<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegistrationConfirmationNotification extends Notification
{
    use Queueable;

    public function __construct(public Registration $registration)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $registration = $this->registration;
        $qrUrl = route('tickets.qr', $registration->ticket->ticket_number);

        return (new MailMessage)
            ->subject('Registration Confirmed — '.$registration->event->title)
            ->greeting('Hello '.$registration->full_name.',')
            ->line('Your registration for '.$registration->event->title.' has been captured successfully.')
            ->line('Registration Number: '.$registration->registration_number)
            ->line('Ticket Number: '.$registration->ticket->ticket_number)
            ->line('Bring this QR code to the event. It will be scanned at the gate for confirmation and check-in.')
            ->action('View / Verify Ticket', route('tickets.verify', $registration->registration_number))
            ->line('Thank you for registering.');
    }
}
