<?php

use Plib\View;

if (!defined("CMSIMPLE_XH_VERSION")) {header("HTTP/1.1 403 Forbidden"); exit;}

/**
 * @var View $this
 * @var string $version
 * @var list<array{class:string,key:string,arg:string,statekey:string}> $checks
 */
?>
<!-- themeswitcher info -->
<h1>Themeswitcher <?=$this->esc($version)?></h1>
<div>
  <h2><?=$this->text('syscheck_title')?></h2>
<?foreach ($checks as $check):?>
  <p class="<?=$this->esc($check['class'])?>"><?=$this->text($check['key'], $check['arg'])?><?=$this->text($check['statekey'])?></p>
<?endforeach?>
</div>
