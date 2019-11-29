<?php

class Widget_Visited extends aWidget
{
    protected $table = 'menu';
    protected $items;

    function init()
    {

        $this->load->model('product');

        if (isset($_COOKIE['visited_item'])) {
            $cookie_visited = explode(' ',$_COOKIE['visited_item']);
            $lastShow = $_COOKIE['visited_time'];

            $visited = $this->model->product->getByIds($cookie_visited);

            $ii = 0;

            foreach ($visited as $product) {
                if($product->disabled==1)
                    continue;

                $ii++;

                if ($ii > 10)
                	break;

                $this->tpl->assignBlockVars('visited', array(
                    'ID' => $product->id,
                    'KEY' => $product->key,
                    'NAME' => $product->name,
                    'BRIEF' => nl2br($product->brief),
                    'LABEL' => $product->label,
                    'PRICE' => $product->price,
                    'BRIEF' => $product->brief,
                    'CODE' => $product->code,
                    'PRICE_OLD' => $product->price_old
                ));
                if ($product->picture) {
                    $this->tpl->assignBlockVars('visited.picture', array(
                        'SRC' => $product->picture
                    ));
                    $photos = explode('|', $product->album);
                    foreach ($photos as $photo) {
                        if ($photo)
                            $this->tpl->assignBlockVars('visited.album', array(
                                'SRC' => $photo
                            ));
                    }
                }
                if ($product->price)
                    $this->tpl->assignBlockVars('visited.price');
                if ($product->price_old)
                    $this->tpl->assignBlockVars('visited.price_old');
                /**
                 * Params
                 */
                $params = (array)json_decode($product->params, true);
                foreach ($params as $param) {
//=============== 1 =============
                    $price = 0;
                    $price_old = 0;
                    $pos = -1;
                    foreach ($param['values'] as $k => $v) {
                        if (isset($v['hidden']) AND $v['hidden'] == 1) {
                            unset($param['values'][$k]);

                        } else {
                            if ($price == 0)
                                $price = $v['price'];
                            if ($price_old == 0)
                                $price_old = $v['price_old'];
                            if($pos < 0)
                                $pos=$k;
                        }
                    }
//================ /1 ==========




                    if (!empty($param['values'])) {
                        $this->tpl->assignBlockVars('visited.param', array(
                            'NAME' => $param['name'],
                            'POS' => $pos
                        ));
                        foreach ($param['values'] as $i => $value) {

                            $this->tpl->assignBlockVars('visited.param.val', array(
                                'NUM' => $i,
                                'NAME' => @$value['value'],
                                'PRICE' => !empty($value['price']) ? $value['price'] : $product->price,
                                'PRICE_OLD' => !empty($value['price_old']) ? $value['price_old'] : (empty($value['price']) ? $product->price_old : '')
                            ));
                            if ($price != 0) {
                                $this->tpl->appendBlockVars('visited', array(
                                    'PRICE' => $price,
                                    'PRICE_OLD' => $price_old
                                ));
                                if (!$product->price && !empty($value['price']))
                                    $this->tpl->assignBlockVars('visited.price');
                                if (!$product->price_old && !empty($value['price_old']))
                                    $this->tpl->assignBlockVars('visited.price_old');
                            }
                        }
                    } else
                        $this->tpl->assignBlockVars('visited.param2');
                }
            }
            if (!$visited->isEmpty()) {
                $this->tpl->assignBlockVars('leftVisited');

            }
        }
    }
}