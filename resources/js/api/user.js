import {apiRequest} from './apiRequest'
import {PAPERLESS_CONST} from '../constant'


const getCurrentUser = () => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/current-user', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getUser = (id) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/user/' + id, PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getUsers = () => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/user/', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const createNewUser = (dataUser) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/user/', PAPERLESS_CONST.api_method.post, dataUser)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const updateUser = (dataUser) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/user/' + dataUser.id, PAPERLESS_CONST.api_method.put, dataUser)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const updatePassUser = (dataUser) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/user/reset-password/' + dataUser.id, PAPERLESS_CONST.api_method.put, dataUser)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const deleteUser = (id) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/user/' + id, PAPERLESS_CONST.api_method.delete)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const changeLanguage = (dataUser) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/user/language', PAPERLESS_CONST.api_method.put, dataUser)
                .then(response => {  
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

export { getUser, getUsers, createNewUser, deleteUser, updateUser, updatePassUser, getCurrentUser, changeLanguage }
