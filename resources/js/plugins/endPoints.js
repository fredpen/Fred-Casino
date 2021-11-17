export const API_BASE_URL = `${BASE_URL}/api/`;

// Auth
export const LOGIN = `${API_BASE_URL}auth/login`;
export const REGISTER = `${API_BASE_URL}auth/register`;
export const LOGOUT = `${API_BASE_URL}auth/logout`;

// Admin - Users
export const GET_ALL_USERS = `${API_BASE_URL}user/all`;
export const CREATE_A_USER = `${API_BASE_URL}auth/register`;



export const Dynamic_endpoints = {
    UPDATE_USER_BY_ID: (id) => `${API_BASE_URL}user/${id}/update`,
    DELETE_USER_BY_ID: (id) => `${API_BASE_URL}user/${id}/delete`,

};
