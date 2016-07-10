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
 * Thx to monolog for this class.
 *
 * @see https://github.com/Seldaek/monolog/blob/1.20.0/src/Monolog/Handler/RedisHandler.php
 */
class RedisHandler implements HandlerInterface
{
    private $redisClient;
    private $redisKey;
    protected $capSize;

    /**
     * @param \Predis\Client|\Redis $redis   The redis instance
     * @param string                $key     The key name to push records to
     * @param int                   $capSize Number of entries to limit list size to
     */
    public function __construct($redis, $key, $capSize = false)
    {
        if (!(($redis instanceof \Predis\Client) || ($redis instanceof \Redis))) {
            throw new \InvalidArgumentException('Predis\Client or Redis instance required');
        }
        $this->redisClient = $redis;
        $this->redisKey = $key;
        $this->capSize = $capSize;
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
        $this->redisClient->rpush($this->redisKey, $notification->getMessage());
    }
}
