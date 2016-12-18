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

namespace Monotify\Tests;

use Monotify\Handler\SwiftMailerHandler;
use Monotify\Notification\Notification;
use Monotify\Notifier;

class NotifierTest extends \PHPUnit_Framework_TestCase
{
    public function testAddingHandlers()
    {
        $transport = \Swift_NullTransport::newInstance();
        $swiftMailer = \Swift_Mailer::newInstance($transport);

        $notifier = new Notifier('mail-notifier');
        $notifier->addHandler((new SwiftMailerHandler($swiftMailer, 'Subject', ['from@mail.org' => 'From'], ['to@mail.org' => 'Email'])));

        $this->assertCount(1, $notifier->getHandlers());
    }

    public function testNotify()
    {
        $transport = \Swift_NullTransport::newInstance();
        $swiftMailer = \Swift_Mailer::newInstance($transport);

        $notifier = new Notifier('mail-notifier');
        $notifier->addHandler((new SwiftMailerHandler($swiftMailer, 'Subject', ['from@mail.org' => 'From'], ['to@mail.org' => 'Email'])));

        $this->assertTrue($notifier->notify($this->createNotification()));
    }

    public function testNotifyException()
    {
        $transport = \Swift_NullTransport::newInstance();
        $swiftMailer = \Swift_Mailer::newInstance($transport);

        $notificationMock = $this->prophesize('Monotify\Notification\Notification');
        $notificationMock->willBeConstructedWith(['message']);

        $notifier = new Notifier('mail-notifier');
        $this->setExpectedException('\Monotify\Exceptions\MonotifyException');

        $notifier->notify($notificationMock->reveal());
    }

    private function createNotification()
    {
        return new Notification('message');
    }
}
