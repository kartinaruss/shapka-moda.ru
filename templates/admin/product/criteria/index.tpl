<!-- INCLUDE admin/header.tpl -->
<script type="text/javascript">
var tableCols = 4;
var pageKey = "product/criteria";
var pageClass  = "masterCats";
var message = {
    notice : {
        deleted:'Критерий "%s" успешно удален',
        added  :'Критерий успешно добавлен',
        edited :'Критерий успешно отредактирован'
    },
    confirm : {
        deleting:'Вы действительно хотите удалить критерий "%s"?'
    }
};
</script>
<script type="text/javascript" src="scripts/admin/table2.js"></script>
<div class="helpDescr">
    Здесь можно управлять критериями товаров для фильтра.
</div>
<div class="cats">
    <a href="admin/product/main">Товары на главной</a>
    <span>Критерии</span>
    <a href="admin/product/category">Категории</a>
    <a href="admin/product/all">Все товары</a>
    <a href="admin/product/export/csv">Экспорт</a>
    <a href="admin/product/import/csv">Импорт</a>
</div>
<div class="catExt">
    <div class="masterCats">
        <div class="oActButtons"><a href="admin/product/criteria/add" class="add">Добавить группу критериев</a></div>
        <div class="master oEditor"><!-- INCLUDE admin/product/criteria/table.tpl --></div>
    </div>
</div>
<!-- INCLUDE admin/footer.tpl -->