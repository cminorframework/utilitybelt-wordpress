<?php
namespace CminorFramework\UtilityBelt\Wordpress\Components\Models;

use CminorFramework\UtilityBelt\Wordpress\Contracts\Models\IDecoratedModel;

class DecoratedModel implements IDecoratedModel
{

    protected $_raw_object;
    protected $_meta_data;
    protected $_extra_data;

    public function _setRawObject($raw_object)
    {
        $this->_raw_object = $raw_object;
    }

    public function getRawObject()
    {
        return $this->_raw_object;
    }

    public function _setMetaDataArray(array $data_array)
    {
        $this->_meta_data = $data_array;
    }

    public function _setExtraDataArray(array $data_array)
    {
        $this->_extra_data = $data_array;
    }

    public function setMetaData($key, $value)
    {
        $this->_meta_data[$key] = $value;
    }

    public function setExtraData($key, $value)
    {
        $this->_extra_data[$key] = $value;
    }

    public function getMetaData( $meta_key, $single = true, $filter_function = null)
    {

        if(!$data = $this->_getDataFromArray($this->_meta_data, $meta_key, $single)){
            if($single){
                return null;
            }
            return [];
        }

        //filter the result of the data if a custom function is provided
        if($filter_function){
            $data = $filter_function($data);
        }

        return $data;

    }

    public function getExtraData($key, $single = false, $filter_function = null)
    {

        if(!$data = $this->_getDataFromArray($this->_extra_data, $key, $single)){
            return null;
        }

        //filter the result of the data if a custom function is provided
        if($filter_function){
            $data = $filter_function($data);
        }

        return $data;

    }

    protected function _getDataFromArray($data_array, $key, $single = false)
    {

        if(!$data_array){
            return null;
        }

        // check if the requested key exists in the $data_array array and return the content
        $data = isset( $data_array[$key] ) ? $data_array[$key] : null;
        if ( $data ) {

            // for nested arrays like post metadata, if single is true, return the first element of the array
            if ( $single ) {

                if(isset($data[0])){
                    $data = $data[0];
                }

            }

        }

        return $data;

    }

}