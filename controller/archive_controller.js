const tiny = require('../utils/shortURL');
const file = require('../utils/file_manager');

function getLink(payload) {

    const p = new Promise((resolve, reject) => {

        if(payload.mimeType != null) {

            //For iOS
            if(payload.mimeType == 'application/octet-stream') {
                
                // 1. Load Manifest Template
                file.read('./utils/manifest_template.txt')
                    .then((data) => {
    
                        // 2. Prapre Manigfest File
                        data = data.replace('BUILD_NAME', payload.fullName);
                        data = data.replace('BUILD_VERSION', '1.0.1');
                        data = data.replace('BUILD_BUNDLE_ID','com.apple.developer');
                        data = data.replace('BUILD_FULL_PATH', payload.uploadPath);
    
                        // 3.Create Manifest.plist file
                        let manifestPath = './manifest/'+payload.md5+'.plist';

                        file.write(manifestPath)
                            .then((hasWritten) => {

                                // 4. Create tinyURL of Manifest Path
                                let publicManifest = 'http://'+payload.hostName+'/'+payload.md5+'.plist';

                                if(hasWritten) {
                                    tiny.shorten(publicManifest)
                                    .then((shortURL) => {

                                        //5. Success
                                        resolve(shortURL);
                                    })
                                    .catch((error) => reject(error));
                                }
                                else {
                                    reject(new Error('Error on creating Manifest.plist file'));
                                }
                            })
                            .catch((error) => {
                                reject(error);
                            });
                    })
                    .catch((error) => {
                        reject(error);
                    });    
            }
            // For Android 
            else if(payload.mimeType == 'application/vnd.android.package-archive') {
                
                // Convert the Actual Build Path into tinyURL
                tiny.shorten(payload.uploadPath)
                    .then((shortURL) => {
                        resolve(shortURL);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            }
            // Unknown Type
            else {
    
            }
        }

    });
    return p;

}

module.exports.getLink = getLink;