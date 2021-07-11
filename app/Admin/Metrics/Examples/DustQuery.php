<?php


namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Widgets\Metrics\Line;
use Illuminate\Http\Request;
use App\Models\Dustlevel;

class DustQuery extends Line
{
    public $data;

    public function __construct($data=[1,2])
    {
        parent::__construct();

        $this->data = $data;
    }

    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        $this->title('Dust Concentration');
        $this->chartColors('#996600');
    }

    public function handle(Request $request)
    {
        // 获取 parameters 方法设置的自定义参数
        $data0 = $request->get('data');
        $star = $data0[0];
        $end = $data0[1];
        $data = Dustlevel::query()->whereBetween('id',[$star,$end])->pluck('dust_concentration')->toArray();

        switch ($request->get('option')) {
            default:
                // 你的数据查询逻辑
                $this->withContent(array_sum($data)/sizeof($data));
                $this->withChart($data);
                break;
        }

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
