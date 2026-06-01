(function($){
    $( document ).ready(function(){
        $( document ).on( 'click', '.byPrice_modal a', function(){
            $link = $( this ).attr( 'href' );
            if( !$link ) return false;
            $(':mobile-pagecontainer').pagecontainer( 'change', $link );
            return false;
        });
        if( $( '#select1' ) .length > 0 ) { 
            $( document ).on( 'change', '#select1', function(){
                $link = $( '.byPrice_modal' ).last( ).find( '.btn_active' ).attr( 'href' );
                if( !$link ) return;
                $(':mobile-pagecontainer').pagecontainer( 'change', $link + '&make=' + $( this ).val( ) );
            });
        }
        if( $( '#select2' ) .length > 0 ) { 
            $( document ).on( 'change', '#select2', function(){
                $link = $( '.byPrice_modal' ).last( ).find( '.btn_active' ).attr( 'href' );
                if( !$link ) return;
                $(':mobile-pagecontainer').pagecontainer( 'change', $link + '&make=' + $( 'div[data-role="page"] #select1' ).last().val( ) + '&rangecode=' + $( this ).val( ) );
            });
        }
    });
})( jQuery );