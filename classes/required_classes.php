<?php

/**
 * The autoloader.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Themeswitcher
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2014-2017 Christoph M. Becker <http://3-magi.net/>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */

spl_autoload_register(function ($className) {
    $parts = explode('_', $className);
    if ($parts[0] == 'Themeswitcher') {
        include_once __DIR__ . '/' . $parts[1] . '.php';
    }
});

?>
