import {apiRequest} from './apiRequest'
import {PAPERLESS_CONST} from '../constant'

const getAllSettings = () => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/setting', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getTimeDefault = () => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/setting/default_time', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};


const updateDataSetting = (value) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/setting/update', PAPERLESS_CONST.api_method.put, value)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

export { getAllSettings, updateDataSetting, getTimeDefault }
