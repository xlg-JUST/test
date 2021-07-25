<?php


namespace App\Admin\Metrics\Examples;

use App\Models\Windspeed;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;


class AlertWindTable extends LazyRenderable
{
    protected $data;

    public function render()
    {
        // 获取外部传递的参数
        $wind = $this->wind;

        // 查询数据逻辑
        $this->data = $wind;

        return
            Grid::make(new Windspeed(), function (Grid $grid) {
                $grid->model()->where('speed', '>', $this->data);


                $grid->column('id')->width('20%');
                $grid->column('time')->width('30%');
                $grid->column('number')->width('20%');
                $grid->column('speed')->width('30%');


                $grid->paginate(10);
                $grid->disableActions();

                $grid->disableRowSelector();
                $grid->disableToolbar();

            });

    }



    public function grid(): Grid
    {
        return Grid::make(new Windspeed(), function (Grid $grid) {

        });
    }


}
