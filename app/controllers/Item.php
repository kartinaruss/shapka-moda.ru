<?php
/**
 * Catalog Item
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Item extends Controller
{
    function indexAction(array $params)
    {
        $key = @$params[0];
        if (empty($key))
        {
            return $this->Url_redirectToHome();
        }

        $product = $this->model->product->getByKey($key);
        if ($product->isEmpty() || $product->disabled)
            return $this->setPage404();

	//=============================
        // абтест просмотренных товаров
        $visited_item = array();
        $maxVisitedCount = 20;
        if (isset($_COOKIE['visited_item'])) {
            $visited_item = explode(' ', $_COOKIE['visited_item']);
            if (count($visited_item) > $maxVisitedCount AND !in_array($product->id, $visited_item)) {
                unset($visited_item[$maxVisitedCount - 1]);
            }
        }
        if (!in_array($product->id, $visited_item)) {
            array_unshift($visited_item, $product->id);
        }
        setcookie('visited_item', implode(' ', $visited_item), time() + 365 * 24 * 3600, '/');
        setcookie('visited_time', time(), time() + 365 * 24 * 3600, '/');
        // абтест просмотренных товаров
        //=============================


        $cookies_id_item = array();
        if($_COOKIE['ids_item']) {

			$cookies_id_item = explode(",",$_COOKIE['ids_item']);
		}

		if(!in_array($product->id,$cookies_id_item)) {
			$cookies_id_item[] = $product->id;
			setcookie("ids_item",implode(",",$cookies_id_item),time()+30*24*3600,'/');
		}

        $this->tpl->assignBlockVars('product', array(
            'ID'   => $product->id,
            'KEY'   => $product->key,
            'NAME' => $product->name,
            'DESCRIPTION' => str_replace('<p>', '', str_replace('</p>', '', $product->description_html)),
            'SEOTEXT' => str_replace('<p>', '', str_replace('</p>', '', $product->seotext_html)),
            'PRICE' => $product->price,
            'PRICE_OLD' => $product->price_old,
            'BRIEF' => $product->brief,
            'CODE' => $product->code,
			'RATING' => $product->rating,
            'LABEL' => $product->label
        ));
        if ($product->picture)
        {
            $this->tpl->assignBlockVars('product.picture', array(
                'SRC'   => $product->picture
            ));
            $photos = explode('|',$product->album);
            foreach ($photos as $photo)
            {
                if ($photo)
                $this->tpl->assignBlockVars('product.album', array(
                    'SRC'   => $photo
                ));
            }
        }
        if ($product->album)
            $this->tpl->assignBlockVars('product.if_album');
        if ($product->price)
            $this->tpl->assignBlockVars('product.price');
        if ($product->price_old)
            $this->tpl->assignBlockVars('product.price_old');
        if ($product->seotext_html)
            $this->tpl->assignBlockVars('product.seotext');

        if ($product->title)
            $this->page->setTitle($product->title);
        $this->page->setKeywords($product->keywords)
                   ->setDescription($product->description);
        /**
         * Params
         */
        $params = (array)json_decode($product->params,true);
        foreach ($params as $param)
        {
            if (!empty($param['values']))
            {
                $this->tpl->assignBlockVars('product.param', array(
                    'NAME'   => $param['name']
                ));
                foreach ($param['values'] as $i=>$value)
                {
                    $this->tpl->assignBlockVars('product.param.val', array(
                        'NUM'   => $i,
                        'NAME'   => @$value['value'],
                        'PRICE'  => !empty($value['price']) ? $value['price'] : $product->price,
                        'PRICE_OLD'  => !empty($value['price_old']) ? $value['price_old'] : (empty($value['price']) ? $product->price_old : '')
                    ));
                    if ($i==0 && !empty($value['price']))
                    {
                        $this->tpl->appendBlockVars('product', array(
                            'PRICE' => @$value['price'],
                            'PRICE_OLD' => @$value['price_old']
                        ));
                        if (!$product->price && !empty($value['price']))
                            $this->tpl->assignBlockVars('product.price');
                        if (!$product->price_old && !empty($value['price_old']))
                            $this->tpl->assignBlockVars('product.price_old');
                    }
                }
            }
        }

        $this->setTitle(array('PRODUCT_NAME'=>$product->name));

        // Upper cats
        $uppercats = array();
        $parent_cats = $product->category->asArray();
		$parent_id = null;
		$cat_ref_key = array_shift(explode('/',array_pop(explode('/catalog/',@$_SERVER['HTTP_REFERER']))));
		if ($cat_ref_key)
		{
			$parent_cat_keys = array();
			foreach ($parent_cats as $parent_cat)
			    $parent_cat_keys[] = $parent_cat['key'];
			$parent_found = array_search($cat_ref_key,$parent_cat_keys);
			if (false !== $parent_found)
			    $parent_id = (int)@$parent_cats[$parent_found]['id'];
		}
		if (is_null($parent_id))
            $parent_id = (int)@$parent_cats[0]['id'];
        if ($parent_id)
        do
        {
            $uppercat = $this->model->product->category->getById($parent_id);
            $uppercats[] = $uppercat;
            $parent_id = $uppercat->parent_id;
        }
        while ($parent_id);
        $uppercats = array_reverse($uppercats);
        foreach ($uppercats as $uppercat)
        {
            $this->tpl->assignBlockVars('uppercat', array(
                'KEY'   => $uppercat->key,
                'NAME'  => $uppercat->name
            ));
        }
        if (!empty($uppercats))
            $this->tpl->assignBlockVars('if_uppercats');

        $category = @$uppercats[0];
        if ($category && $category->block)
            $this->tpl->assignBlockVars('category_block',array(
                'HTML' => $category->block,
            ));

        // Соседние товары
        if (isset($uppercat) && !$uppercat->isEmpty())
        {
            $flag = '_prev';
            $i=0;
            $entries = $this->model->product->getByCategory($uppercat->id, $total);
            foreach ($entries as $entry)
            {
                $i++;
                if (is_null($flag))
                    continue;

                if ((isset($found) && $entry->id==$product->id) || $flag=='_next')
                {
                    if ($flag=='_next')
                        $found = $entry;
                    $this->tpl->assignBlockVars('product'.$flag, array(
                        'KEY' => $found->key,
                        'NAME' => mb_strlen($found->name,'UTF-8')>35 ? mb_substr($found->name,0,35,'UTF-8').'...' : $found->name,
                    ));
                    if ($flag=='_next')
                        $flag = null;
                }
                if ($entry->id==$product->id)
                    $flag = '_next';
                $found = $entry;
            }
            if ($i>1)
                $this->tpl->assignBlockVars('neighbours');
        }

        /**
         * See also
         */
        if ($product->also)
        {
            $entries = $this->model->product->getByIds(explode('|',$product->also));
            $i=0;
            foreach ($entries as $product)
            {
				if($product->disabled==1)
					continue;

                $i++;
                $this->tpl->assignBlockVars('also', array(
                    'ID'   => $product->id,
                    'KEY'   => $product->key,
                    'NAME' => $product->name,
                    'BRIEF' => $product->brief,
                    'LABEL' => $product->label,
                    'PRICE' => $product->price,
                    'BRIEF' => $product->brief,
                    'CODE' => $product->code,
                    'PRICE_OLD' => $product->price_old
                ));
                if ($product->picture)
                {
                    $this->tpl->assignBlockVars('also.picture', array(
                        'SRC'   => $product->picture
                    ));
                }
                if ($product->price)
                    $this->tpl->assignBlockVars('also.price');
                if ($product->price_old)
                    $this->tpl->assignBlockVars('also.price_old');
                /**
                 * Params
                 */
                $params = (array)json_decode($product->params,true);
                foreach ($params as $param)
                {
                    if (!empty($param['values']))
                    {
                        $this->tpl->assignBlockVars('also.param', array(
                            'NAME'   => $param['name']
                        ));
                        foreach ($param['values'] as $i=>$value)
                        {
                            $this->tpl->assignBlockVars('also.param.val', array(
                                'NUM'   => $i,
                                'NAME'   => @$value['value'],
                                'PRICE'  => !empty($value['price']) ? $value['price'] : $product->price,
                                'PRICE_OLD'  => !empty($value['price_old']) ? $value['price_old'] : (empty($value['price']) ? $product->price_old : '')
                            ));
                            if ($i==0 && !empty($value['price']))
                            {
                                $this->tpl->appendBlockVars('also', array(
                                    'PRICE' => @$value['price'],
                                    'PRICE_OLD' => @$value['price_old']
                                ));
                                if (!$product->price && !empty($value['price']))
                                    $this->tpl->assignBlockVars('also.price');
                                if (!$product->price_old && !empty($value['price_old']))
                                    $this->tpl->assignBlockVars('also.price_old');
                            }
                        }
                    }
                    else
                		$this->tpl->assignBlockVars('also.param2');
                }
            }
            if (!$entries->isEmpty())
                $this->tpl->assignBlockVars('see_also');
        }
    }

	function strtoupper2($string)
	{
		$small = array('а','б','в','г','д','е','ё','ж','з','и','й',
					   'к','л','м','н','о','п','р','с','т','у','ф',
					   'х','ч','ц','ш','щ','э','ю','я','ы','ъ','ь',
					   'э', 'ю', 'я','a','b','c','d','e','f','g','h',
					   'i','j','k','l','m','n','o','p','q','r','s','t',
					   'u','v','w','x','y','z');
		$large = array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й',
					   'К','Л','М','Н','О','П','Р','С','Т','У','Ф',
					   'Х','Ч','Ц','Ш','Щ','Э','Ю','Я','Ы','Ъ','Ь',
					   'Э', 'Ю', 'Я','A','B','C','D','E','F','G','H',
					   'I','J','K','L','M','N','O','P','Q','R','S','T',
					   'U','V','W','X','Y','Z');
		return str_replace($small, $large, $string);
	}
}
