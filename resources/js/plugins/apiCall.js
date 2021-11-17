import Axios from "axios";

let token = localStorage.getItem("token");
let BASE_URL = "http://fred-casino.test";

const instance = Axios.create({
    baseURL: BASE_URL,
    timeout: 100000000,
    withCredentials: true,
    headers: {
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
    },
});

function getCall(url, params) {
    return instance.get(url, { params: params });
}

function postCall(url, params) {
    return instance.post(url, params);
}

function putCall(url, params) {
    return instance.put(url);
}

function deleteCall(url, params) {
    return instance.delete(url, params);
}

function afterCall(status) {
    return status == 401 ? router.push("Login") : false;
}

export { getCall, postCall, putCall, deleteCall, afterCall };
