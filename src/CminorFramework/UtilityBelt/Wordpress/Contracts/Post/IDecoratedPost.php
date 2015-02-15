<?php
namespace CminorFramework\UtilityBelt\Wordpress\Contracts\Post;

interface IDecoratedPost
{

    public function _setRawObject($raw_object);

    public function getRawObject($raw_object);

    public function _setMetaDataArray(array $data_array);

    public function  _setExtraDataArray(array $data_array);

    public function setMetaData($key, $value);

    public function setExtraData($key, $value);

    public function getMetaData( $meta_key, $single = true, $filter_function = null);

    public function getExtraData($key, $single = false, $filter_function = null);

}