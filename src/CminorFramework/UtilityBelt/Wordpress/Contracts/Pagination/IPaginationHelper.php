<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Pagination;

/**
 *
 * Creates paginated links and echo pagination on the screen
 *
 * @package CminorFramework
 * @subpackage UtilityBelt
 * @author Jakub Gadkowski <jakub@netwerven.nl> / refactored and enchanced by Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface IPaginationHelper
{

    /**
     * Sets the pagination arguments
     * @param array $pagination_arguments
     */
    public function setPaginationArguments($pagination_arguments);

    /**
     * Initialise pagination and return prepared html with pagination links
     */
    public function getPaginationHtml($posted_page_parameter, $exclude_request_parameters = array(), $use_ajax = false);

}