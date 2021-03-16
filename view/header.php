<?php
if (session_id() == "") {//session_status() == PHP_SESSION_NONE PHP >=5.4.0
  Session::init();
}
?>
<html>
    <head>
         <meta charset="utf-8" />
        <title>Movies DB</title>
        <!--
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css"/>
        -->
        
        <script src="<?=URL?>public/js/jquery.js"></script>        
        
        <link rel="stylesheet" href="<?=URL?>public/css/mycss.css"/>
        <script type="text/javascript" src="<?=URL?>public/js/constants.js"></script>
        <script type="text/javascript" src="<?=URL?>public/js/global.js"></script>
        <script type="text/javascript" src="<?=URL?>public/js/actors.js"></script>
        <script type="text/javascript" src="<?=URL?>public/js/category.js"></script>
        <script type="text/javascript" src="<?=URL?>public/js/movie.js"></script>
        <script type="text/javascript" src="<?=URL?>public/js/search.js"></script>
        <script type="text/javascript" src="<?=URL?>public/js/user.js"></script>

        <?php
        if(isset($this->js)){
            foreach ($this->js as $js) {
                echo "<script type='text/javascript' src='".URL.'view/'.$js."'></script>";
            }
        }
        ?>
        <script>
            $(document).ready(function(){
                $('ul.tabs li').click(function(){
                    var tab_id = $(this).attr('data-tab');
                    $('ul.tabs li').removeClass('current');
                    $('.tab-content').removeClass('current');
                    $(this).addClass('current');
                    $("#"+tab_id).addClass('current');
                })
            });
            
        </script>
        
    </head>
    <body>
        <div id="main">
        <header id="header">
            

                <div class="menu_div">
                    <ul class="menu">
                    <?php
                    if (Cookie::get('loggedin') == 1 && Cookie::get('role')==1):
                    ?>
                        <li class="moviecls" title="<?= Lang::load('newmovie_menu') ?>">
                             <a href="<?= URL ?>movie"></a>
                         </li>
                         <li class="actorcls" title="<?= Lang::load('newactor_menu') ?>">
                             <a href="<?= URL ?>actor"></a> 
                         </li>
                         <li class="categorycls" title="<?= Lang::load('newcategory_menu') ?>">
                             <a href="<?= URL ?>category"></a>
                         </li>                         
                    <?php endif; ?>
                    <?php
                    if (Cookie::get('loggedin') == 1):
                    ?>     
                         <li class="searchcls" title="<?= Lang::load('search_menu') ?>">                                                         
                             <a href="<?= trim(URL ."advsearch?keyword=".System::advancedSearchValues('keyword').
                                "&category=".System::advancedSearchValues('category')."&yearfrom=".System::advancedSearchValues('yearfrom').
                                "&yearto=".System::advancedSearchValues('yearto')."&rating=".System::advancedSearchValues('rating').
                                "&searchfor=".System::advancedSearchValues('searchfor'))?>
                            "></a>
                         </li>                      
                    <?php endif;?>
                     </ul>
                </div>
                        
            <div id="bar">
                <div class="title">
                    <a href="<?=URL?>/main">Movies Database</a>
                </div>
                <?php 
                if(Cookie::get('loggedin')==1):
                ?>
                    <form method="get" action="<?=URL?>search" id="searchtext" class="searchform">
                        <input type="text" class="search search_jq" name="searchtext"/>
                    </form>                   
                <?php
                endif;
                ?>                
                <div id="start_menu">
                        <?php 
                        if(Cookie::get('loggedin')==1):
                        ?>
                            <a href="<?=URL?>logout" class="noborder"><?=Lang::load('logout_menu')?></a>
                        <?php else: ?>                                
                            <a href="<?=URL?>home" class="hasborder">Αρχική</a>
                            <a href="<?=URL?>login" class="noborder">Login</a>
                        <?php
                        endif;
                        ?>        
                </div>
            </div>
            
        </header>
       
        <br/><br/>