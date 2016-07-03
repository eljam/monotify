<?php

namespace Monotify\Notification;

/**
 * Notifcation object
 */
class Notification implements NotificationInterface
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message
    }

    public function getMessage()
    {
        return $this->message;
    }
}
