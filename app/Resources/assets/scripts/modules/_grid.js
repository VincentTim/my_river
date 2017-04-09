/**
 * Structure par défaut de tout nouveau module
 */

module.exports = function(context){

	"use strict";

	require('../vendors/isotope');

	function init(){
		$('.container').isotope({
			itemSelector: '.element',
			layoutMode: 'fitRows'
		});
	}

	return {
		ready : init
	}

};