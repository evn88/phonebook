## Об аукционе

Веб-приложение для продажи техники по принципу аукциона.

![screen](/public/images/screen.png)
<!-- https://github.com/evn88/technosale/blob/master/public/images/screen.png -->

Возможности: 
- Бронировать технику пользователем без регистрации, но с подтверждением эл. почты;
- Повышать ставку лота, с подтверждением по e-mail;
- Вывод отчетов по результатам аукциона;
- Админка SleepingOWl https://github.com/LaravelRUS/SleepingOwlAdmin

## Установка
1. Клонируйте репозиторий <code>git clone https://github.com/evn88/technosale.git</code>
2. Скопируйте и переименуйте файл <b>.env.example</b>  в <b>.env</b>, далее укажите ваши настройки для БД и вашего почтового сервера, через который будут отправляться сообщения.
3. <code>composer install</code>
4. <code>npm install</code>
5. <code>php artisan vendor:publish --tag=assets --force</code>
6. <code>php artisan migrate</code>
7. Аукцион использует очереди и Supervisor https://laravel.ru/docs/v5/queues
8. Установите Supervisor <code>sudo apt-get install supervisor</code>
9. Файлы настроек Supervisor обычно находятся в папке /etc/supervisor/conf.d. Там вы можете создать любое количество файлов с настройками, по которым Supervisor поймёт, как отслеживать ваши процессы. Для работы аукциона, создадим файл laravel-worker-auction.conf, который запускает и наблюдает за процессом queue:work:
<pre>
   [program:laravel-worker-auction]
    process_name=%(program_name)s_%(process_num)02d
    command=php /data/wwwroot/[ПУТЬ ДО ПРИЛОЖЕНИЯ]/technosale/artisan queue:work --sleep=3 --tries=3 --daemon
    autostart=true
    autorestart=true
    user=www-data
    numprocs=4
    redirect_stderr=true
    stdout_logfile=/data/wwwroot/[ПУТЬ ДО ПРИЛОЖЕНИЯ]/technosale/storage/logs/worker.log
</pre>
Подробнее о Supervisor читайте в его [документации](http://supervisord.org/index.html).

10. После создания файла настроек вы можете обновить конфигурацию Supervisor и запустить процесс при помощи следующих команд: <br>
    <code>sudo supervisorctl reread</code><br>
    <code>sudo supervisorctl update</code><br>
    <code>sudo supervisorctl start laravel-worker:*</code>

11. Для входа в админку вам потребуется создать учетную запись. Регистрация по умолчанию доступна только авторизованным пользователям, что бы исправить это перейдите в <code>\app\Http\Controllers\Auth\RegisterController.php </code>
    Закомментируйте в конструкторе строку:
    <code>$this->middleware('auth');</code>
    Это позволит вам зарегистрировать пользователя по адресу [Адрес сайта]/register

12. Заключительным этапом необходимо загрузить данные о продаваемой технике. Компьютеры и оргтехника разделены и никак не связанны. Для загрузки данных используйте HediSQL или phpMyAdmin импортируя файлы <b>.csv</b> в таблицы <code>article_pc</code> и <code>article_orgtech</code> соответственно.
## License

open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
