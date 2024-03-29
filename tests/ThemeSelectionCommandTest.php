<?php

/**
 * Copyright (C) 2023 Christoph M. Becker
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

use ApprovalTests\Approvals;
use PHPUnit\Framework\TestCase;
use Themeswitcher\Infra\Request;
use Themeswitcher\Infra\Templates;
use Themeswitcher\Infra\View;

class ThemeSelectionCommandTest extends TestCase
{
    public function testRendersThemeSelector(): void
    {
        $sut = $this->sut();
        $response = $sut($this->request());
        Approvals::verifyHtml($response->output());
    }

    public function testRendersThemeSelectorWithSelectedTemplateSelected(): void
    {
        $sut = $this->sut();
        $response = $sut($this->request(["selectedTemplate" => "bar_template"]));
        Approvals::verifyHtml($response->output());
    }

    public function testRendersAutomaticThemeSelector(): void
    {
        $sut = $this->sut();
        $response = $sut($this->request(), true);
        Approvals::verifyHtml($response->bjs());
    }

    public function testRendersNothingInFrontEndModeIfInEditMode(): void
    {
        global $edit;
        $edit = true;
        $sut = $this->sut(["display_automatic" => "frontend"]);
        $response = $sut($this->request(), true);
        $this->assertEquals("", $response->output());
        $this->assertNull($response->bjs());
    }

    private function sut(array $opts = [])
    {
        $opts += ["display_automatic" => "always"];
        $plugin_cf = ["themeswitcher" => [
            "allowed_themes" => "foo_theme,bar_template",
            "display_automatic" => $opts["display_automatic"],
            "site_template" => "foo_theme",
        ]];
        $templates = $this->createMock(Templates::class);
        $templates->method("findAll")->willReturn(["foo_theme", "bar_template"]);
        $view = new View("./views/", XH_includeVar("./languages/en.php", "plugin_tx")["themeswitcher"]);
        return new ThemeSelectionCommand($plugin_cf["themeswitcher"], $templates, $view);
    }

    private function request(array $opts = [])
    {
        $opts += ["selectedTemplate" => null];
        $request = $this->createMock(Request::class);
        $request->method("selectedTemplate")->willReturn($opts["selectedTemplate"]);
        return $request;
    }
}
