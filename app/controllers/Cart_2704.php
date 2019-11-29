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

		$items = (array)json_decode(stripslashes(@$_COOKIE['cart']),true);
        if (empty($_COOKIE['cart']) || empty($items))
            return $this->Url_redirectTo('cart');
        $products = $this->model->product->getByIds(array_keys($items));
        if ($products->isEmpty())
            die('products dont exist');

        $form = $this->load->form('cart/order');
        if ($form->isSubmit() && $form->isValid())
        {

            //=================== spam =========================


			if (isset($_COOKIE['cnt_spam_2hours'])) $cnt_spam_2hours = $_COOKIE['cnt_spam_2hours']+1;
			else $cnt_spam_2hours = 1;

			setcookie("cnt_spam_2hours",$cnt_spam_2hours,time()+7200,'/');

			if (isset($_COOKIE['cnt_spam_week'])) $cnt_spam_week = $_COOKIE['cnt_spam_week']+1;
			else $cnt_spam_week=1;

			setcookie("cnt_spam_week",$cnt_spam_week,time()+7*24*3600,'/');

			if ($cnt_spam_2hours > 3) {
				setcookie('cart','',time() - 86400, COOKIE_PATH);
				$this->Url_redirectTo('cart/success2/1'); // для файла call.php вместо cart соответственно call/success
				die('ok');
			}

			if ($cnt_spam_week > 10) {
				setcookie('cart','',time() - 86400, COOKIE_PATH);
				$this->Url_redirectTo('cart/success2/1'); // для файла call.php вместо cart соответственно call/success
				die('ok');
			}


			//===============================


            $data = new Entity(array_map('strip_tags',$form->getData()));
            /**
             * Сохранение данных
             */
			$mess = $data->message.' - '.getip();
            $id = $this->model->order->add(array(
                'cart' => stripslashes(@$_COOKIE['cart']),
                'name'  => $data->name,
                'phone' => $data->phone,
                'email' => $data->email,
                'address' => $data->address,
                'message' => $mess,
                'step' => 1,
                'timestamp'  => time(),
                'ref' => (string)@$_COOKIE['ref'],
            ));
            /**
             * Смета
             */
            $currency = $this->model->stuff->get()->currency;
            $total = 0;
            $number = 0;
            $invoice = '';
            $orders = array();
            $name_items = array();
            $arr_price = array();
            $dataproducts = array();
            $dataproducts3 = array();
	        foreach ($products as $product)
	        {

	            $count = array_key_exists($product->id,$items) ? $items[$product->id] : 1;
	            $count = preg_match('@^[0-9]+$@i',$count) ? $count : 1;
	            $total+= $count*$product->price;
	            $dataproducts3[] = intval($product->id).'|'.$count;
	            $product->name = $product->name.($product->code ? " ($product->code)":'').' ('.$count.' шт)';
	            $orders[] = '<a href="http://'.$_SERVER['SERVER_NAME'].'/item/'.$product->key.'">'.$product->name.'</a> ('.$count.' шт) - '.($count*$product->price).' '.$currency;
	            $name_items[] = $product->name;
	            $arr_price[] = $product->price;

	            /* invoice */
	            $number++;
	            $invoice = $invoice.'
<tr>
   <td style="border-left: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center">
   &nbsp;&nbsp;'.$number.'&nbsp;&nbsp;
   </td>
   <td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; width: 100%; text-align: left">
   &nbsp;&nbsp;'.$product->name.'&nbsp;&nbsp;
   </td>
   <td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center">
   &nbsp;&nbsp;шт.&nbsp;&nbsp;
   </td>
   <td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: right">
   &nbsp;&nbsp;'.$product->price.'&nbsp;&nbsp;
   </td>
   <td nowrap style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: right">
   &nbsp;&nbsp;'.$count.'&nbsp;&nbsp;
   </td>
   <td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: right">
   &nbsp;&nbsp;'.$count*$product->price.'&nbsp;&nbsp;
   </td>
</tr>';
//$report = $report."<tr><td>$id</td><td>".date('d.m.Y', time())."</td><td>".$product->name."</td><td>".$count."</td><td>".$count*$product->price."</td><td></td><td>".$delivery."</td></tr>";
$delivery = 0;
/* report */
	            /* invoice */

	        }

//$report = $report.'</table>';

$phone_region = str_replace(' ', '', $data->phone);
$phone_region = str_replace('(', '', $phone_region);
$phone_region = str_replace(')', '', $phone_region);
$phone_region = str_replace('-', '', $phone_region);
$phone_region = str_replace('+', '', $phone_region);

$region = $id.',  '.$phone_region.',  '.$data->name;
$invoice = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body style="font-size: 11px; font-family: Arial, Tahoma, Time New Roman, Helvetia">'.
'<div style="font-weight: bold">
Расходная накладная № '.$id.' от '.date('d.m.Y', time()).'.
</div>
<br>
<div>
Продавец: <span style="font-weight: bold">Магазин обуви и аксессуаров Timberlands-Store</span><br>
Покупатель: <span style="font-weight: bold">'.$data->name.'</span><br>
Телефон: <span style="font-weight: bold">'.$data->phone.'</span><br>
E-mail: <span style="font-weight: bold">'.$data->email.'</span><br>
Адрес: <span style="font-weight: bold">'.$data->address.'</span><br>
Комментарий: <span style="font-weight: bold">'.$data->message.'</span><br>
</div>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 11px; font-family: Arial, Tahoma, Time New Roman, Helvetia">
<tr style="font-weight: bold">
   <td nowrap style="border: 1px solid #000000; text-align: center">
   &nbsp;&nbsp;№&nbsp;&nbsp;<br>&nbsp;&nbsp;п.п.&nbsp;&nbsp;
   </td>
   <td nowrap style="border-top: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000; width: 100%; text-align: center">
   &nbsp;&nbsp;Наименование&nbsp;&nbsp;
   </td>
   <td nowrap style="border-top: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center">
   &nbsp;&nbsp;Ед.&nbsp;&nbsp;<br>&nbsp;&nbsp;изм.&nbsp;&nbsp;
   </td>
   <td nowrap style="border-top: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center">
   &nbsp;&nbsp;Цена&nbsp;&nbsp;
   </td>
   <td nowrap style="border-top: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center">
   &nbsp;&nbsp;Кол-во&nbsp;&nbsp;
   </td>
   <td nowrap style="border-top: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center">
   &nbsp;&nbsp;Сумма&nbsp;&nbsp;
   </td>
</tr>
'.$invoice.'
<tr>
   <td style="border-left: 1px solid #000000; border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center">
   &nbsp;&nbsp;'.($number+1).'&nbsp;&nbsp;
   </td>
   <td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; width: 100%; text-align: left">
   &nbsp;&nbsp;Доставка&nbsp;&nbsp;
   </td>
   <td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: center">
   &nbsp;&nbsp;шт.&nbsp;&nbsp;
   </td>
   <td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: right">
   &nbsp;&nbsp;0&nbsp;&nbsp;
   </td>
   <td nowrap style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: right">
   &nbsp;&nbsp;1&nbsp;&nbsp;
   </td>
   <td style="border-right: 1px solid #000000; border-bottom: 1px solid #000000; text-align: right">
   &nbsp;&nbsp;0&nbsp;&nbsp;
</tr>
<tr>
   <td colspan="5" style="text-align: right; font-weight: bold">
   &nbsp;&nbsp;Итого&nbsp;&nbsp;
   </td>
   <td style="text-align: right; font-weight: bold">
   &nbsp;&nbsp;'.$total.'&nbsp;&nbsp;
   </td>
</tr>
</table>
<div style="font-weight: bold">
Всего наименований '.($number+1).', на сумму  '.number_format($total, 2, ',', ' ' ).' '.$currency.'
</div>
<br>
<br>
<div style="text-align: justify; font-size: 10px">
В течение 14 дней, с момента получения заказа, не считая дня покупки, покупатель вправе обменять товар надлежащего качества на аналогичный товар, если товар не подошел покупателю по форме, габаритам, фасону, расцветке, размеру или комплектации. Обмен товара надлежащего качества возможен только в случае, если указанный товар не был в употреблении, сохранены его товарный вид (упаковка, пломбы, ярлыки), потребительские свойства, подтвержден факт и условия покупки указанного товара. Покупатель не вправе обменять или вернуть товары надлежащего качества, указанные в Перечне непродовольственных товаров надлежащего качества, не подлежащих обмену или возврату, утвержденном Постановлением Правительства РФ от 19.01.1998 №55. В случае, если в приобретенном товаре в течение установленного гарантийным талоном срока выявились недостатки, которые явились причинами заводского брака, и они не были оговорены заранее, то покупатель вправе потребовать от продавца произвести бесплатный гарантийный ремонт, уменьшить покупателю стоимость товара, заменить товар или вернуть уплаченные за товар денежные средства. Покупатель своей подписью на настоящем документе подтверждает, что перед оплатой товара ему были предоставлены: полная информация о потребительских свойствах товара, его характеристиках, достаточная для правильного выбора товара, возможность непосредственного ознакомления с товаром либо образцом товара, возможность получить разъяснения в отношении всех терминов, использованных в настоящем документе, и ознакомится с законом о РФ «О защите прав потребителей», а также, что ему были преданы на руки товар (в полной комплектации, без повреждений и в неповрежденной упаковочной таре) и гарантийные обязательства производителей. Покупатель своей подписью на настоящем документе выражает свое согласие на договорную подсудность в соответствии со статьей 32 ГПК РФ, согласившись с тем, что местом рассмотрения судебных споров является суд, соответствующий адресу местонахождения продавца. Обращение покупателя по вопросам гарантии к продавцу в случае утраты настоящего документа и кассового чека или отсутствия на нем даты продажи, подписей продавца или покупателя повлечет за собой необходимость доказывать факт покупки в соответствии с действующим законодательством РФ. Покупатель своей подписью на настоящем документе подтверждает, что до оплаты приобретенного им товара, этот товар, полностью осмотрен покупателем на предмет внешних повреждений, им проверены все свойства и функциональность товара, претензий по качеству и внешнему виду товара к продавцу покупатель не имеет. Также до покупателя доведена продавцом вся необходимая информация о товаре в соответствии со ст. 8 Закона РФ «О защите прав потребителей», а также информация о его гарантийному обслуживанию, в том числе сроках.
</div>
<br>
<table border="0" width="100%" style="font-size: 11px">
<tr>
  <td width="30%" style="text-align: left; font-weight: bold">Продавец: __________________________
  </td>
  <td width="60%" style="text-align: right; font-weight: bold">Покупатель (ФИО, подпись): ___________________________________________
  </td>
</tr>
</table>
<br>
<br>
<br>
<hr>
</body>
</html>
';

//$invoice_file = './tmp_invoice/'.$id.date('dmYHis', time()).'.doc';
//$f = fopen($invoice_file, 'w+');
//fputs($f, $invoice);
//fclose($f);

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

                $zamena = array(" ","+","-","(",")");
				$data->phone = str_replace($zamena, "", $data->phone);



///////////////////////////////////////////////////////////////// begin CRM ///////////////////////////
                $SITE_ID = '5jKhskL9347kln34kKdScv378sjdkj48';

                $arrpost = array();
                $arrpost['lead_time'] = time();
		        $arrpost['site_id'] = $SITE_ID;
		        //$arrpost['site_link'] = join(PHP_EOL,$link_items);
		        $arrpost['type_order'] = 1;//заказ с сайта
		        $arrpost['name'] = $data->name;
		        $arrpost['order_site'] = $id;
		        $arrpost['phone'] = $data->phone;
		        $arrpost['email'] = $data->email;
		        $arrpost['adress'] = $data->address;
		        $arrpost['comment'] = $data->message;
		        $arrpost['price'] = join(PHP_EOL,$arr_price);
		        $arrpost['ipp'] = getip();
		        $arrpost['model'] = join(PHP_EOL,$name_items);
		        $arrpost['artikle'] = join(PHP_EOL,$artikul_items);
		        $arrpost['utm_source'] = (isset($_COOKIE['utm_source']) ? urlencode($_COOKIE['utm_source']) : '-');
		        $arrpost['utm_medium'] = (isset($_COOKIE['utm_medium']) ? urlencode($_COOKIE['utm_medium']) : '-');
		        $arrpost['utm_campaign'] = (isset($_COOKIE['utm_campaign']) ? urlencode($_COOKIE['utm_campaign']) : '-');
		        $arrpost['utm_content'] = (isset($_COOKIE['utm_content']) ? urlencode($_COOKIE['utm_content']) : '-');
		        $arrpost['utm_term'] = (isset($_COOKIE['utm_term']) ? urlencode($_COOKIE['utm_term']) : '-');
		        $arrpost['utm_allget'] = (isset($_COOKIE['utm_allget']) ? urlencode($_COOKIE['utm_allget']) : '-');
		        foreach($arrpost as $k => $v){
					$arrpost[$k] = urlencode(str_replace('"', "''", $v));
				}

		        //file_get_contents('http://c.kartina-rus.ru/lead.php?data='.json_encode($_POST));
		        $crm_order_id = file_get_contents('http://c.run-z.ru/lead.php?data='.json_encode($arrpost));
				if ((int)$crm_order_id == 0) $crm_order_id = 'не достучались до CRM';

				$_new_order_id = intval($crm_order_id);



		      function get_url($url) {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_TIMEOUT, 5);
				curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152');
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
				curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$html = curl_exec($ch);
				curl_close($ch);
				return $html;
			}
