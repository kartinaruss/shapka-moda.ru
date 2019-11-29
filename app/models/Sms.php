<?php
/**
 * SMS Model
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class Model_Sms extends Model
{
    public $api;

    function init()
    {
    	$stuff = $this->model->stuff->get();
        $this->api = new Smsc($stuff->smsc_login,$stuff->smsc_pass);
    }

    function send($numbers,$message)
    {
        if (!is_array($numbers))
            $numbers = array($numbers);
            
        foreach ($numbers as $i=>$number)
            $numbers[$i] = preg_replace('@[^0-9]+@i','',$number);
            
        return $numbers ? $this->api->messageSend($numbers,$message) : false;
    }
}