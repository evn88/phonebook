<?php
use App\Rate_pc;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Rate_pc::class, function(ModelConfiguration $model){
    $model->setTitle('Заявки на компьютеры');

    $model->onDisplay(function (){
        $display = AdminDisplay::datatables();
        $display->with('article_pc');
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
                   AdminColumn::text('article_pc.id')->setLabel('pid')->setWidth('80px')->append(
                        AdminColumn::filter('pc_id')
                   ),
                   AdminColumn::text('article_pc.inventar')->setLabel('Инвентарный номер'),
                   AdminColumn::text('article_pc.pcconfig')->setLabel('Конфигурация'),
                   AdminColumn::text('article_pc.monitor')->setLabel('Монитор'),
                   AdminColumnEditable::text('username')->setLabel('ФИО')->setWidth('250px'),
                   AdminColumnEditable::text('area')->setLabel('Филиал/участок'),
                   AdminColumn::text('article_pc.start_price')->setLabel('Начальная стоимость'),
                   AdminColumn::text('price')->setLabel('Ставка'),
                   AdminColumn::datetime('created_at')->setLabel('Дата ставки')->setFormat('d.m.Y H:i')
        ]);
        return $display;
    });


    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setItems([
                AdminFormElement::text('username', 'ФИО')->required(),
                AdminFormElement::text('email','e-mail'),
                AdminFormElement::text('ip','ip'),
                AdminFormElement::text('area','Филиал/участок')->required(),
                AdminFormElement::text('price','Ставка'),
                AdminFormElement::datetime('created_at','Дата ставки')->required(),
            ]);

        $form->getButtons()->setSaveButtonText('Сохранить');

        return $form;
       
    }); 
});
