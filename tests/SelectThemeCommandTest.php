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
use Themeswitcher\Infra\Templates;

class SelectThemeCommandTest extends TestCase
{
    /** @var SelectThemeCommand */
    private $subject;

    /** @var Templates */
    private $templates;

    /**
     * @return void
     */
    public function setUp(): void
    {
        global $plugin_cf;
        $plugin_cf = ["themeswitcher" => ["allowed_themes" => "one"]];
        $this->templates = $this->createMock(Templates::class);
        $this->templates->expects($this->any())->method('findAll')
            ->will($this->returnValue(array('one', 'three', 'two')));
        $this->subject = new SelectThemeCommand($this->templates);
    }

    public function testSwitchesThemeOnGet(): void
    {
        $_GET = array('themeswitcher_select' => 'one');
        $this->templates->expects($this->once())->method('switch')
            ->with($this->equalTo('one'));
        $this->subject->execute();
    }

    public function testSwitchesThemeOnCookie(): void
    {
        $_COOKIE = array('themeswitcher_theme' => 'one');
        $this->templates->expects($this->once())->method('switch')
            ->with($this->equalTo('one'));
        $this->subject->execute();
    }

    public function testDontSwitchThemeIfNotAllowed(): void
    {
        $_GET = array('themeswitcher_select' => 'foo');
        $this->templates->expects($this->never())->method('switch');
        $this->subject->execute();
    }

    public function testSwitchThemeIfPageThemeIsNotPreferred(): void
    {
        global $pd_current, $plugin_cf;

        $pd_current = array('template' => 'two');
        $plugin_cf['themeswitcher']['prefer_page_theme'] = '';
        $_GET = array('themeswitcher_select' => 'one');
        $this->templates->expects($this->once())->method('switch');
        $this->subject->execute();
    }

    public function testDontSwitchThemeIfPageTemplateIsPreferred(): void
    {
        global $pd_current, $plugin_cf;

        $pd_current = array('template' => 'two');
        $plugin_cf['themeswitcher']['prefer_page_theme'] = 'true';
        $_GET = array('themeswitcher_select' => 'one');
        $this->templates->expects($this->never())->method('switch');
        $this->subject->execute();
    }

    public function testCookieIsSetOnGet(): void
    {
        $_GET = array('themeswitcher_select' => 'one');
        $response = $this->subject->execute();
        $this->assertEquals("one", $response->themeCookie());
    }
}
