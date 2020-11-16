<?php
namespace App\Mail;

use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuestionUploaded extends Mailable
{
    use Queueable, SerializesModels;
    public $question;
    public $action;
    public $asked;
    public $pathToPhoto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Question $question, $action, $asked, $pathToPhoto) {
        $this->question = $question;
        $this->action = $action;
        $this->asked = $asked;
        $this->pathToPhoto = $pathToPhoto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('content.admin.mailuploaded')->with(
            ['queid' => $this->question->que_id,'asked' => $this->asked,'action' => $this->action, 'pathToPhoto' => $this->pathToPhoto
            ]);
    }
}
