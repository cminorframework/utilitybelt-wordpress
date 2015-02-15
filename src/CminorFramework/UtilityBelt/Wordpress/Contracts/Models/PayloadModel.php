<?php
namespace CminorFramework\UtilityBelt\Contracts\Wordpress\Extendables\Components\Models;
interface PayloadModel
{

    public function setPayload($item_name, $value);

    public function getPayload($item_name);


}