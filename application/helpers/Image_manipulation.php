<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Image_manipulation {

    /**
     * @var array Configuracion de la imagen que se va a crear
     */
    private static $config;
    
    /**
     * CodeIgniter super object
     *
     * @var object
     */
    private static $CI;

    private static function init() {
        // Get the CodeIgniter super object
        self::$CI = & get_instance();

        // Load the Library
        self::$CI->load->library('image_lib');

        // Configuration
        self::$config['image_library'] = 'gd2';
    }

    /**
     * Crea una miniatura de una imagen
     * 
     * @param string    $source_image Ruta hacia la imagen original
     * @param string    $new_image Ruta hacia la imagen nueva
     * @param int       $width Anchura de la miniatura
     * @param int       $height Altura de la miniatura
     * @param bool      $maintain_ratio Especifica si mantenemos el ratio o la deformamos
     */
    public static function imageThumb($source_image, $new_image, $width, $height, $maintain_ratio = TRUE) {
        self::init();

        self::$config['source_image'] = $source_image;
        self::$config['new_image'] = $new_image;
        self::$config['create_thumb'] = TRUE;
        self::$config['width'] = $width;
        self::$config['height'] = $height;
        self::$config['maintain_ratio'] = $maintain_ratio;
        self::$config['thumb_marker'] = '';

        self::$CI->image_lib->initialize(self::$config);

        // handle if there is any problem
        if (!self::$CI->image_lib->resize()) {
            echo "Errors image_lib <br />";
            echo "<pre>";
            print_r(self::$CI->image_lib->display_errors());
            echo "</pre>";
        }

        // Clear
        self::$CI->image_lib->clear();
    }

    /**
     * Redimensiona una imagen
     */
    public function imageResize() {
        self::init();
    }

    /**
     *  Recorta una imagen
     */
    public function imageCrop() {
        self::init();
    }

    /**
     * Crea una marca de agua a una imagen
     */
    public function imageWatermark() {
        self::init();
    }

}
