<?php
//use App\Peoples;
use App\User;
use SleepingOwl\Admin\Model\ModelConfiguration;

AdminSection::registerModel(User::class, function(ModelConfiguration $model){
    $model->setTitle('Пользователи');

    $model->onDisplay(function (){
        $display = AdminDisplay::datatables();

        $display->setColumns([
                   AdminColumn::text('name')->setLabel('Username'),
                   AdminColumn::text('email')->setLabel('Email'),
                   AdminColumn::datetime('created_at')->setLabel('Дата создания')->setFormat('d.m.Y H:i')
                ]);
        return $display;
    });

    $model->onEdit(function (){
        $form = AdminForm::panel()
                ->addBody([
                     AdminFormElement::text('name','Username')->required(),
                     AdminFormElement::text('password','Пароль')->required(),
                ]);
        $form->getButtons()->setSaveButtonText('Сохранить')->hideSaveAndCloseButton();
        return $form;
    });
});
