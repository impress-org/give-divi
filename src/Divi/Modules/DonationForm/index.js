// External Dependencies
import React from 'react';
import API, {CancelToken} from '../../resources/js/api';
import parse from 'html-react-parser';
import Iframe from './Components/Iframe';
import ModalForm from "./Components/ModalForm";

export default class DonationForm extends React.Component {
    static slug = 'give_donation_form';

    initialState = {
        fetching: false,
        content: null,
        isV3Form: null,
        dataSrc: null,
    };

    constructor(props) {
        super(props);

        this.state = this.initialState;
    }

    getSnapshotBeforeUpdate(prevProps) {
        if (
            prevProps.id !== this.props.id ||
            prevProps.style !== this.props.style ||
            prevProps.title !== this.props.title ||
            prevProps.goal !== this.props.goal
        ) {
            return {
                id: this.props.id,
                style: this.props.style,
                title: this.props.title === 'on',
                goal: this.props.goal === 'on',
            };
        }

        return null;
    }

    componentDidMount() {
        if (this.props.id) {
            this.fetchDonationForm({
                id: this.props.id,
                style: this.props.style,
                title: this.props.title === 'on',
                goal: this.props.goal === 'on',
            });
        }
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (snapshot && !this.state.fetching) {
            this.fetchDonationForm(snapshot);
        }
    }

    fetchDonationForm(params) {
        this.setState({
            fetching: true,
        });

        API.post('/render-donation-form', params, {cancelToken: CancelToken.token})
           .then((response) => {
               this.setState({
                   fetching: false,
                   content: response.data.content,
                   isV3Form: response.data.isV3Form,
                   dataSrc: response.data?.dataSrc,
               });
           })
           .catch(() => {
               CancelToken.cancel();
               this.setState(this.initialState);
           });
    }

    render() {
        if (this.state.isV3Form) {
            if (this.props.style === 'button') {
                return (
                    <a className="givewp-donation-form-link" href={formUrl} target="_blank" rel="noopener noreferrer">
                        {'Donate'}
                    </a>
                );
            }

            if (['modal', 'reveal'].includes(this.props.style)) {
                return <ModalForm openFormButton={'Donate'} dataSrc={this.state.dataSrc} />;
            }

            return <Iframe dataSrc={this.state.dataSrc} />;
        }

        return <>{this.state.content && parse(this.state.content)}</>;
    }
}
