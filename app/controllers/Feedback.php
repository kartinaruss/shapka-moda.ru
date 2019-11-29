<?php
/**
 * Feedback
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Feedback extends Controller
{
    function indexAction(array $params)
    {
        $this->var = $this->model->page->get('order');

        $form = $this->load->form('feedback');
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity(array_map('strip_tags',$form->getData()));
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
"
i-Kross-Master.ru
Имя: $data->name
Телефон: $data->phone
E-mail: $data->email
Сообщение: $data->message");
	            $mail->AltBody = strip_tags(str_replace("<br/>", "\n", $mail->Body));
	            $mail->Subject = 'Обратная связь';//$data->subject;
	            $emails = array_map('trim',explode(',',$this->var->email));
	            foreach ($emails as $email)
	               $mail->AddAddress($email);

	            $sent = $mail->Send();
	        }
	        /**
	         * Результат
	         */
	        if ($sent)
	        {
                $this->Url_redirectTo('feedback/success/'.$id);
	            die('ok');
	        }
        }
        else $form->renderErrors($this->tpl);
    }

    function successAction(array $params)
    {

    }
}