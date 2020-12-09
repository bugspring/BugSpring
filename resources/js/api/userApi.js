import axios from 'axios'

const BASE_URL = '/api/user';

export default {
    index() {
        return axios.get(BASE_URL).then(result => result.data);
    },

    show(id) {
        return axios.get(`${BASE_URL}/${id}`).then(result => result.data);
    },

    session() {
        return axios.get(`${BASE_URL}/session`).then(result => result.data);
    },

    update(project) {
        return axios.put(`${BASE_URL}/${project.id}`, project).then(result => result.data);
    },

    destroy(id) {
        return axios.delete(`${BASE_URL}/${id}`).then(result => result.data);
    },
}
