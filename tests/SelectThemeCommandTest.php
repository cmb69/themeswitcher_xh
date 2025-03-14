<?php

namespace Themeswitcher;

use PHPUnit\Framework\TestCase;
use Plib\FakeRequest;
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
        $sut->execute(new FakeRequest(["url" => "http://example.com/?&themeswitcher_select=one"]), []);
    }

    public function testSwitchesThemeOnCookie(): void
    {
        $sut = $this->sut();
        $this->templates->expects($this->once())->method('switch')
            ->with($this->equalTo('one'));
        $sut->execute(new FakeRequest(["cookie" => ["themeswitcher_theme" => "one"]]), []);
    }

    public function testTemplateIsNotSwitchedIfNotRequested(): void
    {
        $sut = $this->sut();
        $this->templates->expects($this->never())->method("switch");
        $sut->execute(new FakeRequest(), []);
    }

    public function testDontSwitchThemeIfNotAllowed(): void
    {
        $sut = $this->sut();
        $this->templates->expects($this->never())->method('switch');
        $sut->execute(new FakeRequest(), []);
    }

    public function testSwitchThemeIfPageThemeIsNotPreferred(): void
    {
        global $plugin_cf;

        $plugin_cf['themeswitcher']['prefer_page_theme'] = '';
        $sut = $this->sut(["prefer_page_theme" => ""]);
        $this->templates->expects($this->once())->method('switch');
        $sut->execute(
            new FakeRequest(["url" => "http://example.com/?&themeswitcher_select=one"]),
            ["template" => "foo"]
        );
    }

    public function testDontSwitchThemeIfPageTemplateIsPreferred(): void
    {
        global $plugin_cf;

        $plugin_cf['themeswitcher']['prefer_page_theme'] = 'true';
        $sut = $this->sut();
        $this->templates->expects($this->never())->method('switch');
        $sut->execute(new FakeRequest(), ["template" => "foo"]);
    }

    public function testCookieIsSetOnGet(): void
    {
        $sut = $this->sut();
        $response = $sut->execute(new FakeRequest(["url" => "http://example.com/?&themeswitcher_select=one"]), []);
        $this->assertSame(["themeswitcher_theme", "one", 0], $response->cookie());
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
}
