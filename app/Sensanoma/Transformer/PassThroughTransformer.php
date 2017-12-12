<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 12/12/17
 * Time: 15:33
 */

namespace App\Sensanoma\Transformer;



class PassThroughTransformer implements TransformerInterface
{

    public function transform($data)
    {
        return $data;
    }

}