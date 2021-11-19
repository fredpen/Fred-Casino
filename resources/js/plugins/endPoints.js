export const API_BASE_URL = `${BASE_URL}/api/`;

// Auth
export const LOGIN = `${API_BASE_URL}auth/login`;
export const REGISTER = `${API_BASE_URL}auth/register`;
export const LOGOUT = `${API_BASE_URL}auth/logout`;

// Admin - Users
export const GET_ALL_USERS = `${API_BASE_URL}user/all`;
export const CREATE_A_USER = `${API_BASE_URL}auth/register`;

//casinos
export const GET_ALL_CASINOS = `${API_BASE_URL}casino/all`;
export const CREATE_A_CASINO = `${API_BASE_URL}casino/create`;

//listings
export const GET_ALL_LISTINGS = `${API_BASE_URL}casino-listing/all`;
export const UPDATE_CASINO_LISTINGS = `${API_BASE_URL}casino-listing/update`;

export const Dynamic_endpoints = {
    // users
    UPDATE_USER_BY_ID: (id) => `${API_BASE_URL}user/${id}/update`,
    DELETE_USER_BY_ID: (id) => `${API_BASE_URL}user/${id}/delete`,

    // casinos
    UPDATE_CASINO_BY_ID: (id) => `${API_BASE_URL}casino/${id}/update`,
    DELETE_CASINO_BY_ID: (id) => `${API_BASE_URL}casino/${id}/delete`,

    // casinos listings
    LISTINGS_BY_COUNTRY: (id) => `${API_BASE_URL}casino-listing/${id}/by-countries`,
};
