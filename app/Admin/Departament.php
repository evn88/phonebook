<?php
use App\Departament;
use SleepingOwl\Admin\Model\ModelConfiguration;


AdminSection::registerModel(Departament::class, function(ModelConfiguration $model){
    $model->setTitle('Справочник подразделений');

    $model->onDisplay(function (){
        $display = AdminDisplay::datatables();
        $display->setOrder([[2, 'asc']]);
        $display->disablePagination(true);


        $display->setColumnFilters(
            [
                null,
                AdminColumnFilter::text()->setPlaceholder('Название подразделения')->setOperator('begins_with'),
                null,
                null,
            ]
        )->setPlacement('panel.heading');

        // $display->setFilters(
        //     AdminDisplayFilter::field('id')->setTitle('ID [:value]')
        // );

        $display->setColumns([
                //    AdminColumn::text('id')->setLabel('fid')->setWidth('80px'),
                   AdminColumn::text('name')->setLabel('Название подразделения'),
                   AdminColumn::text('order')->setLabel('Сортировка')->setWidth('100px')
                ]);
        return $display;
    });


    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setItems([
            AdminFormElement::text('name', 'Название подразделения')->required(),
            AdminFormElement::text('order','Сортировка')->required()
        ]);

        $form->getButtons()->setSaveButtonText('Сохранить');


        return $form;
       
    }); 
});
