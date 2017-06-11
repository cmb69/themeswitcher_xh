<?php

/**
 * Testing the controller.
 *
 * PHP version 5
 *
 * @category  Testing
 * @package   Themeswitcher
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2014-2017 Christoph M. Becker <http://3-magi.net>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */

namespace Themeswitcher;

use PHPUnit_Framework_TestCase;
use PHPUnit_Extensions_MockFunction;

/**
 * Testing the controller.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class ControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * The test subject.
     *
     * @var Controller
     */
    protected $subject;

    /**
     * The theme selection command.
     *
     * @var SelectionCommand
     */
    protected $themeSelectionCommand;

    /**
     * The info command.
     *
     * @var InfoCommand
     */
    protected $infoCommand;

    /**
     * The print_plugin_admin() mock.
     *
     * @var PHPUnit_Extensions_MockFunction
     */
    protected $printPluginAdmin;

    /**
     * Sets up the test fixture.
     *
     * @return void
     */
    public function setUp()
    {
        if (!defined('XH_ADM')) {
            define('XH_ADM', true);
        } else {
            runkit_constant_redefine('XH_ADM', true);
        }
        $commandFactory = $this->getMock('Themeswitcher\CommandFactory');
        $this->themeSelectionCommand = $this
            ->getMockBuilder('Themeswitcher\ThemeSelectionCommand')
            ->disableOriginalConstructor()
            ->getMock();
        $commandFactory->expects($this->any())
            ->method('makeThemeSelectionCommand')
            ->will($this->returnValue($this->themeSelectionCommand));
        $this->_selectThemeCommand = $this
            ->getMockBuilder('Themeswitcher\SelectThemeCommand')
            ->disableOriginalConstructor()
            ->getMock();
        $commandFactory->expects($this->any())
            ->method('makeSelectThemeCommand')
            ->will($this->returnValue($this->_selectThemeCommand));
        $this->infoCommand = $this->getMockBuilder('Themeswitcher\InfoCommand')
            ->disableOriginalConstructor()->getMock();
        $commandFactory->expects($this->any())->method('makeInfoCommand')
            ->will($this->returnValue($this->infoCommand));
        $this->subject = new Controller($commandFactory);
        $this->printPluginAdmin = new PHPUnit_Extensions_MockFunction(
            'print_plugin_admin', $this->subject
        );
        new PHPUnit_Extensions_MockFunction(
            'XH_registerStandardPluginMenuItems', $this->subject
        );
    }

    /**
     * Tests that a select theme command is executed on an appropriate GET request.
     *
     * @return void
     */
    public function testExecutesSelectThemeCommandOnGet()
    {
        $_POST = array('themeswitcher_select' => 'foo');
        $this->_selectThemeCommand->expects($this->once())->method('execute');
        $this->subject->dispatch();
    }

    /**
     * Tests that a select theme command is executed on an appropriate COOKIE.
     *
     * @return void
     */
    public function testExecutesSelectThemeCommandOnCookie()
    {
        $_COOKIE = array('themeswitcher_theme' => 'foo');
        $this->_selectThemeCommand->expects($this->once())->method('execute');
        $this->subject->dispatch();
    }

    /**
     * Tests that the info command is rendered.
     *
     * @return void
     *
     * @global string Whether the plugin is requested.
     * @global string The value of <var>admin</var> GP paramter.
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
     * Tests that plugin_admin_common() is called.
     *
     * @return void
     *
     * @global string Whether the plugin is requested.
     * @global string The value of the <var>admin</var> GP paramter.
     * @global string The value of the <var>action</var> GP parameter.
     */
    public function testPluginAdminCommon()
    {
        global $themeswitcher, $admin, $action;

        $themeswitcher = 'true';
        $admin = 'plugin_config';
        $action = 'plugin_edit';
        $this->printPluginAdmin->expects($this->once());
        $pluginAdminCommon = new PHPUnit_Extensions_MockFunction(
            'plugin_admin_common', $this->subject
        );
        $pluginAdminCommon->expects($this->once())->with(
            $action, $admin, 'themeswitcher'
        );
        $this->subject->dispatch();
    }

    /**
     * Tests the theme selection.
     *
     * @return void
     */
    public function testThemeSelection()
    {
        $this->themeSelectionCommand->expects($this->once())->method('render');
        $this->subject->renderThemeSelection();

    }
}

?>
