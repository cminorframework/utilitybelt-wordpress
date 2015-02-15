<?php
namespace CminorFramework\UtilityBelt\Wordpress\Helpers\Html;

use CminorFramework\UtilityBelt\Wordpress\Helpers\Taxonomy\TaxonomyHelper;
use CminorFramework\UtilityBelt\General\Helpers\URI\URIHelper;

/**
 * Helper class to build html links and filters based on taxonomy
 *
 * @package CminorFramework
 * @subpackage UtilityBelt
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class HtmlTaxonomySearchFilterHelper
{

    //DEPENDENCIES
    protected $taxonomy_helper;
    protected $uri_helper;

    public function  __construct(TaxonomyHelper $taxonomy_helper, URIHelper $uri_helper)
    {
        $this->taxonomy_helper = &$taxonomy_helper;
        $this->uri_helper = &$uri_helper;

    }

    /**
     * Returns an array with lists ul elements containing the anchors elements of the taxonomies found
     * @param array $facets The facets found in elastic search
     * @param array $taxonomies The taxonomies we want to use
     * @param $excluded_parameters The parameters to be excluded from the url
     * @param $use_ajax
     * @return multitype:array
     */
    public function getHtmlTaxonomyFilterLinks($facets, $taxonomies, $excluded_parameters = array(), $use_ajax = false)
    {
        $taxonomy_helper = $this->taxonomy_helper;

        $taxonomy_labels = $taxonomy_helper->getFacetTaxonomiesWithLabel();

        list($taxonomy_arrays, $facets_terms_array) = $this->_transformTaxonomiesAndTermsIntoAssociativeArrays($taxonomies, $facets);


        //clean the url from the request parameters
        $cleaned_url = null;
        if(!$use_ajax){
            $cleaned_url = $this->uri_helper->cleanURLStringFromParameters($_SERVER['REQUEST_URI']);
        }

        //now push back the parameters
        $request_parameter_string = $this->uri_helper->getURIParameterStringLegacy($_SERVER['REQUEST_URI']);
        $request_parameter_array = $this->uri_helper->getURIParameterArrayLegacy($request_parameter_string);

        //also exclude the page parameter
        array_push($excluded_parameters, '_page');
        $request_parameter_array = $this->uri_helper->excludeParametersFromParameterArray($request_parameter_array, $excluded_parameters);


        //now that we have the found terms per taxonomy field, display them in a list with the counts
        $taxonomy_list_options = array();
        foreach($taxonomies as $taxonomy)
        {
            if (isset($facets_terms_array[$taxonomy])) {
            
                $taxonomy_list_options[] = '<div class="search-filter-single block-grey block-grey-shade">';
            
                $taxonomy_list_options[] = '<h3 class="search-filter-header">'.$taxonomy_labels[$taxonomy].'</h3>';
                $taxonomy_list_options[] = '<ul class="search-filter-list">';
                foreach($facets_terms_array[$taxonomy] as $term_slug=>$term_counts){

                    $parameters = $request_parameter_array;

                    //add the taxonomy to the request parameters
                    $parameters['filter-'.$taxonomy] = $term_slug;
                    $parameter_string = $this->uri_helper->buildURLParameterStringFromParameterArray($parameters);
                    $url = home_url().$cleaned_url.'?'.$parameter_string;

                    $anchor = '<a href="'.$url.'">'.$taxonomy_arrays[$taxonomy][$term_slug].' <span>('.$term_counts.')</span></a>';

                    $taxonomy_list_options[] = '<li>'.$anchor.'</li>';
                }
                $taxonomy_list_options[] = '</ul><!-- /.search-filter-list -->';
                $taxonomy_list_options[] = '</div><!-- /.search-filter-single -->';
            }
        }
        return $taxonomy_list_options;
    }


    /**
     * Transforms the taxonomies and facets into associative arrays with its terms and counts
     * @param array $taxonomies
     * @param array $facets
     * @return multitype:unknown
     */
    protected function _transformTaxonomiesAndTermsIntoAssociativeArrays($taxonomies, $facets)
    {

        $taxonomy_helper = $this->taxonomy_helper;

        //init arrays
        $facets_terms_array = $taxonomies;
        $taxonomy_arrays = $taxonomies;

        //build the taxonomy terms into nice arrays
        foreach($taxonomies as $taxonomy){

            foreach($taxonomy_helper->getTaxonomyTerms($taxonomy) as $term){
                $taxonomy_arrays[$taxonomy][$term->slug] = $term->name;
            }

            if($facets[$taxonomy]['total']){

                $facets_terms = $facets[$taxonomy]['terms'];

                //transform the resulting facets array to associative array
                foreach($facets_terms as $term){

                    $facets_terms_array[$taxonomy][$term['term']] = $term['count'];

                }

            }
            else{

                //echo 0;

            }

        }

        return array($taxonomy_arrays, $facets_terms_array);

    }


}