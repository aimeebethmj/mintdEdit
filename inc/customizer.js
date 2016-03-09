( function( $ ) {
	
	// Header Text Color
	wp.customize( 'header_color', function( value ) {
		value.bind( function( newval ) {
			$( '.site-title a' ).css('color', newval );
		} );
	} );
	
	// Navbar Text Color
	wp.customize( 'navbar_text_color', function( value ) {
		value.bind( function( newval ) {
			$( '.menu-toggle,.menu-bar ul li a' ).css('color', newval );
		} );
	} );
	

	// Navbar Background Color
	wp.customize( 'navbar_background_color', function( value ) {
		value.bind( function( newval ) {
			$( '.site-top' ).css('background', newval ).css('border', '0' );
		} );
	} );
	
	// Navbar Border Color
	wp.customize( 'navbar_border_color', function( value ) {
		value.bind( function( newval ) {
			$( '.site-top' ).css('border-color', newval );
		} );
	} );
	
	// Widget Title Text Color
	wp.customize( 'pipdig_widget_title_text_color', function( value ) {
		value.bind( function( newval ) {
			$( '.widget-title' ).css('color', newval );
		} );
	} );
	
	// Social Icon Color
	wp.customize( 'social_color', function( value ) {
		value.bind( function( newval ) {
			$( '.pipdig_widget_social_icons .socialz a' ).css('color', newval );
		} );
	} );


	// Post content link color
	wp.customize( 'post_links_color', function( value ) {
		value.bind( function( newval ) {
			$( '.entry-content a' ).css('color', newval );
		} );
	} );

} )( jQuery );