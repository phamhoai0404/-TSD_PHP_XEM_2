import {
    apiRequest
} from './apiRequest'
import {
    PAPERLESS_CONST
} from '../constant'

const getAllDepCodes = () => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/sync_file/departments', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getSetting = (name) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/setting/' + name, PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getSourceTree = () => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/sync_file/source', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    if (response.data == undefined) response.data = [];
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getDesTree = () => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/sync_file/des', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    if (response.data == undefined) response.data = [];
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const syncFiles = (newFiles, deletedFiles) => {
    return new Promise((resolve, reject) => {
        apiRequest('/api/sync_file/sync', PAPERLESS_CONST.api_method.post, {
            newFiles: newFiles,
            deletedFiles: deletedFiles
        })
        .then(response => {
            resolve(response.data);
        })
        .catch(error => {
            reject(error);
        })
    })
};

const deleteItemInTree = (path) => {
    return new Promise((resolve, reject) => {
        apiRequest('/api/sync_file/delete', PAPERLESS_CONST.api_method.post, {
            itemPath: path
        })
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error);
            })
    })
};

const renameItemInTree = (path, newName, newNamePath) => {
    return new Promise((resolve, reject) => {
        apiRequest('/api/sync_file/rename', PAPERLESS_CONST.api_method.post, {
            itemPath: path,
            newNamePath: newNamePath,
            newName: newName
        })
            .then(response => {
                resolve(response.data);
            })
            .catch(error => {
                reject(error);
            })
    })
};

export {
    getAllDepCodes,
    getSetting,
    getSourceTree,
    getDesTree,
    syncFiles,
    deleteItemInTree,
    renameItemInTree
}
