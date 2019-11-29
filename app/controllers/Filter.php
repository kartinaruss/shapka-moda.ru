<?php
/**
 * Filter
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Filter extends Controller
{
    protected $itemsPerPage = 30; 
    
    function indexAction(array $params)
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
            
        $items = (array)json_decode(@$_COOKIE['filter'],true);
        
        $start = ($page-1)*$this->itemsPerPage;
        $products = $this->model->product->getByCriterias(array_values($items),$total,@$_COOKIE['filter_price_from'],@$_COOKIE['filter_price_to'], $start, $this->itemsPerPage);
        foreach ($products as $product)
        {
            $this->tpl->assignBlockVars('product', array(
                'ID'   => $product->id,
                'KEY'  => $product->key,
                'NAME' => $this->strtoupper2($product->name),
                'BRIEF' => $product->brief,
                'LABEL' => $product->label,
                'PRICE' => $product->price,
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
        
        $this->tpl->assignVar('TOTAL',$total);
    }
    
    function totalAction(array $params)
    {
        $items = (array)json_decode(@$_COOKIE['filter'],true);
        
        $this->model->product->getByCriterias(array_values($items),$total,@$_COOKIE['filter_price_from'],@$_COOKIE['filter_price_to'],0,100);
        die((string)$total);
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