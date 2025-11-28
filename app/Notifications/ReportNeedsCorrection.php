<?php

namespace App\Notifications;

use App\Models\PatrolReport;

class ReportNeedsCorrection extends BaseReportNotification
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
        
        $this->subject = 'Your Patrol Report Needs Corrections';
        $this->message = 'Your patrol report "' . $report->title . '" requires some corrections before it can be approved. Please review the admin notes and submit the corrected report.';
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
            ->line('Admin Notes: ' . ($this->report->validation_notes ?? 'No additional notes provided.'))
            ->action('Update Report', route('patrol-reports.edit', $this->report->id));
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
            'admin_notes' => $this->report->validation_notes,
            'action_url' => route('patrol-reports.edit', $this->report->id),
            'action_text' => 'Update Report',
        ]);
    }
}
