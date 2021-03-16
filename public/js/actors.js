$(document).ready(function(){
   $(document).on('click','.addactor_jq',xhrAddActor);
   $(document).on('click','.selectmovie_jq',xhrSelectMovie);
   $(document).on('click','.remove_movie_jq',removeMovie);   
});

function xhrAddActor(){
    
    $('.messages').hide();
    $('.addactor_jq').attr('disabled', 'disabled');
    $('.addactor_jq').addClass('disable_button');
    var type = $(this).data("type");
    var obj = new Object();
    obj.name = $('#name').val();
    if(obj.name.trim()===""){
        $('#name').removeClass("error_input");
        if(obj.name.trim()===""){
            $('#name').addClass("error_input");
            $('.check_name').addClass("error_text");
        }
        $('.addactor_jq').removeAttr('disabled');
        $('.addactor_jq').removeClass('disable_button');
        $('.empty_msg').show();
    }else{
        
        var idmovies = [];
        $('#actor_movies .actor_movie').each(function(){            
            var idmovie = $(this).data("id");
            var item = {idmovie:idmovie};
            idmovies.push(item);
        });
        var movies = JSON.stringify(idmovies);
        $('.loading').show();        
        var url;
        if(type==="insert"){
            url = URL+"actor/xhrAddActor";
        }else if(type==="edit"){
            url = URL+"actor/xhrEditActor";
            obj.idactor = $("#idactor").val();
        }
        var data = JSON.stringify(obj);
        $.post(url,{data:data,movies:movies},function(out){
            $('.loading').hide();
            $('.addactor_jq').removeAttr('disabled');
            var response = JSON.parse(out);
            if(response.completed==="ok"){
               $('#id_reffer').val(response.idactor);
               $('#userimage').submit();
               if(type==="insert"){
                   $('.textfield').val("");
                   $('#actor_movies').html("");
               }else if(type==="edit"){
                   
               }
               $('.textfield').removeClass("error_input");
               $('label').removeClass("error_text");
               $('.addactor_jq').removeClass('disable_button');
               $('.success_msg').show();
            }
        });
    }
}

function xhrSelectMovie(){
    $("#movies").autocomplete({
        source: URL+"movie/xhrSelectMovie",
        minLength:1,
        select: function(event,ui) {	      
            var count = $('.actor_movie').length+1;
            $.post(URL+"movie/addHtmlMovie",{data:ui.item,count:count},function(out){               
                $("#actor_movies").append(out);
                $("#movies").val("");
            });            
        }
    }); 
}

function removeMovie(){    
    var count = $(this).data("count");
    $('#movie'+count).remove();    
}
