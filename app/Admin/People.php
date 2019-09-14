<?php
use App\People;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(People::class, function(ModelConfiguration $model){
    $model->setTitle('Контакты');

    $model->onDisplay(function (){
        $display = AdminDisplay::datatables();
        $display->with('people');
        $display->setOrder([[8, 'desc']]);
        $display->disablePagination(true);

        $display->setColumnFilters(
            [
                null,
                AdminColumnFilter::text()->setPlaceholder('Инв. номер')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('Конфигурация')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('Монитор')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('ФИО')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('Филиал')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('Стоимость'),
                AdminColumnFilter::text()->setPlaceholder('Ставка'),
                null,
            ]
        )->setPlacement('panel.heading');

        $display->setFilters(
            AdminDisplayFilter::field('pc_id')->setTitle('PID [:value]')
        );

        $display->setColumns([
                   AdminColumn::text('people.id')->setLabel('pid')->setWidth('80px')->append(
                        AdminColumn::filter('filial_id')
                   ),
                   AdminColumnEditable::text('people.name')->setLabel('ФИО'),
                   AdminColumnEditable::text('people.profession')->setLabel('Должность'),
                   AdminColumnEditable::text('people.short_number')->setLabel('Короткий номер'),
                   AdminColumnEditable::text('people.ext_number')->setLabel('Внешний номер'),
                   AdminColumn::text('people.speed_number')->setLabel('Быстрый набор (ЦРПБ)'),
                   AdminColumn::text('people.mobile_number')->setLabel('Мобильный'),
                   AdminColumn::datetime('people.birthday')->setLabel('День рождения')->setFormat('d.m.Y'),
                   AdminColumnEditable::text('people.order')->setLabel('Сортировка'),
        ]);
        return $display;
    });


    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setItems([
                AdminFormElement::text('name', 'ФИО')->required(),
                AdminFormElement::text('profession','Профессия')->required(),
                AdminFormElement::text('short_number','Короткий номер'),
                AdminFormElement::text('ext_number','Внешний номер'),
                AdminFormElement::text('speed_number','Быстрый набор (ЦРПБ)'),
                AdminFormElement::text('mobile_number','Мобильный'),
                AdminFormElement::datetime('birthday','День рождения'),
            ]);

        $form->getButtons()->setSaveButtonText('Сохранить');

        return $form;
       
    }); 
});
