// External Dependencies
import $ from 'jquery';

import DonationForm from '../../Modules/DonationForm';

$( window ).on( 'et_builder_api_ready', ( event, API ) => {
	API.registerModules( [ DonationForm ] );
} );
