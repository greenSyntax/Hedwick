const fs = require('fs');

function read(pathOfFile) {

    const p = new Promise((resolve, reject) => {
        fs.readFile(pathOfFile, 'utf8', (error, data) => {
            if(error) reject(error);
            resolve(data);
        });
    });
    return p;
}

function write(pathOfFile, data) {
    const p = new Promise((resolve, reject) => {
        fs.writeFile(pathOfFile, data, { flag: 'w' }, (error) => {
            if(error) reject(error);
            resolve(true);
        });
    });
    return p;
}

module.exports.read = read;
module.exports.write = write;