<?php
//use App\Peoples;
use App\Article_pc;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(Article_pc::class, function(ModelConfiguration $model){
    $model->setTitle('Компьютеры');

    $model->onDisplay(function (){
        $display = AdminDisplay::datatables();
        $display->setColumnFilters([
            // AdminColumnFilter::text()->setPlaceholder('Full Name')->setColumnName('filial'),
            // AdminColumnFilter::select(['ПРМЭС', 'ЗМЭС'], 'Title')->setDisplay('title')->setPlaceholder('Select Country')->setColumnName('filial'),
        ]);

        $display->setColumns([
                   AdminColumn::checkbox('id','#'),
                   AdminColumn::text('year')->setLabel('Год выпуска'),
                   AdminColumn::text('filial')->setLabel('Филиал'),
                   AdminColumn::text('inventar')->setLabel('Инвентарный номер'),
                   AdminColumn::link('pcconfig')->setLabel('Тех характеристики'),
                   AdminColumn::text('monitor')->setLabel('Монитор'),
                   AdminColumn::text('status')->setLabel('Состояние'),
                //    AdminColumn::datetime('date_entry')->setLabel('Дата ввода')->setFormat('d.m.Y'),
                   AdminColumn::text('start_price')->setLabel('Начальная стоимость'),
                //    AdminColumn::datetime('created_at')->setLabel('Дата создания')->setFormat('d.m.Y H:i')
                ]);
        return $display;
    });


    $model->onCreateAndEdit(function ($id = null) {
        $form = AdminForm::panel();
        $form->setItems([
                AdminFormElement::text('year','Год выпуска')->required(),
                AdminFormElement::text('filial','Филиал')->required(),
                AdminFormElement::text('inventar','Инвентарный номер')->required(),
                AdminFormElement::text('pcconfig','Тех характеристики')->required(),
                AdminFormElement::text('monitor','Монитор'),
                AdminFormElement::text('status','Состояние'),
                // AdminFormElement::date('date_entry','Дата ввода')->required(),
                AdminFormElement::text('start_price','Начальная стоимость')->required(),
            ]);

        $form->getButtons()->setSaveButtonText('Сохранить')->hideSaveAndCloseButton(true);

        return $form;
       
    }); 
});
