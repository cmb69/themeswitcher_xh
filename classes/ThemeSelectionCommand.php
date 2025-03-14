<?php

/**
 * Copyright (c) Christoph M. Becker
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

use Plib\Request;
use Plib\Response;
use Plib\View;
use Themeswitcher\Model\Template;

class ThemeSelectionCommand
{
    /** @var array<string,string> */
    private $conf;

    /** @var Template */
    private $template;

    /** @var View */
    private $view;

    /** @param array<string,string> $conf */
    public function __construct(array $conf, Template $template, View $view)
    {
        $this->conf = $conf;
        $this->template = $template;
        $this->view = $view;
    }

    public function __invoke(Request $request, bool $automatic = false): Response
    {
        if (!$automatic) {
            return Response::create($this->render($request, $automatic));
        }
        if ($this->isAutomatic($request)) {
            return Response::create()->withBjs($this->render($request, $automatic));
        }
        return Response::create();
    }

    private function render(Request $request, bool $automatic): string
    {
        return $this->view->render("form", [
            "class" => $automatic ? "themeswitcher_automatic" : "",
            'selected' => $request->selected(),
            'themes' => $this->templateRecords($request)
        ]);
    }

    private function isAutomatic(Request $request): bool
    {
        $mode = $this->conf['display_automatic'];
        return ($mode === 'always' || ($mode === 'frontend' && !$request->edit()));
    }

    /** @return list<array{name:string,selected:string}> */
    private function templateRecords(Request $request): array
    {
        $allowedTemplates = $this->template->findAllowed($this->conf['allowed_themes']);
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
        $selectedTemplate = $request->get("themeswitcher_select") ?? $request->cookie("themeswitcher_theme");
        if ($selectedTemplate !== null) {
            return $selectedTemplate;
        }
        return $this->conf["site_template"];
    }
}
