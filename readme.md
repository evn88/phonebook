## Об телефонной книге

Веб-приложение для размещения локального телефонного справочника компании.

<!-- ![screen](/public/images/screen.png) -->
<!-- https://github.com/evn88/technosale/blob/master/public/images/screen.png -->

Возможности: 
- Поиск контактов по ФИО, должности и номерам телефонов;
- Приложение обращается один раз к серверу за списком контактов, все остальное время можно использовать без соединения с сервером;
- Возможность задавать фильтры для филиалов и отделов;
- Админка SleepingOWl https://github.com/LaravelRUS/SleepingOwlAdmin

## Установка
1. Клонируйте репозиторий <code>git clone https://github.com/evn88/phonebook.git</code>
2. Скопируйте и переименуйте файл <b>.env.example</b>  в <b>.env</b>, далее укажите ваши настройки для БД и вашего почтового сервера, через который будут отправляться сообщения.
3. <code>composer install</code>
4. <code>npm install</code>
5. <code>php artisan vendor:publish --tag=assets --force</code>
6. <code>php artisan migrate</code>
7. <code>php artisan db:seed</code> <br>После выполнения этой команды будет создан стандартный пользователь для входа в админку:

    логин: admin@admin.ru <br>
    пароль: admin

    После авторизации будет доступна регистрация новых пользователей, рекомендуется зарегистрировать нового пользователя и удалить старого или сменить пароль у существующего. 


8. Заключительным этапом необходимо загрузить данные о контактах. Для этого используйте админку.

## License

open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
