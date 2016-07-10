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

use Monotify\Notification\NotificationInterface;

/**
 * Interface for Handlers.
 */
interface HandlerInterface
{
    /**
     * canHandle Check if the handler can handle the notification.
     *
     * @param NotificationInterface $notification
     *
     * @return bool
     */
    public function canHandle(NotificationInterface $notification);

    /**
     * handle Process notification.
     *
     * @param NotificationInterface $notification
     *
     * @return bool true if the handler process the notification.
     *              false if the handler has not process the notification
     */
    public function handle(NotificationInterface $notification);
}
