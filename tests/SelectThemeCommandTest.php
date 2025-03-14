<?php

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
