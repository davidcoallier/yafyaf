<?php

define ('YAFYAF_ROOT',        dirname(__FILE__)           . DIRECTORY_SEPARATOR);
define ('YAFYAF_CONFIG',      YAFYAF_ROOT . 'Config'      . DIRECTORY_SEPARATOR);
define ('YAFYAF_CONTROLLERS', YAFYAF_ROOT . 'Controllers' . DIRECTORY_SEPARATOR);
define ('YAFYAF_DATABASE',    YAFYAF_ROOT . 'Database'    . DIRECTORY_SEPARATOR);
define ('YAFYAF_MODULES',     YAFYAF_ROOT . 'Modules'     . DIRECTORY_SEPARATOR);
define ('YAFYAF_MARKUP',      YAFYAF_ROOT . 'Markup'      . DIRECTORY_SEPARATOR);

require YAFYAF_CONFIG . 'Config.php';
require YAFYAF_CONTROLLERS . 'MainController.php';
require YAFYAF_MODULES . 'Module.php';
require YAFYAF_DATABASE . 'Database.php';
require YAFYAF_DATABASE . 'PDO.php';
