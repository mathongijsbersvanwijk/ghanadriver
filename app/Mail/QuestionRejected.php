<?php
namespace App\Mail;

use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuestionRejected extends Mailable
{
    use Queueable, SerializesModels;
    public $question;
    public $reason;
    public $asked;
    public $pathToPhoto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Question $question, $reason, $asked, $pathToPhoto) {
        $this->question = $question;
        $this->reason = $reason;
        $this->asked = $asked;
        $this->pathToPhoto = $pathToPhoto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('content.questions.mailrejected')->with(
            ['queid' => $this->question->que_id, 'asked' => $this->asked, 'reason' => $this->reason, 'pathToPhoto' => $this->pathToPhoto
            ]);
    }
}
