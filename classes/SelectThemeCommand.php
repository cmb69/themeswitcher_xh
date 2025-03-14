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
use Themeswitcher\Model\Template;

class SelectThemeCommand
{
    /** @var array<string,string> */
    private $conf;

    /** @var Template */
    private $template;

    /** @param array<string,string> $conf */
    public function __construct(array $conf, Template $template)
    {
        $this->conf = $conf;
        $this->template = $template;
    }

    /** @param array<string,string> $pageData */
    public function execute(Request $request, array $pageData): Response
    {
        $selectedTemplate = $request->get("themeswitcher_select") ?? $request->cookie("themeswitcher_theme");
        if ($selectedTemplate === null) {
            return Response::create();
        }
        if (!$this->isUserThemeAllowed($request)) {
            return Response::create();
        }
        if (!empty($pageData["template"]) && $this->conf['prefer_page_theme']) {
            return Response::create();
        }
        $this->template->switch($selectedTemplate);
        return Response::create()->withCookie("themeswitcher_theme", $selectedTemplate, 0);
    }

    /**
     * @return bool
     */
    private function isUserThemeAllowed(Request $request)
    {
        $selectedTemplate = $request->get("themeswitcher_select") ?? $request->cookie("themeswitcher_theme");
        $allowedTemplates = $this->template->findAllowed($this->conf['allowed_themes']);
        return in_array($selectedTemplate, $allowedTemplates, true);
    }
}
