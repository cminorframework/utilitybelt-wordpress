<?php
namespace CminorFramework\UtilityBelt\Contracts\Wordpress\Extendables\Components\Factories;

interface PayloadFactory
{

    public function build();

    public function setBuildParameters($parameters);

}