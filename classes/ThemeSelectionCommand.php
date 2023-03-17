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

use Themeswitcher\Infra\Request;
use Themeswitcher\Infra\Templates;
use Themeswitcher\Infra\View;
use Themeswitcher\Logic\Util;

class ThemeSelectionCommand
{
    /** @var array<string,string> */
    private $conf;

    /** @var Templates */
    private $templates;

    /** @var View */
    private $view;

    /** @param array<string,string> $conf */
    public function __construct(array $conf, Templates $templates, View $view)
    {
        $this->conf = $conf;
        $this->templates = $templates;
        $this->view = $view;
    }

    /** @return void */
    public function __invoke(Request $request)
    {
        if ($this->isAutomatic()) {
            $this->outputContents($this->render($request));
        }
    }

    public function render(Request $request): string
    {
        return $this->view->render("form", [
            'selected' => $request->su(),
            'themes' => $this->templateRecords($request)
        ]);
    }

    private function isAutomatic(): bool
    {
        global $print, $edit, $f;

        $mode = $this->conf['display_automatic'];
        return ($mode == 'always' || $mode == 'frontend' && !$edit)
            && !$print && !in_array($f, ['login', 'xh_login_failed', 'forgotten']);
    }

    /** @return void */
    private function outputContents(string $html)
    {
        global $c, $o, $pd_s, $s, $edit, $xh_publisher;

        $startPage = $xh_publisher->getFirstPublishedPage();
        if ($pd_s === $startPage && $s !== $startPage && !(defined("XH_ADM") && XH_ADM && $edit)) {
            $c[$pd_s] = $html . $c[$pd_s];
        } else {
            $o .= $html;
        }
    }

    /** @return list<array{name:string,selected:string}> */
    private function templateRecords(Request $request): array
    {
        $allowedTemplates = Util::allowedThemes($this->templates->findAll(), $this->conf['allowed_themes']);
        $themes = [];
        foreach ($allowedTemplates as $name) {
            $themes[] = [
                'name' => $name,
                'selected' => $name === $this->getCurrentTheme($request) ? 'selected' : ''
            ];
        }
        return $themes;
    }

    private function getCurrentTheme(Request $request): string
    {
        if ($request->selectedTemplate() !== null) {
            return $request->selectedTemplate();
        }
        return $this->conf["site_template"];
    }
}
