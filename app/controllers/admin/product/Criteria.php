<?php
/**
 * Product Criteria
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Admin_Product_Criteria extends Controller
{
    const DIR_PICTURES = 'product';
    const DIR_PICTURES_TEMP = 'product/temp';

    const PHOTO_WIDTH  = 78;
    const PHOTO_HEIGHT = 78;

    function init()
    {
        if ($this->User_getRole() !== 'admin')
            $this->Url_redirectTo403();
    }

    function indexAction(array $params)
    {
        $items = $this->model->product->criteria->getMain(true);
        foreach ($items as $item)
        {
            $this->tpl->assignBlockVars('criteria', array(
                'ID'   => $item->id,
                'NAME' => $item->name,
            ));
            if ($item->disabled)
                $this->tpl->assignBlockVars('criteria.disabled');
            else
                $this->tpl->assignBlockVars('criteria.enabled');

            $subitems = $this->model->product->criteria->getSub($item->id,true);
            foreach ($subitems as $subitem)
            {
                $this->tpl->assignBlockVars('criteria.sub', array(
                    'ID'   => $subitem->id,
                    'NAME' => $subitem->name,
                ));
                if ($subitem->disabled)
                    $this->tpl->assignBlockVars('criteria.sub.disabled');
                else
                    $this->tpl->assignBlockVars('criteria.sub.enabled');

                $subsubitems = $this->model->product->criteria->getSub($subitem->id,true);
                foreach ($subsubitems as $subsubitem)
                {
                    $this->tpl->assignBlockVars('criteria.sub.far', array(
                        'ID'   => $subsubitem->id,
                        'NAME' => $subsubitem->name,
                    ));
                    if ($subsubitem->disabled)
                        $this->tpl->assignBlockVars('criteria.sub.far.disabled');
                    else
                        $this->tpl->assignBlockVars('criteria.sub.far.enabled');
                }
                if (!$subsubitems->isEmpty())
                    $this->tpl->assignBlockVars('criteria.sub.has_child');
            }
            if (!$subitems->isEmpty())
                $this->tpl->assignBlockVars('criteria.has_child');
        }
        /**
         * Если запрос на обновление страницы
         */
        if ($this->byAjax())
        {
            $this->load->view('admin/product/criteria/table');
        }
    }

    function addAction(array $params)
    {
        $id = (int)@$params[0];
        $this->tpl->assignVar('ID',$id);

        $criteriaOptions = array();
        $cats = $this->model->product->criteria->getTree(true);
        foreach ($cats as $cat)
        {
            $criteriaOptions[$cat->id] = $cat->name;
            if (false && $cat->children)
            foreach ($cat->children as $subcat)
            {
                $criteriaOptions[$subcat->id] = '-- '.$subcat->name;
            }
        }

        $form = $this->load->form('admin/product/criteria/add');
        $form->setOptions(array('categories'=>$criteriaOptions));
        if (!$form->isSubmit())
        {
            $form->setValues(array('parent_id'=>$id));
        }
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            $dataToInsert = array(
                'name' => $data->name,
                'parent_id' => (int)$data->parent_id,
                'timestamp' => time()
            );
            $id = $this->model->product->criteria->add($dataToInsert);
            if ($data->pictureKey)
            {
                $source = DIR_IMAGES.'/'.self::DIR_PICTURES_TEMP.'/'.$data->pictureKey;
                $filename = $id.substr(uniqid(),-5).'.jpg';
                $dest   = DIR_IMAGES.'/'.self::DIR_PICTURES.'/'.$filename;
                if (is_file($source))
                {
                    copy($source, $dest);
                    unlink($source);
                    $this->model->product->criteria->edit(array(
                        'file' => $filename
                    ),$id);
                }
            }
            $this->model->dir->clean(DIR_IMAGES.'/'.self::DIR_PICTURES_TEMP);
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

        $criteria = $this->model->product->criteria->getById($id);
        if ($criteria->isEmpty())
            die('fail2');

        $this->tpl->assignVar('NAME',$criteria->name);

        $criteriaOptions = array();
        $cats = $this->model->product->criteria->getTree(true);
        foreach ($cats as $cat)
        {
            if ($cat->id == $id)
                continue;
            $criteriaOptions[$cat->id] = $cat->name;
            if (false && $cat->children)
            foreach ($cat->children as $subcat)
            {
	            if ($subcat->id == $id)
                    continue;
                $criteriaOptions[$subcat->id] = '-- '.$subcat->name;
            }
        }

        $form = $this->load->form('admin/product/criteria/edit');
        $form->setOptions(array('categories'=>$criteriaOptions));
        if (!$form->isSubmit())
        {
            $form->setValues($criteria->asArray());
        }
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            $dataToInsert = array(
                'name' => $data->name, 
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
                $old    = DIR_IMAGES.'/'.self::DIR_PICTURES.'/'.$criteria->file;
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
            $this->model->product->criteria->edit($dataToInsert,$id);
            die('ok');
        }
        else $form->renderErrors($this->tpl);
        /**
         * Отображаем ранее загруженный файл
         */
        if (empty($_POST['pictureKey']))
        {
            if ($criteria->file)
            {
                $source = DIR_IMAGES.'/'.self::DIR_PICTURES.'/'.$criteria->file;
                $this->tpl->assignBlockVars('picture',array('FILE'=>$criteria->file));
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

        $item = $this->model->product->criteria->getById($id);
        if ($item->isEmpty())
            die('fail');

        $this->model->product->criteria->delete($id);
        $products = $this->model->product->getByCriteria($id);
        foreach ($products as $product)
        {
            //$this->model->product->delete($product->id);
        }
        /**
         * Delete sub items
         */
        $items = $this->model->product->criteria->getSub($id,true);
        foreach ($items as $item)
        {
            $this->model->product->criteria->delete($item->id);
            $products = $this->model->product->getByCriteria($item->id);
            foreach ($products as $product)
            {
                //$this->model->product->delete($product->id);
            }
        }
        die('ok');
    }

    function disableAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die();

        $this->model->product->criteria->edit(array('disabled'=>1),$id);
        die('ok');
    }

    function enableAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die();

        $this->model->product->criteria->edit(array('disabled'=>0),$id);
        die('ok');
    }

    function reorderAction(array $params)
    {
        $positions = array_reverse((array)@$_GET['list']);
        $count = count($positions);
        foreach ($positions as $position => $id)
        {
            $id = (int)$id;
            if ($id > 0)
            {
                $this->model->product->criteria->edit(array('position' => $count-$position), $id);
            }
        }
    }

    function pictureAction(array $params)
    {
        $form = $this->load->form('admin/product/criteria/picture/upload');
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