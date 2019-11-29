<form action="admin/menu/add/{ID}" method="post">
    <div class="typPopTitle">Добавление пункта меню</div>
    <div class="addNewCat">
        <div class="oT2"><table><tbody>
		    <tr>
		        <td><span>Название:</span></td>
		        <td><div class="inputText"><i><b><input type="text" name="title"/></b></i></div>
		            <!-- BEGIN error_title --><div class="error">{error_title.MESSAGE}</div><!-- END error_title -->
		        </td>
		    </tr>
		    <tr>
		        <td><span>Ссылка:</span></td>
		        <td>
		            <div class="inputText"><i><b><input type="text" name="link"/></b></i></div>
		            <!-- BEGIN error_link --><div class="error">{error_link.MESSAGE}</div><!-- END error_link -->
		        </td>
		    </tr>
            <tr>
                <td><span>Вложить в:</span></td>
                <td>
                    <div class="select"><i><b><u><select name="parent_id"><option value="0"></option>$categories</select></u></b></i></div>
                    <!-- BEGIN error_parent_id --><div class="error">{error_parent_id.MESSAGE}</div><!-- END error_parent_id -->
                </td>
            </tr>
            <tr>
                <td class="empty">&nbsp;</td>
                <td><div class="Buttons">
                    <div class="oBut Big green save"><input type="submit" value="Добавить"/></div>
                    <div class="oBut Big cancel"><input type="submit" value="Отмена"/></div>
                </div></td>
            </tr>
        </tbody></table></div>
    </div>
</form>