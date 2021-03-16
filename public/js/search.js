$(function(){

  $('.loadmore').on('click', function(){    
     var obj = {         
         start : $('.movies').length,
         type  : $(this).data('type')
     },
     data = JSON.stringify(obj);     
    $.post(URL+"search/loadMoreResults",{data:data},function(out){
         $.post(URL+"search/loadMoreResultsHTML",{out:out},function(response){
            $('#movies_content_area').append(response);
         });
     });
  })


});