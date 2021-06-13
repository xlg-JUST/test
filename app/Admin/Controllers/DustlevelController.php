<?php

namespace App\Admin\Controllers;

use App\Models\Dustlevel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class DustlevelController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Dustlevel(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('time');
            $grid->column('number');
            $grid->column('dust_concentration');
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
        return Show::make($id, new Dustlevel(), function (Show $show) {
            $show->field('id');
            $show->field('time');
            $show->field('number');
            $show->field('dust_concentration');
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
        return Form::make(new Dustlevel(), function (Form $form) {
            $form->display('id');
            $form->text('time');
            $form->text('number');
            $form->text('dust_concentration');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
