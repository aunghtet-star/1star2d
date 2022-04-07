<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddAndWithdraw extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $transaction_id;
    protected $sourceable_id;
    protected $sourceable_type;
    
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $message, $transaction_id,$sourceable_id, $sourceable_type)
    {
        $this->title = $title;
        $this->message = $message;
        $this->transaction_id = $transaction_id;
        $this->sourceable_id = $sourceable_id;
        $this->sourceable_type = $sourceable_type;
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
    

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'trx_id' => $this->transaction_id,
            'sourceable_id' => $this->sourceable_id ,
            'sourceable_type' => $this->sourceable_type
        ];
    }
}
