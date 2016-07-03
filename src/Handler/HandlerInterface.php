<?php

namespace Monotify\Handler;

/**
 * Interface for Handlers
 */
interface HandlerInterface
{

    /**
     * canHandle Check if the handler can handle the notification
     * @param  NotificationInterface $notification
     * @return boolean
     */
    public function canHandle(NotificationInterface $notification);

    /**
     * handle Process notification
     * @param  NotificationInterface $notification
     * @return boolean true if the handler process the notification.
     *                 false if the handler has not process the notification
     */
    public function handle(NotificationInterface $notification);
}
