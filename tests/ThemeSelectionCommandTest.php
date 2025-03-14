<?php

namespace Themeswitcher;

use ApprovalTests\Approvals;
use PHPUnit\Framework\TestCase;
use Plib\FakeRequest;
use Plib\View;
use Themeswitcher\Model\Template;

class ThemeSelectionCommandTest extends TestCase
{
    public function testRendersThemeSelector(): void
    {
        $sut = $this->sut();
        $response = $sut(new FakeRequest());
        Approvals::verifyHtml($response->output());
    }

    public function testRendersThemeSelectorWithSelectedTemplateSelected(): void
    {
        $sut = $this->sut();
        $request = new FakeRequest(["url" => "http://example.com/?&themeswitcher_select=bar_template"]);
        $response = $sut($request);
        Approvals::verifyHtml($response->output());
    }

    public function testRendersAutomaticThemeSelector(): void
    {
        $sut = $this->sut();
        $response = $sut(new FakeRequest(), true);
        Approvals::verifyHtml($response->bjs());
    }

    public function testRendersNothingInFrontEndModeIfInEditMode(): void
    {
        global $edit;
        $edit = true;
        $sut = $this->sut(["display_automatic" => "frontend"]);
        $response = $sut(new FakeRequest(), true);
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
        $templates = $this->createMock(Template::class);
        $templates->method("findAllowed")->willReturn(["foo_theme", "bar_template"]);
        $view = new View("./views/", XH_includeVar("./languages/en.php", "plugin_tx")["themeswitcher"]);
        return new ThemeSelectionCommand($plugin_cf["themeswitcher"], $templates, $view);
    }
}
