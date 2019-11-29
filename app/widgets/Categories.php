<?php
/**
 * Виджет категорий
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class Widget_Categories extends aWidget
{
	function init()
    {
        $this->load->model('product');
        //$this->load->model('category');
        /**
         * Данные
         */
        $cats = $this->model->product->category->getTree();
		
		$cat_name_actual = "";
		
		$sat_id_actual = 0;
		$temp222 = explode("/",$_SERVER['REQUEST_URI']);
		if (in_array("catalog",$temp222)) {
			
			$arrtemp222 = explode("?",$temp222[2]);
			$cat_name_actual = ($arrtemp222[0] != "" ? $arrtemp222[0] :	NULL);
		}
		elseif (in_array("item",$temp222)) {
			
			$arrtemp222 = explode("?",$temp222[2]);
			$prod_name_actual = ($arrtemp222[0] != "" ? $arrtemp222[0] :	NULL);
			$arrproduct = $this->model->product->getByKey($prod_name_actual);
			$arrcat = $arrproduct->category;
			$iiii = 0;
			foreach($arrproduct->category as $cat22) {
				if ($iiii == 0)$cat_name_actual = $cat22->key;
				$iiii++;
			}
				
		}
			
		 
		// echo "$cat_name_actual = actual ".print_r($temp222);
		 
		 foreach ($cats as $key22 => $cat)
        {
		
			if ($cat->key == $cat_name_actual)	
				$sat_id_actual = $cat->id;
				
			if ($cat->children)
            {
                foreach ($cat->children as $sub)
                {
	                if ($sub->key == $cat_name_actual)	
						$sat_id_actual = $cat->id;
		            if ($sub->children)
		            {
		                foreach ($sub->children as $subsub)
		                	if ($subsub->key == $cat_name_actual)	
								$sat_id_actual = $cat->id;
		            }
                }
            }
		}
		
//		echo "<pre>id = $sat_id_actual <br><br>".print_r($cats)."</pre>";
		 
        foreach ($cats as $cat)
        {
            $this->tpl->assignBlockVars('widget.cat', array(
                'KEY'  => $cat->key,
                'NAME' => $cat->name,
				'ID'   => $cat->id,
				'ACTIV'=> ($sat_id_actual == $cat->id ? 1 : 0),
				'ACTM'=> ($sat_id_actual == $cat->id ? "class=\"active\"" : ""),
				'AIMG'=> ($sat_id_actual == $cat->id ? "<img src=\"./images/galochka.png\" style=\"float:right;margin-right:0px;margin-top:5px;\" ?>" : "")
				
            ));
            if ($cat->file)
            {
                $this->tpl->assignBlockVars('widget.cat.picture', array(
                    'SRC'   => $cat->file
                ));
            }
            if ($cat->children)
            {
                $this->tpl->assignBlockVars('widget.cat.has_child');
                foreach ($cat->children as $sub)
                {
	                $this->tpl->assignBlockVars('widget.cat.sub', array(
	                    'KEY'  => $sub->key,
	                    'NAME' => $sub->name,
						'ID'   => $sub->id,
						'IDPAR'=> $cat->id,
						'ACTIV'=> ($sat_id_actual == $cat->id ? "block" : "none"),
						'ACTM'=> ($sat_id_actual == $cat->id ? 'class="active2'.($cat_name_actual == $sub->key ? ' active"' : '"') : "")
	                ));
		            if ($sub->children)
		            {
		                $this->tpl->assignBlockVars('widget.cat.sub.has_child');
		                foreach ($sub->children as $subsub)
		                $this->tpl->assignBlockVars('widget.cat.sub.sub2', array(
		                    'KEY'  => $subsub->key,
		                    'NAME' => $subsub->name,
							'ID'   => $subsub->id,
							'IDPAR'=> $cat->id,
							'ACTIV'=> ($sat_id_actual == $cat->id ? "block" : "none"),
							'ACTM'=> ($sat_id_actual == $cat->id ? 'class="active2'.($cat_name_actual == $subsub->key ? ' active"' : '"') : "")
		                ));
		            }
                }
            }
        }
        if (!$cats->isEmpty())
            $this->tpl->assignBlockVars('widget.cats');
    }
}