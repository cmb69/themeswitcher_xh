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

class CommandFactoryTest extends TestCase
{
    /**
     * @var CommandFactory
     */
    private $subject;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->subject = new CommandFactory();
    }

    /**
     * @return void
     */
    public function testMakeThemeSelectionCommand()
    {
        $this->assertInstanceOf(
            'Themeswitcher\ThemeSelectionCommand',
            $this->subject->makeThemeSelectionCommand()
        );
    }

    /**
     * @return void
     */
    public function testMakeSelectThemeCommand()
    {
        $this->assertInstanceOf(
            'Themeswitcher\SelectThemeCommand',
            $this->subject->makeSelectThemeCommand()
        );
    }

    /**
     * @return void
     */
    public function testMakeInfoCommand()
    {
        $this->assertInstanceOf(
            'Themeswitcher\InfoCommand',
            $this->subject->makeInfoCommand()
        );
    }
}
