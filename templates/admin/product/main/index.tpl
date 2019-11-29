<!-- INCLUDE admin/header.tpl -->
<script:no-cache type="text/javascript">
var tableCols = 8;
var pageKey  = "product/main"; 
var pageClass = "product";
var addButtonClass = "addNode";
var message = {
    notice : {
        deleted:'Товар "%s" успешно удален из списка',
        added  :'В список добавлен новый товар',
        edited :'Данные товара успешно отредактированы'
    },
    confirm : {
        deleting:'Вы действительно хотите удалить товар "%s" из списка?'
    }
};
</script>
<script:no-cache type="text/javascript" src="scripts/admin/table.js"></script>
<script:no-cache type="text/javascript">
$(document).ready(function() {
    // Таблица
    initTable();
    // Выбор категории
    $(".catSelect select").change(function(){
        location.href = 'admin/product/'+$(this).val();
    }); 
    // Дополнительные возможности
    setFeatures(function(block){
        $(".chosen",block).chosen({no_results_text: "Ничего не найдено по запросу"});
    });
});
</script>
<div class="helpDescr">В данном разделе вы можете управлять списком товаров на главной странице</div>
<div class="cats">
    <div class="catSelect">
        Категория: <select name="category"><option value="all">--все--</option><option value="main">--на главной--</option>$cats</select>
    </div>
    <span style="background:#ffffff;">Товары на главной</span>
    <a href="admin/product/category">Категории</a>
    <a href="admin/product/criteria">Критерии</a>
    <a href="admin/product/all">Все товары</a>
    <a href="admin/product/export/csv">Экспорт</a>
    <a href="admin/product/import/csv">Импорт</a>
</div>
<div class="product oEditor catExt">
    <div class="addNode"></div>
    <div class="list oEditor"><!-- INCLUDE admin/product/main/table.tpl --></div>
</div>
<!-- INCLUDE admin/footer.tpl -->