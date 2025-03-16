# Themeswitcher_XH

Themeswitcher_XH ermöglicht die Anzeige von Widgets, die es Ihren Besuchern
erlauben eines der verfügbaren Themes (alias Templates) auszuwählen. Dies
ist besonders praktisch für Demonstrationszwecke, aber könnte ebenso für
normale Websites angemessen sein, vor allem, wenn Sie ein ausgefallenes
Template verwenden, das nicht unbedingt barrierefrei oder gut benutzbar
ist.

- [Voraussetzungen](#voraussetzungen)
- [Download](#download)
- [Installation](#installation)
- [Einstellungen](#einstellungen)
- [Verwendung](#verwendung)
- [Einschränkungen](#einschränkungen)
- [Problembehebung](#problembehebung)
- [Lizenz](#lizenz)
- [Danksagung](#danksagung)

## Voraussetzungen

Themeswitcher_XH ist ein Plugin für [CMSimple_XH](https://www.cmsimple-xh.org/de/).
Es benötigt CMSimple_XH ≥ 1.7.0 und PHP ≥ 7.1.0.
Themeswitcher_XH benötigt weiterhin [Plib_XH](https://github.com/cmb69/plib_xh) ≥ 1.2;
ist dieses noch nicht installiert (see *Einstellungen*→*Info*),
laden Sie das [aktuelle Release](https://github.com/cmb69/plib_xh/releases/latest)
herunter, und installieren Sie es.

## Download

Das [aktuelle Release](https://github.com/cmb69/themeswitcher_xh/releases/latest)
kann von Github herunter geladen werden.

## Installation

Die Installation erfolgt wie bei vielen anderen CMSimple_XH-Plugins auch.

1. Sichern Sie die Daten auf Ihrem Server.
1. Entpacken Sie das herunter geladene Archiv auf Ihrem Computer.
1. Laden Sie das komplette Verzeichnis `themeswitcher/` auf Ihren Server in
   das Pluginverzeichnis (`plugins/`) von CMSimple_XH.
1. Machen Sie die Unterverzeichnisse `config/`, `css/` und `languages/` beschreibbar.
1. Browsen Sie zu `Plugins` → `Themeswitcher` im Administrationsbereich,
   um zu prüfen, ob alle Voraussetzungen erfüllt sind.

## Einstellungen

Die Konfiguration des Plugins erfolgt wie bei vielen anderen
CMSimple_XH-Plugins auch im Administrationsbereich der Website.
Gehen Sie zu `Plugins` → `Themeswitcher`.

Sie können die Original-Einstellungen von Themeswitcher_XH unter
`Konfiguration` ändern. Beim Überfahren der Hilfe-Icons mit der Maus
werden Hinweise zu den Einstellungen angezeigt.

Die Lokalisierung wird unter `Sprache` vorgenommen. Sie können die
Sprachtexte in Ihre eigene Sprache übersetzen, falls keine entsprechende
Sprachdatei zur Verfügung steht, oder diese Ihren Wünschen gemäß anpassen.

Das Aussehen von Themeswitcher_XH kann unter `Stylesheet` angepasst werden.

## Verwendung

Sie können Themeswitcher-Widgets manuell entweder im Template:

    <?=themeswitcher()?>

oder auf einzelnen Seiten einbinden:

    {{{themeswitcher()}}}

Dies ermöglicht es Ihren Besuchern ihr bevorzugtes Theme auszuwählen. Diese
Wahl wird in einem Cookie gespeichert, so dass das gewählte Theme für den
Rest der Browser-Sitzung aktiv bleibt. Sie können konfigurieren, ob
seitenspezifische Templates (per `page_params` definiert) die
Benutzerauswahl überschreiben oder nicht.

Wenn Sie viele Templates zur Auswahl haben, und Sie wollen einen
Themeswitcher auf allen Seiten anbieten, können Sie die entsprechende
Konfigurationsoption nutzen. Dann wird das Widget am Ende des Templates
ausgegeben. Die Vorgabe-Style-Regeln platzieren es unten links im Ansichtsfenster.

Es nicht unbedingt notwendig Besuchern ein Themeswitcher-Widget zu zeigen.
Statt dessen können auch ein oder mehrere Links angezeigt werden, so dass
jene das Template auswählen können. Verwenden Sie das Themeswitcher-Widget
um zu sehen, wie die URL dieser Links auszusehen hat.

## Einschränkungen

Seit CMSimple_XH 1.6 gelten seitenspezifische Templates ebenfalls für
Unterseiten (falls nicht ausdrücklich übersteuert). Dies wird bei
Themeswitcher_XH allerdings nicht berücksichtigt.

## Problembehebung

Melden Sie Programmfehler und stellen Sie Supportanfragen entweder auf
[Github](https://github.com/cmb69/themeswitcher_xh/issues)
oder im [CMSimple_XH Forum](https://cmsimpleforum.com/).


## Lizenz

Themeswitcher_XH ist freie Software. Sie können es unter den Bedingungen
der GNU General Public License, wie von der Free Software Foundation
veröffentlicht, weitergeben und/oder modifizieren, entweder gemäß
Version 3 der Lizenz oder (nach Ihrer Option) jeder späteren Version.

Die Veröffentlichung von Themeswitcher_XH erfolgt in der Hoffnung, daß es
Ihnen von Nutzen sein wird, aber *ohne irgendeine Garantie*, sogar ohne
die implizite Garantie der *Marktreife* oder der *Verwendbarkeit für einen
bestimmten Zweck*. Details finden Sie in der GNU General Public License.

Sie sollten ein Exemplar der GNU General Public License zusammen mit
Themeswitcher_XH erhalten haben. Falls nicht, siehe <https://www.gnu.org/licenses/>.

Copyright © Christoph M. Becker

Slowakische Übersetzung © Dr. Martin Sereday

## Danksagung

Themeswitcher_XH wurde von Templateshift von *olape* und *xhomie* angeregt.

Das Plugin-Icon wurde von newmooon entworfen.
Vielen Dank für die Veröffentlichung unter GPL.

Vielen Dank an die Gemeinschaft im [CMSimple_XH-Forum](https://www.cmsimpleforum.com/)
für Tipps, Anregungen und das Testen.

Und zu guter letzt vielen Dank an [Peter Harteg](https://www.harteg.dk/),
den „Vater“ von CMSimple, und allen Entwicklern von
[CMSimple_XH](https://www.cmsimple-xh.org/de/) ohne die es dieses
phantastische CMS nicht gäbe.