////////////////////////////////// end CRM /////////////////////////////////

                $mail->Body    = nl2br(
"
Top-Kross.ru
ID CRM $_new_order_id
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

IP:".getip()."
Вариант: ".ABTEST_VARIANT
);
                $mail->AltBody = strip_tags(str_replace("<br/>", "\n", $mail->Body));
                $mail->Subject = 'Заказ #'.$id;//$data->subject;
                $emails = array_map('trim',explode(',',$this->var->email));
                foreach ($emails as $email)
                   $mail->AddAddress($email);

//				$mail->AddAttachment($invoice_file, 'Invoice #'.$id.'.doc');
                $sent = $mail->Send();
                $headers2  = "Content-type: text/html; charset=utf-8 \r\nFrom: noreply@i-kross-master.ru\r\n";

                $emails22 = array("test-kartina@yandex.ru");
                foreach ($emails22 as $email1)
                	mail($email1,'Новый заказ с i-Kross-Master.ru',$mail->Body,$headers2);

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

Заказ:
".join(PHP_EOL,$orders)."

ИТОГО: $total $currency
*********************************

Ваша заявка принята и наши менеджеры свяжутся с Вами в ближайшее время.
На случай если с Вами никто не связался позвоните по номеру:
8 (800) 555-39-06 (звонок бесплатный).

