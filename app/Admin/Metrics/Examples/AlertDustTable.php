<?php


namespace App\Admin\Metrics\Examples;

use App\Models\Dustlevel;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;


class AlertDustTable extends LazyRenderable
{
    protected $data;

    public function render()
    {
        // 获取外部传递的参数
        $dust = $this->dust;

        // 查询数据逻辑
        $this->data = $dust;

       return
           Grid::make(new Dustlevel(), function (Grid $grid) {
           $grid->model()->where('dust_concentration', '>', $this->data);


           $grid->column('id')->width('20%');
           $grid->column('time')->width('30%');
           $grid->column('number')->width('20%');
           $grid->column('dust_concentration')->width('30%');


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
