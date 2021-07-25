<?php


namespace App\Admin\Metrics\Examples;

use App\Models\Gaslevel;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;


class AlertGasTable extends LazyRenderable
{
    protected $data;

    public function render()
    {
        // 获取外部传递的参数
        $gas = $this->gas;

        // 查询数据逻辑
        $this->data = $gas;

        return
            Grid::make(new Gaslevel(), function (Grid $grid) {
                $grid->model()->where('concentration', '>', $this->data);


                $grid->column('id')->width('20%');
                $grid->column('time')->width('30%');
                $grid->column('number')->width('20%');
                $grid->column('concentration')->width('30%');


                $grid->paginate(10);
                $grid->disableActions();

                $grid->disableRowSelector();
                $grid->disableToolbar();

            });

    }



    public function grid(): Grid
    {
        return Grid::make(new Gaslevel(), function (Grid $grid) {

        });
    }


}