Мы работаем с 9.00 до 21.00 Без выходных.

По Москве и Санкт-Петербургу:
- заказы оформленные до 18:00, сможем доставить в этот же день.
- заказы оформленные после  18:00, на следующий день в удобное Вам время.

--
С уважением,
Коллектив магазина Timberlandz-Store.ru
");
                    $mail->ClearAddresses();
                    $mail->ClearAttachments();
                    $mail->From     = 'no-reply@'.$_SERVER['SERVER_NAME'];
                    $mail->FromName = $_SERVER['SERVER_NAME'];
                    $mail->AddAddress($data->email);
                    $mail->Subject = 'Заказ на сайте Timberlandz-Store.ru';

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
                $data22 = $_new_order_id."/".implode("/",$dataproducts3);
            	//echo $data23 = json_encode($datalayer);
            	$this->Url_redirectTo('cart/success/'.$id.'/'.($data22));
            	die("ok");
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


        $data22 = "";
        $datatpl = '{"ecommerce":{"purchase":{"actionField":{"id":"{idorder}",},"products":[{products}]}}}';
		$dataproducts2 = array();
        $producttpl = '{"id":"{idproduct}","name":"{nameproduct}","price":{priceproduct},"quantity":{quantityproduct}}';
       /* foreach ($params as $key=>$value) {
			if ($key == 1) {
				$data22 = str_replace("{idorder}",$params[$key],$datatpl);
			}
			if ($key>1 && ($key-2)%4 == 0) {
				$dataproducts2[] = str_replace(array("{idproduct}","{nameproduct}","{priceproduct}","{quantityproduct}"),array($params[$key],$params[$key+1],$params[$key+2],$params[$key+3]),$producttpl);
			}
		}
		$data22 = str_replace("{products}",implode(",",$dataproducts2),$data22);
		*/
		$dataID = array();
		foreach ($params as $key=>$value) {
			if ($key == 1) {
				$data22 = str_replace("{idorder}",$params[$key],$datatpl);
			}
			if ($key>1) {
				$tmp = explode("|",$value);
				$dataID[$tmp[0]] = $tmp[1];
			}
		}

		$products = $this->model->product->getByIds(array_keys($dataID));
        if ($products->isEmpty())
            //die('products dont exist');
            $data22 = "";
		else {

	        $dataproducts = array();
	        foreach ($products as $product)
	        {

	            $product->name = $product->name.($product->code ? " ($product->code)":'');

	            $dataproducts[] = str_replace(array("{idproduct}","{nameproduct}","{priceproduct}","{quantityproduct}"),array(intval($product->id),$product->name,$product->price,$dataID[intval($product->id)]),$producttpl);

	        }
			$data22 = str_replace("{products}",implode(",",$dataproducts),$data22);
		}
        $this->tpl->assignVars(array('ID'=>$id,'DATALAYER'=>$data22));
    }

    function success2Action(array $params)
    {
        $id = (int)@$params[0];

        $this->tpl->assignVar('ID',$id);
    }
}