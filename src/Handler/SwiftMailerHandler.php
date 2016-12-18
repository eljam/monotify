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

namespace Monotify\Handler;

use Monotify\Exceptions\MonotifyException;
use Monotify\Notification\EmailNotificationInterface;
use Monotify\Notification\NotificationInterface;

class SwiftMailerHandler implements HandlerInterface
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var array
     */
    protected $recipientAddresses;

    /**
     * SwiftMailerHandler constructor.
     * @param \Swift_Mailer $mailer
     * @param $subject
     * @param array $from
     * @param array $recipientAddresses
     */
    public function __construct(\Swift_Mailer $mailer, $subject, array $from, array $recipientAddresses)
    {
        $this->mailer = $mailer;
        $this->subject = $subject;
        $this->from = $from;
        $this->recipientAddresses = $recipientAddresses;
    }

    /**
     * {@inheritdoc}
     */
    public function canHandle(NotificationInterface $notification)
    {
        return $notification instanceof NotificationInterface;
    }

    /**
     * {@inheritdoc}
     * @throws MonotifyException
     */
    public function handle(NotificationInterface $notification)
    {
        try {
            $message = \Swift_Message::newInstance()
                ->setSubject($this->subject)
                ->setFrom($this->from)
                ->setTo($this->recipientAddresses)
                ->setBody($notification->getMessage());

            $this->mailer->send($message);
        } catch (\Swift_SwiftException $e) {
            throw new MonotifyException($e);
        }
    }
}
