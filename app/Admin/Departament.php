<?php
use App\Departament;
use SleepingOwl\Admin\Model\ModelConfiguration;


AdminSection::registerModel(Departament::class, function(ModelConfiguration $model){
    $model->setTitle('Справочник отделов и служб');

    $model->onDisplay(function (){
        $display = AdminDisplay::datatables();
        // $display->with('people');
        // $display->setOrder([[3, 'desc']]);
        $display->disablePagination(true);


        // $display->setColumnFilters(
        //     [
        //         null,
        //         AdminColumnFilter::text()->setPlaceholder('Название филиала')->setOperator('begins_with'),
        //         null,
        //         null,
        //     ]
        // )->setPlacement('panel.heading');

        // $display->setFilters(
        //     AdminDisplayFilter::field('orgtech_id')->setTitle('OID [:value]')
        // );

        $display->setColumns([
                   AdminColumn::text('filials.id')->setLabel('fid')->setWidth('80px'),
                   AdminColumn::text('filials.name')->setLabel('Название отдела'),
                   AdminColumn::text('filials.order')->setLabel('Сортировка')
                ]);
        return $display;
    });


    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setItems([
            AdminFormElement::text('filials.name', 'Название отдела')->required(),
            AdminFormElement::text('order','Сортировка')->required()
        ]);

        $form->getButtons()->setSaveButtonText('Сохранить')->hideSaveAndCloseButton();

        return $form;
       
    }); 
});
