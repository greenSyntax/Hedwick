## IPA Distribution

An PHP App which lets you share your AdHoc IPA File

### Overview

This is a web-platform which allow developers to share their AdHoc IPA build with testers. You pass on your App Name, App's Bundle ID, Version Number along with the IPA • file. App will return you with a LINK which you can share with people around the world.

### Deployment
Change the Hostname macro in **/include/constant**
```php
<?php

//WebHost
define("HOST_NAME", "http://app.greensyntax.co.in");

//For Local : http://localhost:7070/app/Share

?>
```

### Project Structure

* css
* images
* include
* manifest
* temp
* uploads
* vendor
* index.php
* /css

Application level custom styling i.e. style.css

### /images

No Use

### /manifest

Directory with (755 Permission) where app will store manifest.plist file. Files will have random text.

### /uplosds

Directory with (755 Permission) where app will store *ipa files. Files Name are in timestamp format.

### /include

* constant.php  Application level constant, error messages and HTML Litrals.
* file_manager.php Hanldes File read-write intraction. Here, we handleing manifest.plist write operation.
* form_model.php Model for User Input
* global_context.php Manage Current Session for the application.
* log_manager.php Handles the Log management. It keeps all the log in history.log file
* tiny_url_manager.php Its shorten the genrated URL into tiny url.
* upload_manager.php  Handles IPA Build Upload management.
* utility.php Utils method are defined in this class.
* validation_manager.php  Has Validation related methods.
* zipper.php  Handles Zip and Unzip opearation.
* /vendor (Third Party Files)

### /composer
*/css/bootstrap.min.css
* /fonts
* /guzzelhttp
* /js/bootstrap.min.js
* /monolog
* /psr
* autoload.php

### Bugs
Please post any bugs to the issue tracker found on the project's GitHub page.
Please include the following with your issue:
* a description of what is not working right
* sample code to help replicate the issue
