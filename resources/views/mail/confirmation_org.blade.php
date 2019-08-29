<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width"/>
        <title>Подтверждение ставки</title>
        <link rel="stylesheet" href="" />
    </head>
    <body>
    <h1>Подтверждение ставки</h1>
    <p style="color:slategrey; font-size:13px;">Пользователь: {{ $username }}</p>
        <div class="box">
            <p style="padding:15px;"><b>Для продолжения необходимо "подтвердить ставку", 
                в ином случае она будет аннулирована через 5 минут</b>
            </p>

            <a href="https://portal.voel.ru/technosale/public/mailconfirm/{{ $hash }}/org/" 
                style="display:table; padding:15px; margin:20px; color:royalblue; text-align:center; border-radius:20px; height:10px; border:8px solid royalblue;">ПОДТВЕРДИТЬ СТАВКУ</a>
            <div style="padding:15px; margin:20px;">
                <p>После подтверждения вам придет уведомление.</p>
                <p>Если на ваш лот сделет ставку другой сотрудник, вы также получите уведомление на e-mail.</p>
            </div>
        </div>

        <div style="padding:15px; margin: 20px;">
            <h3>Описание вашего лота:</h3>
            <p>Филиал: {{ $org->filial }}</p>
            <p>Инв. номер: {{ $org->inventar }}</p>
            <p>Модель: {{ $org->model }}</p>
            <p>Тип: {{ $org->type }}</p>
            <p>Год выпуска: {{ $org->year }}</p>
            <p>Состояние: {{ $org->status }}</p>
            <p>Стоимость с учетом вашей ставки: <b>{{ $price }} ₽</b></p>
        </div>
        
        <p style="color:slategrey">Пожалуйста, не отвечайте на это письмо, оно сгенерированно автоматически!</p>
    </body>
</html>

