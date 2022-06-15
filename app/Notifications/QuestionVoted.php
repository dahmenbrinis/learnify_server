<?php

namespace App\Notifications;

use App\Models\Question;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidMessagePriority;
class QuestionVoted extends Notification
{
    use Queueable;
    private User $user;
    private Question $question;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Question $question )
    {
        $this->question = $question;
        $this->user = $this->question->user;
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
            'title'=>$this->user->name,
            'body'=>$this->question->description,
            'type' =>self::class
        ];
    }
}
