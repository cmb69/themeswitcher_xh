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

namespace Themeswitcher\Infra;

class View
{
    /** @var string */
    private $templateFolder;

    /** @var array<string,string> */
    private $text;

    /** @param array<string,string>  $text */
    public function __construct(string $templateFolder, array $text)
    {
        $this->templateFolder = $templateFolder;
        $this->text = $text;
    }

    /** @param scalar $args */
    public function text(string $key, ...$args): string
    {
        return sprintf($this->esc($this->text[$key]), ...$args);
    }

    /** @param array<string,mixed> $_data */
    public function render(string $_template, array $_data): string
    {
        array_walk_recursive($_data, function (&$value) {
            if (is_string($value)) {
                $value = $this->esc($value);
            }
        });
        extract($_data);
        ob_start();
        include $this->templateFolder . $_template . ".php";
        return (string) ob_get_clean();
    }

    public function esc(string $string): string
    {
        return XH_hsc($string);
    }
}
