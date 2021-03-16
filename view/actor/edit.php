<?php
$data = json_decode($this->actor);
$dataMovies = json_decode($this->movies);

if($data->completed!="ok" && $dataMovies->completed!="ok"){
    exit;
}

$idactor = $data->data[0]->idactor;
$name = $data->data[0]->name;
$image = $data->data[0]->image;
?>

<fieldset class="formset">
    <legend><?=Lang::load("new_actor")?></legend>
    <p class="messages empty_msg"><?=Lang::load("fill_required_actor")?></p>
    <p class="messages error_msg"><?Lang::load("error_actor")?></p>
    <p class="messages success_msg"><?=Lang::load("added_actor")?></p>

    <table>
        <tr>
            <td>
                <ul>
                    <li>
                        <label class="check_title"><?= Lang::load('name_actor') ?> </label><br/>
                        <input type="text" id="name" value="<?= $name ?>" class="textfield" size="50" autocomplete="off"/> 
                    </li>
                    <li>
                        <label class="check_title"><?= Lang::load('movies_actor') ?> </label><br/>
                        <input type="text" id="movies" class="selectmovie_jq textfield" size="50" autocomplete="off"/> 
                    </li>
                    <br/><br/>
                </ul>
            </td>
            <td>
                <img src="<?=URL?>public/images/actors/<?=$image?>" width="214" height="321"/>
            </td>
        </tr>
    </table>
    
    <div id="actor_movies">
        <?php        
        $count = 1;
        foreach ($dataMovies->dataMovies as $movie):
        ?>
            <span class="actor_movie" id="movie<?= $count ?>" data-id="<?= $movie->idmovie ?>">
                <?=$movie->title?> 
                <span class="remove_actor_movie remove_movie_jq" data-count="<?= $count ?>">x</span>   
            </span>&nbsp;  
        <?php
            $count++;
        endforeach;
        ?>
    </div>
    
    <form name="userimage" id="userimage" method="post" autocomplete="off" action="<?=URL?>actor/uploadPhoto" enctype="multipart/form-data" target="photoframe">
        <!--<img id="image" width="34" height="34"/>-->
        <label class="normal_settings"><?= Lang::load('userphoto_us_manage'); ?></label><br/>
        <input type="file" id="userphoto" name="image"/>         
        <input type="hidden" id="id_reffer" name="id_reffer" value="<?=$idactor?>"/>         
        <input type="hidden" name="type" value="edit" />
        <input type="button" value="<?=Lang::load('create_button')?>" class="submit addactor_jq" data-type="edit"/>
    </form>
    <iframe width="600" height="600" style="display: none" name="photoframe"></iframe>
    
    <input type="hidden" id="idactor" name="idactor" value="<?=$idactor?>"/>      
    <img src="<?=URL?>public/images/loader.gif" class="loading"/>
</fieldset>


