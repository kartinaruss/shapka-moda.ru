<form action="cart/order" method="post" style="font-size: 15px">
    <div class="Title">Оформление заказа</div>
    <div class="Descr successHide">Заполните, пожалуйста, поля ниже, чтобы мы могли связаться с вами</div>
    <div class="oT2 successHide"><table><tbody>
        <tr>
            <td><span>Ваше имя: <font color="red">*</font></span></td>
            <td>
                <div class="inputText"><i><b><input type="text" name="name" /></b></i></div>
                <!-- BEGIN error_name --><div class="error">{error_name.MESSAGE}</div><!-- END error_name -->
            </td>
        </tr>
        <tr>
            <td><span>Телефон: <font color="red">*</font></span></td>
            <td><div class="inputText"><i><b><input type="text" name="phone" class="phone_number" rel="{PHONE_MASK}" /></b></i></div>
                <!-- BEGIN error_phone --><div class="error">{error_phone.MESSAGE}</div><!-- END error_phone -->
            </td>
        </tr>
<!--        <tr>
            <td><span>E-mail: </span></td>
            <td><div class="inputText"><i><b><input type="text" name="email" /></b></i></div>
                <!-- BEGIN error_email --><div class="error">{error_email.MESSAGE}</div><!-- END error_email -->
            </td>
        </tr>  -->
		<input type="hidden" name="email" value="">
        <input type="hidden" name="address" value="">
        <input type="hidden" name="message" value="">
        <tr>
            <td class="empty">&nbsp;</td>
            <td><div class="Buttons">
                <div class="button red pink send">Заказать</div>
                <div class="button gray cancel">Отмена</div>
            </div></td>
        </tr>
		<tr>
            <td></td>
            <td><div style="font-size: 11px; color: #777777">Нажимая кнопку «Заказать», вы принимаете условия <a href="./oferta" target="_blank" style="color: #777777">Публичной оферты</a></div></td>
        </tr>
    </tbody></table></div>
</form>

<!-- BEGIN metrika -->
<script type="text/javascript">
yaCounter{metrika.COUNTER_ID}.reachGoal('BASKET_2');
</script>
<!-- END metrika -->