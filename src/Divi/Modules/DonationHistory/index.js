import React from 'react';
import API, {CancelToken} from '../../resources/js/api';
import parse from 'html-react-parser';

export default class DonationHistory extends React.Component {
    static slug = 'give_donation_history';

    constructor(props) {
        super(props);

        this.state = {
            fetching: false,
            content: null,
        };
    }

    getSnapshotBeforeUpdate(prevProps) {
        if (
            prevProps.id !== this.props.id ||
            prevProps.date !== this.props.date ||
            prevProps.donor !== this.props.donor ||
            prevProps.amount !== this.props.amount ||
            prevProps.status !== this.props.status ||
            prevProps.payment_method !== this.props.payment_method
        ) {
            return {
                id: this.props.id === 'on',
                date: this.props.date === 'on',
                donor: this.props.donor === 'on',
                amount: this.props.amount === 'on',
                status: this.props.status === 'on',
                payment_method: this.props.payment_method === 'on',
            };
        }

        return null;
    }

    componentDidMount() {
        this.fetchDonationHistory({
            id: this.props.id === 'on',
            date: this.props.date === 'on',
            donor: this.props.donor === 'on',
            amount: this.props.amount === 'on',
            status: this.props.status === 'on',
            payment_method: this.props.payment_method === 'on',
        });
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (snapshot && !this.state.fetching) {
            this.fetchDonationHistory(snapshot);
        }
    }

    fetchDonationHistory(params) {
        this.setState({
            fetching: true,
        });

        API.post('/render-donation-history', params, {cancelToken: CancelToken.token})
            .then((response) => {
                this.setState({
                    fetching: false,
                    content: response.data.content,
                });
            })
            .catch(() => {
                CancelToken.cancel();
                this.setState({
                    fetching: false,
                    content: '',
                });
            });
    }

    render() {
        return <>{this.state.content && parse(this.state.content)}</>;
    }
}
