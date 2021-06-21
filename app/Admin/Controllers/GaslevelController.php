<?php

namespace App\Admin\Controllers;

use App\Models\Gaslevel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Metrics\Card;
use App\Admin\Metrics\Examples\GasDevices;
use App\Admin\Metrics\Examples\GasCard;
use App\Admin\Metrics\Examples\GasChart;


class GaslevelController extends AdminController
{
    private $card;
    private $chart;
    private $devices;

    public function index(Content $content)
    {
        $this->card = new GasCard();
        $this->chart = new GasChart();
        $this->devices = new GasDevices();

//        $data = Dustlevel::query()->forPage(1)->pluck('dust_concentration')->toArray();
//        $data = Dustlevel::query()->where('id','>',11952)->pluck('dust_concentration')->toArray();

//        $this->chart->withContent('89.2k');
//        $this->chart->withChart(array_slice($data,0,10));

        return $content
            ->title($this->title())
            ->description($this->description()['index'] ?? trans('admin.list'))
            ->body(function (Row $row) {
                $row->column(3, $this->card);
                $row->column(6, $this->chart);
                $row->column(3, $this->devices);
            })
            ->body($this->grid());
    }
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
                $filter->between('time')->datetime();

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
