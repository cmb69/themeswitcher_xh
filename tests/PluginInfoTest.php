<?php

namespace Themeswitcher;

use ApprovalTests\Approvals;
use PHPUnit\Framework\TestCase;
use Plib\FakeSystemChecker;
use Plib\View;

class PluginInfoTest extends TestCase
{
    public function testRendersPluginInfo(): void
    {
        $view = new View("./views/", XH_includeVar("./languages/en.php", "plugin_tx")["themeswitcher"]);
        $sut = new PluginInfo("./plugins/themeswitcher/", new FakeSystemChecker(), $view);
        $response = $sut();
        $this->assertEquals("Themeswitcher 1.0", $response->title());
        Approvals::verifyHtml($response->output());
    }
}
