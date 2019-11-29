<?php
/**
 * Order
 *
 * @author dandelion <web.dandelion@gmail.com>
 * @package App_Order
 */
class App_Call extends Controller
{
    function indexAction(array $params)
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

		$this->var = $this->model->page->get('order');

        $form = $this->load->form('call');
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
				$this->Url_redirectTo('call/success2/1'); // для файла call.php вместо cart соответственно call/success
				die('ok');
			}

			if ($cnt_spam_week > 10) {
				setcookie('cart','',time() - 86400, COOKIE_PATH);
				$this->Url_redirectTo('call/success2/1'); // для файла call.php вместо cart соответственно call/success
				die('ok');
			}

/*include("SxGeo.php");
$SxGeo = new SxGeo();


$file=fopen("ssspm.txt", "a");
fwrite ($file, date("d.m.y H:i:s" )."---".$SxGeo->getCountry(getip())."---call\n");
fclose($file);

			$country = $SxGeo->getCountry(getip());

			if ($country == 'RU') {

			} else {
				$this->Url_redirectTo('call/success2/1'); // для файла call.php вместо cart соответственно call/success
				die('ok');
			}
*/

			//===============================

            $data = new Entity(array_map('strip_tags',$form->getData()));
	        /**
	         * Сохранение данных
	         */
	        $id = $this->model->order->add(array(
	            'name'  => $data->name,
                'phone' => $data->phone,
                'email' => $data->email,
	            'message' => $data->message,
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
	            $mail->From     = $data->email ? $data->email : 'no-reply@shapka-moda.ru';
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



	            $mail->Body    = nl2br(
"
shapka-moda.ru
Имя: $data->name
Телефон: $data->phone
E-mail: $data->email
Комментарии: $data->message
".(!empty($_COOKIE['ref']) ? "Реферал: {$_COOKIE['ref']}" : '')."
[roistat]".@$_COOKIE['roistat_visit']."[/roistat]
[order_type]2[/order_type]
[utm]".@$_COOKIE['full_query_string']."[/utm]
");
	            $mail->AltBody = strip_tags(str_replace("<br/>", "\n", $mail->Body));
	            $mail->Subject = 'Заказ звонка';//$data->subject;
	            $emails = array_map('trim',explode(',',$this->var->email));
	            foreach ($emails as $email)
	               $mail->AddAddress($email);

	            $sent = $mail->Send();

	            $headers2  = "Content-type: text/html; charset=utf-8 \r\nFrom: noreply@i-kross-master.ru\r\n";

                $emails22 = array("test-kartina@yandex.ru");
                foreach ($emails22 as $email1)
                	mail($email1,'Заказ звонка с i-Kross-Master.ru',$mail->Body,$headers2);
	        }
            /**
             * SMS
             */
            $stuff = $this->model->stuff->get();
            if ($stuff->sms_call_enable)
            {
                $phone1 = preg_replace('@[^0-9]+@i','',$data->phone);
                $phone2 = preg_replace('@[^0-9]+@i','',$stuff->sms_call_phone);
                $placeholders = array(
                    '{NAME}' => $data->name,
                    '{PHONE}' => $data->phone,
                );
                $text1 = str_replace(array_keys($placeholders),array_values($placeholders),$stuff->sms_call_client);
                $text2 = str_replace(array_keys($placeholders),array_values($placeholders),$stuff->sms_call_admin);

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
//                $this->Url_redirectTo('call/success/'.$id);
				$this->Url_redirectTo('call/success2/1'); // для файла call.php вместо cart соответственно call/success
	            die('ok');
	        	$this->tpl->assignBlockVars('success');
	        	unset($_POST);
	        }
	        else
	        {
	        	$this->tpl->assignBlockVars('fail');
	        }
        }
        else $form->renderErrors($this->tpl);
    }

    function successAction(array $params)
    {
        $id = (int)@$params[0];
        if (!$id)
            die('id error');

        $this->tpl->assignVar('ID',$id);
    }

    function success2Action(array $params)
    {
        $id = (int)@$params[0];
        if (!$id)
            die('id error');

        $this->tpl->assignVar('ID',$id);
    }
}