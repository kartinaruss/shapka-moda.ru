<?php
/**
 * Виджет фильтра по критериям
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class Widget_Filter extends aWidget
{
	function init()
    {
    	if (URL_APP && (0!==strpos(URL_APP,'catalog') && 0!==strpos(URL_APP,'filter') && 0!==strpos(URL_APP,'item')))
    	    return;
    	
        $this->load->model('product');
        /**
         * Данные
         */
        $cats = $this->model->product->criteria->getTree();
        foreach ($cats as $cat)
        {
            $this->tpl->assignBlockVars('widget.criteria', array(
                //'ID'  => $cat->id,
                'NAME' => $cat->name
            ));
            if ($cat->children)
            {
                $this->tpl->assignBlockVars('widget.criteria.has_child');
                foreach ($cat->children as $sub)
                {
	                $this->tpl->assignBlockVars('widget.criteria.sub', array(
	                    'ID'  => $sub->id,
	                    'NAME' => $sub->name
	                ));
                }
            }
        }
        if (!$cats->isEmpty())
            $this->tpl->assignBlockVars('widget.filter');
            
        ob_start(array('HTML_FormPersister', 'ob_formPersisterHandler'));
        $items = (array)json_decode(@$_COOKIE['filter'],true);
        $_POST['filter_criteria_id'] = $items;
        $_POST['filter_price_from'] = !empty($_COOKIE['filter_price_from']) ? $_COOKIE['filter_price_from'] : 0;
        $_POST['filter_price_to'] = !empty($_COOKIE['filter_price_to']) ? $_COOKIE['filter_price_to'] : 50000;
    }
}