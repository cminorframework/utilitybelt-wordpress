<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Taxonomy;

interface ITaxonomyHelper
{

    public function getTaxonomies($post_type);

    public function getTaxonomyTerms($taxonomy, $filter_arguments = array() );

}