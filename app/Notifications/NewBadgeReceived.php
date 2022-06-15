<?php

namespace App\Notifications;

use App\Models\Room;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use \NotificationChannels\Fcm\Resources;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidMessagePriority;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class NewBadgeReceived extends Notification
{
    use Queueable;
    private String $badge;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(String $badge)
    {
        $this->badge = $badge;
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
//            'mail' ,
            'database',
            FcmChannel::class
        ];
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
     * @return FcmMessage
     */
    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setAndroid(
                AndroidConfig::create()
                    ->setPriority(AndroidMessagePriority::HIGH())
                    ->setData($this->toArray($notifiable))
            );
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
//    public function toDatabase($notifiable)
//    {
//        return $this->toArray($notifiable);
//    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title'=>'you have got a new badge',
            'body'=>$this->badge,
            'type' =>self::class
        ];
    }
}
