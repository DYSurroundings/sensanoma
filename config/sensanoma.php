<?php

return [
    'sensor_node_types' => [
        'B-Sprouts v1' => [
            'name' => 'B-Sprouts Urban Farming Prototype v1',
            'class' => '',
            'manufacturer' => 'B-Srpouts',
            'sensors' => [
                [
                    'name' => 'Air Temperature',
                    'type' => 'air',
                    'unit' => 'Celcius',
                    'icon' => 'thermometer-half'
                ],
                [
                    'name' => 'Air Humidity',
                    'type' => 'air',
                    'unit' => '%',
                    'icon' => 'tint'
                ],
                [
                    'name' => 'Soil Temperature',
                    'type' => 'soil',
                    'unit' => 'Celcius',
                    'icon' => 'thermometer-half'
                ],
                [
                    'name' => 'Soil Humidity',
                    'type' => 'soil',
                    'unit' => '%',
                    'icon' => 'tint'
                ],
                [
                    'name' => 'Sensor Lumen',
                    'type' => 'solar',
                    'unit' => 'Lumen',
                    'icon' => 'sun-o'
                ],
                [
                    'name' => 'Sensor Voltage',
                    'type' => 'voltage',
                    'unit' => 'Volts',
                    'icon' => 'bolt'
                ],
                [
                    'name' => 'Sensor Temperature',
                    'type' => 'sensortemp',
                    'unit' => 'Celcius',
                    'icon' => 'thermometer-half'
                ]
            ]
        ]
    ]

];