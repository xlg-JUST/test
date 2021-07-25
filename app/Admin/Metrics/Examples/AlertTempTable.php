<?php


namespace App\Admin\Metrics\Examples;


use App\Models\Temperature;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;


class AlertTempTable extends LazyRenderable
{
    protected $data;

    public function render()
    {
        // 获取外部传递的参数
        $temp = $this->temp;

        // 查询数据逻辑
        $this->data = $temp;

        return
            Grid::make(new Temperature(), function (Grid $grid) {
                $grid->model()->where('temperature', '>', $this->data);


                $grid->column('id')->width('20%');
                $grid->column('time')->width('30%');
                $grid->column('number')->width('20%');
                $grid->column('temperature')->width('30%');


                $grid->paginate(10);
                $grid->disableActions();

                $grid->disableRowSelector();
                $grid->disableToolbar();


            });

    }



    public function grid(): Grid
    {
        return Grid::make(new Dustlevel(), function (Grid $grid) {

        });
    }


}
