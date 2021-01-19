// External Dependencies
import $ from 'jquery';

import DonationForm from '../../Modules/DonationForm';
import DonorWall from '../../Modules/DonorWall';
import FormGoal from '../../Modules/FormGoal';
import RegistrationForm from '../../Modules/RegistrationForm';
import LoginForm from '../../Modules/LoginForm';

$( window ).on( 'et_builder_api_ready', ( event, API ) => {
	API.registerModules( [ DonationForm, DonorWall, FormGoal, RegistrationForm, LoginForm ] );
} );
