<!-- INCLUDE admin/header.tpl -->
<script type="text/javascript">
$(document).ready(function() {
	$(".in").sortable({
        items: ".block",
        //handle: ".name",
        connectWith: ".in",
        placeholder: "ui-state-highlight",
        stop: function(event,ui){  }
    });
    $( ".set .block").draggable({
        connectToSortable: ".in",
        helper: "clone",
        revert: true,
        stop: function(event,ui){ collectConstructorData(); }
    });
    $(".blocks>table>tbody").sortable({
        items: "tr",
        //handle: ".name",
        placeholder: "ui-state-highlight",
        stop: function(event,ui){  }
    });
});
</script>
<style>
.blocks>h2{font-size:22px;text-align:center;padding-bottom:10px;}
.blocks>table td{height:50px;width:33%;border:1px solid #ccc;vertical-align:top;}
.blocks>table td.disabled{background:whitesmoke;text-align:center;vertical-align:middle;color:#ddd;font-size:30px;font-weight:bold;}
.blocks .block{background:#dedede;text-align:center;margin:5px;padding:10px 20px;color:#999;font-size:18px;font-weight:bold;cursor:pointer;}
.ui-state-highlight { background:orange;margin:5px;height:37px; }
.blocks .catalog{height:200px;}

.set{width:200px;float:left;}
.set .block{font-size:14px;padding:5px;}

.framework{width:600px;margin-left:300px;}
</style>
<div class="helpDescr"></div>
<div class="set blocks oEditor">
    <h2>Набор блоков</h2>
    <table>
        <tr>
            <td>
                <div class="block">Меню</div>
                <div class="block">Гарантия</div>
                <div class="block">Акция</div>
                <div class="block">Скидки</div>
                <div class="block">Только что купили</div>
                <div class="block">Спецпредложение</div>
                <div class="block">Категории каталога</div>
                <div class="block">Сообщество</div>
            </td>
        </tr>
    </table>
</div>
<div class="framework blocks oEditor">
    <h2>Каркас сайта</h2>
    <table>
        <tr>
            <td colspan="3" class="in"><div class="block">Блок</div></td>
        </tr>
        <tr>
            <td class="in"><div class="block">Блок</div></td>
            <td class="in"><div class="block">Блок</div></td>
            <td class="in"></td>
        </tr>
        <tr>
            <td class="in"></td>
            <td class="in"></td>
            <td class="in"></td>
        </tr>
        <tr>
            <td colspan="2" class="in"></td>
            <td class="in"></td>
        </tr>
        <tr>
            <td colspan="3" class="in"></td>
        </tr>
        <tr>
            <td colspan="2" class="catalog disabled">Каталог</td>
            <td class="in"><div class="block">Блок</div></td>
        </tr>
        <tr>
            <td colspan="3" class="disabled">Подвал</td>
        </tr>
    </table>
</div>
<!-- INCLUDE admin/footer.tpl -->