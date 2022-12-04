import {apiRequest} from './apiRequest'
import {PAPERLESS_CONST} from '../constant'

const getControlPcs = () => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/controlpc/', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};


const deleteControlPc = (id) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/controlpc/' + id, PAPERLESS_CONST.api_method.delete)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
}
const createNewControlPc = (dataControlPc) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/controlpc/', PAPERLESS_CONST.api_method.post, dataControlPc)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};
const updateControlPc = (dataControlPc) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/controlpc/' + dataControlPc.id, PAPERLESS_CONST.api_method.put, dataControlPc)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};
export { getControlPcs, createNewControlPc, updateControlPc, deleteControlPc }
