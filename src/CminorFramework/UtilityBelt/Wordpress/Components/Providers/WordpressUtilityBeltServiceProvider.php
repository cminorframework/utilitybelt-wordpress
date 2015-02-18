<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Providers;

use CminorFramework\UtilityBelt\Wordpress\Contracts\Providers\IWordpressUtilityBeltServiceProvider;
use Illuminate\Container\Container;

/**
 *
 * The default service provider for the wordpress helper instances.
 * Binds the helper instance
 *
 * @uses \Illuminate\Container\Container
 * @see https://github.com/illuminate/container
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class WordpressUtilityBeltServiceProvider extends Container implements IWordpressUtilityBeltServiceProvider
{

    /**
     * Registers all the component bindings
     */
    public function __construct()
    {
        $this->bind('CminorFramework\UtilityBelt\Wordpress\Contracts\Html\IHtmlHelper', 'CminorFramework\UtilityBelt\Wordpress\Components\Html\HtmlHelper', true);
        $this->bind('CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IDecoratedPost', 'CminorFramework\UtilityBelt\Wordpress\Components\Post\DecoratedPost', false);
        $this->bind('CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IPostHelper', 'CminorFramework\UtilityBelt\Wordpress\Components\Post\PostHelper', true);
        $this->bind('CminorFramework\UtilityBelt\Wordpress\Contracts\Taxonomy\ITaxonomyHelper', 'CminorFramework\UtilityBelt\Wordpress\Components\Taxonomy\TaxonomyHelper', true);
        $this->bind('CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IDecoratedImage', 'CminorFramework\UtilityBelt\Wordpress\Components\Attachment\DecoratedImage', false);
        $this->bind('CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IAttachmentHelper', 'CminorFramework\UtilityBelt\Wordpress\Components\Attachment\AttachmentHelper', true);
        $this->bind('CminorFramework\UtilityBelt\Wordpress\Contracts\User\IDecoratedUser', 'CminorFramework\UtilityBelt\Wordpress\Components\User\DecoratedUser', false);
        $this->bind('CminorFramework\UtilityBelt\Wordpress\Contracts\User\IUserHelper', 'CminorFramework\UtilityBelt\Wordpress\Components\User\UserHelper', true);
        $this->bind('CminorFramework\UtilityBelt\General\Contracts\URI\IURIHelper', 'CminorFramework\UtilityBelt\General\Components\URI\URIHelper', true);
        $this->bind('CminorFramework\UtilityBelt\Wordpress\Contracts\Pagination\IPaginationHelper', 'CminorFramework\UtilityBelt\Wordpress\Components\Pagination\PaginationHelper', true);

    }


    public function attach($abstract, $concrete, $shared = false)
    {
        return $this->bind($abstract, $concrete, $shared);
    }

    public function get($abstract, $parameters = [])
    {
        return $this->make($abstract, $parameters);
    }


}