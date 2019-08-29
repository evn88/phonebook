<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/src/bootstrap4/css/bootstrap.min.css" rel="stylesheet">
    <link href="/src/fontawesome-5.10.1/css/all.css" rel="stylesheet"> 
    <title>Телефонный справочник</title>
</head>
<body>
<?php require_once('../menu.php'); ?>
<div class="container" id="app">
    <div class="row my-2">
        <div class="col-9">
            <h2>{{title}}</h2>
        </div>
        <div class="col-3 d-flex align-items-center justify-content-md-end">
            <a href="#" class="btn btn-light lead" @click="tooggleFilter"><i class="fas fa-filter"></i></a>&nbsp
            <a href="#" class="btn btn-light lead"><i class="far fa-question-circle"></i></a>
        </div>
    </div>

    <!-- Форма поиска -->
    <div class="row">
        <div class="col">
            <form>
                <div class="form-group">
                    <input type="search" name="search" class="form-control" placeholder="Поиск" autocomplete="off" autofocus="autofocus" v-model="search">
                </div>
            </form>
        </div>
    </div>
    {{search}}

    <!-- фильтр START -->
    <div class="form-row align-items-center" v-show="filtersShow"> <!--  .d-none -->
        <div class="col-auto my-2">
          <label class="mr-sm-3 sr-only" for="inlineFormCustomSelect">Preference</label>
          <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
            <option selected>Филиал...</option>
            <option value="1">ЦРПБ</option>
            <option value="2">Пригородные МЭС</option>
            <option value="3">Жирновские МЭС</option>
          </select>
        </div>
        <div class="col-auto my-2">
          <label class="mr-sm-3 sr-only" for="inlineFormCustomSelect">Preference</label>
          <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
            <option selected>Подразделение...</option>
            <option value="1">Группа по внедрению и обслуживанию средств связи и телемеханики</option>
            <option value="2">Контрольное управление</option>
          </select>
        </div>
        <div class="col-auto my-1">
          <div class="custom-control custom-checkbox mr-sm-2">
            <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
            <label class="custom-control-label" for="customControlAutosizing">Запомнить настройки фильтров</label>
          </div>
        </div>
    </div>
    <!-- фильтр END -->

    <!-- Список контактов -->
    <div class="row justify-content-md-center my-2">
        <div class="col-12 ">
            <div class="list-group accordion">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <div class="row">
                                <div class="col-6"> <b>ЦРПБ ПАО "ВОЭ"</b></div>
                                <div class="col-6 text-right"><small class="text-muted"><i class="fas fa-phone-alt"></i> Код: (8442); 400075, <i class="fas fa-home"></i> г. Волгоград, ул. Шопена, 13</small></div>
                            </div>    
                        </div>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12"><b>Контрольное управление</b></div>
                            </div>    
                        </div>
                    </div>

                    <button type="button" class="list-group-item list-group-item-action " id="headingOne"
                        data-toggle="collapse" data-target="#collapseOne" 
                        aria-expanded="false" aria-controls="collapseOne">
                        <div class="row">
                            <div class="col-4">Вершков Егор Николаевич</div>
                            <div class="col-6">Администратор безопасности информационных технологий</div>
                            <div class="col-2 text-right"><i class="fas fa-phone-alt"></i> <b>1083</b></div>
                        </div>
                    </button>

                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body bg-light">
                        <p>Должность: Администратор безопасности ИТ</p>
                        <p><i class="fas fa-phone-alt"></i> 56-20-88</p>
                    </div>
                    </div>

                    <button type="button" class="list-group-item list-group-item-action" id="heading2"
                    data-toggle="collapse" 
                    data-target="#collapse2" 
                    aria-expanded="false"
                    aria-controls="collapse2">
                        <div class="row">
                            <div class="col-4">Сказкоподателев Сергей Александрович</div>
                            <div class="col-6">Начальник</div>
                            <div class="col-2 text-right"><i class="fas fa-phone-alt"></i> <b>1070</b></div>
                        </div>
                    </button>
                    
                    <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordionExample">
                      <div class="card-body bg-light">
                        <p>Должность: Администратор безопасности ИТ</p>
                        <p><i class="fas fa-phone-alt"></i> 56-20-88</p>
                        <p><i class="fab fa-diaspora"></i> Быстрый набор: *653</p>
                      </div>
                    </div>
                    <div class="card">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-12"><b>Группа по внедрению и обслуживанию средств связи и телемеханики</b></div>
                            </div>    
                        </div>
                    </div>
                  
                    <button type="button" class="list-group-item list-group-item-action" id="heading3"
                    data-toggle="collapse" 
                    data-target="#collapse3" 
                    aria-expanded="false"
                    aria-controls="collapse3">
                        <div class="row">
                            <div class="col-4">Сказкоподателев Сергей Александрович</div>
                            <div class="col-6">Начальник</div>
                            <div class="col-2 text-right"><i class="fas fa-phone-alt"></i> <b>1120</b></div>
                        </div>
                    </button>
                    
                    <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionExample">
                      <div class="card-body bg-light">
                        <p>Должность: Администратор безопасности ИТ</p>
                        <p>56-20-88</p>
                        <p>Быстрый набор: *653</p>
                      </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <div class="row">
                                <div class="col-6"><b>ЦРПБ ПАО "ВОЭC"</b></div>
                                <div class="col-6 text-right"><small class="text-muted"><i class="fas fa-phone-alt"></i> Код: (8442); 400075, <i class="fas fa-home"></i> г. Волгоград, ул. Шопена, 13</small></div>
                            </div>    
                        </div>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12"><b>Контрольное управление</b></div>
                            </div>    
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="/src/js/jquery-3.4.1.min.js"></script>
<script src="/src/bootstrap4/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="main.js"></script>
</body>
</html>