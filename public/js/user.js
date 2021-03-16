$(document).ready(function(){
   $(document).on('click','.watch_status_jq',xhrWatchedMovies);
});


function xhrWatchedMovies(){    
    var obj = new Object();
    var status = $(this).data("status");
    obj.id = $(this).data("id");
    var url;
    if(status===1){//update/insert
        url = URL+"user/xhrWatchedMovie";
    }else{//delete
        url = URL+"user/xhrNotWatchedMovie";
    }
    var data = JSON.stringify(obj);
    $.post(url,{data:data},function(out){
        var response = JSON.parse(out);        
        if(response.completed==="ok"){                    
            if(status===1){
                $('#movie'+obj.id).addClass("has_seen");
            }else{
                $('#movie'+obj.id).removeClass("has_seen");
            }            
        }else{
            alert("Ooooops Something went wrong. I am bored to fix this now");            
        }        
    });        
}