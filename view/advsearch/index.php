<div>
    <p class="advsearch_cls">Advanced Search</p>

    <form method="get" action="<?=URL?>search" class="advsearchform_cls">

        <table class="advsearchtable_cls">
            <tr>
                <td>
                    Keyword
                </td>
                <td>
                    <input type="text" name="keyword" class="advfields_cls" value="<?=  System::advancedSearchValues('keyword')?>"/>
                </td>                
            </tr>
            <tr>
                <td>
                    category
                </td>
                <td>
                    <?php
                    $categories = json_decode($this->category);
                    ?>
                    <select name="category" class="advfields_cls">
                        <option value="0">All Categories</option>
                        <?php
                        foreach($categories as $data):
                            $selected = "";
                            $idcategory = $data->idcategory;
                            if(System::advancedSearchValues('category') == $idcategory)
                                $selected = "selected";
                        ?>
                        <option value="<?=$idcategory?>" <?=$selected?>><?=$data->category?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </td>                
            </tr>
           <tr>
                <td>
                    Year From
                </td>
                <td>
                    <select name="yearfrom" class="advfields_cls">
                        <?php
                        for($i=1990;$i<2020;$i++):
                            $selected = "";
                            if(System::advancedSearchValues('yearfrom') == $i)
                                $selected = "selected";
                        ?>
                        <option value="<?=$i?>" <?=$selected?>><?=$i?></option>
                        <?php
                        endfor;
                        ?>
                    </select>
                </td>                
            </tr>
           <tr>
                <td>
                    Year To
                </td>
                <td>
                    <select name="yearto" class="advfields_cls">
                        <?php
                        for($i=1990;$i<2020;$i++):
                            $selected = "";
                            if(System::advancedSearchValues('yearto') == $i)
                                $selected = "selected";
                        ?>
                        <option value="<?=$i?>" <?=$selected?>><?=$i?></option>
                        <?php
                        endfor;
                        ?>
                    </select>
                </td>                
            </tr>            
           <tr>
                <td>
                    rating
                </td>
                <td>
                    <select name="rating" class="advfields_cls">
                        <?php
                        for($i=1;$i<10;$i++):
                            $selected = "";
                            if(System::advancedSearchValues('rating') == $i)
                                $selected = "selected";
                        ?>
                        <option value="<?=$i?>" <?=$selected?>> >=<?=$i?> </option>
                        <?php
                        endfor;
                        ?>
                    </select>
                </td>                
            </tr>          
           <tr>
                <td>
                    search for movies
                </td>
                <td>
                    <?php
                    $checkedNotSeen = "";
                    $checkedAll = "";
                    $checkedSeen = "";
                    if(System::advancedSearchValues('searchfor') == -1)
                        $checkedNotSeen = "checked";
                    else if(System::advancedSearchValues('searchfor') == 0)
                        $checkedAll = "checked";
                    else if(System::advancedSearchValues('searchfor') == 1)
                        $checkedSeen = "checked";
                    else
                        $checkedSeen = "checked";
                    ?>
                    <table class="advinlinetable_cls">
                        <tr>
                            <td>Seen</td>
                            <td><input type="radio" value="1" name="searchfor" <?=$checkedSeen?>></td>
                        </tr>
                        <tr>
                            <td>Not Seen</td>
                            <td><input type="radio" value="-1" name="searchfor" <?=$checkedNotSeen?>></td>
                        </tr>
                        <tr>
                            <td>All</td>
                            <td><input type="radio" value="0" name="searchfor" <?=$checkedAll?>></td>
                        </tr>                        
                    </table>                    
                </td>                
            </tr>
           <tr>
                <td></td>
                <td>
                    <input type="submit" value="Search" class="advsubmit_cls"/>
                </td>                
            </tr>              
        </table>
    </form>
</div>
<br><br><br><br>
