<?php
/**
 * Created by PhpStorm.
 * User: samtax
 * Date: 01/12/2018
 * Time: 3:03 PM
 */







class exUrlPickerController extends Controller1{


    /**
     * @return bool|string
     */
    static function search(){
        $model_id = isset_or($_REQUEST['model_id'], null);
        $model_name = isset_or($_REQUEST['model_name'], null);

        /** @var Model1 $model */
        $model = $model_id? $model_name::withId($model_id): null;
        $search_limit = $_REQUEST['search_limit'];

        // search query
        $q = $_REQUEST['q'];

        // Fetch Images
        $allImages = $model? Model1FileLocator::find_likely($q, $search_limit, true, $model): Model1FileLocator::find_likely($q, $search_limit, true);
        return ResultObject1::make(!!$allImages,  null, $allImages);
    }



    /**
     * Save new Url
     * @return bool|string
     */
    static function saveUrl(){
        $model_id = $_REQUEST['model_id'];
        $model_name = $_REQUEST['model_name'];
        /** @var Model1 $model */
        $model = $model_name::withId($model_id);
        $file_url = $_REQUEST['file_url'];
        $file_name = $_REQUEST['file_name'];
        // Save File Url
        $result = Model1FileLocator::insertUrl($model, $file_url, String1::if_empty($file_name, null, $file_name));
        return ResultObject1::make(!!$result,  null, $result);
    }





}