/**
 * Structure par défaut de tout nouveau module
 */

module.exports = function(context){

	"use strict";

	require('../vendors/owlcarousel');

	function carouselDetail(){
		$("#owl-example").owlCarousel(
			{
				items: 1,
				autoPlay: true,
				autoHeight: true
			}
		);
	}

	function init(){
		//carouselDetail();
	}

	return {
		ready : init
	}

};