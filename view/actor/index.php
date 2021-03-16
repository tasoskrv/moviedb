<fieldset class="formset">
    <legend><?=Lang::load("new_actor")?></legend>
    <p class="messages empty_msg"><?=Lang::load("fill_required_actor")?></p>
    <p class="messages error_msg"><?Lang::load("error_actor")?></p>
    <p class="messages success_msg"><?=Lang::load("added_actor")?></p>
    <ul>
        <li>
            <label class="check_title"><?= Lang::load('name_actor') ?> </label><br/>
            <input type="text" id="name" class="textfield" size="50" autocomplete="off"/> 
        </li>
        <li>
            <label class="check_title"><?= Lang::load('movies_actor') ?> </label><br/>
            <input type="text" id="movies" class="selectmovie_jq textfield" size="50" autocomplete="off"/> 
        </li>
        <br/><br/>
    </ul>
    
    <div id="actor_movies"></div>
    
    <form name="userimage" id="userimage" method="post" autocomplete="off" action="<?=URL?>actor/uploadPhoto" enctype="multipart/form-data" target="photoframe">
        <!--<img id="image" width="34" height="34"/>-->
        <label class="normal_settings"><?= Lang::load('userphoto_us_manage'); ?></label><br/>
        <input type="file" id="userphoto" name="image"/>         
        <input type="hidden" id="id_reffer" name="id_reffer"/>         
        <input type="hidden" name="type" value="add" />
        <input type="button" value="<?=Lang::load('create_button')?>" class="submit addactor_jq" data-type="insert"/>
    </form>
    <iframe width="600" height="600" style="display: none" name="photoframe"></iframe>
    
    
    <img src="<?=URL?>public/images/loader.gif" class="loading"/>
</fieldset>


