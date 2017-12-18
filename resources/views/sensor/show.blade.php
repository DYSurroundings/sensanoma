@extends('layouts.app')
@section('content_header')
    @include('layouts.flash')
    <h1>{{$sensor->getName()}}</h1>
@stop
@section('content')

    <div class="row">
        <div class="col-lg-4 col-xs-6 disabled">
            <!-- small box -->
            <div class="small-box" style="background-color: {{$sensor->getColor()}}; color:white;">
                <div class="inner">
                    @if(is_null($sensor->getLastDay($passThroughTransformer)['value']))
                        <h3>No data received</h3>
                    @else
                        <h3>{{number_format($sensor->getLastDay($passThroughTransformer)['value'],2)}}<sup>{{$sensor->getUnit()}}</sup></h3>
                    @endif
                    <p>Median {{$sensor->getUnit()}} for the last  24 hours</p>
                </div>
                <div class="icon">
                    <i class="fa fa-{{$sensor->getIcon()}}"></i>
                </div>
                <a href="{{ url('/sensor_node/'. $sensor->sensorNode()->id . '/' . $sensor->getName()) }}/24h" class="small-box-footer">Last 24 hours  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box" style="background-color: {{$sensor->getColor()}}; color:white;">
                <div class="inner">
                    @if(is_null($sensor->getLastWeek($passThroughTransformer)['value']))
                        <h3>No data received</h3>
                    @else
                        <h3>{{number_format($sensor->getLastWeek($passThroughTransformer)['value'],2)}}<sup>{{$sensor->getUnit()}}</sup></h3>
                    @endif
                    <p>Median {{$sensor->getUnit()}} for the last 7 days</p>
                </div>
                <div class="icon">
                    <i class="fa fa-{{$sensor->getIcon()}}"></i>
                </div>
                <a href="{{ url('/sensor_node/'. $sensor->sensorNode()->id . '/' . $sensor->getName()) }}/7days" class="small-box-footer">Last 7 days  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box" style="background-color: {{$sensor->getColor()}}; color:white;">
                <div class="inner">

                    @if(is_null($sensor->getLastMonth($passThroughTransformer)['value']))
                        <h3>No data received</h3>
                    @else
                    <h3>{{number_format($sensor->getLastMonth($passThroughTransformer)['value'],2)}}<sup>{{$sensor->getUnit()}}</sup></h3>
                    @endif
                    <p>Median {{$sensor->getUnit()}} for the last 30 days</p>
                </div>
                <div class="icon">
                    <i class="fa fa-{{$sensor->getIcon()}}"></i>
                </div>
                <a href="{{ url('/sensor_node/'. $sensor->sensorNode()->id . '/' . $sensor->getName()) }}/30days" class="small-box-footer">Last 30 days  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="app">
                {!! $chart->html() !!}
        </div>
        <!-- End Of Main Application -->
        {!! Charts::scripts() !!}
        {!! $chart->script() !!}


    </div>

@stop