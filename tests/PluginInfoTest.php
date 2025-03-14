<?php

namespace Themeswitcher;

use ApprovalTests\Approvals;
use PHPUnit\Framework\TestCase;
use Plib\View;
use Themeswitcher\Infra\SystemChecker;

class PluginInfoTest extends TestCase
{
    public function testRendersPluginInfo(): void
    {
        $systemChecker = $this->createMock(SystemChecker::class);
        $systemChecker->method("checkVersion")->willReturn(false);
        $systemChecker->method("checkWritability")->willReturn(false);
        $view = new View("./views/", XH_includeVar("./languages/en.php", "plugin_tx")["themeswitcher"]);
        $sut = new PluginInfo("./plugins/themeswitcher/", $systemChecker, $view);
        $response = $sut();
        $this->assertEquals("Themeswitcher 1.0beta4", $response->title());
        Approvals::verifyHtml($response->output());
    }
}
