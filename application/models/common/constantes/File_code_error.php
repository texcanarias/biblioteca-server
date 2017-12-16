<?php

namespace serve\src\common\constantes;

class File_code_error {

    /**
     * @var int There is no error, the file uploaded with success.
     */
    static $UPLOAD_ERR_OK = 0;

    /**
     *
     * @var int The uploaded file exceeds the upload_max_filesize directive in php.ini. 
     */
    static $UPLOAD_ERR_INI_SIZE = 1;

    /**
     *
     * @var int  The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.
     */
    static $UPLOAD_ERR_FORM_SIZE = 2;

    /**
     *
     * @var int  The uploaded file was only partially uploaded.
     */
    static $UPLOAD_ERR_PARTIAL = 3;

    /**
     *
     * @var int  No file was uploaded.
     */
    static $UPLOAD_ERR_NO_FILE = 4;

    /**
     *
     * @var int  Missing a temporary folder. Introduced in PHP 5.0.3.
     */
    static $UPLOAD_ERR_NO_TMP_DIR = 6;

    /**
     *
     * @var int  Failed to write file to disk. Introduced in PHP 5.1.0.
     */
    static $UPLOAD_ERR_CANT_WRITE = 7;

    /**
     *
     * @var int  A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help. Introduced in PHP 5.2.0.
     */
    static $UPLOAD_ERR_EXTENSION = 8;

}
