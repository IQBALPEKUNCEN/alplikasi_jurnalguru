<?php
/* 
 * masih ada bug jika didalam model yang dipanggil didalam model tersebut memanggil class lain yang 
 * class tersebut berada diluar app/models.
 */

class FlightAppAutoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {

            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class);

            // var_dump(substr($file, 0, 3));
            /* 
             * jika namespace class yang dipanggil memiliki awalan api maka akan dicari dengan metode required, 
             * selain itu abaikan.
             */
            if (substr($file, 0, 3) == 'api') {
                $file = str_replace('api', 'app', $file);
                $file = $file . '.php';
                // echo '<br>';
                // var_dump($file);
                if (file_exists($file)) {
                    require $file;
                    return true;
                }
                return false;
            }
        });
    }
}
FlightAppAutoloader::register();
