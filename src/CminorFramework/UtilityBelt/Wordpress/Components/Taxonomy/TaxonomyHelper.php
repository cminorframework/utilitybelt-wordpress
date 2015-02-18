<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Taxonomy;

use CminorFramework\UtilityBelt\Wordpress\Contracts\Taxonomy\ITaxonomyHelper;
/**
 *
 * Helper class for the taxonomies
 *
 * @uses Wordpress, WPRF_Search
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class TaxonomyHelper implements ITaxonomyHelper
{

	public function getFacetTaxonomies($force = false)
	{
	    global $wpdb;

	    $taxonomies = get_transient( 'wprf-taxonomies-terms' );
	    if( true == $force || false == $taxonomies ) {
	        $taxonomies = array();
	        $search_options = $wpdb->get_var( $wpdb->prepare( "SELECT option_value FROM $wpdb->options WHERE option_name=%s", 'wprf_search_general_options' ) );
	        $search_options = maybe_unserialize( $search_options );

	        $facet_prefix = 'use_facet_';

	        foreach ( $search_options as $key => $value ) {
	            if ( substr( $key, 0, strlen( $facet_prefix ) ) != $facet_prefix ) {
	                continue;
	            }

	            $taxonomy_name = substr( $key, strlen( $facet_prefix ) );

	            $taxonomy = get_taxonomy( $taxonomy_name );

	            if( $taxonomy ) {

	                $taxonomies[ $taxonomy_name ] = $taxonomy;

	                $terms = get_terms( $taxonomy_name, array( 'hide_empty' => false ) );

	                if ( ! is_wp_error( $terms ) )
	                    $taxonomies[ $taxonomy_name ]->terms = $terms;

	            }
	        }

	        set_transient( 'wprf-taxonomies-terms', $taxonomies, 60 * 60 * 24 );
	    }

	    return $taxonomies;

	}

	public function getTaxonomies($post_type = 'vacancy')
	{
		return get_object_taxonomies($post_type);
	}

	public function getTaxonomyTerms($taxonomy, $filter_arguments = array() )
	{

		if(!$filter_arguments){

			//initialize with default
			$filter_arguments = array(
									'orderby'      => 'name',
									'order'        => 'ASC',
									'hide_empty'   => false,
									'fields'       => 'all',
									'hierarchical' => true
									);
		}

		$terms =  get_terms( $taxonomy, $filter_arguments );

		if(count($terms) == 1 && get_class($terms) == 'WP_Error'){
			throw new \RuntimeException('Invalid taxonomy:'.$taxonomy.', taxonomy not found');
		}

		return $terms;

	}

	public function getFacetTaxonomiesWithLabel()
	{

		$taxonomies = $this->getFacetTaxonomies();
		$taxonomy_labels = array();
		foreach($taxonomies as $taxonomy_slug=>$taxonomy_properties){

			$taxonomy_labels[$taxonomy_slug] = $taxonomy_properties->label;

		}

		return $taxonomy_labels;

	}

	/**
	 * Returns the associated Field taxonomy post for this post id
	 * @param int $post_id
	 * @throws InvalidArgumentException
	 * @return NULL|WP_Post
	 */
	public function getAssociatedFieldTaxonomyPost($post_id)
	{

		if(!$post_id){
			throw new InvalidArgumentException(__CLASS__.'->'.__FUNCTION__.'(): '.'Invalid post id!');
		}


		//get the term for this field taxonomy
		$term = wp_get_post_terms( (int) $post_id, 'field');
		$term = $term[0];

		//find the post of this custom taxonomy term
		$args = array(
				'post_type' => 'field',
				'posts_per_page' => 1,
				'meta_query' => array(
						array(
								'key'     => 'jwwbe_field_term',
								'value'   => array($term->term_id),
								'compare' => 'IN',
						),
				)
		);

		$post_query = new \WP_Query($args);

		if(!$post_query->posts){

			return null;

		}

		return $post_query->posts[0];

	}


	/**
	 * Returns the post terms for this taxonomy
	 * A $callback function can be applied to filter the results
	 * @param int $post_id
	 * @param string $taxonomy
	 * @param string $callback
	 * @return array
	 */
	public function getPostTermsByTaxonomy($post_id, $taxonomy, $callback = null)
	{

	    $terms = [];
	    if($taxonomy_terms = wp_get_post_terms($post_id, $taxonomy)){

	        if($callback){
	            $terms = $callback($taxonomy_terms);
	        }
	        $terms = $taxonomy_terms;
	    }

	    return $terms;
	}


}