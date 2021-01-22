// External Dependencies
import $ from 'jquery';

// Modules
import DonationForm from '../../Modules/DonationForm';
import DonorWall from '../../Modules/DonorWall';
import FormGoal from '../../Modules/FormGoal';
import DonationReceipt from '../../Modules/DonationReceipt';
import RegistrationForm from '../../Modules/RegistrationForm';
import LoginForm from '../../Modules/LoginForm';
import Totals from '../../Modules/Totals';
import ProfileEditor from '../../Modules/ProfileEditor';
import DonationHistory from '../../Modules/DonationHistory';
import FormGird from '../../Modules/FormGrid';

// Custom fields
import SimpleInput from '../../CustomFields/MultiSelect';

$( window ).on( 'et_builder_api_ready', ( event, API ) => {
	API.registerModules( [ DonationForm, DonorWall, FormGoal, DonationReceipt, RegistrationForm, LoginForm, Totals, ProfileEditor, DonationHistory, FormGird ] )
  API.registerModalFields( [ SimpleInput ] )
} )
