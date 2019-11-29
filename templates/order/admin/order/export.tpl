<!-- INCLUDE admin/header.tpl -->
<script type="text/javascript">
$(document).ready(function() {
    $('.datepicker').datepicker({
        dateFormat: "dd.mm.yy",
        changeMonth: true
    });
});
</script>
<div class="cats">
    <a href="admin/order">Заказы</a>
    <span style="background:#ffffff;">Экспорт</span>
    <a href="admin/stuff/sms">SMS-уведомления</a>
</div>
<div class="catExt feedback oEditor">
    <form action="admin/order/export" method="post">
        <div class="oT2 oEditItem"><table>
		    <tbody>
		        <tr><td colspan="2"><h3>Экспорт заказов</h3></td></tr>
		        <tr>
		            <td><span>Период:</span></td>
		            <td>
		                <div style="width:20px;float:left;">с</div><div class="inputText" style="width:120px;float:left;"><i><b><input type="text" name="from" class="datepicker"/></b></i></div>
                        <div style="width:20px;float:left;">по</div><div class="inputText" style="width:120px;float:left;"><i><b><input type="text" name="to" class="datepicker"/></b></i></div>
		            </td>
		        </tr>
		        <tr>
		            <td class="empty">&nbsp;</td>
		            <td>
		                <div class="oActButtons">
		                    <input type="submit" name="submit" value="Скачать"/>
		                </div>
		            </td>
		        </tr>
		        <tr>
		            <td><span></span></td>
		            <td></td>
		        </tr>
		    </tbody>
		</table></div>
    </form>
</div>
<!-- INCLUDE admin/footer.tpl -->