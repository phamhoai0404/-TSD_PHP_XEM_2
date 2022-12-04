import {apiRequest} from './apiRequest'
import {PAPERLESS_CONST} from '../constant'

const getRoles = () => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/role', PAPERLESS_CONST.api_method.get)
                .then(response => {  
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

export { getRoles }