<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Gaslevel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class GaslevelController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Gaslevel(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('time');
            $grid->column('number');
            $grid->column('concentration');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Gaslevel(), function (Show $show) {
            $show->field('id');
            $show->field('time');
            $show->field('number');
            $show->field('concentration');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Gaslevel(), function (Form $form) {
            $form->display('id');
            $form->text('time');
            $form->text('number');
            $form->text('concentration');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
