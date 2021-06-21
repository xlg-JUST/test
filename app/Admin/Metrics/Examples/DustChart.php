<?php


namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;
use App\Models\Dustlevel;

class DustChart extends Line
{
    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        $this->title('Dust Concentration');
        $this->dropdown([
            '6' => 'Last hour',
            '72' => 'Last 12 hours',
            '144' => 'Last day',
            '1008' => 'Last week',
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
        $data = Dustlevel::query()->where('id','>',11952)->pluck('dust_concentration')->toArray(); //  存在技术债
        switch ($request->get('option')) {
            case '1008':
                // 卡片内容
                $this->withContent(array_sum($data)/sizeof($data));
                // 图表数据
                $this->withChart($data);
                break;
            case '144':
                $data = array_slice($data,-144);
                // 卡片内容
                $this->withContent(array_sum($data)/sizeof($data));
                // 图表数据
                $this->withChart($data);
                break;
            case '72':
                // 卡片内容
                $data = array_slice($data,-72);
                $this->withContent(array_sum($data)/sizeof($data));
                // 图表数据
                $this->withChart($data);
                break;
            case '6':
            default:
                $data = array_slice($data,-6);
                // 卡片内容
                $this->withContent(array_sum($data)/sizeof($data));
                // 图表数据
                $this->withChart($data);
        }
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
            'series' => [
                [
                    'name' => $this->title,
                    'data' => $data,
                ],
            ],
        ]);
    }

    /**
     * 设置卡片内容.
     *
     * @param string $content
     *
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$content}<sub>average<sub></h2>
    <span class="mb-0 mr-1 text-80">Line Chart</span>
</div>
HTML
        );
    }
}
