@extends('adminlte::page')

@section('content_header')
    @include('layouts.flash')
    <div class="row">
        <div class="form-group">
            <label id="head_label" class="col-md-4 col-sm-5 col-xs-12 col-md-offset-2 col-sm-offset-1">SensorNode Settings</label>

            <div class="col-md-4 col-sm-5 hidden-xs">

                {{ html()->form('DELETE', route('sensor_node.destroy', $sensorNode->id))->open() }}

                {{ html()->submit('Delete')->class('btn btn-flat custom btn-danger')->style('float:right; margin-left:2px') }}

                {{ html()->form()->close() }}

                {{ html()->form('GET', route('sensor_node.edit', $sensorNode->id))->open() }}

                {{ html()->submit('Edit')->class('btn btn-flat custom btn-info')->style('float:right') }}

                {{ html()->form()->close() }}

            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}"/>
@stop

@section('content')

    <div class='row'>
        <div class="col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1">
            <div class="info-box">
                <a href="{{ route('sensor_node.show', $sensorNode) }}">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-microchip"></i></span>
                </a>
                <div class="info-box-content">
                    <span>
                        <h4><a href="{{ route('sensor_node.show', $sensorNode) }}">{{ $sensorNode->name }}</a></h4>
                    </span>
                    <span>
                          Zone:
                        <a href="{{ route('zone.show', $sensorNode->zone->id) }}">
                           {{ $sensorNode->zone->name }}
                        </a>
                        / Created by:
                        <a href="{{ route('account.show', $sensorNode->account->id) }}">
                            {{ $sensorNode->account->name }}
                        </a>

                    </span>
                    <span class="progress-description"> Sensornode type:
                        {{ $sensorNode->type['name'] }}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <h3>Available sensors :</h3>
            <ul class="nav nav-stacked nav-pills">
                @foreach($sensorNode->sensors() as $sensor)
                    <li>
                        <a href="#"><i class="fa fa-asterisk"></i> &nbsp; {{ $sensor->getName() }} <div class="inline text-danger">{{ ($sensorNode->getValue($sensor->getName())['age'] == 'current') ? '' : '[outdated]'}}</div>
                            @if(isset($sensorNode->getValue($sensor->getName())['value']))
                                <span class="pull-right badge {{ ($sensorNode->getValue($sensor->getName())['age'] !== 'current') ? 'bg-red' : 'bg-blue'}}">
                                            {{ $sensorNode->getValue($sensor->getName())['value'] }}
                                        </span>
                            @else
                                <span class="pull-right badge bg-red">No Data</span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
            <br>
            <div class="row">
                <div class="hidden-lg hidden-md hidden-sm col-xs-6">
                    {{ html()->form('GET', route('sensor_node.edit', $sensorNode->id))->open() }}

                    {{ html()->submit('Edit')->class('btn btn-flat btn-block btn-info') }}

                    {{ html()->form()->close() }}
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-6">


                    {{ html()->form('DELETE', route('sensor_node.destroy', $sensorNode->id))->open() }}

                    {{ html()->submit('Delete')->class('btn btn-flat btn-block btn-danger') }}

                    {{ html()->form()->close() }}

                </div>
            </div>
        </div>
    </div>

@stop
