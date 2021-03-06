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

/**
 * Notifcation object.
 */
class Notification implements NotificationInterface
{
    protected $message;

    /**
     * Constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * getMessage.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
