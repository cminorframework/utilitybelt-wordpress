<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Html;

/**
 * Provides Html helper functions
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface IHtmlHelper
{

	public function wrapItemsInHtmlElement($items, $html_element, $css_class = null);

	public function wrapTaxonomyTermObjectsInHtmlSelectboxOptionElement($terms, $css_class = null);

	/**
	 * Builds selectbox html option elements for taxonomy term objects
	 * @param array $taxonomy_terms taxonomy term objects
	 * @param string $selected_slug
	 * @return multitype:|string
	 */
	public function getSelectboxOptionsForTaxonomyTerms($taxonomy_terms, $selected_slug = null);


	/**
	 * @deprecated
	 * @param unknown $array
	 * @param unknown $html_element
	 * @param string $css_class
	 * @return multitype:string
	 */
	public function addHtmlElementWithClassInArrayItems($array, $html_element, $css_class = null);


	/**
	 * Wraps text inside an html element with class
	 * @param string $item
	 * @param string $html_element
	 * @param string $css_class
	 * @return string
	 */
	public function wrapItemInHtmlElement($item, $html_element, $css_class = null);

}