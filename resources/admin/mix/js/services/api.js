const axios = require('axios');

export function removeHeader() {
    axios.defaults.headers.common = {};
}

export function get(resource = "") {
    return axios.get(resource);
}

export function post(resource = "", data, configs = {}) {
    return axios.post(resource, data, configs);
}

export function put(resource = "", data) {
    return axios.put(resource, data);
}

export function patch(resource = "", data) {
    return axios.patch(resource, data);
}

export function deleteAxios(resource = "") {
    return axios.delete(resource);
}

export function customRequest(data) {
    return axios(data);
}
