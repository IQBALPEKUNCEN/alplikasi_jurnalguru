<?php
/* 
 * masih ada bug jika didalam model yang dipanggil didalam model tersebut memanggil class lain yang 
 * class tersebut berada diluar app/models.
 */

class YiiModelAutoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {

            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class);

            // var_dump(substr($file, 0, 3));
            /* 
             * jika namespace class yang dipanggil memiliki awalan app maka akan dicari dengan metode required, 
             * selain itu abaikan karena kemungkinan class tersebut didapat dari vendor dan jika dari vendor, 
             * class tersebut sudah di required diatas.
             */
            if (substr($file, 0, 3) == 'app') {
                $file = '..' . DIRECTORY_SEPARATOR . $file . '.php';
                // echo '<br>';
                // var_dump($file);
                // echo '<br>';
                // var_dump(file_exists($file));
                if (file_exists($file)) {
                    require $file;
                    return true;
                }
                return false;
            }
        });
    }
}
YiiModelAutoloader::register();
