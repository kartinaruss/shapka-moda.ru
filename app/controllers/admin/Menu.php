<?php
/**
 * Menu
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Admin_Menu extends Controller
{
    const DIR_PICTURES = 'menu';
    const DIR_PICTURES_TEMP = 'menu/temp';

    const PHOTO_WIDTH  = 78;
    const PHOTO_HEIGHT = 78;

    function init()
    {
        if ($this->User_getRole() !== 'admin')
            $this->Url_redirectTo403();
    }

    function indexAction(array $params)
    {
        $items = $this->model->menu->getMain(true);
        foreach ($items as $item)
        {
            $this->tpl->assignBlockVars('menu', array(
                'ID'   => $item->id,
                'TITLE' => $item->title,
                'LINK' => $item->link,
            ));
            if ($item->disabled)
                $this->tpl->assignBlockVars('menu.disabled');
            else
                $this->tpl->assignBlockVars('menu.enabled');

            $subitems = $this->model->menu->getSub($item->id,true);
            foreach ($subitems as $subitem)
            {
                $this->tpl->assignBlockVars('menu.sub', array(
                    'ID'   => $subitem->id,
	                'TITLE' => $subitem->title,
	                'LINK' => $subitem->link,
                ));
                if ($subitem->disabled)
                    $this->tpl->assignBlockVars('menu.sub.disabled');
                else
                    $this->tpl->assignBlockVars('menu.sub.enabled');
            }
            if (!$subitems->isEmpty())
                $this->tpl->assignBlockVars('menu.has_child');
        }
        /**
         * Если запрос на обновление страницы
         */
        if ($this->byAjax())
        {
            $this->load->view('admin/menu/table');
        }
    }

    function addAction(array $params)
    {
        $id = (int)@$params[0];
        $this->tpl->assignVar('ID',$id);

        $menuOptions = array();
        $cats = $this->model->menu->getTree(true);
        foreach ($cats as $cat)
        {
            $menuOptions[$cat->id] = $cat->title;
        }

        $form = $this->load->form('admin/menu/add');
        $form->setOptions(array('categories'=>$menuOptions));
        if (!$form->isSubmit())
        {
            $form->setValues(array('parent_id'=>$id));
        }
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            $dataToInsert = array(
                'title' => $data->title,
                'link' => $data->link,
                'parent_id' => (int)$data->parent_id
            );
            $id = $this->model->menu->add($dataToInsert);
            if ($data->pictureKey)
            {
                $source = DIR_IMAGES.'/'.self::DIR_PICTURES_TEMP.'/'.$data->pictureKey;
                $filename = $id.substr(uniqid(),-5).'.jpg';
                $dest   = DIR_IMAGES.'/'.self::DIR_PICTURES.'/'.$filename;
                if (is_file($source))
                {
                    copy($source, $dest);
                    unlink($source);
                    $this->model->menu->edit(array(
                        'file' => $filename
                    ),$id);
                }
            }
            //$this->model->dir->clean(DIR_IMAGES.'/'.self::DIR_PICTURES_TEMP);
            die('ok');
        }
        else $form->renderErrors($this->tpl);
        /**
         * Отображаем ранее загруженный файл
         */
        if (!empty($_POST['pictureKey']))
        {
            $source = DIR_IMAGES.'/'.self::DIR_PICTURES_TEMP.'/'.$_POST['pictureKey'];
            $this->tpl->assignBlockVars('picture',array('KEY'=>$_POST['pictureKey']));
        }
        else $this->tpl->assignBlockVars('no_picture');
    }

    function editAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die('fail1');
        $this->tpl->assignVar('ID',$id);

        $menu = $this->model->menu->getById($id);
        if ($menu->isEmpty())
            die('fail2');

        $this->tpl->assignVar('NAME',$menu->title);

        $menuOptions = array();
        $cats = $this->model->menu->getTree(true);
        foreach ($cats as $cat)
        {
            if ($cat->id == $id)
                continue;
            $menuOptions[$cat->id] = $cat->title;
        }

        $form = $this->load->form('admin/menu/edit');
        $form->setOptions(array('categories'=>$menuOptions));
        if (!$form->isSubmit())
        {
            $form->setValues($menu->asArray());
        }
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            $dataToInsert = array(
                'title' => $data->title,
                'link' => $data->link,
                'parent_id' => (int)$data->parent_id
            );
            /**
             * Сохраняем логотип
             */
            if ($data->pictureKey)
            {
                $source = DIR_IMAGES.'/'.self::DIR_PICTURES_TEMP.'/'.$data->pictureKey;
                $filename = $id.substr(uniqid(),-5).'.jpg';
                $dest   = DIR_IMAGES.'/'.self::DIR_PICTURES.'/'.$filename;
                $old    = DIR_IMAGES.'/'.self::DIR_PICTURES.'/'.$menu->file;
                if (is_file($source))
                {
                    if (copy($source, $dest))
                    {
                        $dataToInsert['file'] = $filename;
                        unlink($source);
                        if (is_file($old))
                            unlink($old);
                    }
                }
            }
            $this->model->menu->edit($dataToInsert,$id);
            die('ok');
        }
        else $form->renderErrors($this->tpl);
        /**
         * Отображаем ранее загруженный файл
         */
        if (empty($_POST['pictureKey']))
        {
            if ($menu->file)
            {
                $source = DIR_IMAGES.'/'.self::DIR_PICTURES.'/'.$menu->file;
                $this->tpl->assignBlockVars('picture',array('FILE'=>$menu->file));
            }
            else $this->tpl->assignBlockVars('no_picture');
        }

        $this->tpl->assignVars(array('ID'=>$id,'RAND'=>rand(1,1000)));
        /**
         * Отображаем ранее загруженный файл
         */
        if (!empty($_POST['pictureKey']))
        {
            $source = DIR_IMAGES.'/'.self::DIR_PICTURES_TEMP.'/'.$_POST['pictureKey'];
            $this->tpl->assignBlockVars('picture2',array('KEY'=>$_POST['pictureKey']));
        }
    }

    function deleteAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id))
            die('fail');

        $item = $this->model->menu->getById($id);
        if ($item->isEmpty())
            die('fail');

        $this->model->menu->delete($id);
        /**
         * Delete sub items
         */
        $items = $this->model->menu->getSub($id,true);
        foreach ($items as $item)
        {
            $this->model->menu->delete($item->id);
        }
        die('ok');
    }

    function disableAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die();

        $this->model->menu->edit(array('disabled'=>1),$id);
        die('ok');
    }

    function enableAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die();

        $this->model->menu->edit(array('disabled'=>0),$id);
        die('ok');
    }

    function reorderAction(array $params)
    {
        $positions = (array)@$_GET['list'];
        $count = count($positions);
        foreach ($positions as $position => $id)
        {
            $id = (int)$id;
            if ($id > 0)
            {
                $this->model->menu->edit(array('position' => $count-$position), $id);
            }
        }
    }

    function pictureAction(array $params)
    {
        $form = $this->load->form('admin/menu/picture/upload');
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            $key = uniqid();
            $dest = DIR_IMAGES.'/'.self::DIR_PICTURES_TEMP.'/'.$key;
            /**
             * Сохраняем картинку
             */
            $image = $this->model->image->load($data->file->tmp_name);
            $image->cropAuto()->shrink(self::PHOTO_WIDTH,self::PHOTO_HEIGHT)->save($dest,IMAGETYPE_JPEG);

            $this->tpl->assignVar('KEY',$key);
            $this->tpl->assignBlockVars('success');
        }
        else
        {
            $form->renderErrors($this->tpl);
            $this->tpl->assignBlockVars('fail');
        }
        /**
         * Удаляем ранее загруженный файл
         */
        if (!empty($_POST['pictureKey']))
        {
            $source = DIR_IMAGES.'/'.self::DIR_PICTURES_TEMP.'/'.$_POST['pictureKey'];
            if (is_file($source))
                unlink($source);
        }
    }
}