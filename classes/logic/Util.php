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

namespace Themeswitcher\Logic;

class Util
{
    /**
     * @param list<string> $allThemes
     * @return list<string>
     */
    public static function allowedThemes(array $allThemes, string $allowedThemes): array
    {
        return array_values(array_filter($allThemes, function (string $theme) use ($allowedThemes) {
            return Util::isThemeAllowed($theme, $allowedThemes);
        }));
    }

    private static function isThemeAllowed(string $theme, string $allowedThemes): bool
    {
        $allowedThemes = array_map("trim", explode(",", $allowedThemes));
        foreach ($allowedThemes as $allowedTheme) {
            if (Util::fnmatch($allowedTheme, $theme)) {
                return true;
            }
        }
        return false;
    }

    private static function fnmatch(string $pattern, string $string): bool
    {
        $pattern = strtr(preg_quote($pattern, "/"), ["\*" => ".*", "\?" => "."]);
        return (bool) preg_match("/^{$pattern}$/", $string);
    }
}
