<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class verificationNotification extends Notification
{
    use Queueable;
    private $data;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
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
        return ['database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
             'user_id'=>$this->Data['user_id'],
             'message' => $this->Data['message'],
             'store_id' => $this->Data['store_id'],
             'type'=> $this->data['type'],
             'object_id'=> $this->data['object_id']
         ];
     } 
    public function toDatabase($notifiable)
    {
        return [
     
            'user_id'=>$this->data['user_id'],
            'message' => $this->data['message'],
            'store_id' => $this->data['store_id'],
            'type'=> $this->data['type'],
            'object_id'=> $this->data['object_id']
         
        ];
    }
}
