<?php

declare(strict_types=1);

use Dotenv\Dotenv;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/***
 * Load global configurations params
 */
require_once __DIR__  . '/config.inc.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
