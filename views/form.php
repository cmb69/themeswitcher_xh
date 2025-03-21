<?php

use Plib\View;

if (!defined("CMSIMPLE_XH_VERSION")) {header("HTTP/1.1 403 Forbidden"); exit;}

/**
 * @var View $this
 * @var string $class 
 * @var string $selected
 * @var list<array{name:string,selected:string}> $themes
 */
?>
<!-- themeswitcher selector -->
<form class="themeswitcher_select_form <?=$this->esc($class)?>" method="get">
  <input type="hidden" name="selected" value="<?=$this->esc($selected)?>">
  <label>
    <span><?=$this->text('label_theme')?></span>
    <select name="themeswitcher_select" onchange="this.form.submit()">
<?foreach ($themes as $theme):?>
      <option value="<?=$this->esc($theme['name'])?>" <?=$this->esc($theme['selected'])?>><?=$this->esc($theme['name'])?></option>
<?endforeach?>
    </select>
  </label>
  <button class="themeswitcher_button"><?=$this->text('label_activate')?></button>
</form>
<script>
  Array.prototype.forEach.call(document.getElementsByClassName("themeswitcher_button"), function (button) {
    button.style.display = "none";
  });
</script>
