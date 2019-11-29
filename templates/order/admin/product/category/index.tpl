<!-- INCLUDE admin/header.tpl -->
<script type="text/javascript">
var tableCols = 4;
var pageKey = "product/category";
var pageClass  = "masterCats";
var message = {
    notice : {
        deleted:'Категория "%s" успешно удалена',
        added  :'Категория успешно добавлена',
        edited :'Категория успешно отредактирована'
    },
    confirm : {
        deleting:'Вы действительно хотите удалить категорию "%s"?'
    }
};
</script>
<script type="text/javascript" src="scripts/admin/table2.js"></script>
<div class="helpDescr">
    Здесь можно управлять категориями каталога. Для добавления товаров выберите одну из категорий.
</div>
<div class="cats">
    <a href="admin/product/main">Товары на главной</a>
    <span>Категории</span>
     <a href="admin/product/criteria">Критерии</a>
    <a href="admin/product/all">Все товары</a>
    <a href="admin/product/export/csv">Экспорт</a>
    <a href="admin/product/import/csv">Импорт</a>
</div>
<div class="catExt">
    <div class="masterCats">
        <div class="oActButtons"><a href="admin/product/category/add" class="add">Добавить категорию</a></div>
        <div class="master oEditor"><!-- INCLUDE admin/product/category/table.tpl --></div>
    </div>
</div>
<!-- INCLUDE admin/footer.tpl -->