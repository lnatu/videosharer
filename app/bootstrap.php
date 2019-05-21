<?php
// load config
require_once 'config/config.php';

require_once 'helpers/date.php';
require_once 'helpers/url_helpers.php';
require_once 'helpers/session_helpers.php';

// auto load Core librabries
spl_autoload_register(function($className) {
    require_once 'lib/'.$className.'.php';
});