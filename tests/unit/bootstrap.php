<?php

require_once './vendor/autoload.php';

require_once '../../cmsimple/functions.php';
require_once '../../cmsimple/adminfuncs.php';

require_once './tests/unit/FunctionMock.php';
require_once './tests/unit/RunkitFunctionMock.php';
require_once './tests/unit/UopzFunctionMock.php';
require_once './tests/unit/TestCase.php';

spl_autoload_register(function (string $className) {
    $parts = explode("\\", $className);
    if ($parts[0] !== "Themeswitcher") {
        return;
    }
    if (count($parts) === 3) {
        $parts[1] = strtolower($parts[1]);
    }
    $filename = implode("/", array_slice($parts, 1));
    if (is_readable("./classes/$filename.php")) {
        include_once "./classes/$filename.php";
    }
});
