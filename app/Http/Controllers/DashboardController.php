<?php

namespace App\Http\Controllers;

use App\Sensanoma\Transformer\ConsoleTvChartTransformer;
use App\Sensanoma\Transformer\PassThroughTransformer;
use ConsoleTVs\Charts\Facades\Charts;

class DashboardController
{
    public function index($sensor = null)
    {
        if (is_null($sensor))
            $sensorNode = Auth()->user()->account->sensorNodes()->first();
        else
            $sensorNode = Auth()->user()->account->sensorNodes()->findOrFail($sensor);


        $chart = Charts::multi('line', 'highcharts')->title($sensorNode->name .' - Last 24 hours')->elementLabel('Units');

        $datas = [];

        foreach ($sensorNode->sensors() as $sensor) {
            array_push($datas, $sensor->getData('24h', '2h', new ConsoleTvChartTransformer()));
        }

        foreach ($datas as $data) {
            if(!empty($data['name'])) {
                $chart->labels($data['labels']);
                $chart->dataset($data['name'], $data['values']);
            }
        }

        $passThroughTransformer = new PassThroughTransformer();


        return view('dashboard', compact(['sensorNode', 'chart', 'passThroughTransformer']));

    }
}