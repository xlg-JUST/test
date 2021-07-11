<?php


namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Bar;
use Illuminate\Http\Request;
use App\Models\Windspeed;

class WindBar extends Bar
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

        $dark35 = $color->dark35();

        // 卡片内容宽度
        $this->contentWidth(5, 7);
        // 标题
        $this->title('WindSpeed Bar');
        // 设置图表颜色
        $this->chartColors([
            $dark35,
            $dark35,
            $color->primary(),
            $dark35,
            $dark35,
            $dark35
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
                '低风速','较低风速','中风速','较高风速','高风速'
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

        $generator = function ($data,$bar=5){
            $max = max($data);
            $min = min($data);
            $delta = ($max-$min)/$bar;
            for ($i=1;$i<=$bar;$i++){
                $top = $min + $delta * $i;
                $button = $min + $delta * ($i-1);
                $count = 0;
                for ($j=0;$j<sizeof($data);$j++){
                    if ($data[$j]>=$button && $data[$j]<=$top){
                        $count += 1;
                    }
                }
                yield $count;
            }
        };

        $data0 = $request->get('data');
        $star = $data0[0];
        $end = $data0[1];
        $data = Windspeed::query()->whereBetween('id',[$star,$end])->pluck('Speed')->toArray();

        switch ($request->get('option')) {
            default:
                // 卡片内容
                $this->withContent('风速柱状图', '+5.2%');

                // 图表数据
                $this->withChart([
                    [
                        'name' => '总次数',
                        'data' => collect($generator($data)),
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
    public function withContent($title, $value, $style = 'success')
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

    <a href="http://test.local/admin/windspeed" class="btn btn-primary shadow waves-effect waves-light">View Details <i class="feather icon-chevrons-right"></i></a>
</div>
HTML
        );
    }
}
