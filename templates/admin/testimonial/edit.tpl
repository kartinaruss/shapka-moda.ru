<form action="admin/testimonial/edit/{ID}" method="post" enctype="multipart/form-data"><div class="oT2"><table><tbody>
    <tr> 
        <td><span>ФИО: <font color="red">*</font></span></td> 
        <td> 
            <div class="inputText"><i><b><input type="text" name="name" /></b></i></div> 
            <!-- BEGIN error_name --><div class="error">{error_name.MESSAGE}</div><!-- END error_name -->
        </td> 
    </tr> 
    <tr> 
        <td><span>Телефон:</span></td> 
        <td><div class="inputText"><i><b><input type="text" name="phone" /></b></i></div>
            <!-- BEGIN error_phone --><div class="error">{error_phone.MESSAGE}</div><!-- END error_phone -->
        </td> 
    </tr> 
    <tr> 
        <td><span>Город: <font color="red">*</font></span></td> 
        <td> 
            <div class="inputText"><i><b><input type="text" name="city" /></b></i></div> 
            <!-- BEGIN error_city --><div class="error">{error_city.MESSAGE}</div><!-- END error_city -->
        </td> 
    </tr>
    <tr> 
        <td><span>Должность:</span></td> 
        <td> 
            <div class="inputText"><i><b><input type="text" name="duties" /></b></i></div> 
            <!-- BEGIN error_duties --><div class="error">{error_duties.MESSAGE}</div><!-- END error_duties -->
        </td> 
    </tr>
    <tr> 
        <td><span>Сайт:</span></td> 
        <td> 
            <div style="width:50px;float:left;line-height: 23px;">http://</div>
            <div class="inputText" style="width:250px;float:left;"><i><b><input type="text" name="website" /></b></i></div> 
            <!-- BEGIN error_website --><div class="error">{error_website.MESSAGE}</div><!-- END error_website -->
        </td> 
    </tr>
    <tr> 
        <td><span>Отзыв: <font color="red">*</font></span></td> 
        <td> 
            <div class="textarea"><i><b><textarea name="message" cols="30" rows="10" style="height:200px;"></textarea></b></i></div>
            <!-- BEGIN error_message --><div class="error">{error_message.MESSAGE}</div><!-- END error_message --> 
        </td> 
    </tr>
    <tr>
        <td><span>Фотография:</span></td>
        <td>
            <div class="Picture">
                <!-- BEGIN no_picture -->
                <div class="addImage">
                    <span class="oFileLink"><i>Прикрепить</i><input type="file" name="file" size="40" rel="admin/testimonial/picture"/></span>
                </div>
                <!-- END no_picture -->
                <!-- BEGIN picture2 -->
                <div class="changeImage">
                    <img src="images/temp/{picture2.KEY}" alt="" title="" />
                    <span class="oFileLink"><i>Поменять</i><input type="file" name="file" size="40" rel="admin/testimonial/picture"/></span>
                </div>
                <!-- END picture2 -->
                <!-- BEGIN picture -->
                <div class="changeImage">
                    <img src="images/people/s/{picture.FILE}" alt="" title="" />
                    <span class="oFileLink"><i>Поменять</i><input type="file" name="file" size="40" rel="admin/testimonial/picture"/></span>
                </div>
                <!-- END picture -->
                <input type="hidden" name="pictureKey" default=""/>
            </div>
        </td>
    </tr>
    <!-- BEGIN picture -->
    <tr>
        <td><span></span></td>
        <td>
            <label><input type="checkbox" name="picture_delete" /> Удалить фотографию</label>
        </td>
    </tr>
    <!-- END picture -->
    <tr>
        <td><span>Аудио-файл .mp3:</span></td>
        <td><!-- BEGIN mp3 --><a href="files/{mp3.SRC}">{mp3.SRC}</a><!-- END mp3 -->
            <input type="file" name="file2"/>
            <!-- BEGIN error_file2 --><div class="error">{error_file2.MESSAGE}</div><!-- END error_file2 --> 
        </td>
    </tr>
    <!-- BEGIN mp3 -->
    <tr>
        <td><span></span></td>
        <td>
            <label><input type="checkbox" name="file_delete" /> Удалить аудио-файл</label>
        </td>
    </tr>
    <!-- END mp3 -->
    <tr>
        <td><span>Дата:</span></td>
        <td>
            <div class="inputText"><i><b><input type="text" name="date" class="datepicker" size="10"/></b></i></div>
            <div class="Example">Например: 25.02.2011 (используйте раскрывающийся календарь)</div>
            <!-- BEGIN error_date --><div class="error">{error_date.MESSAGE}</div><!-- END error_date -->
        </td>
    </tr>
    <tr>
        <td class="empty">&nbsp;</td>
        <td><div class="oActButtons">
            <a href="javascript:;" class="save">Сохранить изменения</a>
            <a href="javascript:;" class="cancel">Отмена</a>
        </div></td>
    </tr>
</tbody></table></div></form>