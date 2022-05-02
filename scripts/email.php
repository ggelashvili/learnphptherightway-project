<?php

declare(strict_types = 1);

use App\App;
use Illuminate\Container\Container;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container();

(new App($container))->boot();

// Send Queued Emails
