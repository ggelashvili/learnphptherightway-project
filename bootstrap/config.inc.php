<?php

declare(strict_types=1);

/**
 * Set default timezone
 */

date_default_timezone_set('GMT');

/**
 * Set default error reporting
 */
error_reporting(E_ALL);

define('VIEW_PATH', dirname(__DIR__) . '/views');
