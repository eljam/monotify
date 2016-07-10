<?php

namespace Monotify\Tests;

use Monotify\Handler\SwiftMailerHandler;
use Monotify\Notification\EmailNotification;
use Monotify\Notifier;

class NotifierTest extends \PHPUnit_Framework_TestCase
{
    public function testAddingHandlers()
    {
        $transport = \Swift_NullTransport::newInstance();
        $swiftMailer = \Swift_Mailer::newInstance($transport);

        $notifier = new Notifier('mail-notifier');
        $notifier->addHandler((new SwiftMailerHandler($swiftMailer)));

        $this->assertCount(1, $notifier->getHandlers());
    }

    public function testNotify()
    {
        $transport = \Swift_NullTransport::newInstance();
        $swiftMailer = \Swift_Mailer::newInstance($transport);

        $notifier = new Notifier('mail-notifier');
        $notifier->addHandler((new SwiftMailerHandler($swiftMailer)));

        $this->assertTrue($notifier->notify($this->createEmailNotification()));
    }

    public function testNotifyException()
    {
        $transport = \Swift_NullTransport::newInstance();
        $swiftMailer = \Swift_Mailer::newInstance($transport);

        $notificationMock = $this->prophesize('Monotify\Notification\EmailNotification');
        $notificationMock->willBeConstructedWith(['message', ['From' => 'from@mail.org'], 'subject', ['Email' => 'to@mail.org']]);

        return $notificationMock;

        $notifier = new Notifier('mail-notifier');
        $this->setExpectedException('RuntimeException');

        $notifier->notify($notificationMock->reveal());
    }

    private function createEmailNotification()
    {
        return new EmailNotification('message', ['from@mail.org' => 'From'], 'subject', ['to@mail.org' => 'To']);
    }
}
