<?php
require_once 'vendor/autoload.php';
require_once 'config/conf.php';
?>

var xhr = new XMLHttpRequest();
xhr.open('GET', '<?php echo config\registry::get('HOST');?>', true);

xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            console.log("ok");
        } else {
            console.error('Request failed with status:', xhr.status);
        }
    }
};

xhr.send();
