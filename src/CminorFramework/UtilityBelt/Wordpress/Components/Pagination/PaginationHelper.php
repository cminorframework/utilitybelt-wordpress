<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Pagination;

use CminorFramework\UtilityBelt\General\Contracts\URI\IURIHelper;
use CminorFramework\UtilityBelt\Wordpress\Contracts\Pagination\IPaginationHelper;
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
class PaginationHelper implements IPaginationHelper
{

    /**
     * DEPENDENCY: holds the uri helper instance
     * @var \CminorFramework\UtilityBelt\General\Contracts\URI\IURIHelper
     */
    protected $uri_helper;

    public function __construct(IURIHelper $uri_helper)
    {
        //dependencies
        $this->uri_helper = $uri_helper;

    }

    /**
     * Array of arguments used in creating pagination
     * @var array
     * int total - number of results (found items) from Elasticsearch query
     * int current - current page
     * int size - number of results per page for Elasticsearch to return
     * int total_pages - automatically calculated number of pages based on total and size
     * int page - here not used, left for compatibility with Bolintra
     * bool show_all - on TRUE show all pages, on FALSE show pages and ellipsis (...)
     * All below that are default paginate settings http://codex.wordpress.org/Function_Reference/paginate_links
     */
    protected $pagination_args = array(
        'page_request_parameter_name'=>'_page',
        'total'        => 1,
        'current'      => 1,
        'size'         => 12,
        'total_pages'  => 0,
        'page'         => 1,
        'show_all'     => false,
        //wp paginate standard settings
        'end_size'     => 1,
        'mid_size'     => 2,
        'prev_next'    => True,
        'prev_text'    => '',
        'next_text'    => '',
        'type'         => 'plain',
        'add_args'     => False,
        'add_fragment' => '',
        'before_page_number' => '',
        'after_page_number' => ''
    );

    public function setPaginationArguments($pagination_arguments)
    {
        $this->_parseArguments($pagination_arguments);
    }

    /**
     * Assign passed arguments to $this->pagination_args
     * @param array $args - array of arguments
     */
    protected function _parseArguments($args)
    {
        foreach ( $args as $arg_name => $arg_val ) {
            if ( isset($this->pagination_args[$arg_name]) ) {
                $this->pagination_args[$arg_name] = $arg_val;
            }
        }

    }

    /**
     * Prepare and calculate settings for pagination. Part of the initialisation process.
     */
    protected  function prepare_pagination($posted_page_parameter)
    {

        $found = $this->pagination_args['total'];
        $size = $this->pagination_args['size'];
        $this->pagination_args['total_pages'] = ceil($found / $size);
        $this->pagination_args['current'] = ( isset( $posted_page_parameter ) ) ? (int) $posted_page_parameter : 1 ;
    }

    /**
     * Initialise pagination and return prepared html with pagination links
     */
    public function getPaginationHtml($posted_page_parameter, $exclude_request_parameters = array(), $use_ajax = false){

        $this->prepare_pagination($posted_page_parameter);

        //clean the url from the request parameters
        $cleaned_url = null;
        if(!$use_ajax){
            $cleaned_url = $this->uri_helper->cleanURLStringFromParameters($_SERVER['REQUEST_URI']);
        }

        //add the page parameter to the excluded ones
        array_push($exclude_request_parameters, $this->pagination_args['page_request_parameter_name']);

        //now push back the parameters excluding the page parameter
        $request_parameter_string = $this->uri_helper->getURIParameterStringLegacy($_SERVER['REQUEST_URI']);
        $request_parameter_array = $this->uri_helper->getURIParameterArrayLegacy($request_parameter_string);

        if($new_parameter_string = $this->uri_helper->buildURLParameterStringFromParameterArrayExcluding($request_parameter_array, $exclude_request_parameters)){

            $new_parameter_string = '?'.$new_parameter_string;

        }

        //build the base url including the website url + the page + the parameters
        $base_url = home_url().$cleaned_url.$new_parameter_string;

        //define the format of the pagination parameter depending on existing parameters
        $format         = !$new_parameter_string ? '?'.$this->pagination_args['page_request_parameter_name'].'=%#%' : '&'.$this->pagination_args['page_request_parameter_name'].'=%#%' ;


        $args = array(
            'base'         => $base_url.'%_%',
            'format'       => $format,
            'total'        => $this->pagination_args['total_pages'],
            'current'      => $this->pagination_args['current'],
            'show_all'     => $this->pagination_args['show_all'],
            'end_size'     => $this->pagination_args['end_size'],
            'mid_size'     => $this->pagination_args['mid_size'],
            'prev_next'    => $this->pagination_args['prev_next'],
            'prev_text'    => ( $this->pagination_args['prev_text'] ) ? $this->pagination_args['prev_text'] : __('« Previous', 'wprf'),
            'next_text'    => ( $this->pagination_args['next_text'] ) ? $this->pagination_args['next_text'] : __('Next »', 'wprf'),
            'type'         => $this->pagination_args['type'],
            'add_args'     => $this->pagination_args['add_args'],
            'add_fragment' => ( $this->pagination_args['add_fragment'] ) ? $this->pagination_args['add_fragment'] :'',
            'before_page_number' => ( $this->pagination_args['before_page_number'] ) ? $this->pagination_args['before_page_number'] :'',
            'after_page_number' => ( $this->pagination_args['after_page_number'] ) ? $this->pagination_args['after_page_number'] :'',
        );

        return paginate_links( $args );
    }
}