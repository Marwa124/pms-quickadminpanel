<?php

namespace Modules\HR\Emails;

use App\Models\AccountDetail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\HR\Entities\LeaveApplication;

class LeaveRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $user_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->details = $data['details'];
        $this->user_id = $data['user_id'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $account = AccountDetail::where('user_id', $this->user_id)->select('user_id', 'fullname')->first();
        // $sender = LeaveApplication::where('user_id', $account->user_id)->latest()->first();
        $email = User::where('id', $account->user_id)->first()->email;
        // dd($email  );
        $name = $account->fullname;
        return $this->from($email, $name)
            ->subject('Pending Questions From ')
            ->view('hr::admin.leaveApplications.leaveMail')
            ->with(['details' => $this->details]);
        // return $this->markdown('hr::admin.leaveApplications.leaveMail')
        //             ->with(['details' => $this->details]);
    }
}
