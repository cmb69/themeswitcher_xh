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

use Themeswitcher\Dic;
use Themeswitcher\Infra\Request;
use Themeswitcher\Infra\Responder;

const THEMESWITCHER_VERSION = "1.0beta4";

/**
 * @return string
 */
function themeswitcher()
{
    return Responder::respond(Dic::makeThemeSelectionCommand()(Request::current()));
}

Dic::makeSelectThemeCommand()->execute(Request::current());
Responder::respond(Dic::makeThemeSelectionCommand()(Request::current(), true));
