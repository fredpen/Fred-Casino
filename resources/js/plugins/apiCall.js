import { API_BASE_URL } from "./endPoints";
import Store from "../Store"


let token = Store.state.token ? Store.state.token : localStorage.getItem("token");

const instance = axios.create({
    baseURL: API_BASE_URL,
    timeout: 100000000,
    withCredentials: true,
    headers: {
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
    },
});

instance.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        if (error.response.status === 401) {
            // if token expired
            return window.location.replace(`${BASE_URL}`);
        }
        return Promise.reject(error);
    }
);

async function getCall(url, params) {
    return await instance.get(url, { params: params });
}

async function postCall(url, params) {
    return await instance.post(url, params);
}

async function putCall(url, params) {
    return await instance.put(url, params);
}

async function deleteCall(url, params) {
    return await instance.delete(url, params);
}

export { getCall, postCall, putCall, deleteCall };
