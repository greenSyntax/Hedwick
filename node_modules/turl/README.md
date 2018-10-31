## node-turl

http://tinyurl.com URL Shortener Node.js Module

### Usage

```
const turl = require('turl');

turl.shorten('http://google.com').then((res) => {
  console.log(res);
}).catch((err) => {
  console.log(err);
});
```
