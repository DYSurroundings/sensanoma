<?php


namespace App\Sensanoma;


use App\Models\SensorNode;
use App\Sensanoma\Storage\QueryBuilder\InfluxQueryBuilder;
use App\Sensanoma\Storage\Reader\InfluxReader;
use App\Sensanoma\Transformer\TransformerInterface;
use Carbon\Carbon;

class Sensor
{

    protected $type;
    protected $color;
    protected $name;
    protected $unit;
    protected $sensorNodeId;
    protected $icon = 'info';

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getSensorNodeId()
    {
        return $this->sensorNodeId;
    }

    /**
     * @param mixed $sensorNodeId
     */
    public function setSensorNodeId($sensorNodeId)
    {
        $this->sensorNodeId = $sensorNodeId;
    }

    public function __construct(Array $sensorDetails)
    {
        !array_has($sensorDetails, 'type') ? $this->setType('generic') : $this->setType($sensorDetails['type']);

        !array_has($sensorDetails, 'icon') ? : $this->setIcon($sensorDetails['icon']);

        $this->setName($sensorDetails['name']);
        $this->setUnit($sensorDetails['unit']);

    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;

        switch ($type) {
            case 'generic':
                $this->setColor('grey');
                break;
            case 'air':
                $this->setColor('#00c0ef');
                break;
            case 'soil':
                $this->setColor('#582900');
                break;
            case 'solar':
                $this->setColor('gold');
                break;
            case 'voltage':
                $this->setColor('#128CDC');
                break;
            case 'sensortemp':
                $this->setColor('#00a65a');
                break;
            default:
                $this->setColor('#fefefe');
                break;
        }

    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param mixed $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    public function sensorNode()
    {
        return SensorNode::find($this->getSensorNodeId());
    }

    public function getLastValue($period, $group, TransformerInterface $transformer)
    {
        $result = $this->getData($period, $group, $transformer)->first()['values'][0];

        $result = $this->toKeyValue($result);

        return $result;
     }

    public function getLastMonth(TransformerInterface $transformer)
    {
        return $this->getLastValue('30d', '30d', $transformer);
    }

    public function getLastWeek(TransformerInterface $transformer)
    {
        return $this->getLastValue('7d', '7d', $transformer);
    }

    public function getLastDay(TransformerInterface $transformer)
    {
        return $this->getLastValue('24h', '24h', $transformer);
    }

    public function studlyName()
    {
        return studly_case($this->getName());
    }

    public function getData($period, $group, TransformerInterface $transformer, $limit = 0, $orderby = 'asc')
    {
        $reader = new InfluxReader();

        $data = $reader->read(
            (new InfluxQueryBuilder())
                ->select(['mean(value)'])
                ->from([$this->studlyName()])
                ->where("time > now() - $period and sensor_node = '{$this->sensorNode()->id}'")
                ->groupBy("time($group)")
                ->fill('previous')
                ->limit($limit)
                ->order($orderby)
                ->build()
        );


        return $transformer->transform($data);
    }

    public function getLatestValue()
    {
        $reader = new InfluxReader();

        $data = $reader->read(
            (new InfluxQueryBuilder())
                ->select(['time', 'value'])
                ->from([$this->studlyName()])
                ->order('time desc')
                ->where("sensor_node = '{$this->sensorNode()->id}'")
                ->limit(1)
                ->build()
        );

        $result = $data->first()['values'][0];

        $lastTimestamp = new Carbon($result[0]);

        $result['age'] = $lastTimestamp->addDay(1) < Carbon::now() ?  'old' : 'current';

        return $result;

    }

    /**
     * @param $result
     * @return array
     */
    private function toKeyValue($result)
    {
        $result = [
            'time' => $result[0],
            'value' => $result[1]
        ];
        return $result;
    }


}