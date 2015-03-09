<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Models;

/**
 *
 * Defines the methods for a decorated model that serves as a structure to extend
 * the raw/original object with extra methods/information.
 * This is the base model that will be extended by other models such as
 * DecoratedPost, DecoratedAttachment, etc
 *
 * @author Dimitrios Psarrou <dpsarrou@gmail.com> d(^_^)b
 * @link http://soundcloud.com/cminor, https://github.com/dpsarrou
 *
 */
interface IDecoratedModel
{

    /**
     * Sets the raw/original object
     *
     * @param mixed $raw_object
     *            Depending on the original object, could be WP_Post, or WP_User etc
     */
    public function _setRawObject($raw_object);

    /**
     * Returns the raw/original object
     */
    public function getRawObject();

    /**
     * Sets an array of meta data associated with the raw object
     *
     * @param array $data_array
     */
    public function _setMetaDataArray(array $data_array);

    /**
     * Sets an array of extra data associated with the raw object
     *
     * @param array $data_array
     */
    public function _setExtraDataArray(array $data_array);

    /**
     * Set a meta data key - value pair
     *
     * @param string $key
     * @param mixed $value
     */
    public function setMetaData($key, $value);

    /**
     * Set an extra data key - value pair
     *
     * @param string $key
     * @param mixed $value
     */
    public function setExtraData($key, $value);

    /**
     * Returns the meta data value associated with the provided key
     *
     * @param string $key
     *            The meta data key
     * @param bool $single
     *            Set to true if you want to retrieve the sigle element if its an array
     * @param mixed $callback_function
     *            If a callback function is given, the meta data value will be passed to this function
     */
    public function getMetaData($key, $single = true, $callback_function = null);

    /**
     * Returns the extra data value associated with the provided key
     *
     * @param string $key
     *            The extra data key
     * @param string $single
     *            Set to true if you want to retrieve the sigle element if its an array
     * @param string $callback_function
     *            If a callback function is given, the extra data value will be passed to this function
     */
    public function getExtraData($key, $single = false, $callback_function = null);

}
