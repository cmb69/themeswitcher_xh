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

namespace Themeswitcher\Model;

class Template
{
    /** @return list<string> */
    public function findAllowed(string $allowedThemes): array
    {
        return $this->allowedThemes($this->findAll(), $allowedThemes);
    }

    /** @return list<string> */
    private function findAll(): array
    {
        $templates = XH_templates();
        natcasesort($templates);
        return array_values($templates);
    }

    /**
     * @param list<string> $allThemes
     * @return list<string>
     */
    private function allowedThemes(array $allThemes, string $allowedThemes): array
    {
        return array_values(array_filter($allThemes, function (string $theme) use ($allowedThemes) {
            return $this->isThemeAllowed($theme, $allowedThemes);
        }));
    }

    private function isThemeAllowed(string $theme, string $allowedThemes): bool
    {
        $allowedThemes = array_map("trim", explode(",", $allowedThemes));
        foreach ($allowedThemes as $allowedTheme) {
            if ($this->fnmatch($allowedTheme, $theme)) {
                return true;
            }
        }
        return false;
    }

    private function fnmatch(string $pattern, string $string): bool
    {
        $pattern = strtr(preg_quote($pattern, "/"), ["\*" => ".*", "\?" => "."]);
        return (bool) preg_match("/^{$pattern}$/", $string);
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
