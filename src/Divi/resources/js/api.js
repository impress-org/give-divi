import axios from 'axios';

export const CancelToken = axios.CancelToken.source();

export default axios.create({
    baseURL: window.GiveDivi.apiRoot,
    headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': window.GiveDivi.apiNonce,
    },
});
