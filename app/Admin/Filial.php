<?php
use App\Filial;
use SleepingOwl\Admin\Model\ModelConfiguration;


AdminSection::registerModel(Filial::class, function(ModelConfiguration $model){
    $model->setTitle('Справочник филиалов');

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
                   AdminColumn::text('filials.name')->setLabel('Название филиала'),
                   AdminColumn::text('filials.order')->setLabel('Сортировка')
                ]);
        return $display;
    });


    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setItems([
            AdminFormElement::text('filials.name', 'Название филиала')->required(),
            AdminFormElement::text('order','Сортировка')->required()
        ]);

        $form->getButtons()->setSaveButtonText('Сохранить')->hideSaveAndCloseButton();

        return $form;
       
    }); 
});
