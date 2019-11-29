<?php
/**
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Testimonials extends Controller
{
    function indexAction(array $params)
    {
        $items = $this->model->testimonial->get();
        foreach ($items as $item)
        {
            $this->tpl->assignBlockVars('tst', array(
                'NAME' => $item->name,
                'MESSAGE'  => nl2br($item->message),
                'CITY'  => $item->city,
                'DUTIES'  => $item->duties,
                'WEBSITE'  => $item->website,
            ));
            if ($item->picture)
            {
                $this->tpl->assignBlockVars('tst.picture', array(
                    'SRC' => $item->picture
                ));
            }
            if ($item->file)
            {
                $this->tpl->assignBlockVars('tst.audio', array(
                    'SRC' => $item->file
                ));
            }
            foreach (array('website','city','duties') as $blockname)
            {
                if ($item->$blockname)
                    $this->tpl->assignBlockVars('tst.'.$blockname);
            }
        }
    }
}