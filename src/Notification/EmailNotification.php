<?php

/*
 * This file is part of the monotify package
 *
 * Copyright (c) 2016 Guillaume Cavana
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Guillaume Cavana <guillaume.cavana@gmail.com>
 */

namespace Monotify\Notification;

class EmailNotification implements EmailNotificationInterface
{
    protected $message;
    protected $subject;
    protected $from;
    protected $recipientAddresses;

    /**
     * Constructor.
     *
     * @param string $message
     * @param string $from
     * @param string $subject
     * @param array  $recipientAddresses
     */
    public function __construct($message, $from, $subject, array $recipientAddresses)
    {
        $this->message = $message;
        $this->from = $from;
        $this->subject = $subject;
        $this->recipientAddresses = $recipientAddresses;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecipientAddresses()
    {
        return $this->recipientAddresses;
    }

    /**
     * {@inheritdoc}
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }
}
