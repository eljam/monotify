<?php

namespace Monotify;

/**
 * Class that manage all notification
 */
class Notifier
{

    /**
     * $name Notifier name
     * @var string
     */
    protected $name;

    /**
     * $handlers Stack of handlers
     * @var HandlerInterface[]
     */
    protected $handlers;

    /**
     * Constructor
     * @param string $name
     * @param string $handlers
     */
    public function __construct($name, array $handlers = [])
    {
        $this->name = $name;
        $this->handlers = $handlers;
    }

    /**
     * addHandler Add one handler
     * @param HandlerInterface $handler
     * @return $this
     */
    public function addHandler(HandlerInterface $handler)
    {
        array_unshift($this->handler, $handler);

        return $this;
    }

    /**
     * setHandlers Set multiple handler at once
     * @param array $handlers
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
}
