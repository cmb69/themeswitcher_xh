# Themeswitcher_XH

Themeswitcher_XH umožňuje zobraziť pre návštevníkov stránky
výberové okienkonpre výber šablóny (template) pre konkrétnu stránku. Je
to užitočné v prípade demonštračných stránok, ale aj v prípade bežných
stránok, najmä ak v šablóne používate špecifické funkcie.


- [Požiadavky](#požiadavky)
- [Download](#download)
- [Inštalácia](#inštalácia)
- [Nastavenie](#nastavenie)
- [Použitie](#použitie)
- [Obmedzenia](#obmedzenia)
- [Troubleshooting](#troubleshooting)
- [Licencia](#licencia)
- [Záruky](#záruky)

## Požiadavky

Themeswitcher_XH is a plugin for [CMSimple_XH](https://www.cmsimple-xh.org/).
It requires CMSimple_XH ≥ 1.7.0 and PHP ≥ 7.1.0.
Themeswitcher_XH also requires the [Plib_XH](https://github.com/cmb69/plib_xh) plugin;
if that is not already installed (see *Settings*→*Info*),
get the [lastest release](https://github.com/cmb69/plib_xh/releases/latest),
and install it.

## Download

The [lastest release](https://github.com/cmb69/themeswitcher_xh/releases/latest)
is available for download on Github.

## Inštalácia

Inštalácia prebieha rovnako ako pri väčšine CMSimple_XH pluginov.

1. Urobte najprv zálohu dát na Vašom serveri.
1. Rozbaľte archív vo Vašom počítači.
1. Uložte celý adresár `themeswitcher/` na Váš server do adresára `plugins/`.
1. Nastavte prístupové práva pre podadresáre `config/`, `css/` a `languages/`.
1. Navigate to `Plugins` → `Themeswitcher` in the back-end to check
   if all requirements are fulfilled.


## Nastavenie

Nastavenie pluginu sa robí rovnako ako pri iných pluginoch CMSimple_XH
v správcovskom prostredí stránky. Otvorte `Plugins`→`Themeswitcher`.

Zmeny nastavení môžete urobiť v Themeswitcher_XH v `Config`.
Vysvetlivky sa zobrazia prechodom na ikonu pomocníka.

Jazykové prostredie si aktuaizujete prekladom položiek v `Language`.
Formulácie môžete prepísať do Vášho jazyka, ak tento nie je v archíve,
alebo ich môžete upraviť podľa Vašich potrieb.

Vzhľad Themeswitcher_XH môžete upraviť pod `Stylesheet`.

## Použitie

Theme switcher môžete vložiť priamo do Vašľej šablóny:

    <?=themeswitcher()?>

alebo na jednotlivé stránky:

    {{{themeswitcher()}}}

To umožňuje návštevníkom stránky vybrať si vyhovujúci šablónu. Táto
voľba sa ukladá do cookies, takže zvolená šablóna ostáva aktívna počas
celej doby surfovania. Môžete nastaviť, čo výber šabl=ony prepíše
základné nastavenia (definované v `page_params`).

AK máte na výber veľa šablón a chcete mať voľbu šablón viditeľnú na
každej stránke, môžete to nastaviť v konfigurácii.
Then the widget will be output at the bottom of the template; the
default style rules will position it at the bottom left of the viewport.

Nie je však nevyhnutné výberové okienko zobrazovať vôbec.
Namiesto toho môžete na stránku umietniť odkazy obsahujúce aj názov
šablóny. Pre správny tvar takéhoto odkazu využite výberové okno.

## Obmedzenia

Od verzie CMSimple_XH 1.6 sú špecifické šablóny platné aj pre podstránky,
pokiaľ nie sú inak definované. Toto však nezabezpečuje Themeswitcher_XH.

## Troubleshooting

Report bugs and ask for support either on [Github](https://github.com/cmb69/themeswitcher_xh/issues)
or in the [CMSimple_XH Forum](https://cmsimpleforum.com/).

## Licencia

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

## Záruky

Themeswitcher_XH je inšpirovaný skriptom Templateshift od *olape* a *xhomie*.

Logo pluginu navrhol newmooon.
Ďakujem za umožnenie používať ho v zmysle licencie GPL.

Ďakujem celej komunite [CMSimple_XH forum](https://www.cmsimpleforum.com/)
za návrhy, rady a testovanie.

Nakoniec, nemenej, veľka patrí [Petrovi Hartegovi](https://harteg.dk/),
otcovi CMSimple a všetkým vývojárom [CMSimple_XH](https://www.cmsimple-xh.org/),
bez pomoci ktorých by tento skvelý CMSimple_XH nikdy neexistoval.
