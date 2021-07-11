<?php


namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Dustlevel;
use App\Admin\Metrics\Examples\DustQuery;
use app\Admin\Controllers\QueryController;

class QueryForm extends Form
{

    public $title = '查询工具';

    public $chart;


    public function handle(Array $input)
    {
        $star0 = $input['star'];
        $end0 = $input['end'];
        $star = Dustlevel::query()->where('time','>=',$star0)->min('id');
        $end = Dustlevel::query()->where('time','<=',$end0)->max('id');
        $result = [$star, $end];
        return $this->response()->success('查询完成')->with(['result'=>$result])->refresh();



    }

    public function form()
    {
        $this->datetimeRange('star','end', '时间范围');
    }


}
