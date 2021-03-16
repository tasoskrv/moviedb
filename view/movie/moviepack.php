<?php
if(isset($_POST['data'])):
    $movieArray = $_POST['data'];    
    $idmovie = $movieArray['idmovie'];
    $movie = $movieArray["value"];
    $count = $_POST['count']; 
?>

<span class="actor_movie" id="movie<?=$count?>" data-id="<?=$idmovie?>">
    <?=$movie?> 
    <span class="remove_actor_movie remove_movie_jq" data-count="<?=$count?>">x</span>   
</span>&nbsp;  

<?php
endif;
?>