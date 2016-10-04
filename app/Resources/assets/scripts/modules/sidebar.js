/**
 * Structure par défaut de tout nouveau module
 */

module.exports = function(context){

	"use strict";

	function showLoaderState() { $('body').addClass('sidebar--loading'); }
	function hideLoaderState() { $('body').removeClass('sidebar--loading'); }

	function openSidebar(){

			$('.sidebar__control').click(function(){
				$('.sidebar').toggleClass('sidebar__open');

				if($(this).data('href') != "" && $('.sidebar').hasClass('sidebar__open')){
					$.ajax({
						url: $(this).data('href'),
						type: 'post',
						success: function(data){
							$('.sidebar').html(data);
						}
					})
				}

				if(!$('.sidebar').hasClass('sidebar__open')){
					$('.sidebar').empty();
				}



			})

	}

	function feedStart(){
		$(document).ajaxStart(function(){
			$('#facebook').fadeIn()
		})
		$(document).ajaxStop(function(){
			$('#facebook').fadeOut()
		})
	}
	

	function init(){
		openSidebar();
		feedStart();
	}

	return {
		ready : init
	}

};