<!-- INCLUDE admin/header.tpl -->
<script type="text/javascript">
var tableCols = 8;
var pageKey  = "product/{CATEGORY_ID}"; 
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
<script type="text/javascript" src="scripts/admin/table.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    // Блок добавления
    $(".product>.actions .add").click(initAdd); 
    // Дополнительные возможности
    setFeatures(function(block){
        $(".chosen",block).chosen({no_results_text: "Ничего не найдено по запросу"});
        var table = $(".params>.list>table");
        // Перемещение строк таблицы
        table.tableDnD({
            onDragClass: "dragRow",
            onDragStart: function(table, row) {
                
            },
            onDrop: function(table, row) {
                
            },
            dragHandle: "move",
            scrollAmount: 100
        });
        // Удаление строк таблицы
        $(".actions a.remove",table).live('click',function(){
            $(this).parents('tr:eq(0)').remove();
        });
        // Добавление строк таблицы
        $(".actions a.enter",table).click(function(){
            var tr = $(this).parents('tr:eq(0)');
            tr.before("<tr>"+$("tr.new",table).html()+"</tr>");
            tr.find("input").each(function(i,item){
                tr.prev().find("input").eq(i).val($(item).val());
                $(item).val('');
            });
        });
    });
    // Таблица
    initTable();
    initSearch();
    // Выбор категории
    $(".catSelect select").change(function(){
        location.href = 'admin/product/'+$(this).val();
    });

    $("#list input").change(function(){
        var input = $(this);
        $.post("admin/product/save/"+$(this).parents('tr').attr('id'),{ 'key':$(this).attr('name'),'value':$(this).val() },function(){
            input.css({'background':'#ccc'});
            setTimeout(function(){
                input.css({'background':'#fff'});
            },1000);
        });
    });
});
</script>
<div class="helpDescr">В данном разделе вы можете управлять списком товаров каталога. Для задания порядка товаров перейдите в нужную категорию.</div>
<div class="cats">
    <div class="catSelect">
        Категория: <select name="category"><option value="all">--все--</option><option value="main">--на главной--</option>$cats</select>
    </div>
    <a href="admin/product/main">Товары на главной</a>
    <a href="admin/product/category">Категории</a>
    <a href="admin/product/criteria">Критерии</a>
    <!-- BEGIN tab_all -->
    <span style="background:#ffffff;">Все товары</span>
    <!-- END tab_all -->
    <!-- BEGIN tab_cat -->
    <a href="admin/product/all">Все товары</a>
    <span style="background:#ffffff;">{CATEGORY_NAME}</span>
    <!-- END tab_cat -->
    <a href="admin/product/export/csv">Экспорт</a>
    <a href="admin/product/import/csv">Импорт</a>
</div>
<div class="product oEditor catExt">
    <!-- BEGIN tab_all -->
    <div class="search" style="float:right;width:250px;padding-top:20px;">
        <div class="oEditItem">
            <form action="admin/product/search" method="post"><div class="oTable"><table><tbody>
            <tr>
                <td><div class="inputText" style="width:170px;"><i><b><input type="text" name="query" value="{SEARCH_QUERY}"/></b></i></div>
                </td>
                <td><div class="oActButtons" style="padding:0;">
                    <a href="javascript:;" class="save" style="height:23px;line-height:23px;">Поиск</a>
                </div></td>
            </tr>
            </tbody></table></div></form>
        </div>
    </div>
    <!-- END tab_all -->
    <div class="actions"><a href="javascript:;" class="add">Добавить товар</a></div>
    <div class="addNode" style="display:none;"></div>
    <div class="list oEditor"><!-- INCLUDE admin/product/table.tpl --></div>
</div>
<!-- INCLUDE admin/footer.tpl -->