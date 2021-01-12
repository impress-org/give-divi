const mix = require( 'laravel-mix' );
const wpPot = require( 'wp-pot' );

mix
	.setPublicPath( 'public' )
	.sourceMaps( false )

	// admin assets
	.js( 'src/Divi/resources/js/give-divi.js', 'public/js/' )
	// images
	.copy( 'src/Divi/resources/images/*.{jpg,jpeg,png,gif}', 'public/images' );

mix.webpackConfig( {
	externals: {
		$: 'jQuery',
		jquery: 'jQuery',
	},
} );

if ( mix.inProduction() ) {
	wpPot( {
		package: 'Give - Divi Add-on',
		domain: 'give-divi',
		destFile: 'languages/give-divi.pot',
		relativeTo: './',
		bugReport: 'https://github.com/impress-org/give-divi/issues/new',
		team: 'GiveWP <info@givewp.com>',
	} );
}
