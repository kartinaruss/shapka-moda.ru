<?php
/**
 * Виджет подгрузки всяких мелких параметров
 *
 * @author dandelion <web.dandelion@gmail.com>
 * @package Widget_Stuff
 */
class Widget_Stuff extends aWidget
{
    function init()
    {
    	$this->tpl->assignVars(array(
            'TITLE'     => $this->page->getTitle(),
            'KEYWORDS'  => $this->page->getKeywords(),
            'DESCRIPTION' => $this->page->getDescription(),
            'BASEURL'   => URL_HOME,
            'URL_THIS'  => URL_THIS,
            'DOMAIN'    => $_SERVER['SERVER_NAME']
        ));

        if (false === ($stuff = $this->cache->get('stuff')))
        {
            $this->load->model('stuff')->model('wiki')->model('email');
            $stuff = $this->model->stuff->get();
            /**
             * Обработка данных
             */
            foreach (array('guarantee_body','promo_body','discount_body','special_body') as $wiki2html)
            {
                $stuff->$wiki2html  = $this->model->wiki->parseArticle($stuff->$wiki2html);
            }
            $stuff->mailto = $this->model->email->crypt($stuff->email);
            if (!$stuff->year)
                $stuff->year = date('Y');
            elseif ($stuff->year < date('Y'))
                $stuff->year  .= '-'.date('Y');

            $stuff->rand = rand(1,1000);

            $this->cache->set($stuff, 'stuff', array('stuff'));
        }
        $this->tpl->assignVars(array(
            'MAILTO' => $stuff->mailto,
            'SKYPE' => $stuff->skype,
            'ICQ' => $stuff->icq,
            'PHONE' => $stuff->phone,
            'PHONE2' => $stuff->phone2,
            'PHONE3' => $stuff->phone3,
            'OGRN' => $stuff->ogrn,
            'TIMER' => time(),
            'WORK_HOURS' => nl2br($stuff->work_hours),
            'DESCRIPT' => $stuff->descript,

            'GOOGLE_ANALYTICS' => $stuff->google_analytics,
            'YANDEX_METRIKA' => $stuff->yandex_metrika,
            'GOOGLE_VERIFICATION' => $stuff->google_verification,
            'YANDEX_VERIFICATION' => $stuff->yandex_verification,
            'COUNTER' => $stuff->counter,

            'SITE_NAME' => $stuff->site_name,
            'YEAR'  => $stuff->year,
            'TITLE_POSTFIX'  =>  (URL_APP) ? $stuff->title_postfix : '',
            'CURRENCY'  => $stuff->currency,
            'CURRENCY'  => '&#8381;',
            'CURRENCY'  => '<i class="ruble4">a</i>',
            
            'PHONE_MASK'  => $stuff->phone_mask,

            'LINK_VK' => $stuff->link_vk,
            'LINK_FB' => $stuff->link_fb,
            'LINK_TW' => $stuff->link_tw,
            'LINK_OD' => $stuff->link_od,

            'BUTTON_ORDER_CLASS'  => 'cart',
            'BUTTON_ORDER_TEXT'  => $stuff->button_order_text,

            'TIMESTAMP' => time()+3600,
            'RAND' => $stuff->rand,

            'ONLINE_CHAT' => $stuff->online_chat,
            'POPUP_FLAG' => $stuff->enable_popup ? ' rel="popup"' : '',
            'EXIT_MESSAGE' => $stuff->enable_popup ? ' name="'.str_replace(PHP_EOL,"\n",str_replace('"','\'',$stuff->exit_message)).'"' : ''
        ));
        foreach (array('skype','icq','email','ogrn','counter','descript','maincats','search','phone','phone2','link_vk','link_fb','link_tw','link_od') as $block)
        {
        	if ($stuff->$block)
                $this->tpl->assignBlockVars($block);
        }
        if ($stuff->link_vk || $stuff->link_fb || $stuff->link_tw || $stuff->link_od)
            $this->tpl->assignBlockVars('social');
        // Яндекс.Метрика
        if ($stuff->ym_counter_id)
            $this->tpl->assignBlockVars('metrika',array('COUNTER_ID'=>$stuff->ym_counter_id));
        // Лого
        if (is_file(DIR_IMAGES.'/logo/logo.png'))
            $this->tpl->assignBlockVars('logo');
        // Гарантия
        if ($stuff->guarantee_on)
        {
            $this->tpl->assignBlockVars('guarantee',array(
                'HEADER' => $stuff->guarantee_header,
                'BODY'   => $stuff->guarantee_body,
                'LINK'   => $stuff->guarantee_link ? $stuff->guarantee_link : 'javascript:;',
            ));
            if (is_file(DIR_IMAGES.'/stuff/guarantee.png'))
                $this->tpl->assignBlockVars('guarantee.img');
        }
        // Акция
        if ($stuff->promo_on)
        {
            $this->tpl->assignBlockVars('promo',array(
                'HEADER' => $stuff->promo_header,
                'BODY'   => $stuff->promo_body,
                'LINK'   => $stuff->promo_link ? $stuff->promo_link : 'javascript:;',
            ));
            if (is_file(DIR_IMAGES.'/stuff/promo.png'))
                $this->tpl->assignBlockVars('promo.img');

            //всегда сами запускаем акцию каждую неделю, вместо настроек админки (мой блок)
/*              $time = time();
              $r = date('w', $time);
              //$r = 1; //0 - воскресенье, 1 - понедельник

              $r = 1 + 7 - $r;
              if ($r > 7) {
                 $r -= 7;   }

              $timestamp = floor($time/60/60)*60*60 - date('H', $time)*60*60;
              $timestamp = $timestamp + $r*24*60*60;

              $count = 24*2 - date('G', $time)*2 - round(date('i', $time)/60);
              if ($count <= 1) $count = 2;

              $this->tpl->assignBlockVars('promo.timer');
              $this->tpl->appendBlockVars('promo',array(
                  'TIMESTAMP'   => $timestamp,
                  'Count' => $count,
              ));
            //закончили (мой блок)
*/

            if ($stuff->promo_timer && $stuff->promo_interval)
            {
                $this->tpl->assignBlockVars('promo.timer');
//                $interval = 3600*$stuff->promo_interval;
//                $timestamp = $stuff->promo_timestamp+$interval;

				$interval = $stuff->promo_interval * 3600 - 19*60;

                if (isset($_COOKIE['timer_name'])) {
                    $timer_name = $_COOKIE['timer_name'];
                }


                if ($stuff->promo_timestamp !== $timer_name) {
                	setcookie("timer",0,time()-1000);
                }

                setcookie("timer_name",$stuff->promo_timestamp,time()+7*24*3600);

                if (isset($_COOKIE['timer'])) {
                    $timestamp = $_COOKIE['timer'];
                } else {
                	$timestamp = $interval + time();
	                setcookie("timer",$timestamp,time()+7*24*3600);
                }

                if ($timestamp<time())
                {
                    $timestamp = time() + $interval;
                }

//                if ($timestamp<time())
//                {
//                    $timestamp = $timestamp + ceil((time()-$timestamp)/$interval)*$interval;
//                }

                //$count = round(($timestamp - $stuff->promo_timestamp)/60/60*2.5);
                $count = round(($timestamp - time())/60/60*3);
                if ($count <= 1) {
                  $count = 2;
                }


                $this->tpl->appendBlockVars('promo',array(
                    'TIMESTAMP'   => $timestamp,
                    'Count' => $count,
                ));

		    	$this->tpl->assignVars(array(
                    'TIMESTAMP'   => $timestamp,
		        ));

            }
        }
        // Скидки
        if ($stuff->discount_on)
        {
            $this->tpl->assignBlockVars('discount',array(
                'HEADER' => $stuff->discount_header,
                'BODY'   => $stuff->discount_body,
                'LINK'   => $stuff->discount_link ? $stuff->discount_link : 'javascript:;',
            ));
            if (is_file(DIR_IMAGES.'/stuff/discount.png'))
                $this->tpl->assignBlockVars('discount.img');
        }
        if (($stuff->guarantee_on || $stuff->promo_on || $stuff->discount_on) && ($stuff->blocks || !URL_APP))
            $this->tpl->assignBlockVars('blocks');
        // Special
        if ($stuff->special_on && (!URL_APP || 0===strpos(URL_APP,'?')))
        {
            $this->load->model('product');
            $product = $this->model->product->getById($stuff->special_product);
            $this->tpl->assignBlockVars('special',array(
                'DESCRIPTION'   => $product->description_html,
                'ID'   => $product->id,
                'KEY'   => $product->key,
                'NAME'   => $product->name,
                'PRICE'   => $product->price,
                'PRICE_OLD'   => $product->price_old,
            ));
            if ($product->picture)
            {
                $this->tpl->assignBlockVars('special.picture', array(
                    'SRC'   => $product->picture
                ));
                $photos = explode('|',$product->album);
                foreach ($photos as $photo)
                {
                    if ($photo)
                    $this->tpl->assignBlockVars('special.album', array(
                        'SRC'   => $photo
                    ));
                }
            }
            if ($product->album)
                $this->tpl->assignBlockVars('special.if_album');
            if ($product->price)
                $this->tpl->assignBlockVars('special.price');
            if ($product->price_old)
                $this->tpl->assignBlockVars('special.price_old');
            // Params
            $params = (array)json_decode($product->params,true);
            foreach ($params as $param)
            {
                if (!empty($param['values']))
                {
                    $this->tpl->assignBlockVars('special.param', array(
                        'NAME'   => $param['name']
                    ));
                    foreach ($param['values'] as $i=>$value)
                    {
                        $this->tpl->assignBlockVars('special.param.val', array(
                            'NUM'   => $i,
                            'NAME'   => @$value['value'],
                            'PRICE'  => !empty($value['price']) ? $value['price'] : $product->price,
                            'PRICE_OLD'  => !empty($value['price_old']) ? $value['price_old'] : (empty($value['price']) ? $product->price_old : '')
                        ));
                        if ($i==0 && !empty($value['price']))
                        {
                            $this->tpl->appendBlockVars('special', array(
                                'PRICE' => @$value['price'],
                                'PRICE_OLD' => @$value['price_old']
                            ));
                                if (!$product->price && !empty($value['price']))
                                    $this->tpl->assignBlockVars('special.price');
                                if (!$product->price_old && !empty($value['price_old']))
                                    $this->tpl->assignBlockVars('special.price_old');
                        }
                    }
                }
            }
        }
        else $this->tpl->assignBlockVars('no_special');
        // ВКонтакте
        if ($stuff->vk_app_id || $stuff->vk_group_id)
            $this->tpl->assignBlockVars('vk');
        if ($stuff->vk_app_id)
            $this->tpl->assignBlockVars('vk_app',array(
                'ID'=>$stuff->vk_app_id,
            ));
        if ($stuff->vk_group_id)
            $this->tpl->assignBlockVars('vk_group',array(
                'ID'=>$stuff->vk_group_id,
            ));


        /**
         * Options
         */
        if ($stuff->float == 'left')
            $this->tpl->assignBlockVars('blocks_left');
        if ($stuff->border_radius)
            $this->tpl->assignBlockVars('border_radius');
        if ($stuff->cats)
            $this->tpl->assignBlockVars('cats'.$stuff->cats);
        if ($stuff->menu)
            $this->tpl->assignBlockVars('menu'.$stuff->menu);
        if ($stuff->needhelp)
            $this->tpl->assignBlockVars('needhelp'.$stuff->needhelp);


        if (URL_APP)
            $this->tpl->assignBlockVars('no_index');
        else
            $this->tpl->assignBlockVars('index');

		//echo print_r($stuff);
    }
}
