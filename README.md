# Themeswitcher_XH

Themeswitcher_XH facilitates to display widgets that allow your visitors to
select one of the available themes (aka. templates). This is especially
useful for demonstration purposes, but might also be appropriate for normal
websites, in particular, if you are using a fancy template which might have
accessibility or usability issues.

- [Requirements](#requirements)
- [Download](#download)
- [Installation](#installation)
- [Settings](#settings)
- [Usage](#usage)
- [Limitations](#limitations)
- [Troubleshooting](#troubleshooting)
- [License](#license)
- [Credits](#credits)

## Requirements

Themeswitcher_XH is a plugin for [CMSimple_XH](https://www.cmsimple-xh.org/).
It requires CMSimple_XH ≥ 1.7.0 and PHP ≥ 7.1.0.
Themeswitcher_XH also requires [Plib_XH](https://github.com/cmb69/plib_xh) ≥ 1.2;
if that is not already installed (see *Settings*→*Info*),
get the [lastest release](https://github.com/cmb69/plib_xh/releases/latest),
and install it.

## Download

The [lastest release](https://github.com/cmb69/themeswitcher_xh/releases/latest)
is available for download on Github.

# Installation

The installation is done as with many other CMSimple_XH plugins.

1. Backup the data on your server.
1. Unzip the distribution on your computer.
1. Upload the whole directory `themeswitcher/` to your server into
   the `plugins/` directory of CMSimple_XH.
1. Set write permissions for the subdirectories `config/`, `css/` and `languages/`.
1. Navigate to `Plugins` → `Themeswitcher` in the back-end to check
   if all requirements are fulfilled.

## Settings


The configuration of the plugin is done as with many other CMSimple_XH plugins
in the back-end of the Website. Go to `Plugins` → `Themeswitcher`.


You can change the default settings of Themeswitcher_XH under `Config`.
Hints for the options will be displayed when hovering over the help icon
with your mouse.

Localization is done under `Language`. You can translate the character
strings to your own language if there is no appropriate language file
available, or customize them according to your needs.


The look of Themeswitcher_XH can be customized under `Stylesheet`.

## Usage

You can manually embed theme switcher widgets either in the template:

    <?=themeswitcher()?>

or on individual pages:

    {{{themeswitcher()}}}

This enables your visitors to choose their preferred theme.
This choice is stored in a cookie, so the selected theme
stays available for the rest of the browser session.
You can configure whether page specific templates
(defined via `page_params`) override the user selection or not.

If you have many templates to choose from, and you want to make a theme
switcher available on all pages, you can set the respective configuration
option. Then the widget will be output at the bottom of the template; the
default style rules will position it at the bottom left of the viewport.


It is not strictly necessary to show a theme switcher widget to visitors.
Instead you can present them one or more links so they can choose the
template. Use the theme switcher widget to see how the URL of these links
should look like.

## Limitations

Since CMSimple_XH 1.6 page specific templates are enabled also for subpages
(unless explicitly overridden). However, this is not catered to by
Themeswitcher_XH.

## Troubleshooting

Report bugs and ask for support either on [Github](https://github.com/cmb69/themeswitcher_xh/issues)
or in the [CMSimple_XH Forum](https://cmsimpleforum.com/).

## License

Themeswitcher_XH is free software: you can redistribute it and/or modify it
under the terms of the GNU General Public License as published
by the Free Software Foundation, either version 3 of the License,
or (at your option) any later version.

Themeswitcher_XH is distributed in the hope that it will be useful,
but without any warranty; without even the implied warranty of merchantibility
or fitness for a particular purpose.
See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Themeswitcher_XH. If not, see https://www.gnu.org/licenses/.

Copyright © Christoph M. Becker

Slovak translation © Dr. Martin Sereday

## Credits

Themeswitcher_XH is inspired by Templateshift by *olape* and *xhomie*.

The plugin logo is designed by newmooon.
Many thanks for publishing this icon under GPL.

Many thanks to the community at the [CMSimple_XH forum](https://www.cmsimpleforum.com/)
for tips, suggestions and testing.

And last but not least many thanks to [Peter Harteg](https://www.harteg.dk/),
the “father” of CMSimple, and all developers of [CMSimple_XH](https://www.cmsimple-xh.org/)
without whom this amazing CMS would not exist.
