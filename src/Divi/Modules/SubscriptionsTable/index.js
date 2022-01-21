import React from 'react';
import API, {CancelToken} from '../../resources/js/api';
import parse from 'html-react-parser';

export default class SubscriptionTable extends React.Component {
    static slug = 'give_subscription_table';

    state = {
        fetching: false,
        content: null,
    };

    getSnapshotBeforeUpdate(prevProps) {
        if (
            prevProps.show_status !== this.props.show_status ||
            prevProps.show_renewal_date !== this.props.show_renewal_date ||
            prevProps.show_progress !== this.props.show_progress ||
            prevProps.show_start_date !== this.props.show_start_date ||
            prevProps.show_end_date !== this.props.show_end_date ||
            prevProps.subscriptions_per_page !== this.props.subscriptions_per_page ||
            prevProps.pagination_type !== this.props.pagination_type
        ) {
            return {
                show_status: this.props.show_status === 'on',
                show_renewal_date: this.props.show_renewal_date === 'on',
                show_progress: this.props.show_progress === 'on',
                show_start_date: this.props.show_start_date === 'on',
                show_end_date: this.props.show_end_date === 'on',
                subscriptions_per_page: this.props.subscriptions_per_page,
                pagination_type: this.props.pagination_type,
            };
        }

        return null;
    }

    componentDidMount() {
        this.fetchSubscriptionTable({
            show_status: this.props.show_status === 'on',
            show_renewal_date: this.props.show_renewal_date === 'on',
            show_progress: this.props.show_progress === 'on',
            show_start_date: this.props.show_start_date === 'on',
            show_end_date: this.props.show_end_date === 'on',
            subscriptions_per_page: this.props.subscriptions_per_page,
            pagination_type: this.props.pagination_type,
        });
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (snapshot && !this.state.fetching) {
            this.fetchSubscriptionTable(snapshot);
        }
    }

    fetchSubscriptionTable(params) {
        this.setState({
            fetching: true,
        });

        API.post('/render-subscription-table', params, {cancelToken: CancelToken.token})
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
