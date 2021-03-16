<?php
foreach ($this->loadmore as $movie):
    if(!$movie->image){
        $image = "default.jpg";
    }
    else{
        $image = $movie->image;
    }            

    $classSaw = "";
    if(is_numeric($movie->usermovie)){
        $classSaw = "has_seen";
    }
?>


<table class="search_table <?=$classSaw?> movies" id="movie<?=$movie->idmovie?>"> 
    <tr>
        <td class="col1">
            <img src="<?=URL?>public/images/movies/<?=$image?>" width="214" height="321"/>
        </td>
        <td class="col2">
            <div class="movie_details">
                <?=$movie->title?> (<span class="movie_year"><?=$movie->year?></span>)
                <?php
                if (Session::get('role')==1):
                ?>
                <a href="<?=URL?>movie/edit/<?=$movie->idmovie?>"><img src="<?=URL?>public/images/edit.png" /></a>
                <?php
                endif;
                ?>
            </div>
            <span class="movie_category"><?= $movie->category ?></span>   
            <?=$movie->runtime?>min / <?=$movie->rating?> 
            <br/><br/>
            <div class="search_plot">
                <?=$movie->plot?>
            </div>
            <?php
            if (Session::get('role')==1 || Session::get('role')==2):
            ?>        
            <p class="button_area">
                <input type="button" value="<?=Lang::load("hasseen_search")?>" 
                       class="watch_status_jq" data-status="1" data-id="<?=$movie->idmovie?>"/>                        
                <input type="button" value="<?=Lang::load("noseen_search")?>" 
                       class="watch_status_jq" data-status="0" data-id="<?=$movie->idmovie?>"/>
            </p>
            <?php
            endif;
            ?>
        </td>
    </tr>
</table>

<br/>

<?php
endforeach;
?>

