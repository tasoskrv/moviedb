$(document).ready(function(){
   $(document).on('click','.addmovie_jq',xhrAddMovie);
   $(document).on('click','#imdb_jq',xhrGetIMDB);
});


function xhrGetIMDB(){
    
    var imdb = $('#imdb').val();
    var data = {
        imdb : imdb
    };
    data = JSON.stringify(data);
    $.post(URL+"movie/xhrGetImdb",{data:data},function(out){      
       var response = JSON.parse(out);             
       var genres = response.genres.split(","),
           category = genres[0],           
           title    = response.title,
           year     = response.year,
           rating   = response.rating,
           runtime  = response.runtime.replace(/[^0-9]/g, ''),
           poster   = response.poster,
           plot     = response.plot;
          
        $('#title').val(title);
        $('#rating').val(rating);
        $('#runtime').val(runtime);
        $("#year > option").each(function() {          
            if(this.value == year){
                $("#year").val(this.value);              
            }
        });
        $("#idcategory > option").each(function() {          
            if(this.text == category){
                $("#idcategory").val(this.value);              
            }
        });            
        $('#poster').val(poster); 
        $('#plot').val(plot); 
    });
}


function xhrAddMovie(){
    $('.messages').hide();
    var type = $(this).data("type");
    var button = "."+$(this).data("button")+"_jq";
    $(button).attr('disabled', 'disabled');
    $(button).addClass('disable_button');
    var obj = new Object();
    obj.title = $('#title').val();
    obj.imdb = $('#imdb').val();
    if(obj.title.trim()==="" || obj.imdb.trim()===""){
        $('#title').removeClass("error_input");
        $('#imdb').removeClass("error_input");
        if(obj.title.trim()===""){
            $('#title').addClass("error_input");
            $('.check_name').addClass("error_text");
        }
        if(obj.imdb.trim()===""){
            $('#imdb').addClass("error_input");
            $('.check_name').addClass("error_text");
        }
        $(button).removeAttr('disabled');
        $(button).removeClass('disable_button');
        $('.empty_msg').show();
    }else{
        $('.loading').show();
        obj.year = $("#year").val();
        obj.idcategory = $("#idcategory").val();
        obj.rating = $("#rating").val();
        obj.runtime = $("#runtime").val();
        obj.poster = $("#poster").val();
        obj.plot = $("#plot").val();
        
        var urlAct;
        if(type==="add"){
            urlAct = "xhrAddMovie";
        }else if(type==="edit"){
            urlAct = "xhrEditMovie";
            obj.idmovie = $("#idmovie").val();
        }
        var data = JSON.stringify(obj);
        $.post(URL+"movie/"+urlAct,{data:data},function(out){            
            $('.loading').hide();
            $(button).removeAttr('disabled');
            var response = JSON.parse(out);
            if(response.completed==="ok"){
               $('#idmovie').val(response.idmovie);
               $('#userimage').submit();
               if(type==="add"){
                   $('.textfield').val("");
                   $('.textareafield').val("");
               }
               $('.textfield').removeClass("error_input");
               $('label').removeClass("error_text");
               $(button).removeClass('disable_button');
               $('.success_msg').show();
            }
        });        
    }
}


/*
 
function userPhoto(){
    $('#userimage').submit();
}

function newpic(pic,msg){
    if(msg == "ok"){        
        $('#image').attr("src", pic);
        $('#userphoto').val("");        
        $('#header_image_person').attr("src", pic);        
        $('#error3').hide();
        $('#nomatch3').hide();
        $('#success3').show();        
        messages(3, "correct");        
    }else if(msg == "tryagain"){                
        $('#userphoto').val("");
        $('#error3').hide();
        $('#nomatch3').show();
        $('#success3').hide();        
        messages(3, "error");                        
    }else if(msg == "wrongtype"){
        $('#userphoto').val("");
        $('#error3').show();
        $('#nomatch3').hide();
        $('#success3').hide();        
        messages(3, "error");                
    }
} 
 */