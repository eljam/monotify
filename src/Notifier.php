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

namespace Monotify;

use Monotify\Handler\HandlerInterface;
use Monotify\Notification\NotificationInterface;

/**
 * Class that manage all notification.
 */
class Notifier
{
    /**
     * $name Notifier name.
     *
     * @var string
     */
    protected $name;

    /**
     * $handlers Stack of handlers.
     *
     * @var HandlerInterface[]
     */
    protected $handlers;

    /**
     * Constructor.
     *
     * @param string $name
     * @param string $handlers
     */
    public function __construct($name, array $handlers = [])
    {
        $this->name = $name;
        $this->handlers = $handlers;
    }

    /**
     * addHandler Add one handler.
     *
     * @param HandlerInterface $handler
     *
     * @return $this
     */
    public function addHandler(HandlerInterface $handler)
    {
        array_unshift($this->handlers, $handler);

        return $this;
    }

    /**
     * setHandlers Set multiple handler at once.
     *
     * @param array $handlers
     *
     * @return $this
     */
    public function setHandlers(array $handlers)
    {
        $this->handlers = [];
        foreach (array_reverse($handlers) as $handler) {
            $this->addHandler($handler);
        }

        return $this;
    }

    /**
     * @return HandlerInterface[]
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * notify.
     *
     * @param NotificationInterface $notification
     *
     * @return bool
     */
    public function notify(NotificationInterface $notification)
    {
        if (!$this->handlers) {
            throw new \RuntimeException('You need at least one handler');
        }

        $handlerKey = null;
        reset($this->handlers);
        while ($handler = current($this->handlers)) {
            if ($handler->canHandle($notification)) {
                $handlerKey = key($this->handlers);
                break;
            }
            next($this->handlers);
        }
        if (null === $handlerKey) {
            return false;
        }

        while ($handler = current($this->handlers)) {
            $handler->handle($notification);
            next($this->handlers);
        }

        return true;
    }
}
