import Vue from 'vue'
import axios from 'axios'
import notification from "./notification"
import translate from "./translate";


axios.interceptors.response.use( response => response, error => {
    notification.error(`${translate('error.request-failed')} (${error.response.status})`)
});
