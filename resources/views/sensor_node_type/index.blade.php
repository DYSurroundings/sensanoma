@extends('adminlte::page')

@section('content_header')
    @include('layouts.flash')
    <h1>Sensor Node Type settings</h1>
@stop

@section('content')

    <div class="col-md-12">
        <div class="box">
            <div class="box-body no-padding">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Sensor Node</th>
                    </tr>
                    @foreach($sensorNodeType as $node)
                        <tr>
                            <td>
                                <a href="{{ route('sensor_node_type.show', $node) }}">{{ $node->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('sensor_node.show', $node->sensorNodes->id) }}">{{ $node->sensorNodes->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('sensor_node_type.edit', $node) }}">
                                    <button type="button" class="btn btn-block btn-info">Edit</button>
                                </a>
                            </td>
                            <td>

                                {{ html()->form('DELETE', route('sensor_node_type.destroy', $node->id))->open() }}

                                {{ html()->submit('Delete')->class('btn btn-danger') }}

                                {{ html()->form()->close() }}

                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <a href="{{ route('sensor_node_type.create') }}">
        <button type="button" class="btn btn-block btn-primary">Create a sensor node type</button>
    </a>
    <hr>

@stop



