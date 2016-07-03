<?php

namespace Monotify\Notification;

use Monotify\Notification\NotificationInterface;
use Monotify\Notification\Type;

class EmailNotification implements NotificationInterface
{
    protected $message;
    protected $subject;
    protected $from;
    protected $recipientAddresses;

    public function __construct($message, $from, $subject, array $recipientAddresses)
    {
        $this->message = $message;
        $this->from = $from;
        $this->subject = $subject;
        $this->recipientAddresses = $recipientAddresses;
    }

    /**
     * getRecipientAddresses
     * @return array All recipient email addresses
     */
    public function getRecipientAddresses()
    {
        return $this->recipientAddresses;
    }

    /**
     * getFrom
     * @return string From address
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * getSubject
     * @return string Email subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    public function getType()
    {
        return Type::EMAIL;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
