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
use Themeswitcher\Infra\View;

class ThemeSelectionCommand
{
    /**
     * @var Model
     */
    private $model;

    /** @var View */
    private $view;

    /**
     * @return void
     */
    public function __construct(Model $model, View $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    /** @return void */
    public function __invoke()
    {
        if ($this->isAutomatic()) {
            $this->outputContents($this->render());
        }
    }

    /**
     * @return string
     */
    public function render()
    {
        global $su;
        static $run = 0;

        $run++;
        return $this->view->render("form", [
            'run' => $run,
            'selected' => $su,
            'themes' => $this->getThemes()
        ]);
    }

    /**
     * @return bool
     */
    private function isAutomatic()
    {
        global $print, $edit, $f, $plugin_cf;

        $mode = $plugin_cf['themeswitcher']['display_automatic'];
        return ($mode == 'always' || $mode == 'frontend' && !$edit)
            && !$print && !in_array($f, ['login', 'xh_login_failed', 'forgotten']);
    }

    /**
     * @param string $html
     * @return void
     */
    private function outputContents($html)
    {
        global $c, $o, $pd_s, $s, $edit, $xh_publisher, $_XH_firstPublishedPage;

        if (isset($xh_publisher)) {
            $startPage = $xh_publisher->getFirstPublishedPage();
        } else {
            $startPage = $_XH_firstPublishedPage;
        }
        if ($pd_s === $startPage && $s !== $startPage && !(defined("XH_ADM") && XH_ADM && $edit)) {
            $c[$pd_s] = $html . $c[$pd_s];
        } else {
            $o .= $html;
        }
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
