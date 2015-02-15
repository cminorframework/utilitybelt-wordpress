<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Html;

use CminorFramework\UtilityBelt\Wordpress\Contracts\Html\IHtmlHelper;
/**
 * Provides Html helper functions
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class HtmlHelper implements IHtmlHelper
{

	public function wrapItemsInHtmlElement($items, $html_element, $css_class = null)
	{
		$html_elements = null;
		$class = null;
		if($css_class){
			$class = 'class="'.$css_class.'"';
		}

		if( !is_array($items) ){

			$html_elements = '<'.$html_element.' '.$class.'>'.$items.'</'.$html_element.'>';

		}
		else{

			$html_elements = array();
			foreach($items as $item){
				$html_elements[] = $this->wrapItemsInHtmlElement($item, $html_element, $css_class);
			}

		}

		return $html_elements;
	}

	public function wrapTaxonomyTermObjectsInHtmlSelectboxOptionElement($terms, $css_class = null)
	{

		$class = null;
		if($css_class){
			$class = 'class="'.$css_class.'"';
		}

		if( ! is_array($terms) ){

			$html_elements = '<option value="'.$terms->slug.'" '.$class.'>'.$terms->name.'</option>';

		}
		else{

			$html_elements = array();
			foreach($terms as $term){

				$html_elements[] = $this->wrapTaxonomyTermObjectsInHtmlSelectboxOptionElement($term, $css_class);

			}

		}

		return $html_elements;

	}

	/**
	 * Builds selectbox html option elements for taxonomy term objects
	 * @param array $taxonomy_terms taxonomy term objects
	 * @param string $selected_slug
	 * @return multitype:|string
	 */
	public function getSelectboxOptionsForTaxonomyTerms($taxonomy_terms, $selected_slug = null)
	{

		$html_options = array();

		if(!$taxonomy_terms){
			return $html_options;
		}

		foreach($taxonomy_terms as $term)
		{
			$selected = null;
			if($selected_slug == $term->slug){
				$selected = 'selected = "selected"';
			}

			$html_options[] = '<option value="'.$term->slug.'" '.$selected.'>'.$term->name.'</option>';

		}

		return implode("\n", $html_options);

	}


	/**
	 * @deprecated
	 * @param unknown $array
	 * @param unknown $html_element
	 * @param string $css_class
	 * @return multitype:string
	 */
	public function addHtmlElementWithClassInArrayItems($array, $html_element, $css_class = null)
	{
		$items = array();
		$class = null;
		if($css_class){
			$class = 'class="'.$css_class.'"';
		}
		foreach($array as $item){
			$items[] = '<'.$html_element.' '.$class.'>'.$item.'</'.$html_element.'>';
		}

		return $items;
	}


	/**
	 * Wraps text inside an html element with class
	 * @param string $item
	 * @param string $html_element
	 * @param string $css_class
	 * @return string
	 */
	public function wrapItemInHtmlElement($item, $html_element, $css_class = null)
	{

	    if($css_class){
	        $string = '<%s class="%s">%s</%s>';
	        return sprintf($string, $html_element, $css_class, $item, $html_element);
	    }
	    else{

	        $string = '<%s>%s</%s>';
	        return sprintf($string, $html_element, $item, $html_element);

	    }



	}

}