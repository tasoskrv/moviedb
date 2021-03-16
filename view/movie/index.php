<fieldset class="formset">
    <legend><?=Lang::load("new_movie")?></legend>
    <p class="messages empty_msg"><?=Lang::load("fill_required_movie")?></p>
    <p class="messages error_msg"><?Lang::load("error_movie")?></p>
    <p class="messages success_msg"><?=Lang::load("added_movie")?></p>
    <ul>        
        <li>
           <label class="check_title"><?=Lang::Load('IMDB ID')?> </label><br/>
           <input type="text" id="imdb" class="textfield" size="50" autocomplete="off"/>  
           <input type="button" id="imdb_jq" value="get imdb"/>
        </li>
         <br/><br/>        
        <li>
            <label class="check_title"><?= Lang::load('title_movie') ?> </label><br/>
            <input type="text" id="title" class="textfield" size="50" autocomplete="off"/> 
        </li>
        <li>
            <label class="check_title"><?= Lang::load('year_movie') ?> </label><br/>
            <select id="year">
                <?php
                for($i=1990;$i<2020;$i++):
                ?>
                <option value="<?=$i?>"><?=$i?></option>
                <?php
                endfor;
                ?>
            </select>
        </li>
        <br/><br/>
        <li>
            <label><?=Lang::load('rating')?><br/>
            <input type="text" id="rating" class="textfield"/>
        </li>
        <li>
            <label><?=Lang::load('runtime')?><br/>
            <input type="text" id="runtime" class="textfield"/>
        </li>
        <br/><br/>
        
        
        <li>
            <label class="check_title"><?= Lang::load('category_movie') ?> </label><br/>
            <?php
            $categories = json_decode($this->category);
            ?>
            <select id="idcategory">
                <?php
                foreach($categories as $data):
                ?>
                <option value="<?=$data->idcategory?>"><?=$data->category?></option>
                <?php
                endforeach;
                ?>
            </select>
            <br/><br/>
            
            <label><?= Lang::load('plot_movie') ?> </label><br/>
            <textarea id="plot" cols="60" rows="5" class="textareafield">

            </textarea>
            
            <br/><br/>
            
            <input type="hidden" id="poster"/>
           
            <form name="userimage" id="userimage" method="post" autocomplete="off" action="<?=URL?>movie/uploadPhoto" enctype="multipart/form-data" target="photoframe">
                
                <label class="normal_settings"><?= Lang::load('userphoto_us_manage'); ?></label><br/>
                <input type="file" id="userphoto" name="image"/>         
                <input type="hidden" id="idmovie" name="idmovie"/>         
                <input type="hidden" name="type" value="add" />
                <input type="button" value="<?=Lang::load('create_button')?>" class="submit addmovie_jq" data-button="addmovie" data-type="add"/>
            </form>
            
            <!--
            <input type="button" value="<?=Lang::load('create_button')?>" class="submit addmovie_jq" data-button="addmovie" data-type="add"/>
            -->            
        </li>
    </ul>
    <iframe width="600" height="600" style="display: none" name="photoframe"></iframe>
    
    <img src="<?=URL?>public/images/loader.gif" class="loading"/>
</fieldset>

























                    
                    
                    
