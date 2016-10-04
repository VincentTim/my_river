/**
 * Structure par défaut de tout nouveau module
 */

module.exports = function(context){

	"use strict";
    
    var datepicker = require('jquery-ui/ui/widgets/datepicker');

    function initDatePicker() {
		$.datepicker.regional['fr'] = {
			closeText: 'Fermer',
			prevText: '&#x3c;Préc',
			nextText: 'Suiv&#x3e;',
			currentText: 'Courant',
			monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
			monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
			dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
			dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
			dayNamesMin: ['D','L','M','M','J','V','S'],
			weekHeader: 'Sm',
			dateFormat: 'dd/mm/yy',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
		};
		$('.form__datepicker').datepicker($.datepicker.regional[ "fr" ]);
	}
    
    function deleteImageContrib(){
        $(".delete-image").click(function(e){
            e.preventDefault();
            if(confirm('Etes-vous sûr de vouloir supprimer cette image?')){
                $(this).parent().fadeOut();
                $(this).parents('.form-files').append('<input name="appbundle_files_delete[]" type="hidden" value="'+$(this).data('id')+'" />');
            }
        })
    }

    function showMenu(){
    	$('#btn-menu').click(function(){
    		if($(this).hasClass('triggered')){
				$(this).removeClass('triggered');
				$('#main-wrapper').removeClass('status-opened');
				$('#menu-wrapper').removeClass('open');
			} else {
				$(this).addClass('triggered');
				$('#main-wrapper').addClass('status-opened');
				$('#menu-wrapper').addClass('open');
			}

		})
	}

	function menuBtn(){
		var toggles = document.querySelectorAll(".c-hamburger");

		for (var i = toggles.length - 1; i >= 0; i--) {
			var toggle = toggles[i];
			toggleHandler(toggle);
		};

		function toggleHandler(toggle) {
			toggle.addEventListener( "click", function(e) {
				e.preventDefault();
				(this.classList.contains("is-active") === true) ? this.classList.remove("is-active") : this.classList.add("is-active");
			});
		}
	}

	function init(){
         
        initDatePicker();
        deleteImageContrib();
		showMenu();
		menuBtn();
		//initFancyBox();
        
	}

	return {
		ready : init
	}

};