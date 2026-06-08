<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentConfirmationNotification extends Notification
{
    use Queueable;

    public function __construct(public Payment $payment)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $payment = $this->payment;
        $registration = $payment->registration;

        return (new MailMessage)
            ->subject('Payment Confirmed — '.$registration->event->title)
            ->greeting('Hello '.$registration->full_name.',')
            ->line('Your M-Pesa payment of KES '.number_format($payment->amount, 2).' has been confirmed.')
            ->line('M-Pesa Receipt: '.$payment->receipt_number)
            ->line('Registration Number: '.$registration->registration_number)
            ->line('Your ticket has been issued. Present the QR code at the event gate.')
            ->action('View Ticket', route('tickets.verify', $registration->registration_number));
    }
}
