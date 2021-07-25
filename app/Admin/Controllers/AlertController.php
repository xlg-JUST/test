<?php


namespace App\Admin\Controllers;

use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Layout\Content;
use App\Models\Dustlevel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Admin\Metrics\Examples\AlertBar;
use App\Admin\Metrics\Examples\AlertForm;
use App\Admin\Metrics\Examples\AlertRound;
use App\Admin\Metrics\Examples\AlertDevicesTest;
use App\Admin\Metrics\Examples\AlertDustTable;
use App\Admin\Metrics\Examples\AlertGasTable;
use App\Admin\Metrics\Examples\AlertTempTable;
use App\Admin\Metrics\Examples\AlertWindTable;



class AlertController extends AdminController
{

    protected $form;
    protected $bar;
    protected $round;
    protected $dusttable;
    protected $gastable;
    protected $temptable;
    protected $windtable;

    public function index(Content $content)
    {
        $this->form = new AlertForm();

        if ($result = session('result')) {
            $this->bar = new AlertBar($result);
            $this->round = new AlertRound($result);
            $this->dusttable = Modal::make()
                ->lg()
                ->title('灰尘浓度超标详细数据表格')
                ->body(AlertDustTable::make(['dust' => $result[4]])) // Modal 组件支持直接传递 渲染类实例
                ->button('灰尘超标详细信息');
            $this->gastable = Modal::make()
                ->lg()
                ->title('瓦斯浓度超标详细数据表格')
                ->body(AlertGasTable::make(['gas' => $result[5]]))
                ->button('瓦斯超标详细信息');
            $this->temptable = Modal::make()
                ->lg()
                ->title('温度超标详细数据表格')
                ->body(AlertTempTable::make(['temp' => $result[6]]))
                ->button('温度超标详细信息');
            $this->windtable = Modal::make()
                ->lg()
                ->title('风速超标详细数据表格')
                ->body(AlertWindTable::make(['wind' => $result[7]]))
                ->button('风速超标详细信息');
        }


        return $content
            ->title('报警参数设置')
            ->description('Alarm Parameter Setting')
            ->body(function (Row $row){
                $row->column(12,$this->form);
                $row->column(6,$this->bar);
                $row->column(6,$this->round);
                $row->column(3,$this->dusttable);
                $row->column(3,$this->gastable);
                $row->column(3,$this->temptable);
                $row->column(3,$this->windtable);
            });
    }

}
