<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Taxonomy;

interface ITaxonomyHelper
{

    public function getTaxonomies($post_type);

    public function getTaxonomyTerms($taxonomy, $filter_arguments = array() );

    /**
     * Returns the post terms for this taxonomy
     * A $callback function can be applied to filter the results
     * @param int $post_id
     * @param string $taxonomy
     * @param string $callback
     * @return array
     */
    public function getPostTermsByTaxonomy($post_id, $taxonomy, $callback = null);

}