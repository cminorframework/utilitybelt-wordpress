<?php
namespace CminorFramework\UtilityBelt\Wordpress\Extendables\Components\Models;
use CminorFramework\UtilityBelt\Contracts\Wordpress\Extendables\Components\Models\PayloadModel;
use Elasticsearch\Common\Exceptions\InvalidArgumentException;

class PayloadModel implements PayloadModel
{

    protected $payload = [];

    public function getPayload($item_name){
        if(!$item_name){
            throw new InvalidArgumentException(__CLASS__.'::'.__FUNCTION__.'()'.__LINE__.' Invalid item name' );
        }
    }

    public function setPayload($item_name, $value)
    {
        if(!$item_name){
            throw new InvalidArgumentException(__CLASS__.'::'.__FUNCTION__.'()'.__LINE__.' Invalid item name' );
        }
        $this->payload[$item_name] = $value;
        return $this;
    }

}