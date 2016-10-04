/**
 * Structure par défaut de tout nouveau module
 */

module.exports = function(context){

	"use strict";

	require('../vendors/backstretch');

	function homeBackground(){

		$('.login').backstretch("images/bg-breme.jpg");

	}
	

	function init(){
		homeBackground();
	}

	return {
		ready : init
	}

};