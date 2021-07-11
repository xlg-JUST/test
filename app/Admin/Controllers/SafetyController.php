<?php


namespace App\Admin\Controllers;

use App\Models\Dustlevel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;

class SafetyController extends AdminController
{
    public function index(Content $content)
    {

        return $content
            ->title($this->title())
            ->description($this->description()['index'] ?? trans('admin.list'))
            ->body($this->grid());
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Dustlevel::with(['gaslevel','temperature','windspeed']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('time');
            $grid->column('dust_concentration');
            $grid->column('gaslevel.concentration');
            $grid->column('temperature.temperature');
            $grid->column('windspeed.speed');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->between('time')->datetime();

            });
            $titles = ['time' => '时间', 'dust_concentration' => '灰尘浓度', 'gaslevel.concentration' => '瓦斯浓度', 'temperature.temperature' => '温度', 'windspeed.speed' => '风速'];
            $grid->export($titles)->xlsx();
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
        return Show::make($id, Dustlevel::with(['gaslevel','temperature','windspeed']), function (Show $show) {
            $show->field('id');
            $show->field('time');
            $show->field('dust_concentration');
            $show->field('gaslevel.Concentration');
            $show->field('temperature.temperature');
            $show->field('windspeed.speed');
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
        return Form::make(Dustlevel::with(['gaslevel','temperature','windspeed']), function (Form $form) {
            $form->display('id');
            $form->text('time');
            $form->text('dust_concentration');
            $form->text('gaslevel.Concentration');
            $form->text('temperature.temperature');
            $form->text('windspeed.speed');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
