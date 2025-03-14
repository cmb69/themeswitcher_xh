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

namespace Themeswitcher\Infra;

class Templates
{
    /** @return list<string> */
    public function findAll(): array
    {
        $templates = XH_templates();
        natcasesort($templates);
        return array_values($templates);
    }

    /** @return void */
    public function switch(string $template)
    {
        global $pth;
        $pth["folder"]["template"] = $pth["folder"]["templates"] . $template . "/";
        $pth["file"]["template"] = $pth["folder"]["template"] . "template.htm";
        $pth["file"]["stylesheet"] = $pth["folder"]["template"] . "stylesheet.css";
        $pth["folder"]["menubuttons"] = $pth["folder"]["template"] . "menu/";
        $pth["folder"]["templateimages"] = $pth["folder"]["template"] . "images/";
    }
}
