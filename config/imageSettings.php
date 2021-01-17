<?php
/**
 * @author Robin Beck
 */

$supportedFiles = array('jpg', 'png', 'jpeg');

//max image size : 3 MB
define('MAX_FILE_SIZE', 3000000);

define('FALLBACK_IMAGE'      , 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'fallback.jpg');
define('PRODUCT_IMAGE_PATH'  , 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products');
define('PRODUCT_THUMBNAIL_PATH', 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'thumbnails');
define('THUMBNAIL_WIDTH', 300);
define('THUMBNAIL_QUALITY', 60);