<?php

namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Round;
use Illuminate\Http\Request;
use App\Models\Dustlevel;

class AlertRound extends Round
{

    protected $data;

    public function __construct($data = null)
    {
        parent::__construct();

        $this->data = $data;

    }

    /**
     * 初始化卡片内容
     */
    protected function init()
    {
        parent::init();
        $color = Admin::color();

        $this->title('超标次数百分比饼状图');
        $this->chartLabels(['Dust', 'Gas', 'Temp', 'Wind']);
        $this->chartColors([
            '#996600',
            '#000000',
            '#FF3300',
            $color->primary()
        ]);
    }

    /**
     * 处理请求
     *
     * @param Request $request
     *
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        $data = $request->get('data');
        $dust = $data[0];
        $gas = $data[1];
        $temp = $data[2];
        $wind = $data[3];
        $total = Dustlevel::query()->count();

        switch ($request->get('option')) {
            default:
                // 卡片内容
                $this->withContent($dust/$total, $gas/$total, $temp/$total, $wind/$total);

                // 图表数据
                $this->withChart([($dust/$total)*100, ($gas/$total)*100, ($temp/$total)*100, ($wind/$total)*100]);

                // 总数
                $this->chartTotal('Total', $dust+$gas+$temp+$wind);
        }
    }

    public function parameters(): array
    {
        return [
            'data'        => $this->data,
        ];
    }

    /**
     * 设置图表数据.
     *
     * @param array $data
     *
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => $data,
        ]);
    }

    /**
     * 卡片内容.
     *
     * @param int $finished
     * @param int $pending
     * @param int $rejected
     *
     * @return $this
     */
    public function withContent($Dust, $Gas, $Temp, $Wind)
    {
        return $this->content(
            <<<HTML
<div class="col-12 d-flex flex-column flex-wrap text-center" style="max-width: 220px">
    <div class="chart-info d-flex justify-content-between mb-1 mt-2" >
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text-warning"></i>
              <span class="text-bold-600 ml-50">Dust</span>
          </div>
          <div class="product-result">
              <span>{$Dust}</span>
          </div>
    </div>

    <div class="chart-info d-flex justify-content-between mb-1">
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text#000000"></i>
              <span class="text-bold-600 ml-50">Gas</span>
          </div>
          <div class="product-result">
              <span>{$Gas}</span>
          </div>
    </div>

     <div class="chart-info d-flex justify-content-between mb-1">
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text-danger"></i>
              <span class="text-bold-600 ml-50">Temp</span>
          </div>
          <div class="product-result">
              <span>{$Temp}</span>
          </div>
    </div>

    <div class="chart-info d-flex justify-content-between mb-1">
          <div class="series-info d-flex align-items-center">
              <i class="fa fa-circle-o text-bold-700 text-primary"></i>
              <span class="text-bold-600 ml-50">Wind</span>
          </div>
          <div class="product-result">
              <span>{$Wind}</span>
          </div>
    </div>
</div>
HTML
        );
    }
}
