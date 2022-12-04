import {apiRequest} from './apiRequest'
import {PAPERLESS_CONST} from '../constant'

const getSourceTreeForPlayFile = () => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/playfile/des', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
}

const DisplayFile = (id) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/download-files/' + id, PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};


const updateOrCreatePlaylists = (data) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/playlists/update/create', PAPERLESS_CONST.api_method.put, data)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const deletePlaylists = (data) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/playlists/delete', PAPERLESS_CONST.api_method.delete, data)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

export { updateOrCreatePlaylists, deletePlaylists, getSourceTreeForPlayFile, DisplayFile }