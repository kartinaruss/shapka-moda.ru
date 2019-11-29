<?php
return
array(
    array(
        'id'        => 'abtest',
        'name'		=> 'see_more',
        'active' => true, //  <--- false
        'variants'  => array(
            array( 'id' => 'v0'),
            array( 'id' => 'v1'),
        ),
    ),
);
// кнопка 'Смотреть еще' для подгрузки товаров в каталоге и на главной
// новый методы see_moreAction в controllers/Index.php, controllers/Catalog.php  и шаблоны templates/see_more.tpl, templates/catalog/see_more.tpl  
// [abtest_v1] в templates/index.tpl, templates/catalog/index.tpl, footer.tpl
?>
