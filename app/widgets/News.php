<?php
/**
 * Виджет новостей
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class Widget_News extends aWidget
{
    function init()
    {
        if (0===strpos(URL_APP,'blog'))
            return;
            
        $this->load->model('blog')->model('date');
        /**
         * Данные
         */
        $news = $this->model->blog->get($total,0,3);
        if ($news->isEmpty())
            return;
        foreach ($news as $entry)
        {
            $this->tpl->assignBlockVars('widget.news', array(
                'ID'     => $entry->id,
                'NAME'    => $entry->name,
                'KEY'    => $entry->key,
                'DATE'  => date('d ',$entry->timestamp).$this->model->date->getMonthText(date('m',$entry->timestamp)).date(', Y',$entry->timestamp),
                'BRIEF' => $entry->brief_html,
            ));
        }
        $this->tpl->assignBlockVars('widget.newsblock',array(
            'TOTAL' => $total
        ));
    }
}