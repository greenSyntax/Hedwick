const tinyURL = require('turl');

function shorten(passedURL) {

    const p = new Promise((resolve, reject) => {
        tinyURL.shorten(passedURL)
            .then((result) => {
                resolve(result);
            })
            .catch((error) => {
                reject(error);
            });
    }); 
    return p;
}

module.exports.shorten = shorten;