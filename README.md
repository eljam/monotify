# monotify
Send notification to files, email, databases, various alert services

```php
<?php

use Monotify\Handler\SlackHandler;
use Monotify\Handler\HipchatHandler;
use Monotify\Notification\Notification;
use Monotify\Notifier;

require 'vendor/autoload.php';

$notifier = new Notifier('realtime-notifier');
$notifier->addHandler(new SlackHandler(
    'yourhookurl',
    'channel' // without the #
));
$notifier->addHandler(new HipchatHandler(
    'yourtoken',
    'room' // string or id
));
$notifier->notify((new Notification('this is a realtime notification')));
```

