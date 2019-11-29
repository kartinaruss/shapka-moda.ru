<?php
/**
 * SEO Stuff
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Admin_Stuff_Seo extends Controller
{
    function init()
    {
        if ($this->User_getRole() !== 'admin')
            $this->Url_redirectTo403();
    }

    function indexAction(array $params)
    {
        $this->settingsAction($params);
    }

    function settingsAction(array $params)
    {
        $data = $this->model->stuff->get();
        $form = $this->load->form('admin/stuff/seo');
        if (!$form->isSubmit())
        {
            $form->setValues(array(
                'robots_txt' => file_get_contents(DIR_ROOT.'/robots.txt'),
            ));
        }
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            
            file_put_contents(DIR_ROOT.'/robots.txt',$data->robots_txt);
            if (!empty($_FILES) && $_FILES['sitemap_xml']['name'])
            file_put_contents(DIR_ROOT.'/sitemap.xml',file_get_contents($_FILES['sitemap_xml']['tmp_name']));
            
            die('ok');
        }
        else $form->renderErrors($this->tpl);
    }
}