(function( $ ) { 

    openDetails = function( $vrt, $band, $category, $tax ) { 
        $modalHtml = '<div class="overlay-modal"></div><div class="modal tax_info" id="modal-details"><div class="modal-dialog"><div class="modal-content"><span class="close" data-dismiss="modal">&times;</span><div id="modelDetails_0"><h4>tax Information</h4><ul><li><strong>VRT:</strong> ' + $vrt + '</li><li><strong>Category:</strong> ' + $category + '</li><li><strong>Band:</strong> ' + $band + '</li><li><strong>Motor Tax:</strong> ' + $tax + '</li></ul></div></div></div></div>';

        $( 'body' ).append( $modalHtml );
        $( '#modal-details' ).toggle( );
        return false;
    };

    $(document).ready(function () { 

        $( document ).on( 'click', '.byPrice_modal a', function(){
            $link = $( this ).attr( 'href' );
            if( !$link ) return false;
            $(':mobile-pagecontainer').pagecontainer( 'change', $link );
            return false;
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
        });
    });
})( jQuery );