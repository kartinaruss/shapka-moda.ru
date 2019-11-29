<form action="call" method="post"> 
    <div class="Title">Заказать звонок/консультацию</div> 
    <div class="Descr successHide">Заполните, пожалуйста, поля ниже, чтобы мы могли связаться с вами</div> 
    <div class="oT2 successHide"><table><tbody> 
        <tr> 
            <td><span>Имя: <font color="red">*</font></span></td> 
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
		<input type="hidden" name="message" value="">
		<input type="hidden" name="email" value="">
        <tr> 
            <td class="empty">&nbsp;</td> 
            <td><div class="Buttons"> 
                <div class="button red send">Позвоните мне</div> 
                <div class="button gray cancel">Отмена</div> 
            </div></td> 
        </tr> 
    </tbody></table></div>
</form>