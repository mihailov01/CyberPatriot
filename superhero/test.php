


<?php
    $div_block = 0; //В самом начале файла объявите переменную

    foreach($stack as $key => $count){  //выводим окончательный вариант
    
        if($div_block === 0){ //Если значение равно нулю открывает новый DIV
        echo '<div id="mySlide" class="mySlides fade">
        ';
        }
    
        echo "<div class='block'>"; //открываем див
        echo "<a href=/" . $xfield . "/";  //открываем ссылку
        echo $key; //подставляем значение для поиска
        echo ">";
        echo $key; //имя ссылки
        echo "</a>"; //закрываем ссылку
        echo "<br><span>";  //открываем спан
        echo declOfNum($count, array('год', 'года', 'годов'));//кол-во повторов со склонением
        echo "</span>"; //закрываем спан
        echo "</div>"; //закрываем див
    
        $div_block++; //Добавляем единицу
        if($div_new === 2){ //Прошло 2 значение, значит закрываем DIV и обнуляем счетчик
        echo '</div>';
        $div_new = 0;
        }
    }