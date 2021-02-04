<?php
/**
 * This file contains several settings for images
 * @author Robin Beck
 */

$supportedFiles = array('jpg', 'png', 'jpeg');

//max image size : 3 MB
define('MAX_FILE_SIZE', 3000000);

define('FALLBACK_IMAGE'      ,   'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'fallback.jpg');
//change, if you want to move the product images folder structure to another folder
define('PRODUCT_IMAGE_PATH'  ,   'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products');
//change, if you want to move the product thumbnail folder structure to another folder
define('PRODUCT_THUMBNAIL_PATH', 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'thumbnails');
//height will be calculated automatically by keeping the proportions
define('THUMBNAIL_WIDTH', 300);
define('THUMBNAIL_QUALITY', 60);