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
use Themeswitcher\Infra\Request;
use Themeswitcher\Infra\Templates;

class SelectThemeCommandTest extends TestCase
{
    /** @var Templates */
    private $templates;

    public function testSwitchesThemeOnGet(): void
    {
        $sut = $this->sut();
        $this->templates->expects($this->once())->method('switch')
            ->with($this->equalTo('one'));
        $sut->execute($this->request());
    }

    public function testSwitchesThemeOnCookie(): void
    {
        $sut = $this->sut();
        $this->templates->expects($this->once())->method('switch')
            ->with($this->equalTo('one'));
        $sut->execute($this->request());
    }

    public function testTemplateIsNotSwitchedIfNotRequested(): void
    {
        $sut = $this->sut();
        $this->templates->expects($this->never())->method("switch");
        $sut->execute($this->request(["selectedTemplate" => null]));
    }

    public function testDontSwitchThemeIfNotAllowed(): void
    {
        $sut = $this->sut();
        $this->templates->expects($this->never())->method('switch');
        $sut->execute($this->request(["selectedTemplate" => "foo"]));
    }

    public function testSwitchThemeIfPageThemeIsNotPreferred(): void
    {
        global $plugin_cf;

        $plugin_cf['themeswitcher']['prefer_page_theme'] = '';
        $sut = $this->sut(["prefer_page_theme" => ""]);
        $this->templates->expects($this->once())->method('switch');

        $sut->execute($this->request(["hasPageTemplate" => true]));
    }

    public function testDontSwitchThemeIfPageTemplateIsPreferred(): void
    {
        global $plugin_cf;

        $plugin_cf['themeswitcher']['prefer_page_theme'] = 'true';
        $sut = $this->sut();
        $this->templates->expects($this->never())->method('switch');
        $sut->execute($this->request(["hasPageTemplate" => true]));
    }

    public function testCookieIsSetOnGet(): void
    {
        $sut = $this->sut();
        $response = $sut->execute($this->request());
        $this->assertEquals("one", $response->themeCookie());
    }

    private function sut(array $opts = [])
    {
        $opts += [
            "prefer_page_theme" => "true",
        ];
        $conf = [
            "allowed_themes" => "one",
            "prefer_page_theme" => $opts["prefer_page_theme"],
        ];
        $this->templates = $this->createMock(Templates::class);
        $this->templates->expects($this->any())->method('findAll')
            ->will($this->returnValue(array('one', 'three', 'two')));
        return new SelectThemeCommand($conf, $this->templates);
    }

    public function request(array $opts = [])
    {
        $opts += [
            "selectedTemplate" => "one",
            "hasPageTemplate" => false,
        ];
        $request = $this->createMock(Request::class);
        $request->method("selectedTemplate")->willReturn($opts["selectedTemplate"]);
        $request->method("hasPageTemplate")->willReturn($opts["hasPageTemplate"]);
        return $request;
    }
}
