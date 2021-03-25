const baseURL = 'http://localhost/bidmca/public/api/';
const webUrl = 'http://localhost/bidmca/public';
const storageURL = 'http://localhost/bidmca/public/storage/';

const headers = () => {
    const headers = {
        'Content-Type': 'application/json'
    };

    return headers;
};

const request = (method, path, body) => {
    const url = `${baseURL}${path}`;
    const options = {method, url, headers: headers()};

    if (body) {
        options.data = body;
    }

    return axios(options);
};


class API {
    sendOtp(inputData){
        return request('POST', 'send-otp', inputData);
    }

    verifyOtp(inputData){
        return request('POST', 'verify-otp', inputData);
    }

    register(inputData){
        return request('POST', 'users', inputData);
    }

    getCities(stateId){
        return request('GET', `common/get-cities/${stateId}`);
    }

    storeApplication(inputData){
        return request('POST', `application/store`, inputData);
    }

    fileUpload(inputData){
        return request('POST', `common/file-upload`, inputData);
    }
}
