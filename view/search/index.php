<div class="content">

<?php
foreach ($this->search as $key => $value) {
    switch ($key) {
        case "movies":
            $movies = $value;
            break;
        /*
        case "actors":
            $actors = $value;
            $count_actors = count($actors);
            break;
        */
    }
}

$count_movies = $this->total_movies->total[0]->total;

?>
<fieldset class="formset">
   
    <legend><?=Lang::load('search_results')?></legend>   
    <br/>
    <span style="color:orange"><?=Lang::load('search_all')?> </span> * |
    <span style="color:orange"><?=Lang::load('search_have_seen')?> </span>1* |
    <span style="color:orange"><?=Lang::load('search_not_have_seen')?> </span>2* |
    <span style="color:orange"><?=Lang::load('search_last50')?> </span> <> |
    <span style="color:orange"><?=Lang::load('search_bigger_rate_than')?> </span> > |
    <span style="color:orange"><?=Lang::load('search_actors')?> </span> #
    <ul class="tabs">
        <li class="tab-link current" data-tab="tab-1">Movies <?=$count_movies?></li>
        <!--
        <li class="tab-link" data-tab="tab-2">Actors <?=$count_actors?></li>
        -->
    </ul>    
    <div id="tab-1" class="tab-content current content_tab">
        <div id="movies_content_area">
        <?php
        foreach ($movies as $movie):
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
                    
                    <div class="wrapper">
                        <img src="<?=URL?>public/images/movies/<?=$image?>" width="214" height="321" data-title="<?=$movie->plot?>"/>
                        <div class="tooltip"><?=$movie->plot?></div>
                    </div>
                    
                    
                </td>
                <td class="col2">
                    <div class="movie_details">
                        <?=$movie->title?> (<span class="movie_year"><?=$movie->year?></span>)
                        <?php
                        if (Cookie::get('role')==1):
                        ?>
                        <a href="<?=URL?>movie/edit/<?=$movie->idmovie?>"><img src="<?=URL?>public/images/edit.png"/></a>
                        <?php
                        endif;
                        ?>
                        <a href="http://www.imdb.com/title/<?=$movie->imdb?>/" target="_blank" class="imdb_link">imdb</a>
                    </div>
                    <span class="movie_category"><?= $movie->category ?></span>   
                    <?=$movie->runtime?>min / <?=$movie->rating?> 
                    <br/><br/>
                    <div class="search_plot">
                        <?=$movie->plot?>
                    </div>
                    <?php
                    if (Cookie::get('role')==1 || Cookie::get('role')==2):
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
        </div>
        <br/>
        <div class="load_div">
            <span class="loadmore" data-type="<?=$this->searchType?>">LOAD MORE</span>
        </div>
        <br/>
    </div>
    <!--
    <div id="tab-2" class="tab-content content_tab">
        <?php
        foreach ($actors as $actor):
            if(!isset($actor->image)){
                $image = "default.jpg";
            }
            else{
                $image = $actor->image;
            } 
        ?>    
        <table class="search_table" id="movie<?=$actor->idactor?>"> 
            <tr>
                <td class="col1">
                    <img src="<?=URL?>public/images/actors/<?=$image?>" width="214" height="321"/>
                </td>
                <td class="col2">
                    <div class="movie_details">                        
                        <a href="<?=URL?>actor/movies/<?=$actor->idactor?>"><?=$actor->name?></a>
                        <?php
                        if (Cookie::get('role')==1):
                        ?>
                        <a href="<?=URL?>actor/edit/<?=$actor->idactor?>"><img src="<?=URL?>public/images/edit.png" /></a>
                        <?php
                        endif;
                        ?>
                    </div>                                                                                            
                </td>
            </tr>
        </table>
        <br/>
        
        <?php
        endforeach;
        ?>
    </div>
    -->
    
</fieldset>
    
</div>


