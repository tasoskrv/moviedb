<?php
$dataMovie = json_decode($this->movie);

if($dataMovie->completed!="ok"){
    exit;
}

$idmovie = $dataMovie->data[0]->idmovie;
$title = $dataMovie->data[0]->title;
$year = $dataMovie->data[0]->year;
$idcategory = $dataMovie->data[0]->idcategory;
$image = $dataMovie->data[0]->image;
$rating = $dataMovie->data[0]->rating;
$runtime = $dataMovie->data[0]->runtime;
$plot = $dataMovie->data[0]->plot;
$imdb = $dataMovie->data[0]->imdb;


if(!$image)
    $image = "default.jpg";

?>

<fieldset class="formset">
    <legend><?=Lang::load("new_movie")?></legend>
    <p class="messages empty_msg"><?=Lang::load("fill_required_movie")?></p>
    <p class="messages error_msg"><?Lang::load("error_movie")?></p>
    <p class="messages success_msg"><?=Lang::load("added_movie")?></p>
    <ul>
        <li>
           <label class="check_title"><?=Lang::Load('IMDB ID')?> </label><br/>
           <input type="text" id="imdb" class="textfield" size="50" autocomplete="off" value="<?=$imdb?>"/>  
           <input type="button" id="imdb_jq" value="get imdb"/>
        </li>
        <br/><br/>
        <li>
            <label class="check_title"><?= Lang::load('title_movie') ?> </label><br/>
            <input type="text" id="title" class="textfield" size="50" autocomplete="off" value="<?=$title?>"/> 
        </li>
        <li>
            <label class="check_title"><?= Lang::load('year_movie') ?> </label><br/>
            <select id="year">
                <?php
                $selected = "";
                for($i=1990;$i<2020;$i++):
                    if($i==$year)
                        $selected = "selected";
                ?>
                <option value="<?=$i?>" <?=$selected?>><?=$i?></option>
                <?php
                $selected = "";
                endfor;
                ?>
            </select>
        </li>
        <br/><br/>
        
        <li>
            <label><?=Lang::load('rating')?><br/>
            <input type="text" id="rating" class="textfield" value="<?=$rating?>"/>
        </li>
        <li>
            <label><?=Lang::load('runtime')?><br/>
            <input type="text" id="runtime" class="textfield" value="<?=$runtime?>"/>
        </li>
        
        <br/><br/>        
        
        <li>
            <label class="check_title"><?= Lang::load('category_movie') ?> </label><br/>
            <?php
            $categories = json_decode($this->category);
            ?>
            <select id="idcategory">
                <?php
                $selected = "";
                foreach($categories as $data):
                    if($idcategory==$data->idcategory)
                        $selected = "selected";
                ?>
                <option value="<?=$data->idcategory?>" <?=$selected?> ><?=$data->category?></option>
                <?php
                $selected = "";
                endforeach;
                ?>
            </select>
            
            <img src="<?=URL?>public/images/movies/<?=$image?>" />
            <input type="hidden" id="poster"/>
            
            <br/><br/>
            <textarea cols="60" rows="5" id="plot"><?=$plot?></textarea>
            <br/><br/>
            
            <form name="userimage" id="userimage" method="post" autocomplete="off" action="<?=URL?>movie/uploadPhoto" enctype="multipart/form-data" target="photoframe">                
                <label class="normal_settings"><?= Lang::load('userphoto_us_manage'); ?></label><br/>
                <input type="file" id="userphoto" name="image"/>         
                <input type="hidden" id="idmovie" name="idmovie" value="<?=$idmovie?>"/>         
                <input type="hidden" name="type" value="edit" />
                <input type="button" value="<?=Lang::load('create_button')?>" class="submit addmovie_jq" data-button="addmovie" data-type="edit"/>
            </form>
            
            <input type="hidden" id="idmovie" name="idmovie" value="<?=$idmovie?>"/> 
            
        </li>
    </ul>
    <iframe width="50" height="50" style="display: none" name="photoframe"></iframe>
    
    <img src="<?=URL?>public/images/loader.gif" class="loading"/>
</fieldset>

