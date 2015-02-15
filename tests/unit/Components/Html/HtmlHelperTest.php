<?php

use CminorFramework\UtilityBelt\Wordpress\WordpressUtilityBelt;
use CminorFramework\UtilityBelt\Wordpress\Components\Providers\WordpressUtilityBeltServiceProvider;
use CminorFramework\UtilityBelt\Wordpress\Components\Containers\UtilityBeltHelpers;
use CminorFramework\UtilityBelt\Wordpress\Components\Html\HtmlHelper;
class HtmlHelperTest extends \Codeception\TestCase\Test
{

    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $helpers;

    protected function _before()
    {
        $wordpress_utility_belt = new WordpressUtilityBelt();
        $helpers = $wordpress_utility_belt->getHelpers();
        $this->helpers = $helpers;
    }

    protected function _after()
    {
    }

    /**
     * Test that the html helper default instance is returned
     */
    public function testItReturnsTheDefaultHelperInstance()
    {
        $html_helper = $this->helpers->getHtmlHelper();
        $this->assertTrue($html_helper instanceof  HtmlHelper);
    }


}