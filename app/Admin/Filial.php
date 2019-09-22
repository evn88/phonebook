<?php
use App\Filial;
use SleepingOwl\Admin\Model\ModelConfiguration;


AdminSection::registerModel(Filial::class, function(ModelConfiguration $model){
    $model->setTitle('Справочник филиалов');

    $model->onDisplay(function (){
        $display = AdminDisplay::datatablesAsync();
        $display->setOrder([[2, 'asc']]);
        $display->disablePagination(true);


        $display->setColumnFilters(
            [
                // null,
                AdminColumnFilter::text()->setPlaceholder('Название филиала')->setOperator('begins_with'),
                null,
                null,
                null,
            ]
        )->setPlacement('panel.heading');

        // $display->setFilters(
        //     AdminDisplayFilter::field('id')->setTitle('ID [:value]')
        // );

        $display->setColumns([
                //    AdminColumn::text('id')->setLabel('fid')->setWidth('80px'),
                   AdminColumn::text('name')->setLabel('Название филиала'),
                   AdminColumn::text('address')->setLabel('Адрес филиала'),
                   AdminColumn::text('order')->setLabel('Сортировка')->setWidth('100px')
                ]);
        return $display;
    });


    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setItems([
            AdminFormElement::text('name', 'Название филиала')->required(),
            AdminFormElement::text('address', 'Адрес филиала'),
            AdminFormElement::text('order','Сортировка')->required()
        ]);

        $form->getButtons()->setSaveButtonText('Сохранить');


        return $form;
       
    }); 
});
