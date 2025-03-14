<?php

/**
 * Copyright (c) Christoph M. Becker
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

use Plib\View;
use Themeswitcher\Infra\SystemChecker;
use Themeswitcher\Infra\Templates;

class Dic
{
    public static function makeThemeSelectionCommand(): ThemeSelectionCommand
    {
        global $cf, $plugin_cf;
        return new ThemeSelectionCommand(
            ["site_template" => $cf["site"]["template"]] + $plugin_cf["themeswitcher"],
            new Templates(),
            self::makeView()
        );
    }

    public static function makeSelectThemeCommand(): SelectThemeCommand
    {
        global $plugin_cf;
        return new SelectThemeCommand(
            $plugin_cf["themeswitcher"],
            new Templates()
        );
    }

    public static function makePluginInfo(): PluginInfo
    {
        global $pth;
        return new PluginInfo($pth["folder"]["plugins"] . "themeswitcher/", new SystemChecker, self::makeView());
    }

    private static function makeView(): View
    {
        global $pth, $plugin_tx;
        return new View($pth["folder"]["plugins"] . "themeswitcher/views/", $plugin_tx["themeswitcher"]);
    }
}
