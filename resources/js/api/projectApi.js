import axios from 'axios'

const BASE_URL = '/api/project';

export default {
    index() {
        return axios.get(BASE_URL).then(result => result.data);
    },

    store(project) {
        return axios.post(BASE_URL, project).then(result => result.data);
    },

    show(id) {
        return axios.get(`${BASE_URL}/${id}`).then(result => result.data);
    },

    update(project) {
        return axios.put(`${BASE_URL}/${project.id}`, project).then(result => result.data);
    },

    destroy(id) {
        return axios.delete(`${BASE_URL}/${id}`).then(result => result.data);
    },
}
