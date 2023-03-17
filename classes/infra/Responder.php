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

use Themeswitcher\Value\Response;

class Responder
{
    public static function respond(Response $response): string
    {
        if ($response->themeCookie() !== null) {
            setcookie('themeswitcher_theme', $response->themeCookie(), 0, CMSIMPLE_ROOT);
        }
        return $response->output();
    }
}
