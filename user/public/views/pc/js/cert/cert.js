/**
 * ��֤ҳ��js
 * author:weipinglee
 * date:2016/4/29
 */

//�л�tab
function nextTab(){
    $('.rz_ul').find('.cur').next('li').find('a').trigger('click');

}

//ȥ��֤
function toCertApply(){
    var url = $('form').attr('action');

    $.ajax({
        'url' :  url,
        'type' : 'post',
        'data' : $('form').serialize(),
        'dataType': 'json',
        'success' : function(data){
            alert(JSON.stringify(data));
        },
        'complate': function(){

        }

    })

}


