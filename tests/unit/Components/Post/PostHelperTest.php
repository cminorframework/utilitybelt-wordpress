<?php

use CminorFramework\UtilityBelt\Wordpress\WordpressUtilityBelt;
use CminorFramework\UtilityBelt\Wordpress\Components\Providers\WordpressUtilityBeltServiceProvider;
use CminorFramework\UtilityBelt\Wordpress\Components\Containers\UtilityBeltHelpers;
use CminorFramework\UtilityBelt\Wordpress\Components\Post\PostHelper;
use CminorFramework\UtilityBelt\Wordpress\Components\Post\DecoratedPost;
class PostHelperTest extends \Codeception\TestCase\Test
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
        $helper = $this->helpers->getPostHelper();
        $this->assertTrue($helper instanceof  PostHelper);
    }

    /**
     * Test it creates a decorated post instance
     */
    public function testItCreatesADecoratedPost()
    {

        $helper = $this->helpers->getPostHelper();

        $decorated_post = $helper->createDecoratedPost(null, [], []);
        $this->assertTrue($decorated_post instanceof  DecoratedPost);

    }

    /**
     * Test it creates a new decorated post instance with meta data provided
     */
    public function testItCreatesADecoratedPostWithMetaData()
    {

        $helper = $this->helpers->getPostHelper();

        $meta_data = ['test_key'=>'test_value'];
        $decorated_post = $helper->createDecoratedPost(null, $meta_data);

        $result = $decorated_post->getMetaData('test_key', false);
        $this->assertTrue($result == $meta_data['test_key']);

    }

    /**
     * Test it creates a new object each time the createDecoratedPost method is called
     */
    public function testItCreatesANewDecoratedPost()
    {

        $helper = $this->helpers->getPostHelper();

        $meta_data = ['test_key'=>'test_value'];
        $decorated_post1 = $helper->createDecoratedPost(null, $meta_data);
        $decorated_post2 = $helper->createDecoratedPost(null, $meta_data);

        $this->assertFalse($decorated_post1 === $decorated_post2);

    }

    /**
     * Test it checks for wordpress required function and throws exception if not found
     */
    public function testItThrowsExceptionIfWordpressGetPostNotFound()
    {
        if(!function_exists('get_post')){
            $this->setExpectedException('CminorFramework\UtilityBelt\Wordpress\Components\Exception\WordpressNotFoundException');
        }
        $helper = $this->helpers->getPostHelper();
        $helper->getDecoratedPost(5);

    }




}