<?php
namespace CminorFramework\UtilityBelt\Wordpress\Helpers\Post;

/**
 *
 * Container for the post meta data and provided for some helpful methods
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
class PostMetaHelper
{

    /**
     * Holds the post meta data
     *
     * @var array
     */
    protected $metadata_array = array();

    public function __construct( $metadata_array )
    {

        $this->metadata_array = $metadata_array;

    }

    /**
     * Returns the data of the specified meta key, if it exists
     *
     * @param string $meta_key
     * @param string $single
     * @param bool $decode_html if true will decode the html
     * @return Ambigous <unknown, NULL, multitype:>
     */
    public function getMetaData( $meta_key, $single = true, $decode_html = false)
    {

        // check if the requested key exists in the metadata array and return the content
        $data = isset( $this->metadata_array[$meta_key] ) ? $this->metadata_array[$meta_key] : null;

        if ( $data ) {

            // the metadata is an array, if single is true, return the first element of the array
            // (usually this is what we want for most cases)
            if ( $single ) {

                $data = $data[0];
            }
        }

        if($decode_html){
            $data = html_entity_decode($data);
        }

        return $data;

    }

}