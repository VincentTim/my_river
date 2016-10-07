module.exports = function(context){

    "use strict";

    require('fancybox/dist/js/jquery.fancybox.js');
    require('fancybox/dist/helpers/js/jquery.fancybox-thumbs.js')

    function fancyCollection(){
        $(".fancybox").fancybox();
    }

    function init(){
        fancyCollection();
    }

    return {
        ready : init
    }

};