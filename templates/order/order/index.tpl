<form action="order/{ID}" method="post"> 
    <div class="Title">Заказать &laquo;{PRODUCT_NAME}&raquo;</div> 
    <div class="Descr successHide">Заполните, пожалуйста, поля ниже, чтобы мы могли связаться с вами</div> 
    <div class="oT2 successHide"><table><tbody> 
        <tr> 
            <td><span>Ф.И.О.: <font color="red">*</font></span></td> 
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
        <tr> 
            <td><span>E-mail: </span></td> 
            <td><div class="inputText"><i><b><input type="text" name="email" /></b></i></div>
                <!-- BEGIN error_email --><div class="error">{error_email.MESSAGE}</div><!-- END error_email -->
            </td> 
        </tr>  
        <tr> 
            <td><span>Адрес доставки:<br/>(с индексом)</span></td> 
            <td> 
                <div class="textarea"><i><b><textarea name="address" cols="30" rows="10" style="height:50px;"></textarea></b></i></div>
                <!-- BEGIN error_address --><div class="error">{error_address.MESSAGE}</div><!-- END error_address --> 
            </td> 
        </tr>
        <tr> 
            <td><span>Комментарий:</span></td> 
            <td> 
                <div class="textarea"><i><b><textarea name="message" cols="30" rows="10" style="height:50px;"></textarea></b></i></div>
                <!-- BEGIN error_message --><div class="error">{error_message.MESSAGE}</div><!-- END error_message --> 
            </td> 
        </tr>
        <tr> 
            <td class="empty">&nbsp;</td> 
            <td><div class="Buttons"> 
                <div class="button red send">Заказать</div> 
                <div class="button gray cancel">Отмена</div> 
            </div></td> 
        </tr> 
    </tbody></table></div>
</form>