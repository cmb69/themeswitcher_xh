<?php

/**
 * Copyright (C) 2023 Christoph M. Becker
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

class Request
{
    /** @codeCoverageIgnore */
    public static function current(): self
    {
        return new self;
    }

    /** @codeCoverageIgnore */
    public function su(): string
    {
        global $su;
        return $su;
    }

    /** @codeCoverageIgnore */
    public function selectedTemplate(): ?string
    {
        return $_GET["themeswitcher_select"] ?? $_COOKIE["themeswitcher_theme"] ?? null;
    }

    /** @codeCoverageIgnore */
    public function hasPageTemplate(): bool
    {
        global $pd_current;
        return !empty($pd_current["template"]);
    }
}
