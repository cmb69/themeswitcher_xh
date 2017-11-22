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

namespace Themeswitcher;

use stdClass;
use Pfw\View\View;

class ThemeSelectionCommand
{
    /**
     * @var Model
     */
    private $model;

    /**
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function render()
    {
        global $su;
        static $run = 0;

        $run++;
        ob_start();
        (new View('themeswitcher'))
            ->template('form')
            ->data([
                'run' => $run,
                'selected' => $su,
                'themes' => $this->getThemes()
            ])
            ->render();
        return ob_get_clean();
    }

    /**
     * @return stdClass[]
     */
    private function getThemes()
    {
        $themes = [];
        foreach ($this->model->getThemes() as $name) {
            $themes[] = (object) array(
                'name' => $name,
                'selected' => $name === $this->getCurrentTheme() ? 'selected' : ''
            );
        }
        return $themes;
    }

    /**
     * @return string
     */
    private function getCurrentTheme()
    {
        global $cf;

        if (isset($_GET['themeswitcher_select'])) {
            return $_GET['themeswitcher_select'];
        } elseif (isset($_COOKIE['themeswitcher_theme'])) {
            return $_COOKIE['themeswitcher_theme'];
        } else {
            return $cf['site']['template'];
        }
    }
}
