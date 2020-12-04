import axios from 'axios'
import notification from "./dialogs/notification"
import translate from "./translate";

export default {
    notifyHttpErrors() {
        axios.interceptors.response.use(response => response, error => {
            notification.error(`${translate('error.request-failed')} (${error.response.status})`)
        });
    },
}
