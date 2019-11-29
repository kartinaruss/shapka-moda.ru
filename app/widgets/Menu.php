<?php
/**
 * Виджет меню
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class Widget_Menu extends aWidget
{
    protected $table = 'menu';
	protected $items;
	
	function init()
    {
        $this->load->model('menu');
        $this->tpl->assignBlockVars('widget.menu');
        
        $items = $this->model->menu->getTree();
        foreach ($items as $item)
        {
            $this->tpl->assignBlockVars('widget.menu.item', array(
                'TITLE' => $item->title,
                'LINK'  => $item->link
            ));
            if ($item->children)
            {
                $this->tpl->assignBlockVars('widget.menu.item.has_child');
                foreach ($item->children as $sub)
                {
                    $this->tpl->assignBlockVars('widget.menu.item.sub', array(
		                'TITLE' => $sub->title,
		                'LINK'  => $sub->link
                    ));
                }
            }
        }
    }
}