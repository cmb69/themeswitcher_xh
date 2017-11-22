<form class="themeswitcher_select_form" method="get">
    <input type="hidden" name="selected" value="<?=$selected?>">
    <label for="themeswitcher_<?=$run?>"><?=$this->text('label_theme')?></label>
    <select id="themeswitcher_<?=$run?>" name="themeswitcher_select">
<?php foreach ($themes as $theme):?>
        <option value="<?=$theme->name?>" <?=$theme->selected?>><?=$theme->name?></option>
<?php endforeach?>
    </select>
    <button><?=$this->text('label_activate')?></button>
</form>
