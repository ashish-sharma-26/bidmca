const baseURL = 'http://localhost/bidmca/public/api/';

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

    getUser(){
        return request('GET', 'users');
    }
}
