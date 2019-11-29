<?php
/**
 * Import
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Import extends Controller
{
    function indexAction(array $params)
    {
    	
    }
    
    function csvAction(array $params)
    {
        set_time_limit(360);
        
        $filename = "";
        
        $rows = $this->parse_csv($filename);//var_dump($rows);
        foreach ($rows as $i=>$row)
        {
            $cat_id = 0;
            $cats = array_map('trim',explode('/',$row['category1']));
            foreach ($cats as $cat)
            {
                $cat_name = $cat;
                $cat_key = $this->model->tools->makeKey($cat_name);
                $category = $this->model->product->category->getByKey($cat_key);
                if ($category->isEmpty())
                {
                    $cat_id = $this->model->product->category->add(array(
                        'name' => $cat,
                        'key' => $cat_key,
                        'parent_id' => $cat_id,
                        'timestamp' => time()
                    ));
                } else $cat_id = $category->id;
            }
            
                $product = $this->model->product->getById($row['product_id']);
                if ($product->isEmpty())
                {
                    $product_id = $this->model->product->add(array(
                        'id'   => $row['product_id'],
                        'code'   => $row['sku'],
                        'key'   => $row['product_id'].'-'.$this->model->tools->makeKey($row['name']),
                        'name'   => $row['name'],
                        'description_wiki'   => '<html>'.PHP_EOL.$row['description'].PHP_EOL.'</html>',
                        'description_html'   => $row['description'],
                        //'price_old' => $price_old,
                        'price' => $row['price']
                    ));
                    $this->model->product->structure->add(array(
                        'product_id'     => $product_id,
                        'category_id' => $cat_id
                    ));
                    
                                    $picstring = file_get_contents($row['image']);
                                    if ($picstring)
                                    {
                                        $filename = $product_id.substr(uniqid(),-5).'.jpg';
                                        $destBig= DIR_IMAGES.'/product/l/'.$filename;
                                        $destSmall= DIR_IMAGES.'/product/s/'.$filename;
                                        $image = $this->model->image->loadFromString($picstring); 
                                        $image->save($destBig,IMAGETYPE_JPEG,80);
                                        $image->framing(300,300)->save($destSmall,IMAGETYPE_JPEG,80);
                                        $image->destroy();
                                        
                                            $this->model->product->edit(array(
                                                'picture' => $filename
                                            ),$product_id);
                                    }
                }
                else
                {
                    
                }
        }
        
        die();
    }
    
    function parse_csv($filename)
    {
        ini_set("auto_detect_line_endings", 1); 
        $current_row = 1; 
        $rows = array();
        $handle = fopen($filename, "r"); 
        while ( ($data = fgetcsv($handle, 10000, ",") ) !== FALSE ) 
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
                    $data_array[$header_array[$c]] = $data[$c]; 
                } 
                $rows[] = $data_array;
            } 
            $current_row++; 
        } 
        fclose($handle); 
        return $rows;
    }
    
    function xlsxAction(array $params)
    {
        set_time_limit(360);
        
        require_once 'lib/Excel/oleread.inc';
        require_once 'lib/Excel/reader.php';
        include DIR_LIB.'/phpQuery.php';
        
        echo '<pre>';
        
        // ExcelFile($filename, $encoding);
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('UTF-8');
        $data->read('price.xls');
        
        
        $doc1 = new DOMDocument;
        $doc1->load(DIR_ROOT.'/drawing1.xml');
        $xpath1 = new DOMXPath($doc1);
        $p = phpQuery::newDocument(file_get_contents(DIR_ROOT.'/drawing1.xml.rels'));
            
        $cat_name = "Прайс";
        if ($cat_name)
        {
            $cat_key = $this->model->tools->makeKey($cat_name);
            $category = $this->model->product->category->getByKey($cat_key);
            if ($category->isEmpty())
            {
                $cat_id = $this->model->product->category->add(array(
                    'name' => $cat_name,
                    'key' => $cat_key,
                    'parent_id' => 0,
                    'timestamp' => time()
                ));
            } else $cat_id = $category->id;
        }
        else $cat_id = 0;
        
        echo '<table border="1">';
        for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
            
            if (empty($data->sheets[0]['cells'][$i][3]) || $data->sheets[0]['cells'][$i][3]=="Наименование")
                continue;
                
            echo '<tr>';
            for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) { 
                echo '<td>'.@$data->sheets[0]['cells'][$i][$j].'</td>';
            }
            echo '</tr>';
                
            //if (empty($data->sheets[0]['cells'][$i][3]))
            //{
                /*$cat_name = $data->sheets[0]['cells'][$i][2];
                $cat_key = $this->model->tools->makeKey($cat_name);
                $category = $this->model->product->category->getByKey($cat_key);
                if ($category->isEmpty())
                {
                    $cat_id = $this->model->product->category->add(array(
                        'name' => $cat_name,
                        'key' => $cat_key,
                        'parent_id' => 0,
                        'timestamp' => time()
                    ));
                } else $cat_id = $category->id;
                continue;*/
            //}
        
            $name = @$data->sheets[0]['cells'][$i][3];
            $code = @$data->sheets[0]['cells'][$i][2];
            $key = $this->model->tools->makeKey($code.' '.$name);
            $product = $this->model->product->getByKey($key);
            if ($product->isEmpty())
            {
                $price = (float)str_replace(',','.',preg_replace('@[^0-9\,\.]@','',@$data->sheets[0]['cells'][$i][4]));
                $description = @$data->sheets[0]['cells'][$i][5];
                if (empty($description))
                    $description = @$data->sheets[0]['cells'][$i][6];
                $product_id = $this->model->product->add(array(
                    'key'  => $key,
                    'name' => $name,
                    'description_wiki'   => $description,
                    'description_html'   => $this->model->wiki->parseArticle($description),
                    'code' => $code,
                    //'price_old' => $oldprice,
                    'price' => $price,
                ));
                if ($cat_id)
                $this->model->product->structure->add(array(
                    'product_id'     => $product_id,
                    'category_id' => $cat_id
                ));
                
                $imgs = array();
                $rowNum = $i-1;
                $embeds = $xpath1->query("/xdr:wsDr/xdr:twoCellAnchor/xdr:from[xdr:row='$rowNum']/../xdr:pic/xdr:blipFill/a:blip");
                for ($e=0;$e<$embeds->length;$e++)
                {
                    $embed = $embeds->item($e);
                    $rId = $embed->getAttribute('r:embed');
                    $res = $p->find("Relationship[Id='$rId']")->attr('Target');
                    $res = str_replace('../media/','',$res);
                    $imgs[] = $res;
                } 
                
                $album = array();
                if (!empty($imgs))
                foreach ($imgs as $n=>$img)
                {
                    
                    $src = DIR_ROOT.'/media/'.$img;
                    if ($src)
                    {
                                    $filename = $product_id.substr(uniqid(),-5).'.jpg';
                                    $destBig= DIR_IMAGES.'/product/l/'.$filename;
                                    $destSmall= DIR_IMAGES.'/product/s/'.$filename;
                                    $image = $this->model->image->load($src);
                                    $image->save($destBig,IMAGETYPE_JPEG,80);
                                    $image->framing(300,300)->save($destSmall,IMAGETYPE_JPEG,80);
                                    $image->destroy();
                                    
                                    if ($n==0)
                                    {
                                        $this->model->product->edit(array(
                                            'picture' => $filename
                                        ),$product_id);
                                    }
                                    else $album[] = $filename;
                    }
                }
                if ($album)
                {
                    $this->model->product->edit(array(
                        'album' => join('|',$album)
                    ),$product_id);
                }
            }
            else
            {
                /*$this->model->product->edit(array(
                    'description_wiki'   => $description,
                    'description_html'   => $this->model->wiki->parseArticle($description),
                ),$product->id);*/
            }
        }
        echo '</table>';
        
        die();
    }
}