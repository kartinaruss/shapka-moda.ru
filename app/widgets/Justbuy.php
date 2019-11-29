<?php
/**
 * Виджет только что купленных товаров
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class Widget_Justbuy extends aWidget
{
	function init()
    {
        if (false === ($stuff = $this->cache->get('stuff')))
        {
            $this->load->model('stuff');
            $stuff = $this->model->stuff->get();
        }
        if (!$stuff->justbuy_on || !$stuff->justbuy_products)
            return;
        
        $this->load->model('product');
        /**
         * Данные
         */
        $items = $this->model->product->getByIds(explode('|',$stuff->justbuy_products));
        if ($items->isEmpty())
            return;
        $this->tpl->assignBlockVars('widget.justbuy',array(
            'NAME' => $stuff->justbuy_header
        ));
        
        $i = 0;
        $times = array('Только что', '17 минут назад', '35 минут назад', '1 час назад', '2 часа назад', '2 часа назад');
        $k = count(explode('|',$stuff->justbuy_products));
        
        foreach ($items as $item) {
          $items2[$i] = $item;
          $i++;
        }
        
        for ($i = 0; $i <= count($times) - 1; $i++) {
            $item = $items2[rand(0, $k-1)];
            $this->tpl->assignBlockVars('widget.justbuy.item', array(
                'NAME' => $item->name,
                'ID'  => $item->id,
                'KEY'  => $item->key,
                'BRIEF'=> nl2br($item->brief),
                'TIME'  => $times[$i],
                'PRICE' => $item->price,
                'PRICE_OLD' => $item->price_old,                
            ));
            if ($item->picture)
            {
                $this->tpl->assignBlockVars('widget.justbuy.item.picture', array(
                    'SRC' => $item->picture
                ));
            }        
        }
        
/*        foreach ($items as $item)
        {
            $this->tpl->assignBlockVars('widget.justbuy.item', array(
                'NAME' => $item->name,
                'ID'  => $item->id,
                'KEY'  => $item->key,
                'BRIEF'=> nl2br($item->brief),
                'TIME'  => $times[$i],
            ));
            $i++;
            if ($item->picture)
            {
                $this->tpl->assignBlockVars('widget.justbuy.item.picture', array(
                    'SRC' => $item->picture
                ));
            }
        }*/
    }
}