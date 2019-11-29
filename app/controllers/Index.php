<?php
/**
 * Index
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Index extends Controller
{
    protected $itemsPerPage = 60;
    function indexAction(array $params)
    {
        /**
         * Параметры
         */
        $pg = 1;
        if(in_array('page',$params))
        {
            $pageInd = array_search('page',$params);
            if(isset($params[$pageInd+1]))
                $pg  = $params[$pageInd+1];
            unset($params[$pageInd]);
            unset($params[$pageInd+1]);
        }

        if (!$pg){
            $pg  = 1;
        }

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

        $start = ($pg-1)*$this->itemsPerPage;
        $i=0;
        //$products = $this->model->product->getMain($total, $start, $this->itemsPerPage);
        $products = $this->model->product->getMainHit($total, $start, $this->itemsPerPage);
        foreach ($products as $product)
        {
            $i++;
            $this->tpl->assignBlockVars('product', array(
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
				$this->tpl->assignBlockVars('product.top',[]);
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
        if (!$products->isEmpty())
            $this->tpl->assignBlockVars('products');

            /**
         * Навигация
         */
        $paginator = new Paginator(array(
           'countPerPage'  => $this->itemsPerPage,
           'countOfEntries'=> $total,
           'currentPage' => $pg,
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



        // Subcats
        $subcats = $this->model->product->category->getMain();
        foreach ($subcats as $subcat)
        {
            $this->tpl->assignBlockVars('subcat', array(
                'ID'    => $subcat->id,
                'KEY'   => $subcat->key,
                'NAME'  => $subcat->name,
                'COUNT' => $this->model->product->getCount($subcat->id)
            ));
            if ($subcat->file)
            {
                $this->tpl->assignBlockVars('subcat.picture', array(
                    'SRC'   => $subcat->file
                ));
            }
        }
        if (!$subcats->isEmpty())
            $this->tpl->assignBlockVars('if_subcats');


    }
    
    function see_moreAction(array $params)
    {
        /**
         * Параметры
         */
        $pg = 1;
        if(in_array('page',$params))
        {
            $pageInd = array_search('page',$params);
            if(isset($params[$pageInd+1]))
                $pg  = $params[$pageInd+1];
            unset($params[$pageInd]);
            unset($params[$pageInd+1]);
        }

        if (!$pg){
            $pg  = 1;
        }

        /**
         * Может статическая страница?
         */
            if (!empty($params) or !$this->byAjax())
            die(); //return $this->loadStaticPage(join('/', $params));


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

        $start = ($pg-1)*$this->itemsPerPage;
        $i=0;
        //$products = $this->model->product->getMain($total, $start, $this->itemsPerPage);
        $products = $this->model->product->getMainHit($total, $start, $this->itemsPerPage);
        foreach ($products as $product)
        {
            $i++;
            $this->tpl->assignBlockVars('product', array(
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
				$this->tpl->assignBlockVars('product.top',[]);
				
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
        if (!$products->isEmpty())
            $this->tpl->assignBlockVars('products');

          

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
        //else $this->setPage404();
        else $this->Url_redirectTo('page/not');
    }
}
