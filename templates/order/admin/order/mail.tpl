<form action="admin/order/mail/{ID}" method="post"><div class="oT2"><table><tbody>
    <tr><td colspan="2"><h3>Отправка письма заказчику</h3></td></tr>
    <tr>
        <td><span>Тема: <font color="red">*</font></span></td>
        <td>
            <div class="inputText"><i><b><input type="text" name="subject"/></b></i></div>
            <!-- BEGIN error_subject --><div class="error">{error_subject.MESSAGE}</div><!-- END error_subject -->
        </td>
    </tr>
    <tr>
        <td><span>Пару слов о товаре: <font color="red">*</font></span></td>
        <td><div class="textarea"><i><b><textarea name="body" cols="30" rows="10" style="height:100px;">Ваш заказ комплектуется, ожидайте доставку.</textarea></b></i></div></td>
    </tr>
    <tr>
       <td class="empty">&nbsp;</td>
       <td><div class="oActButtons">
           <a href="javascript:;" class="save">Отправить</a>
       </div></td>
    </tr>
</tbody></table></div></form>