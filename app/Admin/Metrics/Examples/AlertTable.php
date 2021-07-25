<?php


namespace App\Admin\Metrics\Examples;

use App\Models\Dustlevel;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;


class AlertTable extends LazyRenderable
{
    public function grid(): Grid
    {
        return Grid::make(Dustlevel::with(['gaslevel','temperature','windspeed']), function (Grid $grid) {
//            $grid->model()->where('dust_concentration', '>', 10);




            $grid->column('id');
            $grid->column('time');
            $grid->column('dust_concentration');
            $grid->column('gaslevel.concentration');
            $grid->column('temperature.temperature');
            $grid->column('windspeed.speed');


            $grid->paginate(10);
            $grid->disableActions();

        });
    }
}

