<?php

namespace Monotify\Notification;

interface NotificationInterface
{
    public function getMessage();

    public function getType();
}
