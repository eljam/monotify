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

use HipChat\HipChat;
use HipChat\HipChat_Exception;

/**
 * HipChatHandler.
 */
class HipchatHandler implements HandlerInterface
{
    /**
     * $hipchatClient
     * @var Hipchat
     */
    protected $hipchatClient;

    /**
     * $token
     * @var string
     */
    protected $token;

    /**
     * $roomId
     * @var string
     */
    protected $roomId;

    /**
     * $from
     * @var string
     */
    protected $from;

    /**
     * Contructor.
     * @param string $token
     * @param string $roomId
     * @param string $from
     */
    public function __construct($token, $roomId, $from = 'Monotify')
    {
        $this->hipchatClient = new HipChat($token);
        $this->roomId = $roomId;
        $this->from = $from;
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
            $this->hipchatClient->message_room(
                $this->roomId,
                $this->from,
                $notification->getMessage()
            );
        } catch (HipChat_Exception $e) {
            throw new MonotifyException($e);
        }
    }
}
