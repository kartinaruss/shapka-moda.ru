<?php
/**
 * Product Model
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class Model_Product extends Model_Default
{
    protected $table = 'products';
    protected $cacheTag = 'product';

    public $album;

    function init()
    {
    	$this->category = new Model_Product_Category;
        $this->criteria = new Model_Product_Criteria;
        $this->structure = new Model_Product_Structure;
        $this->structure2 = new Model_Product_Structure2;
    }

    function getById($id)
    {
        $cacheKey = $this->cacheTag."_product_by_id_{$id}";
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $idparts = explode(':',$id);
            $_id = $idparts[0];
            $_num = isset($idparts[1]) ? $idparts[1] : null;
            $data = $this->db->selectRow(
                "SELECT * FROM ?_{$this->table}
                WHERE `id`=?",$_id
            );
            if (!empty($data))
            {
                $data['category'] = $this->category->getByProductId($_id);
                $data['criteria'] = $this->criteria->getByProductId($_id);
                // Params
                if (!is_null($_num))
                {
	                $params = json_decode($data['params'],true);
	                if ($params)
	                {
	                    $params = $params[0];
	                    $param_values = $params['values'];
	                    if (isset($param_values[$_num]))
	                    {
	                        $value = $param_values[$_num];
	                        $data['name'] = $data['name'].' / '.(@$value['value']);
	                        $data['price'] = !empty($value['price']) ? $value['price'] : $data['price'];
	                        $data['price_old'] = !empty($value['price_old']) ? $value['price_old'] : (empty($value['price']) ? $data['price'] : '');
	                        $data['num'] = $_num;
	                    }
	                }
                }
            }
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        return new Entity($data);
    }

    function getByKey($key)
    {
        $cacheKey = $this->cacheTag."_product_by_key_{$key}";
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data = $this->db->selectRow(
                "SELECT * FROM ?_{$this->table}
                WHERE `key`=?",$key
            );
            if (!empty($data))
                $data['category'] = $this->category->getByProductId($data['id']);
            if (!empty($data))
                $data['criteria'] = $this->criteria->getByProductId($data['id']);
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        return new Entity($data);
    }

    function getByCode($code)
    {
        $cacheKey = $this->cacheTag."_product_by_code_{$code}";
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data = $this->db->selectRow(
                "SELECT * FROM ?_{$this->table}
                WHERE `code`=?",$code
            );
            if (!empty($data))
                $data['category'] = $this->category->getByProductId($data['id']);
            if (!empty($data))
                $data['criteria'] = $this->criteria->getByProductId($data['id']);
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        return new Entity($data);
    }

    function get(&$total=null, $start=0, $count=1000, $disabled = false)
    {
        $cacheKey = $this->cacheTag."_start_{$start}_count_{$count}_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data['items'] = (array)$this->db->selectPage($total,
                "SELECT p.* FROM ?_{$this->table} p
                { WHERE p.`disabled`=? }
                ORDER BY p.`id` DESC LIMIT ?d,?d",
                !$disabled ? 0 : DBSIMPLE_SKIP,
                $start, $count
            );
            $data['total'] = $total;
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        else $total = $data['total'];
        return new Entity($data['items']);
    }

    function getByIds($ids)
    {
        $cacheKey = $this->cacheTag."_ids_".join('|',$ids);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $_ids = array();
            foreach ($ids as $id)
            {
                $id = explode(':',$id);
                $_ids[] = $id[0];
            }
            $_data = (array)$this->db->selectPage($total,
                "SELECT * FROM ?_{$this->table}
                WHERE id IN (?a)",
                $_ids
            );
            $items = array();
            foreach ($_data as $d)
            {
                $items[$d['id']] = $d;
            }
            $_data = array();
            foreach ($ids as $id)
            {
                $idparts = explode(':',$id);
                $_id = $idparts[0];
                $_num = isset($idparts[1]) ? $idparts[1] : null;
                if (!array_key_exists($_id,$items))
                    continue;

                $item = $items[$_id];
                $params = json_decode($item['params'],true);
                if ($params)
                {
                    $params = $params[0];
                    $param_values = $params['values'];
                    if (isset($param_values[$_num]))
                    {
                        $value = $param_values[$_num];
                        $item['name'] = $item['name'].' / '.(@$value['value']);
                        $item['price'] = !empty($value['price']) ? $value['price'] : $item['price'];
                        $item['price_old'] = !empty($value['price_old']) ? $value['price_old'] : (empty($value['price']) ? $item['price'] : '');
                        $item['num'] = $_num;
                    }
                }
                $item['price'] = (int)$item['price'];
                $item['id'] = $id;
                $_data[] = $item;
            }
            $data['items'] = $_data;
            $data['total'] = $total;
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        else $total = $data['total'];
        return new Entity($data['items']);
    }

    function getByCategory($category_id, &$total=null, $start=0, $count=1000, $disabled = false)
    {
        $cacheKey = $this->cacheTag."_by_category_{$category_id}_start_{$start}_count_{$count}_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data['items'] = (array)$this->db->selectPage($total,
                "SELECT DISTINCT p.* FROM ?_{$this->table} p
                JOIN ?_{$this->structure->getTable()} s ON s.`product_id`=p.`id`
                WHERE s.`category_id`=?d { AND p.`disabled`=? }
                ORDER BY s.`position` ASC,p.`timestamp` DESC LIMIT ?d,?d",
                $category_id, !$disabled ? 0 : DBSIMPLE_SKIP, $start, $count
            );
            $data['total'] = $total;
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        else $total = $data['total'];
        return new Entity($data['items']);
    }

    function getByCriterias($criteria_ids, &$total=null, $from=null, $to=null, $start=0, $count=100000)
    {
        $cacheKey = $this->cacheTag."_by_criterias_".join('|',$criteria_ids)."_{$from}_{$to}_start_{$start}_count_{$count}";
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            if (!$criteria_ids)
            $data['items'] = (array)$this->db->selectPage($total,
                "SELECT DISTINCT p.*
                    FROM  ?_{$this->table} p
                    WHERE p.`disabled`=0
                       {AND CAST(p.price AS SIGNED)>=?} {AND CAST(p.price AS SIGNED)<=?}
                    GROUP BY p.id
                    ORDER BY CAST(p.price AS SIGNED) ASC, p.`timestamp`
                LIMIT ?d,?d",
                $from ? $from : DBSIMPLE_SKIP,
                $to ? $to : '100000000',
                $start, $count
            );
            else
            $data['items'] = (array)$this->db->selectPage($total,
                "SELECT * FROM
                (
                    SELECT DISTINCT p.*,COUNT(DISTINCT c.parent_id) as criteria_count
                    FROM  ?_{$this->table} p
                    JOIN ?_{$this->structure2->getTable()} s ON s.`product_id`=p.`id`
                    JOIN ?_{$this->criteria->getTable()} c ON s.`criteria_id`=c.`id`
                    WHERE s.`criteria_id` IN(?a) AND p.`disabled`=0
                       {AND CAST(p.price AS SIGNED)>=?} {AND CAST(p.price AS SIGNED)<=?}
                    GROUP BY p.id
                    ORDER BY CAST(p.price AS SIGNED) ASC, p.`timestamp`
                ) result
                WHERE criteria_count =
                    (
                        SELECT COUNT(DISTINCT c2.parent_id)
                        FROM ?_{$this->criteria->getTable()} c2
                        WHERE c2.id IN(?a)
                    )
                LIMIT ?d,?d",
                $criteria_ids ? $criteria_ids : array(0),
                $from ? $from : DBSIMPLE_SKIP,
                $to ? $to : '100000000',
                $criteria_ids ? $criteria_ids : array(0),
                $start, $count
            );
            $data['total'] = $total;
            $this->cache->set($data, $cacheKey, array($this->cacheTag), 3600);
        }
        else $total = $data['total'];
        return new Entity($data['items']);
    }

    function getMain(&$total=null, $start=0, $count=1000, $disabled = false)
    {
        $cacheKey = $this->cacheTag."_main_start_{$start}_count_{$count}_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data['items'] = (array)$this->db->selectPage($total,
                "SELECT * FROM ?_{$this->table}
                WHERE `main`=1 { AND `disabled`=? }
                ORDER BY `position_main` ASC LIMIT ?d,?d",
                !$disabled ? 0 : DBSIMPLE_SKIP,
                $start, $count
            );
            $data['total'] = $total;
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        else $total = $data['total'];
        return new Entity($data['items']);
    }

	function getMain2($cat33)
    {
        $cacheKey = $this->cacheTag."_criteria_main_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data = $this->db->select(
                "SELECT _products.*, _product_structure.position FROM  _products,_product_structure
                WHERE `main`=1 AND `disabled`=0  AND `product_id`=_products.`id` and `category_id`= '".$cat33."'
                ORDER BY `position_main` ASC"
            );
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
		return new Entity($data);
    }

    function search($query, &$total=null, $start=0, $count=1000)
    {
        $cacheKey = $this->cacheTag."_search_{$query}_start_{$start}_count_{$count}";
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data['items'] = (array)$this->db->selectPage($total,
                "SELECT * FROM ?_{$this->table}
                WHERE (`name` LIKE ? OR `code` LIKE ?) AND `disabled`=0
                LIMIT ?d,?d",
                '%'.$query.'%', '%'.$query.'%', $start, $count
            );
            $data['total'] = $total;
            //$this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        else $total = $data['total'];
        return new Entity($data['items']);
    }

    static function checkIfKeyExists($key)
    {
        if ($key=='item')
            return false;
        if (isset($_POST['my_key']) && $_POST['my_key']==$key)
            return true;
        return !Db::factory()->selectCell("SELECT COUNT(`id`) FROM ?_products WHERE `key`=?",$key);
    }

    static function checkIfCategoryKeyExists($key)
    {
        if ($key=='item')
            return false;
        if (isset($_POST['my_key']) && $_POST['my_key']==$key)
            return true;
        return !Db::factory()->selectCell("SELECT COUNT(`id`) FROM ?_product_categories WHERE `key`=?",$key);
    }

    function getCount($category_id)
    {
        $cacheKey = $this->cacheTag."_count_$category_id";
        if (false === ($count = $this->cache->get($cacheKey)))
        {
        	$subcat_ids = array($category_id);
        	$subcats = $this->model->product->category->getSub($category_id);
        	foreach ($subcats as $subcat)
        	    $subcat_ids[] = $subcat->id;
            $count = $this->db->selectCell(
                "SELECT COUNT(DISTINCT p.`id`) FROM ?_{$this->table} p
                JOIN ?_{$this->structure->getTable()} s ON s.`product_id`=p.`id`
                WHERE s.`category_id` IN(?a) AND p.`disabled`=0",
                $subcat_ids
            );
            $this->cache->set($count, $cacheKey, array($this->cacheTag));
        }
        return $count;
    }

    function delete($id)
    {
    	$this->structure->deleteByProductId($id);
        $this->structure2->deleteByProductId($id);
        return parent::delete($id);
    }
}

class Model_Product_Category extends Model_Default
{
    protected $table = 'product_categories';
    protected $cacheTag = 'product';

    function init()
    {

    }

    function get(&$total=null,$start=0,$count=1000,$disabled=false)
    {
        $cacheKey = $this->cacheTag."_cats_limit_{$start}_{$count}_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data['items'] = (array)$this->db->selectPage($total,
                "SELECT * FROM ?_{$this->table}
                { WHERE `disabled`=? }
                ORDER BY `position` ASC
                LIMIT ?d,?d",
                !$disabled ? 0 : DBSIMPLE_SKIP,
                $start, $count
            );
            $data['total'] = $total;
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        else $total = $data['total'];
        return new Entity($data['items']);
    }

    function getSub($parent_id = null, $disabled = false)
    {
        $cacheKey = $this->cacheTag."_cats_sub_".$parent_id."_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data = $this->db->select(
                "SELECT * FROM ?_{$this->table}
                WHERE `parent_id`<>0 {AND `parent_id`=?d} { AND `disabled`=? }
                ORDER BY `position` ASC",
                ($parent_id)?$parent_id:DBSIMPLE_SKIP,
                !$disabled ? 0 : DBSIMPLE_SKIP
            );
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        return new Entity($data);
    }

    function getMain($disabled = false)
    {
        $cacheKey = $this->cacheTag."_cats_main_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data = $this->db->select(
                "SELECT * FROM ?_{$this->table}
                WHERE `parent_id`=0 { AND `disabled`=? }
                ORDER BY `position` ASC",
                !$disabled ? 0 : DBSIMPLE_SKIP
            );
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        return new Entity($data);
    }



    function getTree($disabled = false)
    {
        $cacheKey = $this->cacheTag."_cats_tree_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data = array();
            $items = $this->getMain($disabled);
            foreach ($items as $item)
            {
                $subdata = array();
                $subitems = $this->getSub($item->id,$disabled);
                foreach ($subitems as $subitem)
                {
                    if (!$subitem->disabled)
                    {
                        $subsubdata = array();
                        $subsubitems = $this->getSub($subitem->id,$disabled);
                        foreach ($subsubitems as $subsubitem)
                        {
                            if (!$subsubitem->disabled)
                            {
                                $subsubdata[] = $subsubitem->asArray();
                            }
                        }
                        if ($subsubdata)
                            $subitem->children = $subsubdata;
                        $subdata[] = $subitem->asArray();
                    }
                }
                if ($subdata)
                    $item->children = $subdata;
                $data[] = $item->asArray();
            }
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        return new Entity($data);
    }

    function getByKey($key)
    {
        $cacheKey = $this->cacheTag."_cats_by_key_{$key}";
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data = $this->db->selectRow(
                "SELECT * FROM ?_{$this->table}
                WHERE `key`=? LIMIT 1", $key
            );
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        return new Entity($data);
    }

    function getByName($name)
    {
        $data = $this->db->selectRow(
            "SELECT * FROM ?_{$this->table}
            WHERE `name`=? LIMIT 1", $name
        );
        return new Entity($data);
    }

    function getByProductId($id)
    {
        $data = $this->db->select(
            "SELECT c.* FROM ?_product_structure s
            JOIN ?_{$this->table} c ON c.id=s.category_id
            WHERE s.product_id=?d
            ORDER BY c.`position` ASC", $id
        );
        return new Entity($data);
    }
}
class Model_Product_Structure extends Model_Default
{
    protected $table = 'product_structure';
    protected $cacheTag = 'product';

    function deleteByProductId($id)
    {
        $this->db->query("DELETE FROM ?_{$this->table} WHERE `product_id`=?", $id);
        $this->cache->clean(array($this->cacheTag));
        return $this;
    }

    function set($product_id,$category_ids)
    {
    	// Удаляем существуюшие лишние
    	$this->db->query("DELETE FROM ?_{$this->table} WHERE `product_id`=?d AND `category_id` NOT IN (?a)", $product_id, $category_ids);
    	// Выбираем все существующие
        $exist_ids = (array)$this->db->selectCol("SELECT category_id FROM ?_{$this->table} WHERE product_id=?d", $product_id);
    	// Записываем новые
    	foreach ($category_ids as $category_id)
    	{
    		if (in_array($category_id,$exist_ids))
    		    continue;

    		$this->add(array(
                'product_id'  => $product_id,
                'category_id' => $category_id,
                'position' => 0,
            ));
    	}

        $this->cache->clean(array($this->cacheTag));
        return $this;
    }

    function edit($data,$product_id,$category_id)
    {
        $this->db->query(
            "UPDATE ?_{$this->table} SET ?a WHERE `product_id`=?d AND `category_id`=?d",
            $data, $product_id,$category_id
        );
        $this->cache->clean(array($this->cacheTag));
        return $this;
    }
}
class Model_Product_Criteria extends Model_Default
{
    protected $table = 'product_criteria';
    protected $cacheTag = 'product';

    function init()
    {

    }

    function get(&$total=null,$start=0,$count=1000,$disabled=false)
    {
        $cacheKey = $this->cacheTag."_criteria_limit_{$start}_{$count}_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data['items'] = (array)$this->db->selectPage($total,
                "SELECT * FROM ?_{$this->table}
                { WHERE `disabled`=? }
                ORDER BY `position` ASC
                LIMIT ?d,?d",
                !$disabled ? 0 : DBSIMPLE_SKIP,
                $start, $count
            );
            $data['total'] = $total;
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        else $total = $data['total'];
        return new Entity($data['items']);
    }

    function getSub($parent_id = null, $disabled = false)
    {
        $cacheKey = $this->cacheTag."_criteria_sub_".$parent_id."_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data = $this->db->select(
                "SELECT * FROM ?_{$this->table}
                WHERE `parent_id`<>0 {AND `parent_id`=?d} { AND `disabled`=? }
                ORDER BY `position` ASC",
                ($parent_id)?$parent_id:DBSIMPLE_SKIP,
                !$disabled ? 0 : DBSIMPLE_SKIP
            );
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        return new Entity($data);
    }

    function getMain($disabled = false)
    {
        $cacheKey = $this->cacheTag."_criteria_main_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data = $this->db->select(
                "SELECT * FROM ?_{$this->table}
                WHERE `parent_id`=0 { AND `disabled`=? }
                ORDER BY `position` ASC",
                !$disabled ? 0 : DBSIMPLE_SKIP
            );
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        return new Entity($data);
    }

    function getTree($disabled = false)
    {
        $cacheKey = $this->cacheTag."_criteria_tree_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data = array();
            $items = $this->getMain($disabled);
            foreach ($items as $item)
            {
                $subdata = array();
                $subitems = $this->getSub($item->id,$disabled);
                foreach ($subitems as $subitem)
                {
                    if (!$subitem->disabled)
                    {
                        $subsubdata = array();
                        $subsubitems = $this->getSub($subitem->id,$disabled);
                        foreach ($subsubitems as $subsubitem)
                        {
                            if (!$subsubitem->disabled)
                            {
                                $subsubdata[] = $subsubitem->asArray();
                            }
                        }
                        if ($subsubdata)
                            $subitem->children = $subsubdata;
                        $subdata[] = $subitem->asArray();
                    }
                }
                if ($subdata)
                    $item->children = $subdata;
                $data[] = $item->asArray();
            }
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        return new Entity($data);
    }

    function getByKey($key)
    {
        $cacheKey = $this->cacheTag."_criteria_by_key_{$key}";
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data = $this->db->selectRow(
                "SELECT * FROM ?_{$this->table}
                WHERE `key`=? LIMIT 1", $key
            );
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        return new Entity($data);
    }

    function getByName($name)
    {
        $data = $this->db->selectRow(
            "SELECT * FROM ?_{$this->table}
            WHERE `name`=? LIMIT 1", $name
        );
        return new Entity($data);
    }

    function getByProductId($id)
    {
        $data = $this->db->select(
            "SELECT c.* FROM ?_product_structure2 s
            JOIN ?_{$this->table} c ON c.id=s.criteria_id
            WHERE s.product_id=?d
            ORDER BY c.`position` ASC", $id
        );
        return new Entity($data);
    }
}
class Model_Product_Structure2 extends Model_Default
{
    protected $table = 'product_structure2';
    protected $cacheTag = 'product';

    function deleteByProductId($id)
    {
        $this->db->query("DELETE FROM ?_{$this->table} WHERE `product_id`=?", $id);
        $this->cache->clean(array($this->cacheTag));
        return $this;
    }
}