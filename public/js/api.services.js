// const baseURL = 'http://localhost/bidmca/public/api/';
// const webUrl = 'http://localhost/bidmca/public';
// const storageURL = 'http://localhost/bidmca/public/storage/';

const baseURL = 'http://13.212.91.216/api/';
const webUrl = 'http://13.212.91.216';
const storageURL = 'http://13.212.91.216/storage/';

/**
 *
 * @returns {{"Content-Type": string}}
 */
const headers = () => {
    const headers = {
        'Content-Type': 'application/json'
    };

    return headers;
};

/**
 *
 * @param method
 * @param path
 * @param body
 * @returns {never|AxiosPromise}
 */
const request = (method, path, body) => {
    const url = `${baseURL}${path}`;
    const options = {method, url, headers: headers()};

    if (body) {
        options.data = body;
    }

    return axios(options);
};


class API {
    /**
     *
     * @param inputData
     * @returns {AxiosPromise}
     */
    sendOtp(inputData){
        return request('POST', 'send-otp', inputData);
    }

    /**
     *
     * @param inputData
     * @returns {AxiosPromise}
     */
    verifyOtp(inputData){
        return request('POST', 'verify-otp', inputData);
    }

    /**
     *
     * @param inputData
     * @returns {AxiosPromise}
     */
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

    placeBid(inputData){
        return request('POST', `application/bid`, inputData);
    }

    validateBidScore(inputData){
        return request('POST', `application/validate-bid-score`, inputData);
    }

    generatePlaidLinkToken(){
        return request('GET', `plaid/link-token`);
    }

    storePlaidInfo(inputData){
        return request('POST', `plaid/public-token`, inputData);
    }
}
