<?php

namespace App\Admin\Controllers;

use App\Models\Windspeed;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class WindspeedController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Windspeed(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('time');
            $grid->column('speed');
            $grid->column('direction');
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
        return Show::make($id, new Windspeed(), function (Show $show) {
            $show->field('id');
            $show->field('time');
            $show->field('speed');
            $show->field('direction');
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
        return Form::make(new Windspeed(), function (Form $form) {
            $form->display('id');
            $form->text('time');
            $form->text('speed');
            $form->text('direction');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
