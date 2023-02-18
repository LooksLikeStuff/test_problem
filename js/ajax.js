$("document").ready(function () {


    // создаем функцию которая отправляет запрос обработчику php который возращает массив в json формате
    function requireAjax(ourString, type = "blur") {

        $.ajax({
            method: "post",
            url: "/php/validate.php",
            data: {
                string: ourString,
                submit: type
            },
            dataType: "json",
        })

            .done(function (msg) {

                $(".alert.alert-success").html("<h1>Латинские символы выделены жирным</h1> " + "<br>" + msg.string + "<p>Язык строки:" + "<strong>" + msg.lang + "</strong>" + "</p>");//Выводим обработанную строку и ее язык
                $("#string").val(ourString);


                //Проверяем, создана ли история вводимых строк и не появились ли в ней новые строки. Если нет то создаем ее.
                if(!($("#history").length)) {

                    $(".valid__string").prepend("<div class='form-group'><select class='form-control' id='history'></select></div>"); //Создаем для нашей формы селектор в который будем выводить историю наших строк

                    msg.history.forEach(function (item){
                        $("#history").prepend("<option id='history-option'>" + item + "</option>"); //С помощью foreach добавляем в селектор наши строки из бд
                    });

                }
            })

            .fail(function (msg) {
                alert(msg);
            })
    }



    $(".valid__string").submit(function (event){

        event.preventDefault();  //Останавливаем событие submit

        ourString = $("#string").val();  //Получаем введенную строку

        if(ourString == "") return false;  //Если переданная строка пустая прерываем обработку события

        requireAjax(ourString, "submit");


        //Событие для селектора history в котором при выборе нужной строки она автоматически вставляется в input
        $(document).on('change', '#history', function() {
            $("#string").val($("#history option:selected").text());
        });

        $("#string").blur(function (){   //После срабатывания события submit активируем событие blur, чтобы строка обрабатывалась автоматически

            ourString = $("#string").val()

            if(ourString == "") return false;  //Если переданная строка пустая прерываем обработку события

            requireAjax(ourString);

            $("#string").val(ourString);

            })
        })



})