module.exports = function(context){

    "use strict";

    require('fancybox/dist/js/jquery.fancybox.js');
    require('fancybox/dist/helpers/js/jquery.fancybox-thumbs.js')

    function fancyCollection(){
        if($(window).width() > 991){
            $(".fancybox").fancybox();
        } else {
            $(".fancybox").click(function(){
                return false;
            })
        }

    }

    function init(){
        fancyCollection();
    }

    return {
        ready : init
    }

};