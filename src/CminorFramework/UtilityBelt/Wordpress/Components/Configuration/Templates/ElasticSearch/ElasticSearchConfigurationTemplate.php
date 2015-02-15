<?php
namespace CminorFramework\UtilityBelt\Wordpress\Templates\Configuration\ElasticSearch;

/**
 *
 * Configuration class.
 * This is a template ONLY!!
 * By extending this class we can setup the settings for each specific post type we want to search using elastic search
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
abstract class ElasticSearchConfigurationTemplate
{

	public $settings_per_post_type;

	public function __construct()
	{

		//get the user input
		$search_phrase = isset($_GET['s']) ? $_GET['s'] : null;
		$field = isset($_GET['filter-field']) ? $_GET['filter-field'] : null;
		$educational_level = isset($_GET['filter-educational_level']) ? $_GET['filter-educational_level'] : null;
		$employment_form = isset($_GET['filter-employment-form']) ? $_GET['filter-employment-form'] : null;
		$sort_by = isset($_GET['sort-by']) ? $_GET['sort-by'] : null;
		$pagination = isset($_GET['_page']) ? $_GET['_page'] : 1;

		//define the settings per post type
		$post =
				array(
					'search_phrase'=>$search_phrase,
					'search'=>array('field'=>$field, 'educational-level'=>$educational_level, 'employment-form'=>$employment_form),
					'geolocation'=>array(),
					'sort'=>array('sort-by'=>$sort_by),
					'pagination'=>$pagination,
					'returned_fields'=>array( '_id', 'title.title', 'url', 'excerpt', 'date', 'post_type.name', 'post_type.label', 'thumbnail', 'location', 'taxonomy.city' )

				);

		//store the settings
		$this->settings_per_post_type = $post;

	}




}