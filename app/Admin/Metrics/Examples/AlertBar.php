<?php


namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Bar;
use Illuminate\Http\Request;
use App\Models\Dustlevel;
use App\Models\Gaslevel;
use App\Models\Temperature;
use App\Models\Windspeed;

class AlertBar extends Bar
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
    public function init()
    {
        parent::init();

        $color = Admin::color();

        // 卡片内容宽度
        $this->contentWidth(5, 7);
        // 标题
        $this->title('Statistics of Exceedance Times');
        // 设置图表颜色
        $this->chartColors([
            '#996600',
            '#000000',
            '#FF3300',
            $color->primary()
        ]);
    }

    protected function defaultChartOptions()
    {
        $color = Admin::color();

        $colors = [
            $color->primary(),
        ];

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 200,
                'sparkline' => ['enabled' => true],
                'toolbar' => ['show' => false],
            ],
            'states' => [
                'hover' => [
                    'filter' => 'none',
                ],
            ],
            'colors' => $colors,
            'series' => [
                [
                    'name' => 'Title',
                    'data' => [75, 125, 225, 175, 125, 75, 25],
                ],
            ],
            'grid' => [
                'show' => false,
                'padding' => [
                    'left' => 0,
                    'right' => 0,
                ],
            ],

            'plotOptions' => [
                'bar' => [
                    'columnWidth' => '44%',
                    'distributed' => true,
                    //'endingShape' => 'rounded',
                ],
            ],
            'tooltip' => [
                'x' => ['show' => true],
                'xaxis' => [
                    'type' => 'category',
                ],
            ],
            'labels' => [
                'Dust Concentration','Gas Concentration','Temperature','Windspeed'
            ],
        ];
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


        switch ($request->get('option')) {
            default:
                // 卡片内容
                $this->withContent('超标次数柱状图');

                // 图表数据
                $this->withChart([
                    [
                        'name' => '总次数',
                        'data' => [$dust, $gas, $temp, $wind]
                    ],
                ]);
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
     * 设置卡片内容.
     *
     * @param string $title
     * @param string $value
     * @param string $style
     *
     * @return $this
     */
    public function withContent($title)
    {
        // 根据选项显示
        $label = strtolower(
            $this->dropdown[request()->option] ?? 'last 7 days'
        );

        $minHeight = '183px';

        return $this->content(
            <<<HTML
<div class="d-flex p-1 flex-column justify-content-between" style="padding-top: 0;width: 100%;height: 100%;min-height: {$minHeight}">
    <div class="text-left">
        <h1 class="font-large-2 mt-2 mb-0">{$title}</h1>
        <h5 class="font-medium-2" style="margin-top: 10px;">
        </h5>
    </div>
    <h6 class="font-medium-2" style="margin-top: 10px;">下方可查看详细信息
        </h6>
</div>
HTML
        );
    }
}
