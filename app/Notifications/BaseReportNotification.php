<?php

namespace App\Notifications;

use App\Models\PatrolReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

abstract class BaseReportNotification extends Notification
{
    use Queueable;

    /**
     * The patrol report instance.
     *
     * @var \App\Models\PatrolReport
     */
    public $report;

    /**
     * The notification subject.
     *
     * @var string
     */
    protected $subject;

    /**
     * The notification message.
     *
     * @var string
     */
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\PatrolReport  $report
     * @return void
     */
    public function __construct(PatrolReport $report)
    {
        $this->report = $report;
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
            ->subject($this->subject)
            ->line($this->message)
            ->line('Report ID: ' . $this->report->id)
            ->line('Title: ' . $this->report->title)
            ->line('Status: ' . ucfirst(str_replace('_', ' ', $this->report->validation_status)))
            ->action('View Report', route('patrol-reports.show', $this->report->id))
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
            'report_id' => $this->report->id,
            'title' => $this->report->title,
            'status' => $this->report->validation_status,
            'message' => $this->message,
            'url' => route('patrol-reports.show', $this->report->id),
        ];
    }
}
