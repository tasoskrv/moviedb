<br/>
<h3 style="text-align: center">Τελευταίες Καταχωρήσεις</h3>

<?php
$latestEntries = json_decode($this->latestmovies);
?>

<table width="100%">
	<?php
	for($i=0;$i<count($latestEntries);$i++):            
		if($i%4 == 0):		
	?> 	
    <tr>
	<?php
	endif;
	?>    
	<td style="text-align: center;">
            <a href="http://www.imdb.com/title/<?=$latestEntries[$i]->imdb?>/" target="_blank">            
		<img src="<?=URL.'public/images/movies/'.$latestEntries[$i]->image?>" width="200" height="320"/>
            </a>
                <br>            
		<?=$latestEntries[$i]->category?> / <?=$latestEntries[$i]->rating?> (<?=$latestEntries[$i]->year?>)
	</td>
	
	<?php	
	endfor;
	?>  
</table>

