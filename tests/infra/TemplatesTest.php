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

namespace Themeswitcher\Infra;

use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStream;

class TemplatesTest extends TestCase
{
    /**
     * @var Templates
     */
    private $subject;

    /**
     * @var string
     */
    private $themeFolder;

    public function setUp(): void
    {
        global $pth, $plugin_cf;

        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('templates'));
        $this->themeFolder = vfsStream::url('templates/');
        foreach (array('one', 'two', 'three') as $theme) {
            mkdir($this->themeFolder . $theme, 0777, true);
            touch($this->themeFolder . $theme . '/template.htm');
        }
        $pth = array('folder' => array('templates' => $this->themeFolder));
        $plugin_cf = array(
            'themeswitcher' => ['allowed_themes' => '*']
        );
        $this->subject = new Templates();
    }

    /**
     * @return void
     */
    public function testAllTemplates()
    {
        $this->assertEquals(['one', 'three', 'two'], $this->subject->findAll());
    }

    /**
     * @return void
     */
    public function testSwitchesTemplate()
    {
        global $pth;

        $this->subject->switch('two');
        $this->assertEquals(
            array(
                'folder' => array(
                    'templates' => $this->themeFolder,
                    'template' => $this->themeFolder . 'two/',
                    'menubuttons' => $this->themeFolder . 'two/menu/',
                    'templateimages' => $this->themeFolder . 'two/images/'
                ),
                'file' => array(
                    'template' => $this->themeFolder . 'two/template.htm',
                    'stylesheet' => $this->themeFolder . 'two/stylesheet.css'
                )
            ),
            $pth
        );
    }
}
