<?php
//use App\Peoples;
use App\Article_orgtech;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Article_orgtech::class, function(ModelConfiguration $model){
    $model->setTitle('Компьютеры');

    $model->onDisplay(function (){
        $display = AdminDisplay::datatables();
        $display->setFilters(
            AdminDisplayFilter::field('filial')->setTitle('Филиал [:value]')
        );
        $display->disablePagination(true);

        $display->setColumns([
                   AdminColumn::checkbox(),
                   AdminColumn::text('year')->setLabel('Год выпуска'),
                   AdminColumn::text('filial')->setLabel('Филиал'),
                   AdminColumn::text('inventar')->setLabel('Инвентарный номер'),
                   AdminColumn::link('model')->setLabel('Модель'),
                   AdminColumn::text('type')->setLabel('Тип устройства'),
                   AdminColumn::text('status')->setLabel('Состояние'),
                //    AdminColumn::datetime('date_entry')->setLabel('Дата ввода')->setFormat('d.m.Y'),
                   AdminColumn::text('start_price')->setLabel('Начальная стоимость'),
                   AdminColumn::datetime('created_at')->setLabel('Дата создания')->setFormat('d.m.Y H:i')
                ]);
        return $display;
    });


    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setItems([
                AdminFormElement::text('year','Год выпуска')->required(),
                AdminFormElement::text('filial','Филиал')->required(),
                AdminFormElement::text('inventar','Инвентарный номер')->required(),
                AdminFormElement::text('model','Модель')->required(),
                AdminFormElement::text('type','Тип устройства')->required(),
                AdminFormElement::text('status','Состояние'),
                // AdminFormElement::date('date_entry','Дата ввода')->required(),
                AdminFormElement::text('start_price','Начальная стоимость')->required(),
            ]);

        $form->getButtons()->setSaveButtonText('Сохранить')->hideSaveAndCloseButton();

        return $form;
       
    }); 
});
