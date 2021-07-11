<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Form;
use App\Models\Dustlevel;
use Dcat\Admin\Widgets\Metrics\Card;
use App\Admin\Metrics\Examples\DustQuery;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Database\Eloquent\Model;
use App\Admin\Metrics\Examples\QueryForm;
use App\Admin\Metrics\Examples\GasQuery;
use App\Admin\Metrics\Examples\TempQuery;
use App\Admin\Metrics\Examples\WindQuery;



class QueryController extends AdminController
{
    protected $form;
    public $dust;
    public $gas;
    public $temp;
    public $wind;

    public function index(Content $content)
    {
        $this->form = new QueryForm();
        if ($result = session('result')) {
            $this->dust = new DustQuery($result);
            $this->gas = new GasQuery($result);
            $this->temp = new TempQuery($result);
            $this->wind = new WindQuery($result);

        }

        return $content
            ->header('矿洞数据查询')
            ->description('Data Query')
            ->body(function (Row $row){
                $row->column(6,$this->form);
                $row->column(12,$this->dust);
                $row->column(12,$this->gas);
                $row->column(12,$this->temp);
                $row->column(12,$this->wind);
            });
    }
}
