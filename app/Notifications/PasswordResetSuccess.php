<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetSuccess extends Notification implements ShouldQueue
{
    use Queueable;

//    protected $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notifiable)
    {
//        $this->data = $notifiable;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You are changed your password succeful.')
            ->line('If you did change password, no further action is required.')
            ->line('If you did not change password, protect your account.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->data->id,
            'email' => $this->data->email,
            'token' => $this->data->token,
            'date' => Carbon::now()
        ];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return DatabaseMessage
     */
    public function toDatabase()
    {
//        return new DatabaseMessage([
//            'id' => $this->data = $notifiable;->id,
//            'email' => $this->data = $notifiable;->email,
//            'token' => $this->data = $notifiable;->token,
//            'date' => Carbon::now()
//        ]);
        return new DatabaseMessage([
            'message' => 'Password Reset Successful'
        ]);
    }
}
