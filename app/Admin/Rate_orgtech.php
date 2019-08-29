<?php
use App\Rate_orgtech;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Rate_orgtech::class, function(ModelConfiguration $model){
    $model->setTitle('Заявки на оргтехнику');

    $model->onDisplay(function (){
        $display = AdminDisplay::datatables();
        $display->with('article_orgtech');
        $display->setOrder([[8, 'desc']]);
        $display->disablePagination(true);


        $display->setColumnFilters(
            [
                null,
                AdminColumnFilter::text()->setPlaceholder('Инв. номер')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('Модель')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('Тип')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('ФИО')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('Филиал')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('Стоимость'),
                AdminColumnFilter::text()->setPlaceholder('Ставка'),
                null,
            ]
        )->setPlacement('panel.heading');

        $display->setFilters(
            AdminDisplayFilter::field('orgtech_id')->setTitle('OID [:value]')
        );

        $display->setColumns([
                   AdminColumn::text('article_orgtech.id')->setLabel('oid')->setWidth('80px')->append(
                        AdminColumn::filter('orgtech_id')
                    ),
                   AdminColumn::text('article_orgtech.inventar')->setLabel('Инвентарный номер'),
                   AdminColumn::link('article_orgtech.model')->setLabel('Модель'),
                   AdminColumn::text('article_orgtech.type')->setLabel('Тип устройства'),
                   AdminColumnEditable::text('username')->setLabel('ФИО'),
                   AdminColumnEditable::text('area')->setLabel('Филиал/участок'),
                   AdminColumn::text('article_orgtech.start_price')->setLabel('Начальная стоимость'),
                   AdminColumn::text('price')->setLabel('Ставка'),
                   AdminColumn::datetime('created_at')->setLabel('Дата ставки')->setFormat('d.m.Y H:i')
                ]);
        return $display;
    });


    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setItems([
            AdminFormElement::text('username', 'ФИО')->required(),
            AdminFormElement::text('area','Филиал/участок')->required(),
            AdminFormElement::text('price','Ставка'),
            AdminFormElement::datetime('created_at','Дата ставки')->required(),
        ]);

        $form->getButtons()->setSaveButtonText('Сохранить')->hideSaveAndCloseButton();

        return $form;
       
    }); 
});
