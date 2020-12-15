import axios from 'axios'
import notification from "./dialogs/notification"
import translate from "./translate";
import userApi from "../api/userApi";
import config from "../config";
import router from "../router"
import store from "../store/store";

function _gotoLogin(error = null) {
    console.log(router.history.current.fullPath);
    let query = `${config.login_page.param_redirect}=${encodeURIComponent(router.history.current.fullPath)}`
    if (error !== null) {
        query += `&${config.login_page.param_error}=${encodeURIComponent(error)}`;
    }
    location.replace(`${config.login_page.url}?${query}`);
}

const SessionMonitor = {
    session: null,
    notifyHttpErrors() {
        axios.interceptors.response.use(response => response, error => {
            if (error.response.status === 401) {
                _gotoLogin(error.response.status);
                return;
            }
            notification.error(`${translate('error.request-failed')} (${error.response.status})`)
        });
    },
    logoutOnSessionExpire() {
        store.dispatch('user/loadSession')
            .then(session => {
                let delta = (session.expiry * 1000) - Date.now();
                setTimeout(() => {
                    _gotoLogin('401');
                }, delta + 1000);

            })
            .catch(error => {
                _gotoLogin(error.response.status)
            });
    }


}


export default SessionMonitor;
