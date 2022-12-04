import {apiRequest} from './apiRequest'
import {PAPERLESS_CONST} from '../constant'

const getDepartments = () => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/department/', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getDepWidthRoleLine = (depId) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('api/department/role/' + depId, PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getUserByDepartmentId = (id) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/department/' + id + '/users', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};


const deleteDepartment = (id) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/department/' + id, PAPERLESS_CONST.api_method.delete)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
}
const createNewDepartment = (dataDepartment) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/department/', PAPERLESS_CONST.api_method.post, dataDepartment)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};
const updateDepartment = (dataDepartment) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/department/' + dataDepartment.id, PAPERLESS_CONST.api_method.put, dataDepartment)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};
export { getDepartments, createNewDepartment, updateDepartment, deleteDepartment, getUserByDepartmentId, getDepWidthRoleLine }
