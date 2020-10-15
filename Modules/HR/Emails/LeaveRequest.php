<?php

namespace Modules\HR\Emails;

use App\Models\AccountDetail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\HR\Entities\LeaveApplication;
use Modules\HR\Entities\LeaveCategory;
use Spatie\MediaLibrary\Models\Media;

class LeaveRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $user_id;
    public $leave_category;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $user_id, $leave_category)
    {
        $this->details = $details;
        $this->user_id = $user_id;
        $this->leave_category = $leave_category;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $account = AccountDetail::where('user_id', $this->user_id)->select('user_id', 'fullname')->first();
        // $account = LeaveCategory::where('user_id', $this->user_id)->first();
        $email = User::where('id', $account->user_id)->first()->email;
        $attachment = Media::where('model_type', 'Modules\HR\Entities\LeaveApplication')->where('model_id', $this->details->id)->first();
        // dd($attachment);
        dd(storage_path('app/public/'. $attachment->id . '/' . $attachment->file_name));
        // dd($this->details  );
        $name = $account->fullname;
        return $this->from($email, $name)
            ->subject('Pending Leave Request ')
            ->view('hr::admin.leaveApplications.leaveMail')
            ->attach(public_path('pdf/sample.pdf'), [
                'as' => 'sample.pdf',
                'mime' => 'application/pdf',
            ])
            ->with(['details' => $this->details, 'leave_category' => $this->leave_category]);
    }
}
