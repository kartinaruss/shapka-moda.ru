<?php
/**
 * Robokassa
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Robokassa extends Controller
{
    function indexAction(array $params)
    {
        die();
    }
    
    function resultAction(array $params)
    {
        $mrh_pass2 = ROBOKASSA_PASS2;
        
        // чтение параметров
        $out_summ = $_REQUEST["OutSum"];
        $inv_id = $id = $_REQUEST["InvId"];
        $crc = strtoupper($_REQUEST["SignatureValue"]);
        
        $my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2"));
        
        // проверка корректности подписи
        if ($my_crc !=$crc)
        {
            echo "bad sign\n";
            die();
        }
        // отправляем письмо об оплате
          require_once DIR_LIB.'/phpmailer/class.phpmailer.php';

        $this->var = $this->model->page->get('order');
          $mail = new PHPMailer();
          $mail->From     = 'no-reply@'.$_SERVER['SERVER_NAME'];
          $mail->FromName = $_SERVER['SERVER_NAME'];
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
          $mail->Body    = nl2br("Заказ #$id оплачен на сумму $out_summ в системе Робокасса");
          $mail->AltBody = strip_tags(str_replace("<br/>", "\n", $mail->Body));
          $mail->Subject = 'Заказ оплачен #'.$id;
          $emails = array_map('trim',explode(',',$this->var->email));
          foreach ($emails as $email)
            $mail->AddAddress($email);

          $sent = $mail->Send();
        /**
         * Сохраняем статус заказа
         */
        $this->model->order->edit(array(
            'step' => 4,
        ),$id);
        // признак успешно проведенной операции
        echo "OK$inv_id\n";
        die();
    }
}