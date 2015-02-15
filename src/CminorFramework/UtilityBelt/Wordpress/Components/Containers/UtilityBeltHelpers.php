<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Containers;

use CminorFramework\UtilityBelt\Wordpress\Helpers\Html\HtmlHelper;
use CminorFramework\UtilityBelt\Wordpress\Helpers\Taxonomy\TaxonomyHelper;
use CminorFramework\UtilityBelt\Wordpress\Helpers\Attachment\AttachmentHelper;
use CminorFramework\UtilityBelt\Wordpress\Helpers\User\UserHelper;
use CminorFramework\UtilityBelt\Wordpress\Helpers\Pagination\PaginationHelper;
use CminorFramework\UtilityBelt\General\Helpers\URI\URIHelper;
use CminorFramework\UtilityBelt\Wordpress\Helpers\Html\HtmlTaxonomySearchFilterHelper;
use CminorFramework\UtilityBelt\Wordpress\Helpers\Post\PostHelper;

use CminorFramework\UtilityBelt\Wordpress\Components\Providers\WordpressUtilityBeltServiceProvider;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Providers\IWordpressUtilityBeltServiceProvider;


/**
 * Container for the wordpress helper classes
 *
 * @package CminorFramework
 * @subpackage UtilityBelt
 * @version 0.4
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class UtilityBeltHelpers
{

    /**
     * Holds the instance of the utility belt service provider
     * @var \CminorFramework\UtilityBelt\Wordpress\Contracts\Providers\IWordpressUtilityBeltServiceProvider
     */
    protected $service_provider;

    /**
     * Define the setter dependency on the service provider-container
     * @param IWordpressUtilityBeltServiceProvider $service_provider
     */
    public function setServiceProvider(IWordpressUtilityBeltServiceProvider $service_provider)
    {
        $this->service_provider = &$service_provider;
    }

    /**
     * Returns the post helper instance
     * @since 0.4
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IPostHelper
     */
    public function getPostHelper()
    {
        return $this->service_provider->get('CminorFramework\UtilityBelt\Wordpress\Contracts\Post\IPostHelper');
    }

    /**
     * Returns the html helper
     *
     * @since 0.1
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Html\IHtmlHelper
     */
    public function getHtmlHelper()
    {
        return $this->service_provider->get('CminorFramework\UtilityBelt\Wordpress\Contracts\Html\IHtmlHelper');
    }

    /**
     * Returns the Html Taxonomy search filter helper
     * @since 0.3
     * @return \CminorFramework\UtilityBelt\Wordpress\Helpers\Html\HtmlTaxonomySearchFilterHelper
     */
    public function getHtmlTaxonomySearchFilterHelper()
    {
        if(!isset($this->taxonomy_search_filter_html_helper)){
            $this->taxonomy_search_filter_html_helper = new HtmlTaxonomySearchFilterHelper($this->getTaxonomyHelper(), $this->uri_helper);
        }
        return $this->taxonomy_search_filter_html_helper;
    }

    /**
     * Returns the taxonomy helper
     *
     * @since 0.1
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Taxonomy\ITaxonomyHelper
     */
    public function getTaxonomyHelper()
    {
        return $this->service_provider->get('CminorFramework\UtilityBelt\Wordpress\Contracts\Taxonomy\ITaxonomyHelper');
    }

    /**
     * Returns the attachments helper
     *
     * @since 0.1
     * @return \CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IAttachmentHelper
     */
    public function getAttachmentHelper()
    {
        return $this->service_provider->get('CminorFramework\UtilityBelt\Wordpress\Contracts\Attachment\IAttachmentHelper');
    }

    /**
     * Returns the User Helper
     *
     * @since 0.1
     * @return \CminorFramework\UtilityBelt\Wordpress\Helpers\User\UserHelper
     */
    public function getUserHelper()
    {

        if ( ! isset( $this->user_helper ) ) {
            $this->user_helper = new UserHelper();
        }

        return $this->user_helper;

    }

    /**
     * Returns the pagination helper
     *
     * @since 0.2
     * @return \CminorFramework\UtilityBelt\Wordpress\Helpers\Pagination\PaginationHelper
     */
    public function getPaginationHelper()
    {

        if ( ! isset( $this->pagination_helper ) ) {
            $this->pagination_helper = new PaginationHelper($this->uri_helper);
        }

        return $this->pagination_helper;

    }

}