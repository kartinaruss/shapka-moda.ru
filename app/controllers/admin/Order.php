<?php
/**
 * Order
 *
 * @author dandelion <web.dandelion@gmail.com>
 * @package App_Admin_Order
 */
class App_Admin_Order extends Controller
{
	const ITEMS_PER_PAGE = 25;

    function init()
    {
        if ($this->User_getRole() !== 'admin')
            $this->Url_redirectTo403();
    }

    function indexAction(array $params)
    {
        /**
         * Параметры
         */
        $page = 1;
        if (isset($params[0]) && $params[0]=='page')
            $page = (!empty($params[1]))?(int)$params[1]:1;
        if (!$page)
            $page = 1;
        /**
         * Выборка данных
         */
        $start = ($page-1)*self::ITEMS_PER_PAGE;
        $orders = $this->model->order->get($start, self::ITEMS_PER_PAGE);
        foreach ($orders as $order)
        {
            global $qiwi_statuses;
            if (array_key_exists($order->status,$qiwi_statuses))
            {
                $status = $qiwi_statuses[$order->status];
            }
            else
            {
                if (!$order->status)
                {
                    $status = 'Счет&nbsp;не&nbsp;выставлен';
                } else if ($order->status > 100) {
                    $status = 'Не оплачен ('.$order->status.')';
                } else if ($order->status >= 50 && $order->status < 60) {
                    $status = 'Cчет в процессе проведения ('.$order->status.')';
                } else {
                    $status = 'Неизвестный статус заказа ('.$order->status.')';
                }
            }
            switch ($order->step)
            {
                case 1: $step = "Шаг&nbsp;1"; break;
                case 2: $step = "Шаг&nbsp;2"; break;
                case 3: $step = "Перешел&nbsp;к&nbsp;оплате"; break;
                case 4: $step = "Оплачено"; break;
                case 5: $step = "Оплата&nbsp;наличными"; break;
                default: $step = ""; break;
            }
            $this->tpl->assignBlockVars('order', array(
                'ID'    => $order->id,
                'EMAIL' => $order->email,
                'PRODUCT' => $order->cart ? 'см.&nbsp;<a href="javascript:;" class="show_cart">корзину</a>&nbsp;&darr;' : ($order->product ? "<a href='item/$order->product_key'>".str_replace(' ','&nbsp;',$order->product).($order->product_code ? " ($order->product_code)" : '')."</a>" : 'заказ звонка'),
                'PHONE' => $order->phone,
                'NAME'  => $order->name,
                'DATE'  => date('j ',$order->timestamp).$this->model->date->getOfMonthText(date('m',$order->timestamp)).date(' Y, H:i',$order->timestamp),
                'STATUS' => $order->status,
                'STEP'  => $step,
            ));
        }
        /**
         * Навигация
         */
        $paginator = new Paginator(array(
           'countPerPage'  => self::ITEMS_PER_PAGE,
           'countOfEntries'=> $this->model->order->getCount(),
           'currentPage' => $page,
           'countOfFirstPages'=> 5,
           'countOfLastPages' => 5,
           'countOfMiddlePages'=> 4,
           'template' => $this->tpl
        ));
        $paginator->compile();

        if ($this->byAjax())
        {
        	$this->load->view('admin/order/table');
        }
        else
        {
	        /**
	         * Блок настроек
	         */
	        $var = $this->model->page->get('order');
	        $form = $this->load->form('admin/order/settings');
	        $form->setValues(array(
	            'email' => $var->email
            ));
        }
    }

    function expandAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die();

        $order = $this->model->order->getById($id);
        $this->tpl->assignBlockVars('order', array(
            'MESSAGE' => nl2br($order->message),
            'PAYMETHOD' => $order->paymethod,
            'ADDRESS' => $order->address,
            'REF' => $order->ref,
        ));
        if ($order->ref)
            $this->tpl->assignBlockVars('order.ref');
        
