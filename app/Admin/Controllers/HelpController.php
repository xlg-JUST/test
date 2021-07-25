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

class HelpController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->title('帮助')
            ->description('Help')
            ->body(function (Row $row){
                $row->column(12, '矿洞风险检测系统使用指南');
                $row->column(12, '主页：固定页面');
                $row->column(12, '图纸解析：调用CAD接口，可以在网上编辑CAD图纸并保存到本地');
                $row->column(12, '矿洞风险监测：可以查看数据库中记录下的所有数据，并生成近期数据的可视化折线图');
                $row->column(12, '矿洞数据查询：根据输入的时间段，查询该时间段的所有数据，并生成可视化折现图');
                $row->column(12, '矿洞数据分析：根据输入的时间段，查询并分析该时间段的所有数据，并生成可视化折现图');
                $row->column(12, '安全监测日报：可将数据库中的数据打印至本地');
                $row->column(12, '平台报警参数设置：根据输入的技术参数的阈值，生成超标次数的可视化图，并且生成所有的超标数据');

            });
    }
}
