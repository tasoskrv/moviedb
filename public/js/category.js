$(document).ready(function(){
   $(document).on('click','.addcategory_jq',xhrAddCategory);
});



function xhrAddCategory(){
    $('.messages').hide();
    var button = "."+$(this).data("button")+"_jq";
    $(button).attr('disabled', 'disabled');
    $(button).addClass('disable_button');
    var obj = new Object();
    obj.category = $('#category').val();
    if(obj.category.trim()===""){
        $('#category').removeClass("error_input");
        if(obj.category.trim()===""){
            $('#category').addClass("error_input");
            $('.check_name').addClass("error_text");
        }
        $(button).removeAttr('disabled');
        $(button).removeClass('disable_button');
        $('.empty_msg').show();
    }else{
        $('.loading').show();
        var data = JSON.stringify(obj);
        $.post(URL+"category/xhrAddCategory",{data:data},function(out){
            console.log(out);
            $('.loading').hide();
            $(button).removeAttr('disabled');
            var response = JSON.parse(out);
            if(response.completed==="ok"){
               $('.textfield').val("");
               $('.textfield').removeClass("error_input");
               $('label').removeClass("error_text");
               $(button).removeClass('disable_button');
               $('.success_msg').show();
            }
        });
        
    }
}




/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


