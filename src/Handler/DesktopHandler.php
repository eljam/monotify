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
use Symfony\Component\Process\Process;

class DesktopHandler implements HandlerInterface
{
    /**
     * $title Notification title.
     *
     * @var string
     */
    private $title;

    /**
     * Constructor.
     *
     * @param string $title
     */
    public function __construct($title = 'Notification')
    {
        $this->title = $title;
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
     */
    public function handle(NotificationInterface $notification)
    {
        if ($this->isMacOs()) {
            $this->notifyGrowl($notification);
        }

        if ($this->isLinux() && !$this->isMacOs()) {
            $this->notifySend($notification);
        }
    }

    private function notifyGrowl(NotificationInterface $notification)
    {
        $process = new Process(sprintf('growlnotify --title "%s" --message "%s"', $this->title, $notification->getMessage()));
        $process->setTimeout(2);
        $process->run();
    }

    private function notifySend(NotificationInterface $notification)
    {
        $process = new Process(sprintf('notify-send "%s" "%s"', $this->title, $notification->getMessage()));
        $process->setTimeout(2);
        $process->run();
    }

    private function isLinux()
    {
        return DIRECTORY_SEPARATOR == '/';
    }

    private function isMacOs()
    {
        return false !== strpos(php_uname('s'), 'Darwin');
    }
}
