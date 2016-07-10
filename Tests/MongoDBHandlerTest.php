<?php

namespace Monotify\Tests;

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Monotify\Handler\MongoDBHandler;
use Monotify\Notification\Notification;

class MongoDBHandlerTest  extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorShouldThrowExceptionForInvalidMongo()
    {
        new MongoDBHandler(new \stdClass(), 'DB', 'Collection');
    }

    public function testHandle()
    {
        $mongo = $this->getMock('Mongo', array('selectCollection'), array(), '', false);
        $collection = $this->getMock('stdClass', array('save'));
        $mongo->expects($this->once())
            ->method('selectCollection')
            ->with('DB', 'Collection')
            ->will($this->returnValue($collection));

        $notification = (new Notification('my message'));

        $collection->expects($this->once())
            ->method('save')
            ->with($notification->getMessage());

        $handler = new MongoDBHandler($mongo, 'DB', 'Collection');
        $handler->handle($notification);
    }
}
if (!class_exists('Mongo')) {
    class Mongo
    {
        public function selectCollection()
        {
        }
    }
}
