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

use Elastica\Client;
use Elastica\Exception\ExceptionInterface;

/**
 * Thx to monolog for this class.
 *
 * @see https://github.com/Seldaek/monolog/blob/1.20.0/src/Monolog/Handler/ElasticSearchHandler.php
 */
class ElasticSearchHandler implements HandlerInterface
{
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var array Handler config options
     */
    protected $options = [];

    /**
     * Constructor.
     *
     * @param Client $client  Elastica Client object
     * @param array  $options Handler configuration
     */
    public function __construct(Client $client, array $options = [])
    {
        parent::__construct($level, $bubble);
        $this->client = $client;
        $this->options = array_merge(
            [
                'index' => 'notification',      // Elastic index name
                'type' => 'notification',       // Elastic document type
                'ignore_error' => false,          // Suppress Elastica exceptions
            ],
            $options
        );
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
        try {
            $this->client->addDocuments($this->getDocument($notification));
        } catch (ExceptionInterface $e) {
            if (!$this->options['ignore_error']) {
                throw new \RuntimeException('Error sending messages to Elasticsearch', 0, $e);
            }
        }
    }

    protected function getDocument(NotificationInterface $notification)
    {
        $document = new Document();
        $document->setData($notification->getMessage());
        $document->setType($this->options['type']);
        $document->setIndex($this->options['index']);

        return $document;
    }
}
