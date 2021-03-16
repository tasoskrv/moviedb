<fieldset class="formset">
    <legend><?=Lang::load("new_category")?></legend>
    <p class="messages empty_msg"><?=Lang::load("fill_required_category")?></p>
    <p class="messages error_msg"><?Lang::load("error_category")?></p>
    <p class="messages success_msg"><?=Lang::load("added_category")?></p>
    <ul>
        <li>
            <label class="check_title"><?= Lang::load('category_category') ?> </label><br/>
                <input type="text" id="category" class="textfield" size="50" autocomplete="off"/> 
        </li>
        <br/><br/>
    </ul>
    <input type="button" value="<?=Lang::load('create_button')?>" class="submit addcategory_jq" data-button="addcategory"/>
    <img src="<?=URL?>public/images/loader.gif" class="loading"/>
</fieldset>

