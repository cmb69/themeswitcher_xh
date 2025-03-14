<?php

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
