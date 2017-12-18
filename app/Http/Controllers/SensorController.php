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
    public function show($id, $sensor, $period)
    {

        $passThroughTransformer = new PassThroughTransformer();

        $sensor = SensorNode::find($id)->sensor($sensor);

        switch ($period) {
            case '24h':
                $data = $sensor->getData('1d', '2h', new ConsoleTvChartTransformer());
                $title = 'Last 24 hours';
                break;
            case '7days':
                $data = $sensor->getData('7d', '1d', new ConsoleTvChartTransformer());
                $title = 'Last 7 days';
                break;
            case '30days':
                $data = $sensor->getData('30d', '1d',new ConsoleTvChartTransformer());
                $title = 'Last 30 days';
                break;
        }

        $chart = Charts::multi('line', 'highcharts')->title($title)->elementLabel($sensor->getUnit());

        $chart->labels($data['labels']);
        $chart->dataset($sensor->getName(), $data['values']);

        return view('sensor.show', compact(['sensor', 'chart', 'passThroughTransformer']));
    }

}