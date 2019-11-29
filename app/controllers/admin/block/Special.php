<?php
/**
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Admin_Block_Special extends Controller
{
    const DIR_PICTURES = 'stuff';

    function init()
    {
        if ($this->User_getRole() !== 'admin')
            $this->Url_redirectTo403();
    }

    function indexAction(array $params)
    {
        if (is_file(DIR_IMAGES.'/'.self::DIR_PICTURES.'/special.png'))
        {
            $this->tpl->assignBlockVars('img');
        }
        else
        {
            $this->tpl->assignBlockVars('no_img');
        }
        $this->settingsAction($params);
    }

    function settingsAction(array $params)
    {
        $data = $this->model->stuff->get();
        $form = $this->load->form('admin/stuff/special');
        $optionsAll = array();
        /*$cats = $this->model->product->category->getTree();
        foreach ($cats as $cat)
        {
            $this->tpl->assignBlockVars('cat',array(
               'ID' => $cat->id,
               'NAME' => $cat->name
            ));
            if (!$cat->children->isEmpty())
            {
                $options = array();
                foreach ($cat->children as $subcat)
                {
                    $optionsAll[] = $options[$subcat->id] = $subcat->name;
                }
                $form->setOptions(array('cat'.$cat->id => $options));
            }
        }*/
        $products = $this->model->product->get($total);
        foreach ($products as $product)
        {
            $optionsAll[$product->id] = $product->name;
        }
        $form->setOptions(array('products' => $optionsAll));
        if (!$form->isSubmit())
        {
            $form->setValues($data->asArray());
            $form->setValues(array('cart_special'=>explode('|',$data->cart_special)));
        }
        if ($form->isSubmit() && $form->isValid())
        {
            $data = $form->getData();
            $data['cart_special'] = join('|',(array)@$_POST['cart_special']);
            $this->model->stuff->save($data,1);
            die('ok');
        }
        else $form->renderErrors($this->tpl);
    }

    function addAction(array $params)
    {
        $form = $this->load->form('admin/stuff/upload');
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            $filename = "special.png";
            $dest = DIR_IMAGES.'/'.self::DIR_PICTURES.'/'.$filename;
            /**
             * Сохраняем картинку
             */
            @unlink($dest);
            $image = $this->model->image->load($data->file->tmp_name);
            $image->shrink(400,400)->save($dest,IMAGETYPE_PNG);
            $this->cache->clean(array('stuff'));
        }
        else
        {
            if ($form->isSubmit())
                $form->renderErrors($this->tpl);
        }

        if (is_file(DIR_IMAGES.'/'.self::DIR_PICTURES.'/special.png'))
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
        $filename = "special.png";
        $dest = DIR_IMAGES.'/'.self::DIR_PICTURES.'/'.$filename;
        @unlink($dest);
    }
}