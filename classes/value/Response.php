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

namespace Themeswitcher\Value;

class Response
{
    public static function create(string $output = ""): self
    {
        $that = new self;
        $that->output = $output;
        return $that;
    }

    /** @var string */
    private $output;

    /** @var string|null */
    private $themeCookie = null;

    /** @var string|null */
    private $bjs = null;

    public function withThemeCookie(string $themeCookie): self
    {
        $that = clone $this;
        $that->themeCookie = $themeCookie;
        return $that;
    }

    public function withBjs(string $bjs): self
    {
        $that = clone $this;
        $that->bjs = $bjs;
        return $that;
    }

    public function output(): string
    {
        return $this->output;
    }

    public function themeCookie(): ?string
    {
        return $this->themeCookie;
    }

    public function bjs(): ?string
    {
        return $this->bjs;
    }
}
