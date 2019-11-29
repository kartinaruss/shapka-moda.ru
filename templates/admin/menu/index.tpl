<!-- INCLUDE admin/header.tpl -->
<script type="text/javascript">
var tableCols = 4;
var pageKey  = "menu"; 
var pageClass  = "masterCats";
var message = {
    notice : {
        deleted:'Пункт "%s" успешно удален из меню',
        added  :'В меню добавлен новый пункт',
        edited :'Пункт меню успешно отредактирован'
    },
    confirm : {
        deleting:'Вы действительно хотите удалить пункт "%s" из меню?'
    }
};
</script>
<script type="text/javascript" src="scripts/admin/table2.js"></script>
<div class="helpDescr">В данном разделе вы можете управлять пунктами меню: добавлять, изменять, менять их местами.<br/>
Для того, чтобы пункт меню ссылался на нужную страницу, необходимо в качестве ссылки указать ссылку на соответствующую страницу.</div>
<div class="catExt">
    <div class="masterCats">
        <div class="oActButtons"><a href="admin/menu/add" class="add">Добавить пункт меню</a></div>
        <div class="master oEditor"><!-- INCLUDE admin/menu/table.tpl --></div>
    </div>
</div>
<!-- INCLUDE admin/footer.tpl -->