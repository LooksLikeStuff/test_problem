<?php

if(!empty($_POST["string"])) {

    $string = $_POST["string"];
    $ru = 0;
    $eng = 0;
    $finalString = "";
    $history = '';

    $validateString = mb_str_split($string); // Преобразуем полученную строку в массив с учетом того что строка - многобайтовая


    //Если строка проверялась по нажатию кнопки "проверить" добавляем строку в базу данных
    if($_POST["submit"] == "submit"){
        include_once "db.php";
    }


 // Считаем кол-во символов в русской и английской раскладке с помощью функции ord(), чтобы определить язык строки
    foreach ($validateString as $value) {
        $symbol = ord($value);
        if($symbol >= 65 && $symbol <= 122) {
            $eng += 1;
        } elseif ($symbol >=192 && $symbol <= 255) {
            $ru += 1;
        } else continue;
    }

    $language = $ru >= $eng ? "ru" : "eng";

    //Если язык руский, прячем английские символы в тэг <strong> чтобы они стали жирными
    if($language == "ru") {
        foreach ($validateString as $key => $value) {
            $symbol = ord($value);
            if ($symbol >= 65 && $symbol <= 122) {
                $validateString[$key] = "<strong>$value</strong>";
            }
            $finalString .= $validateString[$key];



        }

        //Если язык английский, прячем русские символы в тег <strong> чтобы они стали жирными
    } else {
            foreach ($validateString as $key => $value) {
                $symbol = ord($value);
                if($symbol >= 192 && $symbol <= 255) {
                    $validateString[$key] = "<strong>$value</strong>";
                }
                $finalString .= $validateString[$key]; //
        }
    }

    $returnedArray = array(
        "lang" => $language,
        "string" => $finalString,
        "history" => $history
    );

    echo json_encode($returnedArray);
}