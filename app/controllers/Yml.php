<?php
/**
 * YML
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Yml extends Controller
{
    function indexAction(array $params)
    {
    	$password = (string)@$params[0];

        $yml_catalog = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><!DOCTYPE yml_catalog SYSTEM "shops.dtd"><yml_catalog />');
        $yml_catalog->addAttribute('date',date('Y-m-d H:i'));
        $shop = $yml_catalog->addChild('shop');
        $stuff = $this->model->stuff->get();
        $shop->addChild('name',$stuff->site_name);
        $shop->addChild('company',$stuff->site_name);
        $shop->addChild('url',URL_HOME);
        //$shop->addChild('local_delivery_cost','300');

        if (true)
        {
	        $currencies = $shop->addChild('currencies');
	        $currency = $currencies->addChild('currency');
	        $currency->addAttribute('id','RUR');
	        $currency->addAttribute('rate','1');
	        $currency->addAttribute('plus','0');

	        $categories = $shop->addChild('categories');
	        $cats = $this->model->product->category->get($total,0,1000,true);
	        foreach ($cats as $cat)
	        {
	            $category = $categories->addChild('category',str_replace('&','',$cat->name_yml));
	            $category->addAttribute('id',$cat->id);
	        }

	        $offers = $shop->addChild('offers');
	        $products = $this->model->product->get($total,0,10000);
	        foreach ($products as $product)
	        {
	            if (!$product->price) continue;

	            $parent_cats = $this->model->product->category->getByProductId($product->id)->asArray();
	            $cat_id = (int)@$parent_cats[0]['id'];
	            if (!$cat_id) continue;

	            $offer = $offers->addChild('offer');
	            $offer->addAttribute('id',$product->id);
	            //$offer->addAttribute('type',"vendor.model");
	            $offer->addAttribute('available',"true");

	            $offer->addChild('url',URL_HOME.'item/'.$product->key);
	            $offer->addChild('price',$product->price);
	            $offer->addChild('currencyId','RUR');
	            $offer->addChild('categoryId',$cat_id);

	            if ($product->picture)
	                $offer->addChild('picture',URL_HOME.'images/product/s/'.$product->picture);

	            $offer->addChild('delivery','true');
	            $product->name_yml = preg_replace('@[ ]+@',' ',$product->name_yml);
	            $product->name_yml = str_replace('&','',$product->name_yml);
	            $offer->addChild('name',$product->name_yml);

	            $description = mb_substr(strip_tags($product->brief),0,512,'UTF-8');
	            $description = str_replace('&','',$description);
	            if ($description)
	                $offer->addChild('description',$description);
	        }
        }

        header("Content-Type: text/xml");
        echo $yml_catalog->asXml();
        die();
    }
}