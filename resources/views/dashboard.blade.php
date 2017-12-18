@extends('layouts.app')

@section('title')
    Sensanoma
@stop
@section('content_header')
    @include('layouts.flash')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Daily Average</h1>
            <h1>{{ $sensorNode->name }}</h1>
            @foreach($sensorNode->sensors() as $sensor)
                @if($sensor->getType() == 'soil' || $sensor->getType() == 'air')
                    <div class="col-lg-3 col-md-6 col-sm-6">
                @else
                    <div class="col-lg-4 col-md-6 col-sm-6">
                @endif
                <!-- small box -->
                <div class="small-box" style="background-color: {{$sensor->getColor()}}; color: white;">
                    <div class="inner">
                        @if(is_null($sensor->getLastDay($passThroughTransformer)['value']))
                            <h4>No data received</h4>
                        @else
                            <h3>{{number_format($sensor->getLastDay($passThroughTransformer)['value'],2)}}<sup>{{$sensor->getUnit()}}</sup></h3>
                        @endif
                        <p>{{$sensor->getName()}} ({{$sensor->sensorNode()->name}})</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-{{$sensor->getIcon()}}"></i>
                    </div>

                    <a href="{{ url('/sensor_node/'. $sensor->sensorNode()->id . '/' . $sensor->getName()) }}/24h" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endforeach
                <div class="row">
                    <div class="app">
                        {!! $chart->html() !!}
                    </div>
                    <!-- End Of Main Application -->
                    {!! Charts::scripts() !!}
                    {!! $chart->script() !!}
                </div>
        </div>
    </div>

@stop