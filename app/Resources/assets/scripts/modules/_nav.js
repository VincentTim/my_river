/**
 * Structure par défaut de tout nouveau module
 */

module.exports = function(context){

	"use strict";

    function dashboardNav(){
        $('.dropdown-btn').click(function(e){
            e.stopPropagation();
            $(this).next('.drop-menu').slideDown();
            if($(this).hasClass('open')){
                $(this).next('.drop-menu').slideUp();    
            }
            $(this).toggleClass('open');
        })
    }
	

	function init(){
        dashboardNav();
	}

	return {
		ready : init
	}

};