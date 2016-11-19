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
use Monotify\Notification\NotificationInterface;
use lygav\slackbot\Exceptions\SlackBotException;
use lygav\slackbot\Exceptions\SlackRequestException;
use lygav\slackbot\SlackBot;

/**
 * SlackHandler.
 */
class SlackHandler implements HandlerInterface
{
    /**
     * $webhookUrl
     * @var string
     */
    protected $webhookUrl;

    /**
     * $roomId
     * @var string
     */
    protected $channel;

    /**
     * $from
     * @var string
     */
    protected $from;

    /**
     * Contructor.
     * @param string $webhookUrl
     * @param string $channel
     * @param string $from
     */
    public function __construct($webhookUrl, $channel, $from = 'Monotify')
    {
        $this->slackClient = new SlackBot($webhookUrl);
        $this->channel = $channel;
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
            $this->slackClient
                ->text($notification->getMessage())
                ->from($this->from)
                ->toChannel($this->channel)
                ->send()
            ;
        } catch (SlackRequestException $e) {
            throw new MonotifyException($e);
        } catch (SlackBotException $e) {
            throw new MonotifyException($e);
        }
    }
}
