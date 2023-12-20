<?php

class PHP_Email_Form
{
    public $ajax = false;

    public $to;
    public $from_name;
    public $from_email;
    public $subject;
    public $message;

    public function add_message($content, $label)
    {
        $this->message .= "<p><strong>{$label}:</strong> {$content}</p>";
    }

    public function send()
    {
        $headers = "From: {$this->from_name} <{$this->from_email}>\r\n";
        $headers .= "Reply-To: {$this->from_email}\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($this->to, $this->subject, $this->message, $headers);

        return 'OK';
    }
}

?>
