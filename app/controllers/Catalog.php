<?php
/**
 * Catalog
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Catalog extends Controller
{
    protected $itemsPerPage = 45;

    function indexAction(array $params)
    {
        if (empty($params))
        {
            $this->load->view('catalog/main');
            return $this->mainAction($params);
        }
        /**
         * Параметры
         */
        $page = 1;
        if(in_array('page',$params))
        {
            $pageInd = array_search('page',$params);
            if(isset($params[$pageInd+1]))
                $page = $params[$pageInd+1];
            unset($params[$pageInd]);
            unset($params[$pageInd+1]);
        }
        if (!$page)
            $page = 1;

        $key = @$params[0];
        if (empty($key))
        {
            return $this->Url_redirectToHome();
        }

        $category = $this->model->product->category->getByKey($key);
		//echo print_r($category);
        if ($category->isEmpty() || $category->disabled)
            $this->setPage404();

        if ($category->block)
            $this->tpl->assignBlockVars('category_block',array(
                'HTML' => $category->block,
            ));
        if ($category->title)
            $this->page->setTitle($category->title);
        $this->page->setKeywords($category->keywords)
                   ->setDescription($category->description);

        $this->tpl->assignBlockVars('cat_output', array(
							'ID'   => $category->id,
							'KEY'  => $category->key,
							'NAME' => $category->name
						));
        if($page == 1) {

	        // Subcats
	        $subcats = $this->model->product->category->getSub($category->id);
			//echo print_r($subcats);
			$numsubcat=0;
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
				$numsubcat++;
	        }
	        if (!$subcats->isEmpty())
	            $this->tpl->assignBlockVars('cat_output.if_subcats');
	        // Upper cats
	        $uppercats = array();
	        if ($category->parent_id)
	        {
	            $uppercat = $this->model->product->category->getById($category->parent_id);
	            $uppercats[] = $uppercat;
	            if ($uppercat->parent_id)
	            {
	                $uppercat = $this->model->product->category->getById($uppercat->parent_id);
	                $uppercats[] = $uppercat;
	            }
	        }
	        $uppercats = array_reverse($uppercats);
	        foreach ($uppercats as $uppercat)
	        {
	            $this->tpl->assignBlockVars('cat_output.uppercat', array(
	                'KEY'   => $uppercat->key,
	                'NAME'  => $uppercat->name
	            ));
	        }
	        if (!empty($uppercats))
	            $this->tpl->assignBlockVars('cat_output.if_uppercats');

        }
        /**
         * Выборка данных
         */
        if ($this->var->itemsPerPage)
            $this->itemsPerPage = $this->var->itemsPerPage;
        $start = ($page-1)*$this->itemsPerPage;
		if ($numsubcat>0) {

			//foreach ($subcats as $sub) {



				$this->tpl->assignBlockVars('cat_output.category', array(
					'ID'    => $category->id,
					'KEY'   => $category->key,
					'NAME' => $category->name,
					'IDC'   => $sub->id,
					'KEYC'  => $sub->key,
					//'NAMEC' => ' > '.$sub->name,
					'NAMEC' => $sub->name?$sub->name:$category->name,
					'SEOTEXT' => $category->seotext_html,
					'DESCRIPTION' => $category->description_html
				));


				if ($category->seotext_html)
					$this->tpl->assignBlockVars('cat_output.category.seotext');

				if ($category->id == 1041)
					$entries = $this->model->product->getByCategoryHit($category->id, $total, $start, $this->itemsPerPage);
				else
					$entries = $this->model->product->getByCategory($category->id, $total, $start, $this->itemsPerPage);
				$i=0;
				foreach ($entries as $product)
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
						'PRICE_OLD' => $product->price_old,
						'TOP' => $product->top,
					));
					
					if ($product->top)
						$this->tpl->assignBlockVars('cat_output.product.top',[]);
						
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
										'PRICE_OLD' => @($value['price_old']?$value['price_old']:$product->price_old)
									));
									if (!$product->price && !empty($value['price']))
										$this->tpl->assignBlockVars('product.price');
									if (!$product->price_old && !empty($value['price_old']))
										$this->tpl->assignBlockVars('product.price_old');
								}
							}
						}
						else
                			$this->tpl->assignBlockVars('cat_output.product.param2');
					}
				}
				if (!$entries->isEmpty())
					$this->tpl->assignBlockVars('cat_output.products');
			//}

		}
		else {

/*			$this->tpl->assignBlockVars('cat_output', array(
				'ID'   => $category->id,
				'KEY'  => $category->key,
				'NAME' => $category->name
			));
*/
			if ($category->parent_id > 0) {

				$uppercat22 = $this->model->product->category->getById($category->parent_id);

				$this->tpl->assignBlockVars('cat_output.category', array(
					'ID'    => $uppercat22->id,
					'KEY'   => $uppercat22->key,
					'NAME' => $uppercat22->name,
					'IDC'    => $category->id,
					'KEYC'   => $category->key,
					'NAMEC' => $category->name,
					'SEOTEXT' => $category->seotext_html,
					'DESCRIPTION' => $category->description_html
				));
			}
			else {

				$this->tpl->assignBlockVars('cat_output.category', array(
					'ID'    => $category->id,
					'KEY'   => $category->key,
					'NAME' => $category->name,
					//'IDC'    => $category->id,
					//'KEYC'   => $category->key,
					//'NAMEC' => $category->name,
					'SEOTEXT' => $category->seotext_html,
					'DESCRIPTION' => $category->description_html
				));
			}
			if ($category->seotext_html)
				$this->tpl->assignBlockVars('cat_output.category.seotext');

			if ($category->id == 1041)
					$entries = $this->model->product->getByCategoryHit($category->id, $total, $start, $this->itemsPerPage);
				else
					$entries = $this->model->product->getByCategory($category->id, $total, $start, $this->itemsPerPage);
			$i=0;
			foreach ($entries as $product)
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
					'PRICE_OLD' => $product->price_old,
					'TOP' => $product->top,
					));
					
				if ($product->top)
					$this->tpl->assignBlockVars('cat_output.product.top',[]);
						
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
									'PRICE_OLD' => @($value['price_old']?$value['price_old']:$product->price_old)
								));
								if (!$product->price && !empty($value['price']))
									$this->tpl->assignBlockVars('product.price');
								if (!$product->price_old && !empty($value['price_old']))
									$this->tpl->assignBlockVars('product.price_old');
							}
						}
					}
					else
                		$this->tpl->assignBlockVars('cat_output.product.param2');
				}
			}
			if (!$entries->isEmpty())
				$this->tpl->assignBlockVars('cat_output.products');
		}
        /**
         * Навигация
         */
        $paginator = new Paginator(array(
           'countPerPage'  => $this->itemsPerPage,
           'countOfEntries'=> $total,
           'currentPage' => $page,
           'countOfFirstPages'=> 5,
           'countOfLastPages' => 5,
           'countOfMiddlePages'=> 4,
           'template' => $this->tpl
        ));
        $paginator->compile();

        $this->setTitle(array('CATEGORY_NAME'=>$category->name));
        $this->tpl->assignVar('CATEGORY_KEY',$category->key);
        if ($category->seotext_html)
	        $this->tpl->assignBlockVars('seotext', array(
	                'SEOTEXT' => $category->seotext_html
	            ));
			
		$this->tpl->assignVars(array(
            'CANONICAL'=>'<link rel="canonical" href="http://'.$_SERVER['SERVER_NAME'].'/catalog/'.$category->key.'">',
        ));
    }
    
    function see_moreAction(array $params)
    {
        if (empty($params) or !$this->byAjax())
        {
            //$this->load->view('catalog/main');
            //return $this->mainAction($params);
            die();
        }
        /**
         * Параметры
         */
        $page = 1;
        if(in_array('page',$params))
        {
            $pageInd = array_search('page',$params);
            if(isset($params[$pageInd+1]))
                $page = $params[$pageInd+1];
            unset($params[$pageInd]);
            unset($params[$pageInd+1]);
        }
        if (!$page)
            $page = 1;

        $key = @$params[0];
        if (empty($key))
        {
            die();//return $this->Url_redirectToHome();
        }

        $category = $this->model->product->category->getByKey($key);
		//echo print_r($category);
        if ($category->isEmpty() || $category->disabled)
            die();//$this->setPage404();

        if ($category->block)
            $this->tpl->assignBlockVars('category_block',array(
                'HTML' => $category->block,
            ));
        if ($category->title)
            $this->page->setTitle($category->title);
        $this->page->setKeywords($category->keywords)
                   ->setDescription($category->description);

        $this->tpl->assignBlockVars('cat_output', array(
							'ID'   => $category->id,
							'KEY'  => $category->key,
							'NAME' => $category->name
						));
        if($page == 1) {

	        // Subcats
	        $subcats = $this->model->product->category->getSub($category->id);
			//echo print_r($subcats);
			$numsubcat=0;
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
				$numsubcat++;
	        }
	        if (!$subcats->isEmpty())
	            $this->tpl->assignBlockVars('cat_output.if_subcats');
	        // Upper cats
	        $uppercats = array();
	        if ($category->parent_id)
	        {
	            $uppercat = $this->model->product->category->getById($category->parent_id);
	            $uppercats[] = $uppercat;
	            if ($uppercat->parent_id)
	            {
	                $uppercat = $this->model->product->category->getById($uppercat->parent_id);
	                $uppercats[] = $uppercat;
	            }
	        }
	        $uppercats = array_reverse($uppercats);
	        foreach ($uppercats as $uppercat)
	        {
	            $this->tpl->assignBlockVars('cat_output.uppercat', array(
	                'KEY'   => $uppercat->key,
	                'NAME'  => $uppercat->name
	            ));
	        }
	        if (!empty($uppercats))
	            $this->tpl->assignBlockVars('cat_output.if_uppercats');

        }
        /**
         * Выборка данных
         */
        if ($this->var->itemsPerPage)
            $this->itemsPerPage = $this->var->itemsPerPage;
        $start = ($page-1)*$this->itemsPerPage;
		if ($numsubcat>0) {

			//foreach ($subcats as $sub) {



				$this->tpl->assignBlockVars('cat_output.category', array(
					'ID'    => $category->id,
					'KEY'   => $category->key,
					'NAME' => $category->name,
					'IDC'   => $sub->id,
					'KEYC'  => $sub->key,
					//'NAMEC' => ' > '.$sub->name,
					'NAMEC' => $sub->name?$sub->name:$category->name,
					'SEOTEXT' => $category->seotext_html,
					'DESCRIPTION' => $category->description_html
				));


				if ($category->seotext_html)
					$this->tpl->assignBlockVars('cat_output.category.seotext');

				if ($category->id == 1041)
					$entries = $this->model->product->getByCategoryHit($category->id, $total, $start, $this->itemsPerPage);
				else
					$entries = $this->model->product->getByCategory($category->id, $total, $start, $this->itemsPerPage);
				$i=0;
				foreach ($entries as $product)
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
										'PRICE_OLD' => @($value['price_old']?$value['price_old']:$product->price_old)
									));
									if (!$product->price && !empty($value['price']))
										$this->tpl->assignBlockVars('product.price');
									if (!$product->price_old && !empty($value['price_old']))
										$this->tpl->assignBlockVars('product.price_old');
								}
							}
						}
						else
                			$this->tpl->assignBlockVars('cat_output.product.param2');
					}
				}
				if (!$entries->isEmpty())
					$this->tpl->assignBlockVars('cat_output.products');
			//}

		}
		else {

/*			$this->tpl->assignBlockVars('cat_output', array(
				'ID'   => $category->id,
				'KEY'  => $category->key,
				'NAME' => $category->name
			));
*/
			if ($category->parent_id > 0) {

				$uppercat22 = $this->model->product->category->getById($category->parent_id);

				$this->tpl->assignBlockVars('cat_output.category', array(
					'ID'    => $uppercat22->id,
					'KEY'   => $uppercat22->key,
					'NAME' => $uppercat22->name,
					'IDC'    => $category->id,
					'KEYC'   => $category->key,
					'NAMEC' => $category->name,
					'SEOTEXT' => $category->seotext_html,
					'DESCRIPTION' => $category->description_html
				));
			}
			else {

				$this->tpl->assignBlockVars('cat_output.category', array(
					'ID'    => $category->id,
					'KEY'   => $category->key,
					'NAME' => $category->name,
					//'IDC'    => $category->id,
					//'KEYC'   => $category->key,
					//'NAMEC' => $category->name,
					'SEOTEXT' => $category->seotext_html,
					'DESCRIPTION' => $category->description_html
				));
			}
			if ($category->seotext_html)
				$this->tpl->assignBlockVars('cat_output.category.seotext');

			if ($category->id == 1041)
					$entries = $this->model->product->getByCategoryHit($category->id, $total, $start, $this->itemsPerPage);
				else
					$entries = $this->model->product->getByCategory($category->id, $total, $start, $this->itemsPerPage);
			$i=0;
			foreach ($entries as $product)
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
									'PRICE_OLD' => @($value['price_old']?$value['price_old']:$product->price_old)
								));
								if (!$product->price && !empty($value['price']))
									$this->tpl->assignBlockVars('product.price');
								if (!$product->price_old && !empty($value['price_old']))
									$this->tpl->assignBlockVars('product.price_old');
							}
						}
					}
					else
                		$this->tpl->assignBlockVars('cat_output.product.param2');
				}
			}
			if (!$entries->isEmpty())
				$this->tpl->assignBlockVars('cat_output.products');
		}
        
    }

    function searchAction(array $params)
    {
        /**
         * Параметры
         */
        $page = 1;
        if(in_array('page',$params))
        {
            $pageInd = array_search('page',$params);
            if(isset($params[$pageInd+1]))
                $page = $params[$pageInd+1];
            unset($params[$pageInd]);
            unset($params[$pageInd+1]);
        }
        if (!$page)
            $page = 1;

        $query = empty($_POST['query']) ? urldecode(@$params[0]) : $_POST['query'];
        $query = strip_tags($query);
        if (empty($query))
        {
            return $this->Url_redirectToHome();
        }
        $this->tpl->assignVar('SEARCH_QUERY',$query);
        $this->tpl->assignVar('SEARCH_QUERY2',urlencode($query));
        /**
         * Выборка данных
         */
        if ($this->var->itemsPerPage)
            $this->itemsPerPage = $this->var->itemsPerPage;
        $start = ($page-1)*$this->itemsPerPage;
        $entries = $this->model->product->search($query, $total, $start, $this->itemsPerPage);
        foreach ($entries as $product)
        {
            $this->tpl->assignBlockVars('product', array(
                'ID'   => $product->id,
                'KEY'  => $product->key,
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
            if ($product->price)
                $this->tpl->assignBlockVars('product.price');
            if ($product->price_old)
                $this->tpl->assignBlockVars('product.price_old');
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
	                            'PRICE_OLD' => @($value['price_old']?$value['price_old']:$product->price_old)
	                        ));
                            if (!$product->price && !empty($value['price']))
                                $this->tpl->assignBlockVars('product.price');
                            if (!$product->price_old && !empty($value['price_old']))
                                $this->tpl->assignBlockVars('product.price_old');
	                    }
	                }
	            }
	            else
                	$this->tpl->assignBlockVars('product.param2');
	        }
        }
        $this->tpl->assignVar('SEARCH_TOTAL',$total);
        if (!$entries->isEmpty())
            $this->tpl->assignBlockVars('products');
        /**
         * Навигация
         */
        $paginator = new Paginator(array(
           'countPerPage'  => $this->itemsPerPage,
           'countOfEntries'=> $total,
           'currentPage' => $page,
           'countOfFirstPages'=> 5,
           'countOfLastPages' => 5,
           'countOfMiddlePages'=> 4,
           'template' => $this->tpl
        ));
        $paginator->compile();
    }



    function mainAction(array $params)
    {
        $entriesmain = $this->model->product->category->getTree();
		//echo print_r($entriesmain)."43434343";
		foreach ($entriesmain as $category) {

			$this->tpl->assignBlockVars('cat_output', array(
					'ID'   => $category->id,
					'KEY'  => $category->key,
					'NAME' => $this->strtoupper2($category->name)
				));

			$entries = $this->model->product->getMain2($category->id, $total);

			//echo print_r($entries);

			foreach ($entries as $product)
			{
				$this->tpl->assignBlockVars('product', array(
					'ID'   => $product->id,
					'KEY'  => $product->key,
					'NAME' => $this->strtoupper2($product->name),
					'BRIEF' => nl2br($product->brief),
					'LABEL' => $product->label,
					'PRICE' => $product->price,
					'BRIEF' => $product->brief,
					'CODE' => $product->code,
					'PRICE_OLD' => $product->price_old
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
				if ($product->price)
					$this->tpl->assignBlockVars('product.price');
				if ($product->price_old)
					$this->tpl->assignBlockVars('product.price_old');
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
									'PRICE_OLD' => @($value['price_old']?$value['price_old']:$product->price_old)
								));
								if (!$product->price && !empty($value['price']))
									$this->tpl->assignBlockVars('product.price');
								if (!$product->price_old && !empty($value['price_old']))
									$this->tpl->assignBlockVars('product.price_old');
							}
						}
					}
					else
                		$this->tpl->assignBlockVars('product.param2');
				}
			}
		}
    }

    function itemAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id))
        {
            return $this->Url_redirectToHome();
        }

        $product = $this->model->product->getById($id);
        if ($product->isEmpty())
        {
            return $this->setPage404();
        }

        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".URL_HOME."item/".$product->key);
        die();
    }
}