        $items = (array)json_decode($order->cart,true);
        $total = 0;
        $products = $this->model->product->getByIds(array_keys($items));
        foreach ($products as $product)
        {
            $count = array_key_exists($product->id,$items) ? $items[$product->id] : 1;
            $count = preg_match('@^[0-9]+$@i',$count) ? $count : 1;
            $product->name = $product->name.($product->code ? " ($product->code)":'');
            $this->tpl->assignBlockVars('product', array(
                'ID'   => $product->id,
                'KEY'   => $product->key,
                'CODE'   => $product->code,
                'NAME' => $product->name,
                'PRICE' => $product->price,
                'COUNT' => $count,
            ));
            if ($product->code)
                $this->tpl->assignBlockVars('product.code');
            $total+= $count*$product->price;
        }
        if (!$products->isEmpty())
        {
        	$this->tpl->assignBlockVars('cart');
        }
        $this->tpl->assignVars(array(
            'PRICE_TOTAL'=>$total
        ));
    }

    function settingsAction(array $params)
    {
    	$var = $this->model->page->get('order');
        $var2 = $this->model->page->get('cart/order');
        $form = $this->load->form('admin/order/settings');
        if (!$form->isSubmit() && !$var->isEmpty())
	        $form->setValues(array(
	            'email'    => $var->email
	        ));
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            $dataToInsert = array(
                'email'     => $data->email
            );
            if ($var->id)
            {
                $this->model->page->edit($dataToInsert,$var->id);
            }
            else
            {
            	$dataToInsert['name'] = 'order';
                $dataToInsert['dynamic'] = 'on';
            	$this->model->page->add($dataToInsert);
            }
            if ($var2->id)
            {
                $this->model->page->edit($dataToInsert,$var2->id);
            }
            else
            {
                $dataToInsert['name'] = 'cart/order';
                $dataToInsert['dynamic'] = 'on';
                $this->model->page->add($dataToInsert);
            }
            die('ok');
        }
        else $form->renderErrors($this->tpl);
    }
    
    function mailAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id))
            die('fail');
            
        $order = $this->model->order->getById($id);

        $form = $this->load->form('admin/order/mail');
        if (!$form->isSubmit())
        {
            $form->setValues(array('subject'=>'Заказ #'.$id));
        }
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
        
            /**
             * Отправка заказчику
             */
            require_once DIR_LIB.'/phpmailer/class.phpmailer.php';
            if ($order->email)
            {
                $mail = new PHPMailer();
                $mail->From     = 'no-reply@'.$_SERVER['SERVER_NAME'];
                $mail->FromName = $this->model->stuff->get()->site_name;
                $mail->Host     = $_SERVER['HTTP_HOST'];
                $mail->Mailer   = "mail";
                $mail->Body    = nl2br($data->body);
                $mail->AltBody = strip_tags(str_replace("<br/>", "\n", $mail->Body));
                $mail->Subject = $data->subject;
                $mail->AddAddress($order->email);

                $mail->Send();
            }
            die('ok');
        }
        else $form->renderErrors($this->tpl);
        
        $this->tpl->assignVars(array('ID'=>$id,'RAND'=>rand(1,1000)));
    }
    
    function editAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die('fail1');

        $item = $this->model->order->getById($id);
        if ($item->isEmpty())
            die('fail2');

        $form = $this->load->form('admin/order/edit');
        if (!$form->isSubmit())
        {
            $form->setValues($item->asArray());
        }
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            $dataToInsert = array(
                'status' => strip_tags($data->status),
            );
            $this->model->order->edit($dataToInsert,$id);
            
            die('ok');
        }
        else $form->renderErrors($this->tpl);

        $this->tpl->assignVars(array('ID'=>$id,'RAND'=>rand(1,1000)));
    }

    function deleteAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id))
            die('fail');

        $this->model->order->delete($id);
        die('ok');
    }

    function delete_allAction(array $params)
    {
        //$this->model->order->deleteAll();
        die('ok');
    }
    
    function exportAction(array $params)
    {
        if (empty($_POST['submit']))
        {
            
            
            return;
        }
            
        function get_timestamp($date) {
                list($d, $m, $y) = explode('.', $date);
                return mktime(0, 0, 0, $m, $d, $y);
        }
        
        $from = !empty($_POST['from']) ? get_timestamp($_POST['from']) : 0;
        $to = !empty($_POST['to']) ? get_timestamp($_POST['to']) : time();
        
        $stuff = $this->model->stuff->get();
        $currency = $stuff->currency;
        $data[] = explode(',','#,Имя,Телефон,E-mail,Адрес доставки,Комментарий,Корзина,Стоимость,Дата,Статус');
        $orders = $this->model->order->getByPeriod($from,$to);
        foreach ($orders as $order)
        {
            $items = $order->cart ? (array)json_decode($order->cart,true) : array($order->product_id=>null);
            $products = $this->model->product->getByIds(array_keys($items));
            $total = 0;
            $cart = array();
            foreach ($products as $product)
            {
                $count = array_key_exists($product->id,$items) ? $items[$product->id] : 1;
                $count = preg_match('@^[0-9]+$@i',$count) ? $count : 1;
                $total+= $count*$product->price;
                $cart[] = $product->name.' ('.$count.' шт)';
            }
            if ($stuff->shipping && $total && (!$stuff->free_shipping || $total<$stuff->free_shipping))
            {
                $cart[] = 'Доставка';
                $total+= $stuff->shipping;
            }
            if ($products->isEmpty())
                $cart[] = 'заказ звонка';
            $data[] = array(
                $order->id,
                $order->name,
                $order->phone,
                $order->email,
                $order->address,
                $order->message,
                join(',',$cart),
                $total,
                date('d.m.Y, H:i',$order->timestamp),
                $order->status,
            );
        }
        $csv = array();
        foreach ($data as $d)
        {
            $csv[] = '"'.join('";"',str_replace('"', '""', $d)).'"';
        }
        $csv = join(PHP_EOL,$csv);
        //echo '<pre>'.$csv;
                header('Content-Type: application/csv');
        header("Content-disposition: attachment; filename=orders-".date("Y-m-d").".csv; charset=windows-1251; size=".strlen($csv));
        echo mb_convert_encoding($csv, 'windows-1251', 'utf-8');
        die();
    }
}