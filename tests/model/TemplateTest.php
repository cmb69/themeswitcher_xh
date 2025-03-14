<?php

namespace Themeswitcher\Model;

use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStream;

class TemplateTest extends TestCase
{
    /** @var Template */
    private $subject;

    /** @var string */
    private $themeFolder;

    public function setUp(): void
    {
        global $pth, $plugin_cf;

        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('templates'));
        $this->themeFolder = vfsStream::url('templates/');
        foreach (array('one', 'two', 'three') as $theme) {
            mkdir($this->themeFolder . $theme, 0777, true);
            touch($this->themeFolder . $theme . '/template.htm');
        }
        $pth = array('folder' => array('templates' => $this->themeFolder));
        $plugin_cf = array(
            'themeswitcher' => ['allowed_themes' => '*']
        );
        $this->subject = new Template();
    }

    /** @dataProvider allowedTemplates */
    public function testFindsAllowedTemplates(string $allowed, array $expected): void
    {
        $this->assertSame($expected, $this->subject->findAllowed($allowed));
    }

    public function allowedTemplates(): array
    {
        return [
            ["four", []],
            ["t*", ["three", "two"]],
            ["*", ["one", "three", "two"]],
        ];
    }

    public function testSwitchesTemplate(): void
    {
        global $pth;

        $this->subject->switch('two');
        $this->assertEquals(
            array(
                'folder' => array(
                    'templates' => $this->themeFolder,
                    'template' => $this->themeFolder . 'two/',
                    'menubuttons' => $this->themeFolder . 'two/menu/',
                    'templateimages' => $this->themeFolder . 'two/images/'
                ),
                'file' => array(
                    'template' => $this->themeFolder . 'two/template.htm',
                    'stylesheet' => $this->themeFolder . 'two/stylesheet.css'
                )
            ),
            $pth
        );
    }
}
