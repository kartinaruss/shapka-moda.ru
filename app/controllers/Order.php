<?php
/**
 * Order
 *
 * @author dandelion <web.dandelion@gmail.com>
 * @package App_Order
 */
class App_Order extends Controller
{
    function indexAction(array $params)
    {
        $product_id = @$params[0];
        if (!$product_id)
            die('id error');
        $product = $this->model->product->getById($product_id);
        if ($product->isEmpty())
            die('product doesnt exist');
    	
        $form = $this->load->form('order');
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity(array_map('strip_tags',$form->getData()));
	        /**
	         * Сохранение данных
	         */
	        $id = $this->model->order->add(array(
                'product_id' => $product_id,
	            'name'  => $data->name,
                'phone' => $data->phone,
                'email' => $data->email,
                'address' => $data->address,
	            'message' => $data->message,
                //'step' => 1,
	            'timestamp'  => time(),
                'ref' => (string)@$_COOKIE['ref'],
	        ));
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
	            $mail->Body    = nl2br(
"Товар: <a href='http://{$_SERVER['SERVER_NAME']}/item/{$product->key}'>$product->name</a>".($product->code ? " ($product->code)":'')."
Имя: $data->name
Телефон: $data->phone
E-mail: $data->email
Адрес: $data->address
Комментарии: $data->message
[utm]".@$_COOKIE['full_query_string']."[/utm]
".(!empty($_COOKIE['ref']) ? "Реферал: {$_COOKIE['ref']}" : '')."
");
	            $mail->AltBody = strip_tags(str_replace("<br/>", "\n", $mail->Body));
	            $mail->Subject = 'Заказ '.$product->name;//$data->subject;
	            $emails = array_map('trim',explode(',',$this->var->email));
	            foreach ($emails as $email)
	                $mail->AddAddress($email);

	            $sent = $mail->Send();
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
                    '{TOTAL}' => ((int)$product->price).' '.$currency,
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
                $this->Url_redirectTo('order/success/'.$id);
	            die('ok');
	        	//$this->tpl->assignBlockVars('success');
	        	//unset($_POST);
                //$this->Url_redirectTo('order/shipping/'.$id);
	        }
	        else
	        {
	        	//$this->tpl->assignBlockVars('fail');
	        }
	        /*
            if (isset($params[1]) && $params[1]=='pay')
            {
                $this->model->order->edit(array(
                    'step' => 3,
                    'paymethod'  => 'robokassa'
                ),$id);

                $stuff = $this->model->stuff->get();
                
                $mrh_login = ROBOKASSA_LOGIN;
                $mrh_pass1 = ROBOKASSA_PASS1;
                $out_summ = $product->price;
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
                $this->Url_redirectTo('order/success/'.$id);
                die('ok');
            }
	         */
        }
        else $form->renderErrors($this->tpl);
        
        $this->tpl->assignVars(array(
            'ID'=>$product_id,
            'PRODUCT_NAME'=>$product->name
        ));
    }
    
    function shippingAction(array $params)
    {
        $id = (int)@$params[0];
        if (!$id)
            die('id error');
        
        $form = $this->load->form('order2');
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity(array_map('strip_tags',$form->getData()));
            /**
             * Сохранение данных
             */
            $this->model->order->edit(array(
                'name'  => $data->name,
                'address' => $data->zipcode.', '.$data->state.', '.$data->city.', '.$data->address
            ),$id);
            /**
             * Результат
             */
            if (isset($params[1]) && $params[1]=='pay')
            {
                $this->Url_redirectTo('order/payment/'.$id);
            }
            else
            {
                $this->Url_redirectTo('order/payment2/'.$id);
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
            $this->Url_redirectTo('order/payment2/'.$id);
        }
            
        $order = $this->model->order->getById($id);

        $form = $this->load->form('order3');
        $form->setValues(array('phone'=>preg_replace('@[^0-9]@i','',str_replace('+7','',$order->phone))));
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity(array_map('strip_tags',$form->getData()));
            /**
             * Сохранение данных
             */
            $this->model->order->edit(array(
                'paymethod'  => 'qiwi'
            ),$id);
            /**
             * Перенаправление на страницу оплаты
             */
            $product = $this->model->product->getById($order->product_id);
            $stuff = $this->model->stuff->get();
            $url = "http://w.qiwi.ru/setInetBill_utf.do?".http_build_query(array(
                'from' => QIWI_LOGIN,
                'lifetime' => '72.0',
                'check_agt' => 'false',
                'txn_id' => $id,
                'to' => $data->phone,
                'summ' => $product->price,
                'com' => $product->name,
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