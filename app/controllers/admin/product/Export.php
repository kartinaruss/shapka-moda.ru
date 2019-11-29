<?php
/**
 * Product Export
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Admin_Product_Export extends Controller
{
    function init()
    {
        if ($this->User_getRole() !== 'admin')
            $this->Url_redirectTo403();
    }

	function indexAction(array $params)
    {
        die();
    }

    function csvAction(array $params)
    {
        $head = array(
            'id',
            'code',
            'key',
            'name',
            'price',
            'price_old',
            'brief',
            'description1',
            'description2',
            'categories',
            //'criterias',
            //'picture',
            'title',
            'keywords',
            'description',
            'label',
            'main',
            'disabled',
        );
        $products = $this->model->product->get($total,0,10000,true);
        foreach ($products as $product)
        {
        	$cat_names = $cri_names = array();
        	$categories = $this->model->product->category->getByProductId($product->id);
        	foreach ($categories as $category)
        	    $cat_names[] = $category->name;
            //$criterias = $this->model->product->criteria->getByProductId($product->id);
            //foreach ($criterias as $criteria)
            //    $cri_names[] = $criteria->name;
                
            $data[] = array(
                $product->id,
                $product->code,
                $product->key,
                $product->name,
                $product->price,
                $product->price_old,
                $product->brief,
                $product->description_wiki,
                $product->seotext_wiki,
                join(',',$cat_names),
                //join(',',$cri_names), 
                //'http://'.$_SERVER['SERVER_NAME'].'/images/product/l/'.$product->picture,
                $product->title,
                $product->keywords,
                $product->description,
                $product->label,
                $product->main,
                $product->disabled,
            );
        }
        $data = array_merge(array($head),array_reverse($data));
        $csv = array();
        foreach ($data as $d)
        {
            $csv[] = '"'.join('";"',str_replace('"', '""', $d)).'"';
        }
        $csv = join(PHP_EOL,$csv);
        //echo '<pre>'.$csv;
        header('Content-Type: application/csv');
        header("Content-disposition: attachment; filename=catalog-".date("Y-m-d").".csv; charset=windows-1251; size=".strlen($csv));
        echo mb_convert_encoding($csv, 'windows-1251', 'utf-8');
        die();
    }

    function ymlAction(array $params)
    {
        
    }
}