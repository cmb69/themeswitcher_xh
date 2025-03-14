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

use Plib\Response;
use Themeswitcher\Infra\Request;
use Themeswitcher\Infra\Templates;
use Themeswitcher\Logic\Util;

class SelectThemeCommand
{
    /** @var array<string,string> */
    private $conf;

    /** @var Templates */
    private $templates;

    /** @param array<string,string> $conf */
    public function __construct(array $conf, Templates $templates)
    {
        $this->conf = $conf;
        $this->templates = $templates;
    }

    public function execute(Request $request): Response
    {
        if ($request->selectedTemplate() === null) {
            return Response::create();
        }
        if (!$this->isUserThemeAllowed($request)) {
            return Response::create();
        }
        if ($request->hasPageTemplate() && $this->conf['prefer_page_theme']) {
            return Response::create();
        }
        $this->templates->switch($request->selectedTemplate());
        return Response::create()->withCookie("themeswitcher_theme", $request->selectedTemplate(), 0);
    }

    /**
     * @return bool
     */
    private function isUserThemeAllowed(Request $request)
    {
        $allowedTemplates = Util::allowedThemes($this->templates->findAll(), $this->conf['allowed_themes']);
        return in_array($request->selectedTemplate(), $allowedTemplates, true);
    }
}
