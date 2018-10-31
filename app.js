const express = require('express');
const fileUpload = require('express-fileupload');
const controller = require('./controller/archive_controller');
const port = process.env.port || 5000;

var app = express();

app.use(fileUpload());
app.use(express.static('upload'));
app.use(express.static('manifest'));

app.get('/', (req, res) => {
    res.sendfile("./public/index.html");
});

app.post('/', (req, res) => {
    
    if(!req.files) return res.status(400).send('No Files'); 

    let uploadedFile = req.files.fileName;
    let newName = uploadedFile.md5+"."+uploadedFile.name.split('.').pop();

    uploadedFile.mv('./upload/'+newName, (error) => {
        if(error) res.status(400).send('Error on Uploading File');

        let payload = {'fullName': uploadedFile.name, 
                    'mimeType': uploadedFile.mimetype,
                    'extension': uploadedFile.name.split('.').pop(),
                    'newName': uploadedFile.md5+"."+uploadedFile.name.split('.').pop(),
                    'uploadPath': 'http://'+req.get('Host')+"/"+newName,
                    'md5': uploadedFile.md5,
                    'hostName': req.get('Host')
                };

        controller.getLink(payload)
            .then((data) => {

                res.status(200).send(data);
            })
            .catch((error) => {
                res.status(400).send(error);
            }) ;
    });
});

app.listen(port, console.log(`Server running at ${port} 🔥`));