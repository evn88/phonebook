<?php
use App\Departament;
use App\Filial;
use App\People;
use App\FilialDepartamentPeople;
use SleepingOwl\Admin\Model\ModelConfiguration;


AdminSection::registerModel(FilialDepartamentPeople::class, function(ModelConfiguration $model){
    $model->setTitle('FDP');

    $model->onDisplay(function (){
        $display = AdminDisplay::datatables();
        $display->setOrder([[0, 'asc']]);
        $display->disablePagination(true);


        $display->setColumnFilters(
            [
                // null,
                // AdminColumnFilter::text()->setPlaceholder('Название подразделения')->setOperator('begins_with'),
                AdminColumnFilter::select()->setModel(new Filial)->setDisplay('name')->setColumnName('filial_id')->setPlaceholder('Филиал'),
                AdminColumnFilter::select()->setModel(new Departament)->setDisplay('name')->setColumnName('departament_id')->setPlaceholder('Подразделение'),
                AdminColumnFilter::select()->setModel(new People)->setDisplay('name')->setColumnName('people_id')->setPlaceholder('Сотрудник'),
                // null,
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
                    AdminColumn::text('filial.name')->setLabel('Филиал')->append(
                        AdminColumn::filter('filial_id')
                    )->setWidth('350px'),
                   AdminColumn::text('departament.name')->setLabel('Подразделение'),
                   AdminColumn::text('people.name')->setLabel('ФИО'),
                ]);
        return $display;
    });


    $model->onCreateAndEdit(function () {
        $form = AdminForm::panel();
        $form->setItems([
            AdminFormElement::select('filial_id', 'Филиал', Filial::class)->setDisplay('name')->required('Необходимо обязательно выбрать филиал'),
            AdminFormElement::select('departament_id', 'Подразделение', Departament::class)->setDisplay('name')->required('Необходимо обязательно выбрать подразделение'),
            AdminFormElement::select('people_id', 'Подразделение', People::class)->setDisplay('name')->required('Необходимо обязательно выбрать сотрудника'),
        ]);

        $form->getButtons()->setSaveButtonText('Сохранить');


        return $form;

    });
});
