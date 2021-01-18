// External Dependencies
import $ from 'jquery';

import DonationForm from '../../Modules/DonationForm';
import DonorWall from '../../Modules/DonorWall';
import FormGoal from '../../Modules/FormGoal';

$( window ).on( 'et_builder_api_ready', ( event, API ) => {
	API.registerModules( [ DonationForm, DonorWall, FormGoal ] );
} );
