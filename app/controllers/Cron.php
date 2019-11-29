<?php
/**
 * Cronjob
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Cron extends Controller
{
    function indexAction(array $params)
    {
    	die();
    }
    
    function yml_catalogAction(array $params)
    {
        set_time_limit(360);
        sleep(rand(0,100));

        $yml_catalog = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><!DOCTYPE yml_catalog SYSTEM "shops.dtd"><yml_catalog />');
        $yml_catalog->addAttribute('date',date('Y-m-d H:i'));
        $shop = $yml_catalog->addChild('shop');
        $stuff = $this->model->stuff->get();
        $shop->addChild('name',$stuff->site_name);
        $shop->addChild('company',$stuff->site_name);
        $shop->addChild('url',URL_HOME);
        //$shop->addChild('local_delivery_cost','300');
        
        $currencies = $shop->addChild('currencies');
        $currency = $currencies->addChild('currency');
        $currency->addAttribute('id','RUR');
        $currency->addAttribute('rate','1');
        $currency->addAttribute('plus','0');
        
        $categories = $shop->addChild('categories');
        $cats = $this->model->product->category->get($total,0,1000,true);
        foreach ($cats as $cat)
        {
            $category = $categories->addChild('category',$cat->name);
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
            $product->name = preg_replace('@[ ]+@',' ',$product->name);
            $offer->addChild('name',$product->name);
            
            $description = mb_substr(strip_tags($product->brief),0,512,'UTF-8');
            if ($description)
                $offer->addChild('description',$description);
        }
        
        file_put_contents(DIR_ROOT.'/catalog.xml',$yml_catalog->asXml());
    }
}