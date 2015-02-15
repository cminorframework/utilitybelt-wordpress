<?php


use CminorFramework\UtilityBelt\Wordpress\WordpressUtilityBelt;
use CminorFramework\UtilityBelt\Wordpress\Components\Providers\WordpressUtilityBeltServiceProvider;
use CminorFramework\UtilityBelt\Wordpress\Components\Containers\UtilityBeltHelpers;
class WordpressUtilityBeltTest extends \Codeception\TestCase\Test
{

    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * Test that the utility belt object is created successfully
     */
    public function testItStarts()
    {
        $wordpress_utility_belt = new WordpressUtilityBelt();
        $this->assertTrue($wordpress_utility_belt instanceof  WordpressUtilityBelt);
    }

    /**
     * Test that the default service provider is returned if the user has not explicitly set a custom one
     */
    public function testItReturnsTheDefaultServiceProvider()
    {
        $wordpress_utility_belt = new WordpressUtilityBelt();
        $service_provider = $wordpress_utility_belt->getServiceProvider();
        $this->assertTrue($service_provider instanceof  WordpressUtilityBeltServiceProvider);
    }

    /**
     * Test that the wordpress helpers instance is returned correctly
     */
    public function testItReturnsTheWordpressHelpers()
    {
        $wordpress_utility_belt = new WordpressUtilityBelt();
        $helpers = $wordpress_utility_belt->getHelpers();
        $this->assertTrue($helpers instanceof  UtilityBeltHelpers);
    }

}