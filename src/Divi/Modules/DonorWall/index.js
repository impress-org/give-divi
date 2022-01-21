import React from 'react';
import API, {CancelToken} from '../../resources/js/api';
import parse from 'html-react-parser';

export default class DonorWall extends React.Component {
    static slug = 'give_donor_wall';

    constructor(props) {
        super(props);

        this.state = {
            fetching: false,
            content: null,
        };
    }

    getSnapshotBeforeUpdate(prevProps) {
        if (
            prevProps.show !== this.props.show ||
            prevProps.ids !== this.props.ids ||
            prevProps.form !== this.props.form ||
            prevProps.order !== this.props.order ||
            prevProps.orderby !== this.props.orderby ||
            prevProps.columns !== this.props.columns ||
            prevProps.avatarsize !== this.props.avatarsize ||
            prevProps.avatar !== this.props.avatar ||
            prevProps.name !== this.props.name ||
            prevProps.company !== this.props.company ||
            prevProps.total !== this.props.total ||
            prevProps.time !== this.props.time ||
            prevProps.comments !== this.props.comments ||
            prevProps.anonymous !== this.props.anonymous ||
            prevProps.withcomments !== this.props.withcomments ||
            prevProps.commentlength !== this.props.commentlength ||
            prevProps.readtext !== this.props.readtext ||
            prevProps.loadtext !== this.props.loadtext
        ) {
            return {
                show: this.props.show,
                ids: this.props.ids,
                form: this.props.form,
                order: this.props.order,
                orderby: this.props.orderby,
                columns: this.props.columns,
                avatarsize: this.props.avatarsize,
                avatar: this.props.avatar === 'on',
                name: this.props.name === 'on',
                company: this.props.company === 'on',
                total: this.props.total === 'on',
                time: this.props.time === 'on',
                comments: this.props.comments === 'on',
                anonymous: this.props.anonymous === 'on',
                withcomments: this.props.withcomments === 'on',
                commentlength: this.props.commentlength,
                readtext: this.props.readtext,
                loadtext: this.props.loadtext,
            };
        }

        return null;
    }

    componentDidMount() {
        this.fetchDonorWall({
            show: this.props.show,
            ids: this.props.ids,
            form: this.props.form,
            order: this.props.order,
            orderby: this.props.orderby,
            columns: this.props.columns,
            avatarsize: this.props.avatarsize,
            avatar: this.props.avatar === 'on',
            name: this.props.name === 'on',
            company: this.props.company === 'on',
            total: this.props.total === 'on',
            time: this.props.time === 'on',
            comments: this.props.comments === 'on',
            anonymous: this.props.anonymous === 'on',
            withcomments: this.props.withcomments === 'on',
            commentlength: this.props.commentlength,
            readtext: this.props.readtext,
            loadtext: this.props.loadtext,
        });
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (snapshot && !this.state.fetching) {
            this.fetchDonorWall(snapshot);
        }
    }

    fetchDonorWall(params) {
        this.setState({
            fetching: true,
        });

        API.get('/render-donor-wall', {params}, {cancelToken: CancelToken.token})
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
