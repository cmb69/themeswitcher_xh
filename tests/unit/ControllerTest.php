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

class ControllerTest extends TestCase
{
    /**
     * @var Controller
     */
    private $subject;

    /**
     * @var SelectionCommand
     */
    private $themeSelectionCommand;

    /**
     * @var InfoCommand
     */
    private $infoCommand;

    /**
     * @var FunctionMock
     */
    private $printPluginAdmin;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->setConstant('XH_ADM', true);
        $commandFactory = $this->createMock('Themeswitcher\CommandFactory');
        $this->themeSelectionCommand = $this->createMock('Themeswitcher\ThemeSelectionCommand');
        $commandFactory->expects($this->any())
            ->method('makeThemeSelectionCommand')
            ->will($this->returnValue($this->themeSelectionCommand));
        $this->_selectThemeCommand = $this->createMock('Themeswitcher\SelectThemeCommand');
        $commandFactory->expects($this->any())
            ->method('makeSelectThemeCommand')
            ->will($this->returnValue($this->_selectThemeCommand));
        $this->infoCommand = $this->createMock('Themeswitcher\InfoCommand');
        $commandFactory->expects($this->any())->method('makeInfoCommand')
            ->will($this->returnValue($this->infoCommand));
        $this->subject = new Controller($commandFactory);
        $this->printPluginAdmin = $this->createFunctionMock('print_plugin_admin');
        $this->createFunctionMock('XH_registerStandardPluginMenuItems');
    }

    /**
     * @return void
     */
    public function testExecutesSelectThemeCommandOnGet()
    {
        $_GET = array('themeswitcher_select' => 'foo');
        $this->_selectThemeCommand->expects($this->once())->method('execute');
        $this->subject->dispatch();
    }

    /**
     * @return void
     */
    public function testExecutesSelectThemeCommandOnCookie()
    {
        $_COOKIE = array('themeswitcher_theme' => 'foo');
        $this->_selectThemeCommand->expects($this->once())->method('execute');
        $this->subject->dispatch();
    }

    /**
     * @return void
     */
    public function testRendersInfoCommand()
    {
        global $themeswitcher, $admin;

        $themeswitcher = 'true';
        $admin = '';
        $this->printPluginAdmin->expects($this->once());
        $this->infoCommand->expects($this->once())->method('render');
        $this->subject->dispatch();
    }

    /**
     * @return void
     */
    public function testPluginAdminCommon()
    {
        global $themeswitcher, $admin, $action;

        $themeswitcher = 'true';
        $admin = 'plugin_config';
        $action = 'plugin_edit';
        $this->printPluginAdmin->expects($this->once());
        $pluginAdminCommon = $this->createFunctionMock('plugin_admin_common');
        $pluginAdminCommon->expects($this->once())->with($action, $admin, 'themeswitcher');
        $this->subject->dispatch();
    }

    /**
     * @return void
     */
    public function testThemeSelection()
    {
        $this->themeSelectionCommand->expects($this->once())->method('render');
        $this->subject->renderThemeSelection();
    }
}
