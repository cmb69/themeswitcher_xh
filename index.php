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

// phpcs:disable PSR1.Files.SideEffects

use Plib\Request;
use Themeswitcher\Dic;

const THEMESWITCHER_VERSION = "1.0beta4";

function themeswitcher(): string
{
    return Dic::makeThemeSelectionCommand()(Request::current())();
}

if (!defined("CMSIMPLE_XH_VERSION")) {
    http_response_code(403);
    exit;
}

/** @var ?array<string,string> $pd_current */

Dic::makeSelectThemeCommand()->execute(Request::current(), $pd_current ?? []);
Dic::makeThemeSelectionCommand()(Request::current(), true)();
