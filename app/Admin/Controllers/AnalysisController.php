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
use App\Admin\Metrics\Examples\DustBar;
use App\Admin\Metrics\Examples\GasBar;
use App\Admin\Metrics\Examples\TempBar;
use App\Admin\Metrics\Examples\WindBar;
use App\Admin\Metrics\Examples\WindDonut;

class AnalysisController extends AdminController
{
    protected $form;
    protected $dustbar;
    protected $gasbar;
    protected $tempbar;
    protected $windbar;
    protected $winddonut;

    public function index(Content $content)
    {
        $this->form = new QueryForm();

        if ($result = session('result')) {
            $this->dustbar = new DustBar($result);
            $this->gasbar = new GasBar($result);
            $this->tempbar = new TempBar($result);
            $this->windbar = new WindBar($result);
            $this->winddonut = new WindDonut($result);
        }

        return $content
            ->header('矿洞数据分析')
            ->description('Data Analysis')
            ->body(function (Row $row){
                $row->column(6,$this->form);
                $row->column(6,$this->dustbar);
                $row->column(6,$this->gasbar);
                $row->column(6,$this->tempbar);
                $row->column(6,$this->windbar);
                $row->column(6,$this->winddonut);

            });
    }

}
