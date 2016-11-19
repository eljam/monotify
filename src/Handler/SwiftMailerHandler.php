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
    protected $mailer;

    /**
     * Constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * {@inheritdoc}
     */
    public function canHandle(NotificationInterface $notification)
    {
        return $notification instanceof EmailNotificationInterface;
    }

    /**
     * {@inheritdoc}
     * @throws MonotifyException
     */
    public function handle(NotificationInterface $notification)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($notification->getSubject())
            ->setFrom($notification->getFrom())
            ->setTo($notification->getRecipientAddresses())
            ->setBody($notification->getMessage());

        try {
            $this->mailer->send($message);
        } catch (\Swift_TransportException $e) {
            throw new MonotifyException($e);
        }
    }
}
