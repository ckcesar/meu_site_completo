<?php

namespace Application\Validator\Mail;

class Email
{
    private $from;
    private $to;
    private $subject;
    private $message;
    private $headers;

    public function __construct($email, $name)
    {
        $this->to[$name] = $email;
    }

    public function send()
    {
        $this->setHeaders();
        $this->makeMessage();
        return mail($this->to[0], $this->subject, $this->message, $this->headers);
    }

    /**
     * @return array
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $email
     * @param string $name
     */
    public function setFrom($email, $name)
    {
        $this->from[$name] = $email;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return void
     */
    private function setHeaders()
    {
        $headers  = "MIME-Version: 1.1\n";
        $headers .= "Content-Type: text/html; charset=utf-8\n";

        $name = key($this->from);
        $headers .= "From: \"{$name}\" <{$this->from[$name]}>\n";

        $name = key($this->to);
        $headers .= "To: \"{$name}\" <{$this->to[$name]}>\n";
        $this->headers = $headers;
    }

    /**
     * @return void
     */
    private function makeMessage()
    {
        ob_start();
        include __DIR__ . "/layout/email.phtml";
        $content = ob_get_contents();
        ob_end_clean();
        $this->message = $content;
    }
} 