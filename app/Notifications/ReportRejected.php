<?php

namespace App\Notifications;

use App\Models\PatrolReport;

class ReportRejected extends BaseReportNotification
{
    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\PatrolReport  $report
     * @return void
     */
    public function __construct(PatrolReport $report)
    {
        parent::__construct($report);
        
        $this->subject = 'Your Patrol Report Has Been Rejected';
        $this->message = 'We regret to inform you that your patrol report "' . $report->title . '" has been rejected. Please see the admin notes for more information.';
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return parent::toMail($notifiable)
            ->line('Reason for Rejection: ' . ($this->report->validation_notes ?? 'No reason provided.'))
            ->line('If you believe this was done in error, please contact the admin team.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return array_merge(parent::toArray($notifiable), [
            'reason' => $this->report->validation_notes,
            'contact_support' => true,
        ]);
    }
}
