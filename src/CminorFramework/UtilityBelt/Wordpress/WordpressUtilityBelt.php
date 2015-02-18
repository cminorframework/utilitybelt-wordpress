<?php
namespace CminorFramework\UtilityBelt\Wordpress;

use CminorFramework\UtilityBelt\Wordpress\Components\Providers\WordpressUtilityBeltServiceProvider;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Providers\IWordpressUtilityBeltServiceProvider;
use CminorFramework\UtilityBelt\Wordpress\Components\Containers\Helpers;
use CminorFramework\UtilityBelt\Wordpress\Components\Containers\UtilityBeltHelpers;


/**
 * The Wordpress Utility Belt
 *
 * @package CminorFramework
 * @subpackage UtilityBelt
 * @version 0.5
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class WordpressUtilityBelt
{

    /**
     * Holds the utility belt service provider instance
     * @var \CminorFramework\UtilityBelt\Wordpress\Contracts\Providers\IWordpressUtilityBeltServiceProvider
     */
    protected $service_provider;

    /**
     * Holds the wordpress utility belt helpers container instance
     * @var \CminorFramework\UtilityBelt\Wordpress\Components\Containers\UtilityBeltHelpers
     */
    protected $utility_belt_helpers;

    /**
     * Binds a wordpress utility belt service provider to resolve the utility belt components
     *
     * @param \CminorFramework\UtilityBelt\Wordpress\Contracts\Providers\IWordpressUtilityBeltServiceProvider $service_provider
     */
    public function _bindServiceProvider(IWordpressUtilityBeltServiceProvider $service_provider)
    {

        $this->service_provider = $service_provider;

    }

    /**
     * Returns the utility belt service provider
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Providers\IWordpressUtilityBeltServiceProvider
     */
    public function getServiceProvider()
    {

        /*
         * Initialize the service provider with the utility belt's default provider
         * if a custom one has not been set before
         */
        if(!isset($this->service_provider)){

            $this->service_provider = new WordpressUtilityBeltServiceProvider();

        }

        return $this->service_provider;
    }

    /**
     * Returns the wordpress utility belt helpers contaniner singleton instance
     *
     * @return \CminorFramework\UtilityBelt\Wordpress\Components\Containers\UtilityBeltHelpers
     */
    public function getHelpers()
    {
        //
        if( !isset($this->utility_belt_helpers) ){

            $utility_belt_helpers = new UtilityBeltHelpers();
            $utility_belt_helpers->setServiceProvider($this->getServiceProvider());

            $this->utility_belt_helpers = $utility_belt_helpers;
        }

        return $this->utility_belt_helpers;

    }

}