<?php

/**
 * Copyright (C) 2014-2017 Christoph M. Becker
 *
 * This file is part of Themeswitcher_XH.
 *
 * Themeswitcher_XH is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Themeswitcher_XH is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Themeswitcher_XH.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Themeswitcher;

use Themeswitcher\Infra\View;
use stdClass;

class InfoCommand
{
    /**
     * @return string
     */
    public function render()
    {
        global $pth, $plugin_tx;

        $view = new View($pth["folder"]["plugins"] . "themeswitcher/views/", $plugin_tx["themeswitcher"]);
        return $view->render("info", [
            'logo' => "{$pth['folder']['plugins']}themeswitcher/themeswitcher.png",
            'version' => Plugin::VERSION,
            'checks' => $this->checks()
        ]);
    }

    /** @return list<stdClass> */
    private function checks(): array
    {
        global $pth;
        return [
            $this->checkPhpVersion("5.4.0"),
            $this->checkXhVersion("1.6.3"),
            $this->checkWritability($pth["folder"]["plugins"] . "themeswitcher/config/"),
            $this->checkWritability($pth["folder"]["plugins"] . "themeswitcher/css/"),
            $this->checkWritability($pth["folder"]["plugins"] . "themeswitcher/languages/"),
        ];
    }

    private function checkPhpVersion(string $version): stdClass
    {
        global $plugin_tx;
        $state = version_compare(PHP_VERSION, $version, "ge") ? "success" : "fail";
        return (object) [
            "state" => $state,
            "label" => sprintf($plugin_tx["themeswitcher"]["syscheck_phpversion"], $version),
            "stateLabel" => $plugin_tx["themeswitcher"]["syscheck_$state"],
        ];
    }

    private function checkXhVersion(string $version): stdClass
    {
        global $plugin_tx;
        $state = version_compare(CMSIMPLE_XH_VERSION, "CMSimple_XH $version", "ge") ? "success" : "fail";
        return (object) [
            "state" => $state,
            "label" => sprintf($plugin_tx["themeswitcher"]["syscheck_xhversion"], $version),
            "stateLabel" => $plugin_tx["themeswitcher"]["syscheck_$state"],
        ];
    }

    private function checkWritability(string $folder): stdClass
    {
        global $plugin_tx;
        $state = is_writable($folder) ? "success" : "fail";
        return (object) [
            "state" => $state,
            "label" => sprintf($plugin_tx["themeswitcher"]["syscheck_writable"], $folder),
            "stateLabel" => $plugin_tx["themeswitcher"]["syscheck_$state"],
        ];
    }
}
