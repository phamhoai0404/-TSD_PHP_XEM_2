import { apiRequest } from './apiRequest'
import { PAPERLESS_CONST } from '../constant'

const getMicroPcs = () => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/micro_pc/', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const addMicroPC = (data) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/micro_pc/', PAPERLESS_CONST.api_method.post, data)
                .then(response => {
                    resolve(response);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const editMicroPC = (data) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/micro_pc/' + data.id, PAPERLESS_CONST.api_method.put, data)
                .then(response => {
                    resolve(response);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const updateIsRunningForMicroPC = (microCodes) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/micro_pc/isrunning', PAPERLESS_CONST.api_method.put, microCodes)
                .then(response => {
                    resolve(response);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const shutDownMicroPCById = (id) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/micro_pc/shutdown/' + id, PAPERLESS_CONST.api_method.post)
                .then(response => {
                    resolve(response);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const rebootMicroPCById = (id) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/micro_pc/reboot/' + id, PAPERLESS_CONST.api_method.post)
                .then(response => {
                    resolve(response);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const deleteMicroPc = (id) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/micro_pc/' + id, PAPERLESS_CONST.api_method.delete)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

export { getMicroPcs, addMicroPC, deleteMicroPc, editMicroPC, updateIsRunningForMicroPC, shutDownMicroPCById, rebootMicroPCById }