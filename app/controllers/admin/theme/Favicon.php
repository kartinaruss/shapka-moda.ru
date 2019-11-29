<?php
/**
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Admin_Theme_Favicon extends Controller
{
    function init()
    {
        if ($this->User_getRole() !== 'admin')
            $this->Url_redirectTo403();
    }

    function indexAction(array $params)
    {
        if (is_file(DIR_ROOT.'/favicon.ico') && file_get_contents(DIR_ROOT.'/favicon.ico'))
        {
            $this->tpl->assignBlockVars('img');
        }
        else
        {
            $this->tpl->assignBlockVars('no_img');
        }
    }

    function addAction(array $params)
    {
        $form = $this->load->form('admin/theme/favicon');
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            file_put_contents(DIR_ROOT.'/favicon.ico',file_get_contents($data->file->tmp_name));
            $this->model->stuff->save(array('version_favicon'=>(int)$this->model->stuff->get()->version_favicon+1),1);
        }
        else
        {
            if ($form->isSubmit())
                $form->renderErrors($this->tpl);
        }

        if (is_file(DIR_ROOT.'/favicon.ico') && file_get_contents(DIR_ROOT.'/favicon.ico'))
        {
            $this->tpl->assignBlockVars('img');
        }
        else
        {
            $this->tpl->assignBlockVars('no_img');
        }
    }

    function deleteAction(array $params)
    {
        file_put_contents(DIR_ROOT.'/favicon.ico','');
        $this->model->stuff->save(array('version_favicon'=>(int)$this->model->stuff->get()->version_favicon+1),1);
    }
}