if ( window.parent ) {
	const iframe = window.parent.document.querySelector( 'iframe' );

	if ( iframe && iframe.style.visibility === 'hidden' ) {
		window.parent.document.querySelector( 'iframe' ).style.visibility = 'visible';
		window.parent.document.querySelector( '.iframe-loader' ).style.opacity = 0;
	}
}
