<?php
/**
 * Shopping Cart
 *
 * @author dandelion <web.dandelion@gmail.com>
 * @package App_Cart
 */
class App_Cart extends Controller
{
    function indexAction(array $params)
    {
        $items = (array)json_decode(stripslashes(@$_COOKIE['cart']),true);

        $total = 0;
        $products = $this->model->product->getByIds(array_keys($items));
        foreach ($products as $product)
        {
        	$count = array_key_exists($product->id,$items) ? $items[$product->id] : 1;
        	$count = preg_match('@^[0-9]+$@i',$count) ? $count : 1;
        	$this->tpl->assignBlockVars('product', array(
                'ID'   => $product->id,
                'NAME' => $product->name,
                'PRICE' => $product->price,
                'COUNT' => $count,
            ));
            $total+= $count*$product->price;
        }
        /**
         * Доставка
         */
        $stuff = $this->model->stuff->get();
        if ($stuff->shipping && $total)
        {
            $this->tpl->assignBlockVars('shipping', array(
                'PRICE' => $stuff->shipping
            ));
            //if (!$stuff->free_shipping || $total<$stuff->free_shipping)
                //$total+= $stuff->shipping;
        }
        if ($stuff->free_shipping)
            $this->tpl->assignBlockVars('free_shipping', array(
                'PRICE' => $stuff->free_shipping
            ));
        /**
         * Итого
         */
        $this->tpl->assignVars(array(
            'PRICE_TOTAL'=>$total
        ));
        /**
         * See also
         */
        $also = explode('|',$stuff->cart_special);
        $exist = array_keys($items);
        foreach ($also as $k=>$id)
        {
            if (in_array($id,$exist))
               unset($also[$k]);
        }
        if ($also)
        {
            $entries = $this->model->product->getByIds($also, $total);
            foreach ($entries as $product)
            {
                $this->tpl->assignBlockVars('also', array(
                    'ID'   => $product->id,
                    'KEY'   => $product->key,
                    'NAME' => $product->name,
                    'BRIEF' => $product->brief,
                    'LABEL' => $product->label,
                    'PRICE' => $product->price,
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
            }
            if (!$entries->isEmpty())
                $this->tpl->assignBlockVars('see_also');
        }
    }

    function totalAction(array $params)
    {
        $items = (array)json_decode(stripslashes(@$_COOKIE['cart']),true);

        $total = 0;
        $products = $this->model->product->getByIds(array_keys($items));
        foreach ($products as $product)
        {
            $count = array_key_exists($product->id,$items) ? $items[$product->id] : 1;
            $count = preg_match('@^[0-9]+$@i',$count) ? $count : 1;
            $total+= $count*$product->price;
        }
        /**
         * Доставка
         */
        $stuff = $this->model->stuff->get();
        $shipping = $stuff->shipping;
        if ($shipping && $total && (!$stuff->free_shipping || $total<$stuff->free_shipping))
        {
            //$total+= $shipping;
        }
        die((string)$total);
    }



    function orderAction(array $params)
    {
        $items = (array)json_decode(stripslashes(@$_COOKIE['cart']),true);
        if (empty($_COOKIE['cart']) || empty($items))
            return $this->Url_redirectTo('cart');
        $products = $this->model->product->getByIds(array_keys($items));
        if ($products->isEmpty())
            die('products dont exist');

        $form = $this->load->form('cart/order');
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity(array_map('strip_tags',$form->getData()));
            /**
             * Сохранение данных
             */
            $id = $this->model->order->add(array(
                'cart' => stripslashes(@$_COOKIE['cart']),
                'name'  => $data->name,
                'phone' => $data->phone,
                'email' => $data->email,
                'address' => $data->address,
                'message' => $data->message,
                'step' => 1,
                'timestamp'  => time(),
                'ref' => (string)@$_COOKIE['ref'],
            ));
            /**
             * Смета
             */
            $currency = $this->model->stuff->get()->currency;
            $total = 0;
            $orders = array();
	        foreach ($products as $product)
	        {
	            $count = array_key_exists($product->id,$items) ? $items[$product->id] : 1;
	            $count = preg_match('@^[0-9]+$@i',$count) ? $count : 1;
	            $total+= $count*$product->price;
	            $product->name = $product->name.($product->code ? " ($product->code)":'');
	            $orders[] = '<a href="http://'.$_SERVER['SERVER_NAME'].'/item/'.$product->key.'">'.$product->name.'</a> ('.$count.' шт) - '.($count*$product->price).' '.$currency;
	        }
            $stuff = $this->model->stuff->get();
            if ($stuff->shipping && $total && (!$stuff->free_shipping || $total<$stuff->free_shipping))
            {
                $orders[] = 'Доставка - '.($stuff->shipping).' '.$currency;
                $total+= $stuff->shipping;
            }
            /**
             * Отправка на мыло
             */
            $sent = false;
            if ($this->var->email)
            {
                require_once DIR_LIB.'/phpmailer/class.phpmailer.php';

                $mail = new PHPMailer();
                $mail->From     = $data->email ? $data->email : 'no-reply@'.$_SERVER['SERVER_NAME'];
                $mail->FromName = $data->name ? $data->name : $_SERVER['SERVER_NAME'];
                $mail->Host     = $_SERVER['HTTP_HOST'];
                if (YANDEX_SMTP_LOGIN && YANDEX_SMTP_PASS)
                {
                    $mail->From     = YANDEX_SMTP_LOGIN;//$data->email;
                    $mail->IsSMTP(); // enable SMTP
                    $mail->SMTPAuth = true;  // authentication enabled
                    $mail->Host = 'smtp.yandex.ru';
                    $mail->Port = 25;
                    $mail->Username = YANDEX_SMTP_LOGIN;
                    $mail->Password = YANDEX_SMTP_PASS;
                }
                else
                {
                    $mail->Mailer   = "mail";
                }

function getip()
{
  if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
    $ip = getenv("HTTP_CLIENT_IP");

  elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
    $ip = getenv("HTTP_X_FORWARDED_FOR");

  elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
    $ip = getenv("REMOTE_ADDR");

  elseif (!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
    $ip = $_SERVER['REMOTE_ADDR'];

  else
    $ip = "unknown";

  return($ip);
}

                $mail->Body    = nl2br(
"
Timberlands-STORE.ru
время заказа: ".date('H:i:s d.m.Y', time())."
Имя: $data->name
Телефон: $data->phone
E-mail: $data->email
Адрес: $data->address
Комментарии: $data->message
".(!empty($_COOKIE['ref']) ? "Реферал: {$_COOKIE['ref']}" : '')."

Заказ:
".join(PHP_EOL,$orders)."

ИТОГО: $total $currency

".getip());
                $mail->AltBody = strip_tags(str_replace("<br/>", "\n", $mail->Body));
                $mail->Subject = 'Заказ #'.$id;//$data->subject;
                $emails = array_map('trim',explode(',',$this->var->email));
                foreach ($emails as $email)
                   $mail->AddAddress($email);

                $sent = $mail->Send();

                if ($data->email)
                {
                    $stuff = $this->model->stuff->get();
                    $mail->Body    = nl2br(
"Здравствуйте!

Спасибо за заказ в нашем магазине!

Вы указали следующие данные:

*********************************
Имя: $data->name
Телефон: $data->phone
E-mail: $data->email
Адрес: $data->address
Комментарии: $data->message

Заказ:
".join(PHP_EOL,$orders)."

ИТОГО: $total $currency
*********************************

Ваша заявка принята и наши менеджеры свяжутся с Вами в ближайшее время.
На случай если с Вами никто не связался позвоните по номеру:
Телефон (многоканальный): 8 (499) 346-86-53, 8 (499) 346-86-73.

Мы работаем ежедневно с 9.00 до 21.00 по Московскому времени.

По Москве и Санкт-Петербургу:
- заказы оформленные до 14:00, сможем доставить в этот же день.
- заказы оформленные после  14:00, на следующий день в удобное Вам время.

--
С уважением,
Коллектив магазина Timberlands-Store.ru
");
                    $mail->ClearAddresses();
                    $mail->From     = 'no-reply@'.$_SERVER['SERVER_NAME'];
                    $mail->FromName = $_SERVER['SERVER_NAME'];
                    $mail->AddAddress($data->email);
                    $mail->Subject = 'Заказ наушников на сайте i-BeatsDre.ru';

                    $mail->Send();
                }
            }
            /**
             * SMS
             */
            $stuff = $this->model->stuff->get();
            if ($stuff->sms_order_enable)
            {
                $phone1 = preg_replace('@[^0-9]+@i','',$data->phone);
                $phone2 = preg_replace('@[^0-9]+@i','',$stuff->sms_order_phone);
                $placeholders = array(
                    '{NAME}' => $data->name,
                    '{PHONE}' => $data->phone,
                    '{TOTAL}' => $total.' '.$currency,
                );
                $text1 = str_replace(array_keys($placeholders),array_values($placeholders),$stuff->sms_order_client);
                $text2 = str_replace(array_keys($placeholders),array_values($placeholders),$stuff->sms_order_admin);

                if ($phone1 && $text1)
                    $this->model->sms->send($phone1,$text1);
                if ($phone2 && $text2)
                    $this->model->sms->send($phone2,$text2);
            }
            /**
             * Результат
             */
            if ($id || $sent)
            {
                setcookie('cart','',time() - 86400, COOKIE_PATH);
                $this->Url_redirectTo('cart/success/'.$id);
            	die('ok');
                //$this->tpl->assignBlockVars('success');
                //unset($_POST);
                //$this->Url_redirectTo('cart/shipping/'.$id);
            }
            else
            {
                //$this->tpl->assignBlockVars('fail');
            }
            /*
            setcookie('cart','',time() - 86400, COOKIE_PATH);
            if (isset($params[0]) && $params[0]=='pay')
            {
                $this->model->order->edit(array(
                    'step' => 3,
                    'paymethod'  => 'robokassa'
                ),$id);

                $stuff = $this->model->stuff->get();

                $mrh_login = ROBOKASSA_LOGIN;
                $mrh_pass1 = ROBOKASSA_PASS1;
                $out_summ = $total;
                $inv_id = $id;
                $inv_desc = "Оплата заказа в магазине \"{$stuff->site_name}\"";
                $shp_item = 1;
                $in_curr = "PCR";
                $culture = "ru";
                $crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");
                $test_url = "http://test.robokassa.ru/Index.aspx";
                $production_url = "https://merchant.roboxchange.com/Index.aspx";
                $final_url = "{$production_url}?".http_build_query(array(
                    'MrchLogin' => $mrh_login,
                    'OutSum' => $out_summ,
                    'InvId' => $inv_id,
                    'Desc' => $inv_desc,
                    'SignatureValue' => $crc,
                    //'IncCurrLabel' => $in_curr,
                    'Culture' => $culture,
                ));
                die("<meta http-equiv=\"refresh\" content=\"0; url={$final_url}\"/>
                <p>Пожалуйста, подождите, идет перенаправление на сервис RoboKassa...</p>
                <p>Если ваш браузер не поддерживает автоматической переадресации, нажмите <a href=\"{$final_url}\">сюда</p>");
            }
            else
            {
                $this->model->order->edit(array(
                    'step' => 5,
                ),$id);
                $this->Url_redirectTo('cart/success/'.$id);
                die('ok');
            }
             */
        }
        else $form->renderErrors($this->tpl);
    }

    function shippingAction(array $params)
    {
        $id = (int)@$params[0];
        if (!$id)
            die('id error');

        $form = $this->load->form('cart/shipping');
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity(array_map('strip_tags',$form->getData()));
            /**
             * Сохранение данных
             */
            $this->model->order->edit(array(
                'name'  => $data->name,
                'step' => 2,
                'address' => $data->zipcode.', '.$data->state.', '.$data->city.', '.$data->address
            ),$id);
            /**
             * Результат
             */
            if (isset($params[1]) && $params[1]=='pay')
            {
                $this->Url_redirectTo('cart/payment/'.$id);
            }
            else
            {
                die('ok');
            }
        }
        else $form->renderErrors($this->tpl);

        $this->tpl->assignVar('ID',$id);
    }

    function paymentAction(array $params)
    {
        $id = (int)@$params[0];
        if (!$id)
            die('id error');

        if (isset($params[1]) && $params[1]=='pay')
        {
            $this->Url_redirectTo('cart/payment2/'.$id);
        }

        $order = $this->model->order->getById($id);

        $form = $this->load->form('cart/payment');
        $form->setValues(array('phone'=>preg_replace('@[^0-9]@i','',str_replace('+7','',$order->phone))));
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity(array_map('strip_tags',$form->getData()));
            /**
             * Сохранение данных
             */
            $this->model->order->edit(array(
                'paymethod'  => 'qiwi',
                'step' => 3,
            ),$id);
            /**
             * Перенаправление на страницу оплаты
             */
            $items = (array)json_decode($order->cart,true);
            $products = $this->model->product->getByIds(array_keys($items));
            $total = 0;
            foreach ($products as $product)
            {
                $count = array_key_exists($product->id,$items) ? $items[$product->id] : 1;
                $count = preg_match('@^[0-9]+$@i',$count) ? $count : 1;
                $total+= $count*$product->price;
            }
            $stuff = $this->model->stuff->get();
            $url = "http://w.qiwi.ru/setInetBill_utf.do?".http_build_query(array(
                'from' => QIWI_LOGIN,
                'lifetime' => '72.0',
                'check_agt' => 'false',
                'txn_id' => $id,
                'to' => $data->phone,
                'summ' => $total,
                'com' => "Оплата заказа в магазине \"{$stuff->site_name}\"",
            ));
            die("<meta http-equiv=\"refresh\" content=\"0; url=$url\"/><p>Пожалуйста, подождите, идет перенаправление на QIWI Кошелек...</p>
            <p>Если ваш браузер не поддерживает автоматической переадрессации, <a href='$url'>нажмите здесь</a></p>");
        }
        else $form->renderErrors($this->tpl);

        $this->tpl->assignVar('ID',$id);
    }

    function successAction(array $params)
    {
        $id = (int)@$params[0];
        if (!$id)
            die('id error');

        $this->tpl->assignVar('ID',$id);
    }
}