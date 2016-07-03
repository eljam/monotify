<?php

namespace Monotify\Handler;

use Monotify\Notification\NotificationInterface;

class SwiftMailerHandler implements HandlerInterface
{
    protected $mailer;

    /**
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
        return $notification->getType() === Type::EMAIL;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(NotificationInterface $notification)
    {
        $this->mailer->send($notification->getMessage());
    }
}
