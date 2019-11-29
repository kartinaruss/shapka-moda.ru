<?php
/**
 * Menu Model
 * 
 * @author dandelion <web.dandelion@gmail.com>
 */
class Model_Menu extends Model_Default
{
    protected $table = 'menu';
    protected $cacheTag = 'menu';
    
    function get(&$total=null,$start=0,$count=1000,$disabled=false)
    {
        $cacheKey = $this->cacheTag."_cats_limit_{$start}_{$count}_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data['items'] = (array)$this->db->selectPage($total,
                "SELECT * FROM ?_{$this->table}
                { WHERE `disabled`=? }
                ORDER BY `position` DESC
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
        $cacheKey = $this->cacheTag."_sub_".$parent_id."_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data = $this->db->select(
                "SELECT * FROM ?_{$this->table}
                WHERE `parent_id`<>0 {AND `parent_id`=?d} { AND `disabled`=? }
                ORDER BY `position` DESC",
                ($parent_id)?$parent_id:DBSIMPLE_SKIP,
                !$disabled ? 0 : DBSIMPLE_SKIP
            );
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        return new Entity($data);
    }

    function getMain($disabled = false)
    {
        $cacheKey = $this->cacheTag."_main_disabled_".((int)$disabled);
        if (false === ($data = $this->cache->get($cacheKey)))
        {
            $data = $this->db->select(
                "SELECT * FROM ?_{$this->table}
                WHERE `parent_id`=0 { AND `disabled`=? }
                ORDER BY `position` DESC",
                !$disabled ? 0 : DBSIMPLE_SKIP
            );
            $this->cache->set($data, $cacheKey, array($this->cacheTag));
        }
        return new Entity($data);
    }

    function getTree($disabled = false)
    {
        $cacheKey = $this->cacheTag."_tree_disabled_".((int)$disabled);
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
}