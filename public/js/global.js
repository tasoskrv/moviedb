/*scroll
     $(function() {
        $(".product_list").on('scroll', function () {
            if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
            last_msg_funtion($(this).data("number"));
        }
    });
    });*/

$(document).ready(function(){
   $(document).on('click','.close_jq',closeWindow);
});

function closeWindow(){
    var close = $(this).data("close");
    $(close).hide();
}
