<form action="feedback" method="post">
    <h3>Форма обратной связи</h3>
    <div class="oT2"><table style="width:400px;"><tbody>
        <tr>
            <td><span>Имя: <font color="red">*</font></span></td>
            <td>
                <div class="inputText"><i><b><input type="text" name="name" /></b></i></div>
                <!-- BEGIN error_name --><div class="error">{error_name.MESSAGE}</div><!-- END error_name -->
            </td>
        </tr>
        <tr>
            <td><span>Телефон: </span></td>
            <td><div class="inputText"><i><b><input type="text" name="phone" class="phone_number" rel="{PHONE_MASK}" /></b></i></div>
                <!-- BEGIN error_phone --><div class="error">{error_phone.MESSAGE}</div><!-- END error_phone -->
            </td>
        </tr>
        <tr>
            <td><span>E-mail: <font color="red">*</font></span></td>
            <td><div class="inputText"><i><b><input type="text" name="email" /></b></i></div>
                <!-- BEGIN error_email --><div class="error">{error_email.MESSAGE}</div><!-- END error_email -->
            </td>
        </tr>
        <tr>
            <td><span>Сообщение:</span></td>
            <td>
                <div class="textarea"><i><b><textarea name="message" cols="30" rows="10" style="height:100px;"></textarea></b></i></div>
                <!-- BEGIN error_message --><div class="error">{error_message.MESSAGE}</div><!-- END error_message -->
            </td>
        </tr>
        <tr>
            <td class="empty">&nbsp;</td>
            <td><div class="Buttons">
                <div class="button red send">Отправить</div>
            </div></td>
        </tr>
    </tbody></table></div>
</form>