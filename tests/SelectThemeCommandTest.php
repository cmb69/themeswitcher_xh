<?php

namespace Themeswitcher;

use PHPUnit\Framework\TestCase;
use Plib\FakeRequest;
use Themeswitcher\Model\Template;

class SelectThemeCommandTest extends TestCase
{
    /** @var Template */
    private $template;

    public function testSwitchesThemeOnGet(): void
    {
        $sut = $this->sut();
        $this->template->expects($this->once())->method('switch')
            ->with($this->equalTo('one'));
        $sut(new FakeRequest(["url" => "http://example.com/?&themeswitcher_select=one"]), []);
    }

    public function testSwitchesThemeOnCookie(): void
    {
        $sut = $this->sut();
        $this->template->expects($this->once())->method('switch')
            ->with($this->equalTo('one'));
        $sut(new FakeRequest(["cookie" => ["themeswitcher_theme" => "one"]]), []);
    }

    public function testTemplateIsNotSwitchedIfNotRequested(): void
    {
        $sut = $this->sut();
        $this->template->expects($this->never())->method("switch");
        $sut(new FakeRequest(), []);
    }

    public function testDontSwitchThemeIfNotAllowed(): void
    {
        $sut = $this->sut();
        $this->template->expects($this->never())->method('switch');
        $sut(new FakeRequest(), []);
    }

    public function testSwitchThemeIfPageThemeIsNotPreferred(): void
    {
        global $plugin_cf;

        $plugin_cf['themeswitcher']['prefer_page_theme'] = '';
        $sut = $this->sut(["prefer_page_theme" => ""]);
        $this->template->expects($this->once())->method('switch');
        $sut(
            new FakeRequest(["url" => "http://example.com/?&themeswitcher_select=one"]),
            ["template" => "foo"]
        );
    }

    public function testDontSwitchThemeIfPageTemplateIsPreferred(): void
    {
        global $plugin_cf;

        $plugin_cf['themeswitcher']['prefer_page_theme'] = 'true';
        $sut = $this->sut();
        $this->template->expects($this->never())->method('switch');
        $sut(new FakeRequest(), ["template" => "foo"]);
    }

    public function testCookieIsSetOnGet(): void
    {
        $sut = $this->sut();
        $response = $sut(new FakeRequest(["url" => "http://example.com/?&themeswitcher_select=one"]), []);
        $this->assertSame(["themeswitcher_theme", "one", 0], $response->cookie());
    }

    private function sut(array $opts = []): SelectThemeCommand
    {
        $opts += [
            "prefer_page_theme" => "true",
        ];
        $conf = [
            "allowed_themes" => "one",
            "prefer_page_theme" => $opts["prefer_page_theme"],
        ];
        $this->template = $this->createMock(Template::class);
        $this->template->expects($this->any())->method('findAllowed')
            ->will($this->returnValue(array('one')));
        return new SelectThemeCommand($conf, $this->template);
    }
}
