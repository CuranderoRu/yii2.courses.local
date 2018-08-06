/**
 * Created by Sergey on 06.08.2018.
 */
function SelectChange() {
    $.ajax({
        method: "GET", // метод HTTP, используемый для запроса
        url: "tasktable", // строка, содержащая URL адрес, на который отправляется запрос
        data: { // данные, которые будут отправлены на сервер
            project: $("#task-project_id").val(),
            month: $("#task-month").val()
        },
        success: [function ( msg ) {
            $( "#calendar_table" ).html( msg ); // добавляем текстовую информацию и данные возвращенные с сервера
            console.log(msg);
        }],
        statusCode: {
            200: function () { // выполнить функцию если код ответа HTTP 200
                console.log( "Ok" );
            }
        }
    });


}