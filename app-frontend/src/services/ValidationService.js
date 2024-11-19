export default {
    getFirstErrorMessage(response) {
        for (let key in response) {
            if (response.hasOwnProperty(key)) {
                if (Array.isArray(response[key]) && response[key].length > 0) {
                    return response[key][0];
                }
            }
        }
        return null;
    }
};
