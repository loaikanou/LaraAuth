<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SignupActivate extends Notification // implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
//        $this->toDatabase($notifiable);
        $this->data = $data;
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
        $url = url('/api/auth/signup/activate/'.$this->data->activation_token);

        return (new MailMessage)
//            ->error()
            ->subject('Confirm your account')
            ->greeting('Confirm your account!')
            ->line('Thanks for signup! Please before you begin, you must confirm your account.')
            ->action('Confirm Account', url($url))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast()
    {
        return new BroadcastMessage([
            'id' => $this->data->id,
            'email' => $this->data->email,
            'active' => $this->data->active,
            'activation_token' => $this->data->activation_token
        ]);
    }

    public function toDatabase()
    {
        return new DatabaseMessage([
            'id' => $this->data->id,
            'email' => $this->data->email,
            'active' => $this->data->active,
            'activation_token' => $this->data->activation_token
        ]);
    }
}
