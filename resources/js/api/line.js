import {apiRequest} from './apiRequest'
import {PAPERLESS_CONST} from '../constant'

const getLines = () => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/line/', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getLinesByUserId = (userId) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/line/user/' + userId, PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getLinesByDepId = (depId) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/line/department/' + depId, PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getInfoLine = (id) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/line/' + id, PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getMicroByLineId = (id) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/line/' + id + '/micros', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getMicrosByDepIdWidthLineIdNull = (departmentId) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/line/add/micros/' + departmentId , PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const getMicrosByDepIdWidthLineIdCurrentOrNull = (lineId, depId) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/line/edit/' + depId + '/' + lineId + '/micros', PAPERLESS_CONST.api_method.get)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const createLine = (dataLine) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/line/', PAPERLESS_CONST.api_method.post, dataLine)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const updateLine = (dataLine) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/line/' + dataLine.id, PAPERLESS_CONST.api_method.put, dataLine)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const updateIsRunningForLine = (lineId, data) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/line/isrunning/' + lineId, PAPERLESS_CONST.api_method.put, data)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const deleteLine = (id) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/line/' + id, PAPERLESS_CONST.api_method.delete)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

const updateCheckedForLine = (id, checked) => {
    return new Promise(
        (resolve, reject) => {
            apiRequest('/api/line/checked/' + id, PAPERLESS_CONST.api_method.put, checked)
                .then(response => {
                    resolve(response.data);
                })
                .catch(function (error) {
                    reject(error);
                });
        }
    );
};

export { getLines, getInfoLine, getLinesByUserId, getLinesByDepId, createLine,
     updateLine, deleteLine, getMicroByLineId, getMicrosByDepIdWidthLineIdNull,
      getMicrosByDepIdWidthLineIdCurrentOrNull, updateIsRunningForLine, updateCheckedForLine }