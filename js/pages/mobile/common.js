
// (function( $ ) { 
	var tableOffset = false;
	var $tHead = false;
	var $tBody = false;
	var $itemTable = false;
	var $fixedHeader = false;
	var tableOffset = false;
	var outerWIDTH = false;
	
	initVars = function(){
		tableOffset = false;
		$tHead = false;
		$itemTable = false;
		$fixedHeader = false;
		tableOffset = false;
		outerWIDTH = false;
	};
	
	resetHeading = function( $currentDocument ){
		if( !$currentDocument ) $currentDocument = document;
		var offset = $( $currentDocument ).scrollTop();

		// console.log(offset);



		$itemTable = $itemTable?$itemTable:$( document ).find("div.ui-page-active table.items").last();
		if($itemTable.length){
			
			tableOffset = tableOffset?tableOffset:$itemTable.offset().top;
			outerWIDTH = outerWIDTH?outerWIDTH:$itemTable.outerWidth( );
			
			$fixedHeader = $fixedHeader?$fixedHeader:$( document ).find("div.ui-page-active #header-fixed").last( );
			$tHead = $tHead?$tHead:$itemTable.find( 'thead' ).eq(0).clone();
			$fixedHeader.html($tHead);
			
			
			/* console.log(  offset );
				console.log(  tableOffset );
				console.log(  $header );
				console.log(  $fixedHeader );
			*/	
			if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
				$fixedHeader.css( 'width', outerWIDTH + 'px' ).show();
			}
			else if (offset < tableOffset) {
				$fixedHeader.hide();
			}
		}
	};

    openDetails = function( $vrt, $band, $category, $tax, $page ) { 
		$modalHtml = "";
		if( !$page ) $page = "cars";
        
        $modalHtml = '<div class="overlay-modal"></div><div class="modal tax_info" id="modal-details"><div class="modal-dialog"><div class="modal-content"><span class="close" data-dismiss="modal">&times;</span><div id="modelDetails_0"><h4>tax Information</h4><ul><li><strong>VRT:</strong> ' + $vrt + '</li><li><strong>Category:</strong> ' + $category + '</li><li><strong>Band:</strong> ' + $band + '</li><li><strong>Motor Tax:</strong> ' + $tax + '</li></ul></div></div></div></div>';

        if($page == 'cars'){
            $modalHtml = '<div class="overlay-modal"></div><div class="modal tax_info" id="modal-details"><div class="modal-dialog"><div class="modal-content"><span class="close" data-dismiss="modal">&times;</span><div id="modelDetails_0"><h4>tax Information</h4><ul><li><strong>VRT:</strong> ' + $vrt + '</li><li><strong>Band:</strong> ' + $band + '</li><li><strong>Motor Tax:</strong> ' + $tax + '</li></ul></div></div></div></div>';
        } 

        $( 'body' ).addClass( 'modal-open' ).append( $modalHtml );
        $( '#modal-details' ).toggle( );
        return false;
	};
	
	openCondSuppyDetails = function( $heading, $details) { 
		$modalHtml = "";
        $modalHtml = '<div class="overlay-modal"></div><div class="modal tax_info popup_box" id="modal-details"><div class="popup_dialog"><div class="popup_content"><span class="close" data-dismiss="modal">&times;</span><div id="modelDetails_0 headings"><h6 style="padding: 10px;">'+ $heading +'</h6><p>'+ $details +'</p></div></div></div></div>';

        $( 'body' ).addClass( 'modal-open' ).append( $modalHtml );
        $( '#modal-details' ).toggle( );
        return false;
    };

	openCondSuppyDetails = function( $heading, $details) { 
		$modalHtml = "";
        $modalHtml = '<div class="overlay-modal"></div><div class="modal tax_info popup_box" id="modal-details"><div class="popup_dialog"><div class="popup_content"><span class="close" data-dismiss="modal">&times;</span><div id="modelDetails_0 headings"><h6 style="padding: 10px;">'+ $heading +'</h6><p>'+ $details +'</p></div></div></div></div>';

        $( 'body' ).addClass( 'modal-open' ).append( $modalHtml );
        $( '#modal-details' ).toggle( );
        return false;
    };




    $(document).ready(function () {
		
	
        $( document ).on( 'click', '.tax_info .close', function(){
            $( 'body' ).removeClass( 'modal-open' )
            $( '.overlay-modal, .modal.tax_info' ).remove();

        });
		
		 $( document ).on( 'click', '.tax_info', function(){
			$( 'body' ).removeClass( 'modal-open' );
			$(".modal.tax_info").hide();
			$('#modelDetails_0').click(function(event){
				event.stopPropagation();
			});
		});
		
		
        $( document ).on( 'click', '.byPrice_modal a', function(){
            $link = $( this ).attr( 'href' );
            if( !$link ) return false;
            $(':mobile-pagecontainer').pagecontainer( 'change', $link );
            return false;
        });

        $( document ).on( 'change', '#arch_month', function(){
            $link = $( '.byPrice_modal' ).last( ).find( '.btn_active' ).attr( 'href' );
            if( !$link ) return;
            $(':mobile-pagecontainer').pagecontainer( 'change', $link + '&arch=' + $( this ).val( ) + '&com_arch=' + $( this ).val( ) );
        });

        $( document ).on( 'change', '#select1', function(){
            $link = $( '.byPrice_modal' ).last( ).find( '.btn_active' ).attr( 'href' );
            if( !$link ) return;
            $(':mobile-pagecontainer').pagecontainer( 'change', $link + '&arch=' + $( 'div[data-role="page"] #arch_month' ).last().val( ) + '&com_arch=' + $( 'div[data-role="page"] #arch_month' ).last().val( ) + '&make=' + $( this ).val( ) );
        });

        $( document ).on( 'change', '#select2', function(){
            $link = $( '.byPrice_modal' ).last( ).find( '.btn_active' ).attr( 'href' );
            if( !$link ) return;
            $(':mobile-pagecontainer').pagecontainer( 'change', $link + '&arch=' + $( 'div[data-role="page"] #arch_month' ).last().val( ) + '&com_arch=' + $( 'div[data-role="page"] #arch_month' ).last().val( ) + '&make=' + $( 'div[data-role="page"] #select1' ).last().val( ) + '&rangecode=' + $( this ).val( ) );
        });

        $( document ).on( 'change', '#aselect1', function(){
            $link = $( '.byPrice_modal' ).last( ).find( '.btn_active' ).attr( 'href' );
            if( !$link ) return;
            $(':mobile-pagecontainer').pagecontainer( 'change', $link + '&make=' + $( this ).val( ) );
        });

        $( document ).on( 'change', '#aselect3', function(){
            $link = $( '.byPrice_modal' ).last( ).find( '.btn_active' ).attr( 'href' );
            if( !$link ) return;
            $(':mobile-pagecontainer').pagecontainer( 'change', $link + '&make=' + $( 'div[data-role="page"] #aselect1' ).last().val( ) + '&series=' + $( this ).val( ) );
        });

        $( document ).on( 'change', '#aselect2', function(){
            $link = $( '.byPrice_modal' ).last( ).find( '.btn_active' ).attr( 'href' );
            if( !$link ) return;

            $series = ( $( 'div[data-role="page"] #aselect3' ).last().val( ) )?'&series=' +$( 'div[data-role="page"] #aselect3' ).last().val( ):'';

            $(':mobile-pagecontainer').pagecontainer( 'change', $link + '&make=' + $( 'div[data-role="page"] #aselect1' ).last().val( ) + $series + '&model=' + $( this ).val( ) );
        });

        $(window).resize(function () {
            if (window.innerWidth < 425) {
                $(".bhp-text").css("display", "none")
                $(".drs-text").css("display", "none")
                $(".gvw-text").css("display", "none")
            }
			initVars();
			// $(window).scrollTop(0);
        });

        $( '#user_kms' ).numeric({
            negative: false
        });

        $(':mobile-pagecontainer').on("pageshow", function( event ) { 
            $.each( $( 'body' ).find( 'div[data-role="page"]' ), function( ) { 
                $( this ).find( '#user_kms, input.km' ).numeric({
                    negative: false
                });
            });
			initVars();
        });
		
		// table sticky
		$(document).on("scroll", function() {
			// setInterval(function(){
			   resetHeading( this );
		   // }, 10000);
		});
		//add class 
		
		$(document).on('click', '.open-varnt', function(){
			$(this).closest('tr').addClass('op-varnt');
		});
		
		$(document).on( 'click', "#modal-details .close, .modal.tax_info", function(){
		   $('.op-varnt').removeClass('op-varnt');
		});
		
    });

// })( jQuery );


// function stickyhead (){
	// var tableOffset = false;
	// var $header = false;
	// var $itemTable = false;
	// var $fixedHeader = false;
	// var tableOffset = false;
	// var outerWIDTH = false;

	// $(window).bind("scroll", function() {
		// var offset = $(this).scrollTop();
		// $itemTable = $itemTable?$itemTable:$( document ).find("table.items").last();
		// tableOffset = tableOffset?tableOffset:$itemTable.offset().top;
		// outerWIDTH = outerWIDTH?outerWIDTH:$itemTable.outerWidth( );
		
		// $fixedHeader = $fixedHeader?$fixedHeader:$( document ).find("#header-fixed").last( );
		// $header = $header?$header:$itemTable.find( 'thead' ).clone();
		// $fixedHeader.html($header);
		
		// /*console.log(  offset );
		// console.log(  tableOffset );
		// console.log(  $header );
		// console.log(  $fixedHeader );*/
		
		// if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
			// $fixedHeader.css( 'width', outerWIDTH + 'px' ).show();
			// console.log('in condition');
		// }
		// else if (offset < tableOffset) {
			// $fixedHeader.hide();
			// console.log('outer condition');
		// }
	// });
// }



