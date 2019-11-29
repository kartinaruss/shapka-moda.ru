<?php
/**
 * Index
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Index extends Controller
{
    function indexAction(array $params)
    {
    	/**
    	 * Может статическая страница?
    	 */
    	if (!empty($params))
    		return $this->loadStaticPage(join('/', $params));
        /**
         * Контент страницы
         */
        $page = $this->model->page->get('index');
        if (!$page->isEmpty())
        {
            $this->page->setTitle($page->title)
                       ->setKeywords($page->keywords)
                       ->setDescription($page->description);
            if ($page->content_html)
            $this->tpl->assignBlockVars('page', array(
                'TITLE'   => $page->title,
                'CONTENT' => $page->content_html
            ));
        }

        $i=0;

		$entriesmain = $this->model->product->category->getTree();
		//echo print_r($entriesmain)."43434343";
		foreach ($entriesmain as $category) {

			if ($category->children)
            {
                foreach ($category->children as $sub)
                {


					$products = $this->model->product->getMain2($sub->id);

					if (!$products->isEmpty()) {


						$this->tpl->assignBlockVars('cat_output', array(
							'ID'   => $category->id,
							'KEY'  => $category->key,
							'NAME' => $category->name,
							'IDC'   => $sub->id,
							'KEYC'  => $sub->key,
							'NAMEC' => ' > '.$sub->name
						));
					}

					//$products = $this->model->product->getMain($total);
					//echo print_r($products)."43434343=$category->id<br>";
					foreach ($products as $product)
					{
						$i++;
						$this->tpl->assignBlockVars('cat_output.product', array(
							'ID'   => $product->id,
							'KEY'   => $product->key,
							'NAME' => $product->name,
							'BRIEF' => nl2br($product->brief),
							'LABEL' => $product->label,
							'PRICE' => $product->price,
							'BRIEF' => $product->brief,
							'CODE' => $product->code,
							'PRICE_OLD' => $product->price_old
						));
						if ($product->picture)
						{
							$this->tpl->assignBlockVars('cat_output.product.picture', array(
								'SRC'   => $product->picture
							));
							$photos = explode('|',$product->album);
							foreach ($photos as $photo)
							{
								if ($photo)
								$this->tpl->assignBlockVars('cat_output.product.album', array(
									'SRC'   => $photo
								));
							}
						}
						if ($product->price)
							$this->tpl->assignBlockVars('cat_output.product.price');
						if ($product->price_old)
							$this->tpl->assignBlockVars('cat_output.product.price_old');
						/**
						 * Params
						 */
						$params = (array)json_decode($product->params,true);
						foreach ($params as $param)
						{
							if (!empty($param['values']))
							{
								$this->tpl->assignBlockVars('cat_output.product.param', array(
									'NAME'   => $param['name']
								));
								foreach ($param['values'] as $i=>$value)
								{
									$this->tpl->assignBlockVars('cat_output.product.param.val', array(
										'NUM'   => $i,
										'NAME'   => @$value['value'],
										'PRICE'  => !empty($value['price']) ? $value['price'] : $product->price,
										'PRICE_OLD'  => !empty($value['price_old']) ? $value['price_old'] : (empty($value['price']) ? $product->price_old : '')
									));
									if ($i==0 && !empty($value['price']))
									{
										$this->tpl->appendBlockVars('cat_output.product', array(
											'PRICE' => @$value['price'],
											'PRICE_OLD' => @$value['price_old']
										));
										if (!$product->price && !empty($value['price']))
											$this->tpl->assignBlockVars('cat_output.product.price');
										if (!$product->price_old && !empty($value['price_old']))
											$this->tpl->assignBlockVars('cat_output.product.price_old');
									}
								}
							}
						}
					}

		            if ($sub->children)
		            {

		            }
                }
            }
			else {

				$products = $this->model->product->getMain2($category->id);

				if (!$products->isEmpty()) {

					$this->tpl->assignBlockVars('cat_output', array(
						'ID'   => $category->id,
						'KEY'  => $category->key,
						'NAME' => $category->name
					));
				}

				//$products = $this->model->product->getMain2($category->id);
				//$products = $this->model->product->getMain($total);
				//echo print_r($products)."43434343=$category->id<br>";
				foreach ($products as $product)
				{
					$i++;
					$this->tpl->assignBlockVars('cat_output.product', array(
						'ID'   => $product->id,
						'KEY'   => $product->key,
						'NAME' => $product->name,
						'BRIEF' => nl2br($product->brief),
						'LABEL' => $product->label,
						'PRICE' => $product->price,
						'BRIEF' => $product->brief,
						'CODE' => $product->code,
						'PRICE_OLD' => $product->price_old
					));
					if ($product->picture)
					{
						$this->tpl->assignBlockVars('cat_output.product.picture', array(
							'SRC'   => $product->picture
						));
						$photos = explode('|',$product->album);
						foreach ($photos as $photo)
						{
							if ($photo)
							$this->tpl->assignBlockVars('cat_output.product.album', array(
								'SRC'   => $photo
							));
						}
					}
					if ($product->price)
						$this->tpl->assignBlockVars('cat_output.product.price');
					if ($product->price_old)
						$this->tpl->assignBlockVars('cat_output.product.price_old');
					/**
					 * Params
					 */
					$params = (array)json_decode($product->params,true);
					foreach ($params as $param)
					{
						if (!empty($param['values']))
						{
							$this->tpl->assignBlockVars('cat_output.product.param', array(
								'NAME'   => $param['name']
							));
							foreach ($param['values'] as $i=>$value)
							{
								$this->tpl->assignBlockVars('cat_output.product.param.val', array(
									'NUM'   => $i,
									'NAME'   => @$value['value'],
									'PRICE'  => !empty($value['price']) ? $value['price'] : $product->price,
									'PRICE_OLD'  => !empty($value['price_old']) ? $value['price_old'] : (empty($value['price']) ? $product->price_old : '')
								));
								if ($i==0 && !empty($value['price']))
								{
									$this->tpl->appendBlockVars('cat_output.product', array(
										'PRICE' => @$value['price'],
										'PRICE_OLD' => @$value['price_old']
									));
									if (!$product->price && !empty($value['price']))
										$this->tpl->assignBlockVars('cat_output.product.price');
									if (!$product->price_old && !empty($value['price_old']))
										$this->tpl->assignBlockVars('cat_output.product.price_old');
								}
							}
						}
					}
				}
			}


		}
		if($page->content_html)
			$this->tpl->assignBlockVars('content_foot', array(
	                'CONTENT' => $page->content_html
	            ));
        //if (!$products->isEmpty())
        //    $this->tpl->assignBlockVars('products');
        // Subcats
        /*$subcats = $this->model->product->category->getMain();
        foreach ($subcats as $subcat)
        {
            $this->tpl->assignBlockVars('cat_output.subcat', array(
                'ID'    => $subcat->id,
                'KEY'   => $subcat->key,
                'NAME'  => $subcat->name,
                'COUNT' => $this->model->product->getCount($subcat->id)
            ));
            if ($subcat->file)
            {
                $this->tpl->assignBlockVars('cat_output.subcat.picture', array(
                    'SRC'   => $subcat->file
                ));
            }
        }
        if (!$subcats->isEmpty())
            $this->tpl->assignBlockVars('cat_output.if_subcats');
            */
    }

    /**
     * Загружаем статическую страницу
     */
    private function loadStaticPage($name)
    {
    	$page = $this->model->page->get($name);
        if (!$page->isEmpty())
        {
            $this->page->setTitle($page->title)
                       ->setKeywords($page->keywords)
                       ->setDescription($page->description);
            $this->tpl->assignBlockVars('page', array(
                'TITLE'   => $page->title,
                'CONTENT' => $page->content_html
            ));
            if (is_file(DIR_TEMPLATES.'/'.$name.EXT_TPL))
                $this->load->view($name);
            else
                !$this->byAjax() ? $this->load->view('page') : $this->load->view('popinfo');
        }
        else $this->setPage404();
    }


}