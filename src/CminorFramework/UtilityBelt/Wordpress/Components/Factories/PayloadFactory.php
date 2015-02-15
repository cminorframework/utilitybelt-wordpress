<?php
namespace CminorFramework\UtilityBelt\Wordpress\Extendables\Components\Factories;

use CminorFramework\UtilityBelt\Contracts\Wordpress\Extendables\Components\Factories\PayloadFactory as PayloadFactoryInterface;
abstract class PayloadFactory implements PayloadFactoryInterface
{

    protected $build_parameters;

    public function build()
    {
        //override this
    }

    public function setBuildParameters($parameters)
    {
        $this->build_parameters = $parameters;
        return $this;
    }


}