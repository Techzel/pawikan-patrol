<?php

namespace App\Notifications;

use App\Models\PatrolReport;

class ReportValidated extends BaseReportNotification
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
        
        $this->subject = 'Your Patrol Report Has Been Validated';
        $this->message = 'Your patrol report "' . $report->title . '" has been validated and approved. Thank you for your contribution to our conservation efforts.';
    }
}
