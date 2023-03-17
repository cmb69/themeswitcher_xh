<?php

use Themeswitcher\Infra\View;

/**
 * @var View $this
 * @var string $selected
 * @var int $run
 * @var list<stdClass> $themes
 */
?>
<form class="themeswitcher_select_form" method="get">
    <input type="hidden" name="selected" value="<?=$selected?>">
    <label for="themeswitcher_<?=$run?>"><?=$this->text('label_theme')?></label>
    <select id="themeswitcher_<?=$run?>" name="themeswitcher_select" onchange="this.form.submit()">
<?php foreach ($themes as $theme):?>
        <option value="<?=$theme->name?>" <?=$theme->selected?>><?=$theme->name?></option>
<?php endforeach?>
    </select>
    <button id="themeswitcher_button_<?=$run?>"><?=$this->text('label_activate')?></button>
</form>
<script>
    document.getElementById("themeswitcher_button_<?=$run?>").style.display = "none";
</script>
