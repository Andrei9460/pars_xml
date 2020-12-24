<?php
error_reporting(0);

echo"start";
$path = "000000002";  // директория, с которой стартовать сканирование

function get_files($path, $order = 0, $mask = '*') {
    $fdir = array();
    if (false !== ($files = scandir($path, $order))) {
        foreach ($files as $file_name) {
            if ($file_name != '.' && $file_name != '..' && fnmatch($mask, $file_name)) {
                $fdir[] = $path.'/'.$file_name;
            }
        }
    }
    return ($fdir);
}

$d = dir($path);
if ($d) {
    $dirs = array($path);
    // Считываем все директории
    while (false !== ($name = $d->read())) {
        if ($name === '.' || $name === '..') continue;
        $fullPath = $path.'/'.$name;
        if (is_dir($fullPath)) {
            $dirs[] = $fullPath;
        }
    }
    $d->close();


    foreach($dirs as $cd){
        // Вызов функции get_files():
        // второй параметр - сортировка 1 или 0,
        // третий параметр - расширение файлов
        $files = array_filter(get_files($cd, 0, '*.xml'));

        foreach($files as $file_path){

            if (file_exists($file_path)) {
                print_r($file_path);
                $xml = simplexml_load_file($file_path);

                foreach($xml->Каталог->Товары->Товар as $file_path){
                    if(strpos($file_path->Картинка, ".jpeg") !== false){
                        //print_r($file_path->Картинка);
                        echo $file_path->Наименование;
                        echo $file_path->Картинка;
                        echo "<br>";
                    }
                }

                //echo"$img_list";
            } else {
                exit('Не удалось открыть файл .xml.');
            }
        }

    }

}