<?php

$actor = json_decode($this->actor_details);
$movies = json_decode($this->actor_movies);

if($movies->completed!="ok" || $actor->completed!="ok"){
    exit;
}

$actorMovies = $movies->dataMovies;
$actorDetails = $actor->data[0];
?>

<fieldset class="formset">
    
    <span><?=$actorDetails->name?></span>
    <img src="<?=URL?>public/images/actors/<?=$actorDetails->image?>" width="214" height="321"/>
    <?php
    foreach ($actorMovies as $movie):
    ?>    
        <p><?=$movie->title;?></p>
    <?php    
    endforeach;
    ?>
</fieldset>