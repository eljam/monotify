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
 * @see https://github.com/Seldaek/monolog/blob/1.20.0/src/Monolog/Handler/MongoDBHandler.php
 */
class MongoDBHandler implements HandlerInterface
{
    protected $mongoCollection;

    /**
     * Constructor.
     *
     * @param \MongoClient|\Mongo|\MongoDB\Client $mongo
     * @param string                              $database
     * @param string|\MongoDB\Collection          $collection
     */
    public function __construct($mongo, $database, $collection)
    {
        if (!($mongo instanceof \MongoClient || $mongo instanceof \Mongo || $mongo instanceof \MongoDB\Client)) {
            throw new \InvalidArgumentException('MongoClient, Mongo or MongoDB\Client instance required');
        }
        $this->mongoCollection = $mongo->selectCollection($database, $collection);
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
        if ($this->mongoCollection instanceof \MongoDB\Collection) {
            $this->mongoCollection->insertOne($notification->getMessage());
        } else {
            $this->mongoCollection->save($notification->getMessage());
        }
    }
}
