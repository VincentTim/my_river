/**
 * Structure par défaut de tout nouveau module
 */

module.exports = function(context){

	"use strict";

	require('../vendors/backstretch');

	function homeBackground(){

		$('.panorama').backstretch("dist/images/bg_col.jpg");
		$('.panorama').prepend('<div class="overlay-bg"></div>');

	}
	

	function init(){
		homeBackground();
	}

	return {
		ready : init
	}

};