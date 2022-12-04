import {
    apiRequest
} from "./apiRequest";
import {
    PAPERLESS_CONST
} from "../constant";


const getFile = (id) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/file/' + id, PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getFiles = () => {
    return new Promise((resolve, reject) => {
        apiRequest("/api/file/", PAPERLESS_CONST.api_method.get)
            .then(response => {
                resolve(response.data);
            })
            .catch(function (error) {
                reject(error);
            });
    });
};

const downloadFiles = (id) => {
    return new Promise((resolve, reject) => {
        apiRequest("/api/download-files/" + id, PAPERLESS_CONST.api_method.get)
            .then(response => {
                resolve(response.data);
            })
            .catch(function (error) {
                reject(error);
            });
    });
};

export {
    getFile,
    getFiles,
    downloadFiles
};
