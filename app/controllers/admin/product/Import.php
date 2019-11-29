<?php
/**
 * Product Import
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Admin_Product_Import extends Controller
{
    function init()
    {
        if ($this->User_getRole() !== 'admin')
            $this->Url_redirectTo403();
    }

    function indexAction(array $params)
    {
        die();
    }
    
    function xlsAction()
    {//die();
        if (empty($_FILES))
        {
            return;
        }
        
        set_time_limit(360);
        
        require_once 'lib/Excel/oleread.inc';
        require_once 'lib/Excel/reader.php';
        
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('UTF-8');
        $data->read($_FILES['file']['tmp_name']);
        
        $added = $edited = 0;
        $price_k = (float)@$_POST['price_k'];
        $price_k = $price_k ? $price_k : 1;
        for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) 
        {
            
            //$values = @$data->sheets[0]['cells'][$i];var_dump($values);
            //if ($i>10) die();
            //else continue;
            
            $values = @$data->sheets[0]['cells'][$i];
            
            $code = @$values[1];
            $name = @$values[2];
            $price = @$values[4];
            $price = (float)str_replace(',','.',preg_replace('@[^0-9\,\.]@','',$price));
            $price = $price*$price_k;
            
            if (empty($values) || empty($code) || empty($name))
                continue;
                
            /*$description = "+++Общие характеристики".PHP_EOL.PHP_EOL;
            $params = array();
            foreach ($values as $k=>$value)
            {
                if ($k<=5 || $k>=12) continue;
                
                if ($value)
                   $params[$fields[$k]] = $value;
            }
            foreach ($params as $name=>$value)
            {
                $description.= '**'.$name.':** '.$value.PHP_EOL;
            }*/
            
            /*$category = $this->model->product->category->getByName($values[3]);
            if ($category->isEmpty())
            {
                    $cat_id = $this->model->product->category->add(array(
                        'name' => $values[3],
                        'key' => $this->model->tools->makeKey($values[3]),
                        'parent_id' => 11
                    ));
            }
            else $cat_id = $category->id;*/
            
            $product = $this->model->product->getByCode($code);
            if ($product->isEmpty())
            {
            
                    $product_id = $this->model->product->add(array(
                        'key'   => $this->model->tools->makeKey($code.' '.$name),
                        'name'   => $name,
                        'code'   => $code,
                        'price'   => $price,
                        //'brief'   => $brief,
                        //'description_wiki' => $description,
                        //'description_html' => $this->model->wiki->parseArticle($description)
                    ));
                    if ($product_id)
                    {
                        $added++;
                        
                        $cat_id = 0;
                        if (stripos($name,'мужск')) 
                            $cat_id = 4;
                        elseif (stripos($name,'женск')) 
                            $cat_id = 13;
                        elseif (stripos($name,'детск')) 
                            $cat_id = 18;
                        
                        if ($cat_id)
                        $this->model->product->structure->add(array(
                            'product_id'  => $product_id,
                            'category_id' => $cat_id
                        ));
                    }
            } 
            else
            {
            
                    $this->model->product->edit(array(
                        'price'   => $price,
                    ),$product->id);
                    $edited++;
            }
        }
        
        $this->tpl->assignBlockVars('success',array(
            'ADDED' => $added,
            'EDITED' => $edited,
        ));
    }
    
    function csvAction(array $params)
    {
        if (empty($_FILES))
        {
            return;
        }
        
        set_time_limit(360);
        
        $filename = $_FILES['file']['tmp_name'];
        
        $added = $edited = 0;
        $rows = $this->parse_csv($filename);//var_dump($rows);
        foreach ($rows as $i=>$row)
        {
        	if (empty($row['name']) || empty($row['id']))
        	    continue;
        	
        	$values = array(
				'id'   => $row['id'],
				'code' => $row['code'],
				'key'  => $row['key'],
				'name' => $row['name'],
				'price'      => $row['price'],
				'price_old'  => $row['price_old'],
				'brief'      => $row['brief'],
				'description_wiki' => $row['description1'],
				'description_html' => $this->model->wiki->parseArticle($row['description1']),
				'seotext_wiki' => $row['description2'],
				'seotext_html' => $this->model->wiki->parseArticle($row['description2']),
				'title'      => $row['title'],
				'keywords'   => $row['keywords'],
				'description'=> $row['description'],
				'label'      => $row['label'],
				'main'       => $row['main'],
				'disabled'   => $row['disabled'],
        	);
        	
            $product = $this->model->product->getById($row['id']);
            if ($product->isEmpty())
            {
            	// Добавляем товар
            	$values['key'] = $row['key'] ? $row['key'] : $row['id'].'-'.$this->model->tools->makeKey($row['name']);
                $product_id = $this->model->product->add($values);
                $product = $this->model->product->getById($product_id);
                                    
                $added++;
            }
            else
            {
                // Редактируем товар
                $this->model->product->edit($values,$product->id);
                
            	$edited++;
            } 
            
            // Обновляем категории
            $this->model->product->structure->deleteByProductId($product->id);
            $cats = array_map('trim',explode(',',$row['categories']));
            foreach ($cats as $cat)
            {
                $category = $this->model->product->category->getByName($cat);
                if (!$category->isEmpty())
                {
                    $this->model->product->structure->add(array(
                        'product_id'  => $product->id,
                        'category_id' => $category->id
                    ));
                }
            }
            
            // Обновляем критерии фильтра
            /*$this->model->product->structure2->deleteByProductId($product->id);
            $cris = array_map('trim',explode(',',$row['criterias']));
            foreach ($cris as $cri)
            {
                $criteria = $this->model->product->criteria->getByName($cri);
                if (!$criteria->isEmpty())
                {
                    $this->model->product->structure2->add(array(
                        'product_id'  => $product->id,
                        'criteria_id' => $criteria->id
                    ));
                }
            }*/
        }
        
        $this->tpl->assignBlockVars('success',array(
            'ADDED'  => $added,
            'EDITED' => $edited,
        ));
    }
    
    function parse_csv($filename)
    {
        ini_set("auto_detect_line_endings", 1); 
        $current_row = 1; 
        $rows = array();
        $handle = fopen($filename, "r"); 
        while ( ($data = fgetcsv($handle, 0, ";") ) !== FALSE ) 
        { 
            $number_of_fields = count($data); 
            if ($current_row == 1) 
            { 
                for ($c=0; $c < $number_of_fields; $c++) 
                { 
                    $header_array[$c] = $data[$c]; 
                } 
            } 
            else 
            {
                for ($c=0; $c < $number_of_fields; $c++) 
                { 
                    $data_array[$header_array[$c]] = iconv('windows-1251','utf-8',$data[$c]); 
                } 
                $rows[] = $data_array;
            } 
            $current_row++; 
        } 
        fclose($handle); 
        return $rows;
    }
}