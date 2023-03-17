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

use PHPUnit\Framework\TestCase;

class DicTest extends TestCase
{
    public function setUp(): void
    {
        global $pth, $cf, $plugin_cf, $plugin_tx;
        $pth = ["folder" => ["plugins" => ""]];
        $cf = ["site" => ["template" => ""]];
        $plugin_cf = ["themeswitcher" => []];
        $plugin_tx = ["themeswitcher" => []];
    }

    public function testMakeThemeSelectionCommand(): void
    {
        $this->assertInstanceOf(ThemeSelectionCommand::class, Dic::makeThemeSelectionCommand());
    }

    public function testMakeSelectThemeCommand(): void
    {
        $this->assertInstanceOf(SelectThemeCommand::class, Dic::makeSelectThemeCommand());
    }

    public function testMakePluginInfo(): void
    {
        $this->assertInstanceOf(PluginInfo::class, Dic::makePluginInfo());
    }
}
