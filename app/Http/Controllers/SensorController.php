<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11/12/17
 * Time: 16:54
 */

namespace App\Http\Controllers;


use App\Models\SensorNode;
use App\Sensanoma\Transformer\ConsoleTvChartTransformer;
use App\Sensanoma\Transformer\PassThroughTransformer;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;

class SensorController
{
    public function show($id, $sensor, $date)
    {

        $passThroughTransformer = new PassThroughTransformer();

        $sensor = SensorNode::find($id)->sensor($sensor);

        switch ($date){
            case '24h':
                $data = $sensor->getData('1d', '2h', new ConsoleTvChartTransformer());
                break;
            case '7days':
                $data = $sensor->getData('7d', '12h', new ConsoleTvChartTransformer());
                break;
            case '30days':
                $data = $sensor->getData('30d', '2d',new ConsoleTvChartTransformer());
                break;
        }

        $chart = Charts::multi('line', 'highcharts');

        $chart->labels($data['labels']);
        $chart->dataset($sensor->getName(), $data['values']);

        return view('sensor.show', compact(['sensor', 'chart', 'passThroughTransformer']));
    }

}