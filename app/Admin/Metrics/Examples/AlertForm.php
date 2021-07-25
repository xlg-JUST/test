<?php


namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Widgets\Form;
use App\Models\Dustlevel;
use App\Models\Gaslevel;
use App\Models\Temperature;
use App\Models\Windspeed;


class AlertForm extends Form
{

    public $title = '报警设置';


    public function handle(Array $input)
    {
        $dustdata = $input['Dust_threshold'];
        $gasdata = $input['Gas_threshold'];
        $tempdata = $input['Temp_threshold'];
        $winddata = $input['Wind_threshold'];
        $dustdata0 = Dustlevel::query()->where('dust_concentration','>=',$dustdata)->count();
        $gastdata0 = Gaslevel::query()->where('concentration','>=',$gasdata)->count();
        $tempdata0 = Temperature::query()->where('temperature','>=',$tempdata)->count();
        $winddata0 = Windspeed::query()->where('speed','>=',$winddata)->count();

        $result = [$dustdata0, $gastdata0, $tempdata0, $winddata0, $dustdata, $gasdata, $tempdata, $winddata];

        return $this->response()->success('设置完成')->with(['result'=>$result])->refresh();



    }

    public function form()
    {
        $this->text('Dust_threshold')->placeholder('输入灰尘浓度报警阈值')->default(10);
        $this->text('Gas_threshold')->placeholder('输入瓦斯浓度报警阈值')->default(0.008);
        $this->text('Temp_threshold')->placeholder('输入温度报警阈值')->default(38);
        $this->text('Wind_threshold')->placeholder('输入风速报警阈值')->default(12);
    }


}
