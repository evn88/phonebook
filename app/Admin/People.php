<?php
use App\People;
use App\Filial;
use App\Departament;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(People::class, function(ModelConfiguration $model){
    $model->setTitle('Контакты');

    $model->onDisplay(function (){
        $display = AdminDisplay::datatables();
        $display->setName('testName');
        $display->with('filial','departament');
        // $display->setOrder([[1, 'desc']]);
        $display->disablePagination(true);

        $display->setColumnFilters(
            [
                null,
                AdminColumnFilter::text()->setPlaceholder('Филиал')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('Подразделение')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('ФИО')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('Должность')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('Короткий')->setOperator('begins_with'),
                AdminColumnFilter::text()->setPlaceholder('Внешний'),
                AdminColumnFilter::text()->setPlaceholder('Быстрый'),
                AdminColumnFilter::text()->setPlaceholder('Сортировка'),
                null,
            ]
        )->setPlacement('panel.heading');

        $display->setFilters([
            AdminDisplayFilter::field('filial_id')->setTitle('FID [:value]'),
            AdminDisplayFilter::field('departament_id')->setTitle('DID [:value]')
        ]);

        $display->setColumns([
                   AdminColumn::text('id')->setLabel('#')->setWidth('50px'),
                   AdminColumn::text('filial.name')->setLabel('Филиал')->append(
                     AdminColumn::filter('filial_id')
                   )->setWidth('350px'),
                   AdminColumn::text('departament.name')->setLabel('Подразделение')->append(
                     AdminColumn::filter('departament_id')
                   )->setWidth('350px'),
                   AdminColumnEditable::text('name')->setLabel('ФИО')->setWidth('350px'),
                   AdminColumnEditable::text('profession')->setLabel('Должность'),
                   AdminColumnEditable::text('short_number')->setLabel('Короткий номер'),
                   AdminColumnEditable::text('ext_number')->setLabel('Внешний номер'),
                   AdminColumn::text('speed_number')->setLabel('Быстрый набор (ЦРПБ)'),
                    AdminColumn::text('order')->setLabel('Сортировка'),
        ]);
        return $display;
    });


    $model->onCreateAndEdit(function () {
        $formPrimary = AdminForm::form()->addElement(
            AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::select('filial_id', 'Филиал', Filial::class)->setDisplay('name')->required()
            ],6)
            ->addColumn([
                AdminFormElement::select('departament_id', 'Подразделение', Departament::class)->setDisplay('name')->required(),
            ],6)
        )->addElement(
            AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('name', 'ФИО')->required()
            ],6)
            ->addColumn([
                AdminFormElement::text('profession','Профессия')->required(),
            ],6)
        )->addElement(
            AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('short_number','Короткий номер'),
            ],3)
            ->addColumn([
                AdminFormElement::text('ext_number','Внешний номер'),
            ],3)
            ->addColumn([
                AdminFormElement::text('speed_number','Быстрый набор (ЦРПБ)'),
            ],3)
            ->addColumn([
                AdminFormElement::text('mobile_number','Мобильный')
            ],3)
        );

        $formExtension = new \SleepingOwl\Admin\Form\FormElements([ 
            AdminFormElement::datetime('birthday','День рождения'),
            // AdminFormElement::wysiwyg('address', 'Address')->required('so sad but this field is empty.')
        ]);

        $tabs = AdminDisplay::tabbed();
        $tabs->appendTab($formPrimary, 'Главная');
        $tabs->appendTab($formExtension, 'Дополнительно');

        return $tabs;      
    }); 
});
