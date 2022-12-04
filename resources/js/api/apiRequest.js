import axios from 'axios';

const apiRequest = (url, methodType, data = {}, multipart = false) => {
    let headers;
    headers = {};

    if (multipart) {
        headers['content-type'] = 'multipart/form-data';
    }

    return new Promise(
        (resolve, reject) => {
            axios({
                method: methodType,
                url: url,
                data: data,
                headers: headers
            })
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    if (error && error.response && error.response.status == 401) {
                        window.location.reload();
                        console.warn('unauthorized, logging out ...' + url);
                        postForm('/logout', {toLogin: true, to: location.pathname + location.search + location.hash});
                    }
                    reject(error.response.data);
                });
        });
};


export {apiRequest}
