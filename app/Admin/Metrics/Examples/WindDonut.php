<?php


namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Donut;
use App\Models\Windspeed;

class WindDonut extends Donut
{
    protected $labels = ['North', 'South'];

    /**
     * 初始化卡片内容
     */

    public $data;

    public function __construct($data=[1,2])
    {
        parent::__construct();

        $this->data = $data;
    }


    protected function init()
    {
        parent::init();

        $color = Admin::color();
        $colors = [$color->primary(), $color->alpha('blue2', 0.5)];

        $this->title('Wind Donut');
        $this->chartLabels($this->labels);
        // 设置图表颜色
        $this->chartColors($colors);
        $this->height(250);
    }

    /**
     * 渲染模板
     *
     * @return string
     */
    public function render()
    {
        $this->fill($this->data);

        return parent::render();
    }

    /**
     * 写入数据.
     *
     * @return void
     */
    public function fill($data0)
    {
        $star = $data0[0];
        $end = $data0[1];
        $data = Windspeed::query()->whereBetween('id',[$star,$end])->pluck('Direction')->toArray();
        $north = array_sum($data)/sizeof($data)*100;
        $south = 100-$north;
        $this->withContent($north, $south);

        // 图表数据
        $this->withChart([$north, $south]);
    }

    public function parameters(): array
    {
        return [
            'data'        => $this->data
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
            'series' => $data
        ]);
    }

    /**
     * 设置卡片头部内容.
     *
     * @param mixed $desktop
     * @param mixed $mobile
     *
     * @return $this
     */
    protected function withContent($desktop, $mobile)
    {
        $blue = Admin::color()->alpha('blue2', 0.5);

        $style = 'margin-bottom: 30px';
        $labelWidth = 120;

        return $this->content(
            <<<HTML
<div class="d-flex pl-1 pr-1 pt-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle text-primary"></i> {$this->labels[0]}
    </div>
    <div>{$desktop}</div>
</div>
<div class="d-flex pl-1 pr-1" style="{$style}">
    <div style="width: {$labelWidth}px">
        <i class="fa fa-circle" style="color: $blue"></i> {$this->labels[1]}
    </div>
    <div>{$mobile}</div>
</div>

HTML
        );
    }
}
