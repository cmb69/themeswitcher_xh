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

use Themeswitcher\Infra\SystemChecker;
use Themeswitcher\Infra\Templates;
use Themeswitcher\Infra\View;

class Dic
{
    public static function makeThemeSelectionCommand(): ThemeSelectionCommand
    {
        return new ThemeSelectionCommand(
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

    public static function makeInfoCommand(): InfoCommand
    {
        global $pth;
        return new InfoCommand($pth["folder"]["plugins"] . "themeswitcher/", new SystemChecker, self::makeView());
    }

    private static function makeView(): View
    {
        global $pth, $plugin_tx;
        return new View($pth["folder"]["plugins"] . "themeswitcher/views/", $plugin_tx["themeswitcher"]);
    }
}
