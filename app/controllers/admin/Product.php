<?php
/**
 * Product
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Admin_Product extends Controller
{
    const ITEMS_PER_PAGE = 400;

    CONST DIR_PICTURES = 'product';
    CONST DIR_PICTURES_L = 'product/l';
    CONST DIR_PICTURES_S = 'product/s';
    CONST DIR_PICTURES_X = 'product/x';
    CONST DIR_PICTURES_TEMP = 'product/temp';

    const PICTURE_WIDTH = 350;
    const PICTURE_HEIGHT = 350;

    const PICTURE_WIDTH_X = 650;
    const PICTURE_HEIGHT_X = 650;

    function init()
    {
        if ($this->User_getRole() !== 'admin')
            $this->Url_redirectTo403();
    }

    function indexAction(array $params,$type='cat')
    {
        if (in_array($params[0],array('all','search')))
            $type = $params[0];
        if ($type=='all' && !empty($params[1]) && $params[1]=='search')
        {
            $type = 'search';
            unset($params[0]);
            $params = array_values($params);
        }
        if (!empty($params[1]))
        {
            if (in_array($params[1],array('add','cancel','table','reorder')))
            {
                $action = $params[1].'Action';
                if ($params[1]=='add')
                $this->load->view('admin/product/'.$params[1]);
                unset($params[1]);
                return $this->$action(array_values($params));
            }
        }

        $this->tableAction($params,$type);

        if ($this->byAjax())
        {
            $this->load->view('admin/product/table');
        }
    }

    function expandAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die();

        $item = $this->model->product->getById($id);
        $this->tpl->assignBlockVars('product', array(
            'CONTENT' => $item->description_html
        ));
    }

    function tableAction(array $params = array(),$type='cat')
    {
        $category_id = (int)@$params[0];
        switch ($type)
        {
            case 'cat':
                $category = $this->model->product->category->getById($category_id);
                break;
            case 'all':
            default:
                $category = new Entity();
                break;
        }
        $this->tpl->assignBlockVars('tab_'.$type);

        $catOptions = array();
        $cats = $this->model->product->category->getTree(true);
        foreach ($cats as $cat)
        {
            $catOptions[$cat->id] = $cat->name;
            if ($cat->children)
            foreach ($cat->children as $subcat)
            {
                $catOptions[$subcat->id] = '-- '.$subcat->name;
                if ($subcat->children)
                foreach ($subcat->children as $subsubcat)
                {
                    $catOptions[$subsubcat->id] = '---- '.$subsubcat->name;
                }
            }
        }
        $form = $this->load->form('admin/category');
        $form->setOptions(array('cats'=>$catOptions));
        $form->setValues(array('category'=>$category->id ? $category->id : $type));

        /**
         * Параметры
         */
        $page = 1;
        if(in_array('page',$params))
        {
            $pageInd = array_search('page',$params);
            if(isset($params[$pageInd+1]))
                $page = $params[$pageInd+1];
        }
        if (!$page)
            $page = 1;

        $search = null;
        if($type=='search')
        {
            $search = @$params[1];
        }

        $start = ($page-1)*self::ITEMS_PER_PAGE;

        switch ($type)
        {
            case 'cat':
                $projects = $this->model->product->getByCategory($category_id, $total, $start, self::ITEMS_PER_PAGE, true);
                break;
            case 'search':
                $projects = $this->model->product->search($search, $total, $start, self::ITEMS_PER_PAGE);
                break;
            case 'all':
                $projects = $this->model->product->get($total, $start, self::ITEMS_PER_PAGE, true);
                break;
            default:break;
        }

        foreach ($projects as $project)
        {
            $this->tpl->assignBlockVars('product', array(
                'ID'     => $project->id,
                'NAME' => $project->name,
                'CODE' => $project->code,
                'PRICE' => $project->price,
                'PRICE_OLD' => $project->price_old,
                'BRIEF' => $project->brief,
                'LABEL' => $project->label,
                'RATING' => $project->rating,

                'DATE'  => date('j ',$project->timestamp).$this->model->date->getOfMonthText(date('m',$project->timestamp)).date(' Y',$project->timestamp)
            ));
            if ($project->picture)
            {
                $src = DIR_IMAGES.'/'.self::DIR_PICTURES_S.'/'.$project->picture;
                if (is_file($src))
                {
                    $imageInfo = getimagesize($src);
                    $this->tpl->assignBlockVars('product.picture',array(
                        'SRC' => $project->picture,
                        'WIDTH'  => $imageInfo[0],
                        'HEIGHT' => $imageInfo[1]
                    ));
                }
            }
            if (!$project->disabled)
                $this->tpl->assignBlockVars('product.enabled');
            else
                $this->tpl->assignBlockVars('product.disabled');
            if ($project->main)
                $this->tpl->assignBlockVars('product.mark');
            else
                $this->tpl->assignBlockVars('product.unmark');
        }
        $this->tpl->assignVars(array('RAND'=>rand(1,1000)));
        /**
         * Навигация
         */
        $paginator = new Paginator(array(
           'countPerPage'  => self::ITEMS_PER_PAGE,
           'countOfEntries'=> $total,
           'currentPage' => $page,
           'template' => $this->tpl
        ));
        $paginator->compile();

        $this->tpl->assignVars(array(
            'CURRENT_PAGE' => $page,
            'CATEGORY_NAME' => $category->name,
            'CATEGORY_ID' => $category->id ? $category->id : ($type=='search' ? 'search/'.$search : $type)
        ));
        if ($search)
        {
            $this->tpl->assignVars(array(
                'SEARCH_QUERY' => htmlentities($search),
                //'URL_POSTFIX'  => '/search/'.$search
            ));
        }
    }
    //
    function addAction(array $params)
    {
        $catOptions = array();
        $cats = $this->model->product->category->getTree(true);
        foreach ($cats as $cat)
        {
            $catOptions[$cat->id] = $cat->name;
            if ($cat->children)
            foreach ($cat->children as $subcat)
            {
                $catOptions[$subcat->id] = '-- '.$subcat->name;
                if ($subcat->children)
                foreach ($subcat->children as $subsubcat)
                {
                    $catOptions[$subsubcat->id] = '---- '.$subsubcat->name;
                }
            }
        }

        $cats = $this->model->product->criteria->getTree(true);
        foreach ($cats as $cat)
        {
            $this->tpl->assignBlockVars('criteria',array(
                'NAME' => $cat->name,
                'ID' => $cat->id
            ));
            if ($cat->children)
            foreach ($cat->children as $subcat)
            {
                $this->tpl->assignBlockVars('criteria.sub',array(
                    'ID' => $subcat->id,
                    'NAME' => $subcat->name
                ));
                if ($subcat->children)
                foreach ($subcat->children as $subsubcat)
                {
                    $this->tpl->assignBlockVars('criteria.sub.subsub',array(
                        'NAME' => $subsubcat->name,
                        'ID' => $subsubcat->id
                    ));
                }
            }
        }

        $form = $this->load->form('admin/product/add');

        $optionsAll = array();
        $products = $this->model->product->get($total);
        foreach ($products as $product)
        {
            $optionsAll[$product->id] = $product->name;
        }


        $form->setOptions(array(
            'categories'=>$catOptions,
            'products' => $optionsAll
        ));



        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            $dataToInsert = array(
                'key' => time(),
                'code'   => strip_tags($data->code),
                'name'   => strip_tags($data->name),
                'price' => strip_tags($data->price),
                'price_old' => strip_tags($data->price_old),
                'brief' => $data->brief,
                'description_wiki'  => $data->description_wiki,
                'description_html'  => $this->model->wiki->parseArticle($data->description_wiki),
                'seotext_wiki' => $data->seotext_wiki,
                'seotext_html' => $this->model->wiki->parseArticle($data->seotext_wiki),
                'also' => join('|',(array)@$_POST['also']),
                'main' => (int)(bool)$data->main,
                'label'   => $data->label,
                'title' => strip_tags($data->title),
                'keywords' => strip_tags($data->keywords),
                'description' => strip_tags($data->description),
            );


            $id = $this->model->product->add($dataToInsert);
            $this->model->product->edit(array(
                 'key' => $id.'-'.$this->model->tools->makeKey(strip_tags($data->name))
            ),$id);
            if ($data->pictureKey)
            {
                $source = DIR_IMAGES.'/'.self::DIR_PICTURES_TEMP.'/'.$data->pictureKey;
                $filename = $id.substr(uniqid(),-5).'.jpg';
                $destBig= DIR_IMAGES.'/'.self::DIR_PICTURES_L.'/'.$filename;
                $destSmall= DIR_IMAGES.'/'.self::DIR_PICTURES_S.'/'.$filename;

                $destX= DIR_IMAGES.'/'.self::DIR_PICTURES_X.'/'.$filename;

                if (is_file($source))
                {
                    $image = $this->model->image->load($source);
                    //$image->watermark2(DIR_IMAGES.'/product/watermark.png');
                    $image->save($destBig);
                    $image->framing(self::PICTURE_WIDTH,self::PICTURE_HEIGHT)->save($destSmall);
                    $image = $this->model->image->load($source);
                    $image->framing(self::PICTURE_WIDTH_X,self::PICTURE_HEIGHT_X)->save($destX);
                    unlink($source);
                    $this->model->product->edit(array(
                        'picture' => $filename,
						'md5_imagefile' => strtoupper(md5_file($destSmall)),

                    ),$id);
                }
            }
            $this->model->product->structure->set($id,(array)@$_POST['category_id']);
            foreach ((array)@$_POST['criteria_id'] as $criteria_id)
            {
                $this->model->product->structure2->add(array(
                    'product_id'     => $id,
                    'criteria_id' => $criteria_id
                ));
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

        $this->tpl->assignVars(array(
            'CATEGORY_ID' => $params[0]
        ));
    }

    function saveAction(array $params)
    {
        $id = (int)@$params[0];

        $this->model->product->edit(array(
            $_POST['key'] => $_POST['value']
        ),$id);
        die('ok');
    }

    function editAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die('fail1');

        $item = $this->model->product->getById($id);
        if ($item->isEmpty())
            die('fail2');

        $catOptions = array();
        $cats = $this->model->product->category->getTree(true);
        foreach ($cats as $cat)
        {
            $catOptions[$cat->id] = $cat->name;
            if ($cat->children)
            foreach ($cat->children as $subcat)
            {
                $catOptions[$subcat->id] = '-- '.$subcat->name;
                if ($subcat->children)
                foreach ($subcat->children as $subsubcat)
                {
                    $catOptions[$subsubcat->id] = '---- '.$subsubcat->name;
                }
            }
        }

        $cats = $this->model->product->criteria->getTree(true);
        foreach ($cats as $cat)
        {
            $this->tpl->assignBlockVars('criteria',array(
                'NAME' => $cat->name,
                'ID' => $cat->id
            ));
            if ($cat->children)
            foreach ($cat->children as $subcat)
            {
                $this->tpl->assignBlockVars('criteria.sub',array(
                    'ID' => $subcat->id,
                    'NAME' => $subcat->name
                ));
                if ($subcat->children)
                foreach ($subcat->children as $subsubcat)
                {
                    $this->tpl->assignBlockVars('criteria.sub.subsub',array(
                        'NAME' => $subsubcat->name,
                        'ID' => $subsubcat->id
                    ));
                }
            }
        }

        $form = $this->load->form('admin/product/edit');
        $optionsAll = array();
        $products = $this->model->product->get($total);
        foreach ($products as $product)
        {
            if ($product->id==$item->id)
                continue;
            $optionsAll[$product->id] = $product->name;
        }
        $form->setOptions(array(
            'categories'=>$catOptions,
            'products' => $optionsAll
        ));




        if (!$form->isSubmit())
        {
            $form->setValues($item->asArray());
            $cats = array();
            foreach ($item->category as $category)
            {
                $cats[] = $category->id;
            }
            $form->setValues(array('category_id'=>$cats));
            $cats = array();
            if ($item->criteria)
            foreach ($item->criteria as $criteria)
            {
                $cats[] = $criteria->id;
            }
            $form->setValues(array('criteria_id'=>$cats));
            $form->setValues(array('also'=>explode('|',$item->also)));
        }
        $form->setValues(array('my_key'=>$item->key));

        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            $dataToInsert = array(
                'key'   => $data->key,
                'code'   => strip_tags($data->code),
                'name'   => strip_tags($data->name),
                'price' => strip_tags($data->price),
                'price_old' => strip_tags($data->price_old),
                'brief' => $data->brief,
                'description_wiki'  => $data->description_wiki,
                'description_html'  => $this->model->wiki->parseArticle($data->description_wiki),
                'seotext_wiki' => $data->seotext_wiki,
                'seotext_html' => $this->model->wiki->parseArticle($data->seotext_wiki),
                'also' => join('|',(array)@$_POST['also']),
                'main' => (int)(bool)$data->main,
                'label'   => $data->label,
                'title' => strip_tags($data->title),
                'keywords' => strip_tags($data->keywords),
                'description' => strip_tags($data->description),
            );
            /**
             * Сохраняем логотип
             */
            if ($data->pictureKey)
            {
                $source = DIR_IMAGES.'/'.self::DIR_PICTURES_TEMP.'/'.$data->pictureKey;
                $filename = $id.substr(uniqid(),-5).'.jpg';

                $destBig= DIR_IMAGES.'/'.self::DIR_PICTURES_L.'/'.$filename;
                $destSmall= DIR_IMAGES.'/'.self::DIR_PICTURES_S.'/'.$filename;
                $destX= DIR_IMAGES.'/'.self::DIR_PICTURES_X.'/'.$filename;

                $oldBig = DIR_IMAGES.'/'.self::DIR_PICTURES_L.'/'.$item->picture;
                $oldSmall = DIR_IMAGES.'/'.self::DIR_PICTURES_S.'/'.$item->picture;
                $oldX = DIR_IMAGES.'/'.self::DIR_PICTURES_X.'/'.$item->picture;

                if (is_file($source))
                {
                    if (copy($source, $destBig))
                    {
                        $image = $this->model->image->load($destBig);
                        $image->framing(self::PICTURE_WIDTH,self::PICTURE_HEIGHT)->save($destSmall);
                        $image = $this->model->image->load($destBig);
                        $image->framing(self::PICTURE_WIDTH_X,self::PICTURE_HEIGHT_X)->save($destX);

                        $dataToInsert['picture'] = $filename;
						$dataToInsert['md5_imagefile'] = strtoupper(md5_file($destSmall));

                        unlink($source);
                        if (is_file($oldBig))
                            unlink($oldBig);
                        if (is_file($oldSmall))
                            unlink($oldSmall);
                        if (is_file($oldX))
                            unlink($oldX);
                    }
                }
            }
            $this->model->product->edit($dataToInsert,$id);
            $this->model->product->structure->set($id,(array)@$_POST['category_id']);

            $this->model->product->structure2->deleteByProductId($id);
            foreach ((array)@$_POST['criteria_id'] as $criteria_id)
            {
                $this->model->product->structure2->add(array(
                    'product_id'     => $id,
                    'criteria_id' => $criteria_id
                ));
            }

            die('ok');
        }
        else $form->renderErrors($this->tpl);
        /**
         * Отображаем ранее загруженный файл
         */
        if (empty($_POST['pictureKey']))
        {
            if ($item->picture)
            {
                $source = DIR_IMAGES.'/'.self::DIR_PICTURES.'/'.$item->picture;
                $this->tpl->assignBlockVars('picture',array('FILE'=>$item->picture));
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

    function extraAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die('fail1');

        $item = $this->model->product->getById($id);
        if ($item->isEmpty())
            die('fail2');

        $values = $prices = $oldprices = array();

        $form = $this->load->form('admin/product/extra');
        if (!$form->isSubmit())
        {
            $params = json_decode($item->params,true);
            if ($params)
            {
                $params = $params[0];
                $param_name = $params['name'];
                $param_values = $params['values'];
                foreach ($param_values as $value)
                {
                    $values[] = @$value['value'];
                    $prices[] = @$value['price'];
                    $oldprices[] = @$value['price_old'];
                }
                $form->setValues(array(
                    'param_name' => $param_name,
                    'param_value' => $values,
                    'param_price' => $prices,
                    'param_price_old' => $oldprices,
                ));
            }
        }
        else
        {
            foreach ($_POST['param_value'] as $value)
            {
                if (!empty($value))
                    $values[] = $value;
            }
        }
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            $params = array();
            if ($data->param_name || $data->param_value)
            {
                $params[0] = array(
                    'name' => strip_tags($data->param_name),
                    'values' => array()
                );
                $prices = (array)$data->param_price->asArray();
                $oldprices = (array)$data->param_price_old->asArray();
                foreach ($data->param_value as $i=>$value)
                {
                    if ($value)
                    $params[0]['values'][] = array(
                        'value' => $value,
                        'price' => !empty($prices[$i]) ? $prices[$i] : '',
                        'price_old' => !empty($oldprices[$i]) ? $oldprices[$i] : ''
                    );
                }
            }

            $this->model->product->edit(array(
                'params'   => json_encode($params),
            ),$id);
            die('ok');
        }
        else $form->renderErrors($this->tpl);

        $this->tpl->assignVars(array('ID'=>$id,'RAND'=>rand(1,1000)));

        foreach ($values as $value)
        {
            $this->tpl->assignBlockVars('param');
        }
    }

    function deleteAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id))
            die('fail');

        $item = $this->model->product->getById($id);
        if ($item->isEmpty())
            die('fail');

        $this->model->product->delete($id);
        $images = array($item->picture)+explode('|',$item->album);
        foreach ($images as $image)
        {
        	$src = DIR_IMAGES.'/'.self::DIR_PICTURES_L.'/'.$image;
            if (is_file($src))
                unlink($src);
            $src = DIR_IMAGES.'/'.self::DIR_PICTURES_S.'/'.$image;
            if (is_file($src))
                unlink($src);
            $src = DIR_IMAGES.'/'.self::DIR_PICTURES_X.'/'.$image;
            if (is_file($src))
                unlink($src);
        }
        die('ok');
    }

    function disableAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die();

        $this->model->product->edit(array('disabled'=>1),$id);
        die('ok');
    }

    function enableAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die();

        $this->model->product->edit(array('disabled'=>0),$id);
        die('ok');
    }

    function markAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die();

        $this->model->product->edit(array('main'=>1),$id);
        die('ok');
    }

    function unmarkAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die();

        $this->model->product->edit(array('main'=>0),$id);
        die('ok');
    }
    /**
     * Отмена
     *
     * @param $params
     */
    function cancelAction(array $params)
    {
        $this->model->dir->clean(DIR_IMAGES.'/'.self::DIR_PICTURES_TEMP);
        if (@$params[1]=='add')
            $this->Url_redirectTo('admin/product/add/'.$params[0]);
    }

    function pictureAction(array $params)
    {
        $form = $this->load->form('admin/product/picture/upload');
        if ($form->isSubmit() && $form->isValid())
        {
            $data = new Entity($form->getData());
            $key = uniqid();
            $dest = DIR_IMAGES.'/'.self::DIR_PICTURES_TEMP.'/'.$key;
            /**
             * Сохраняем картинку
             */
            $image = $this->model->image->load($data->file->tmp_name);
            $image->shrink(1024,768)->save($dest);

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
    /**
     * Перестановка
     *
     * @param $params
     */
    function reorderAction(array $params)
    {
    	$category_id = (int)$params[0];
        $positions = array_reverse((array)@$_GET['list']);
        $count = count($positions);
        foreach ($positions as $position => $id)
        {
            $id = (int)$id;
            if ($id > 0)
            {
                $this->model->product->structure->edit(array('position' => $count-$position), $id, $category_id);
            }
        }
    }

    function albumAction(array $params)
    {
        $id = (int)@$params[0];
        if (empty($id)) die();

        $this->tpl->assignVars(array(
            'PRODUCT_ID'=>$id
        ));

        $product = $this->model->product->getById($id);
        $photos = explode('|',$product->album);
        foreach ($photos as $num=>$photo)
        {
            if (!$photo) continue;
            $this->tpl->assignBlockVars('photo',array(
                'NUM' => $num,
                'SRC' => $photo
            ));
        }
    }

    function deletephotoAction(array $params)
    {
        $id = (int)@$params[0];
        $src = @$params[1];
        if (empty($id) || empty($src))
            die('fail');

        $product = $this->model->product->getById($id);
        if ($product->isEmpty())
            die('fail');

        $photos = explode('|',$product->album);
        $photo_num = array_search($src,$photos);
        if (false !== $photo_num)
        {
            unset($photos[$photo_num]);
            $this->model->product->edit(array('album'=>join('|',$photos)),$id);
            @unlink(DIR_IMAGES.'/'.self::DIR_PICTURES_L.'/'.$src);
            @unlink(DIR_IMAGES.'/'.self::DIR_PICTURES_S.'/'.$src);
            @unlink(DIR_IMAGES.'/'.self::DIR_PICTURES_X.'/'.$src);
        }
        die('ok');
    }

    function reorderalbumAction(array $params)
    {
        $id = (int)@$params[0];
        $list = @$params[1];
        if (empty($id) || empty($list))
            die('fail');

        $product = $this->model->product->getById($id);
        if ($product->isEmpty())
            die('fail');

        $ok = true;
        $photos = explode('|',$product->album);
        $new_photos = explode('|',$list);
        foreach ($new_photos as $photo)
        {
            $photo_num = array_search($photo,$photos);
            if (false === $photo_num)
            {
                $ok = false;
            }
        }
        if ($ok)
            $this->model->product->edit(array('album'=>$list),$id);
        die('ok');
    }

    function fiximgAction()
    {
        $products = $this->model->product->get($total);
        foreach ($products as $product)
        {
        	if (!$product->picture)
        	    continue;
            $source = DIR_IMAGES.'/'.self::DIR_PICTURES_L.'/'.$product->picture;

            if (!is_file($source))
                $source = DIR_IMAGES.'/'.self::DIR_PICTURES_S.'/'.$product->picture;

            $dest= DIR_IMAGES.'/'.self::DIR_PICTURES_S.'/'.$product->picture;

            $image = $this->model->image->load($source);

            $image->framing(self::PICTURE_WIDTH,self::PICTURE_HEIGHT)->save($dest);

            //die('<img src="../../images/'.self::DIR_PICTURES.'/m/'.$product->picture.'"/>');

            foreach (explode('|',$product->album) as $pic)
            {
            	$source = DIR_IMAGES.'/'.self::DIR_PICTURES_L.'/'.$pic;
	            $dest= DIR_IMAGES.'/'.self::DIR_PICTURES_S.'/'.$pic;
	            $image = $this->model->image->load($source);
	            $image->framing(self::PICTURE_WIDTH,self::PICTURE_HEIGHT)->save($dest);
            }
        }
    }

    function fixcatsAction()
    {
        $products = $this->model->product->get($total);
        foreach ($products as $product)
        {
            $this->model->product->structure->add(array(
                'product_id'  => $product->id,
                'category_id' => $product->category_id
            ));
        }
    }
}