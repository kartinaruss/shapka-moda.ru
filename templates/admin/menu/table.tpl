<table class="list" id="list" rel="main"><tbody>
    <!-- BEGIN menu -->
    <tr id="{menu.ID}">
        <td class="move move_main" title="Переместить"><i>&nbsp;</i></td>
        <td><div class="actions">
            <a href="admin/menu/edit/{menu.ID}" class="edit" title="Редактировать"><i>Редактировать</i></a>
            <a href="admin/menu/disable/{menu.ID}" class="show" title="Скрыть с сайта" <!-- BEGIN menu.disabled -->style="display:none;"<!-- END menu.disabled -->><i>Скрыть с сайта</i></a>
            <a href="admin/menu/enable/{menu.ID}" class="hide" title="Показывать на сайте"<!-- BEGIN menu.enabled -->style="display:none;"<!-- END menu.enabled -->><i>Показывать на сайте</i></a>
            <a href="admin/menu/delete/{menu.ID}" class="del" title="Удалить"><i>Удалить</i></a>
        </div></td>
        <td>
            <div class="parent">
                <div class="name iName"><a href="{menu.LINK}">{menu.TITLE}</a></div>
            </div>
            <!-- BEGIN menu.has_child -->
            <div class="slaves">
                <div class="master oEditor">
                    <table class="list" id="list" rel="sub"><tbody>
                        <!-- BEGIN menu.sub -->
                        <tr id="{menu.sub.ID}">
                            <td class="move move_sub" title="Переместить"><i>&nbsp;</i></td>
                            <td><div class="actions">
                                <a href="admin/menu/edit/{menu.sub.ID}" class="edit" title="Редактировать"><i>Редактировать</i></a>
                                <a href="admin/menu/disable/{menu.sub.ID}" class="show" title="Скрыть с сайта" <!-- BEGIN menu.sub.disabled -->style="display:none;"<!-- END menu.sub.disabled -->><i>Скрыть с сайта</i></a>
                                <a href="admin/menu/enable/{menu.sub.ID}" class="hide" title="Показывать на сайте"<!-- BEGIN menu.sub.enabled -->style="display:none;"<!-- END menu.sub.enabled -->><i>Показывать на сайте</i></a>
                                <a href="admin/menu/delete/{menu.sub.ID}" class="del" title="Удалить"><i>Удалить</i></a>
                            </div></td>
                            <td>
                                <div class="parent">
                                    <div class="name iName"><a href="{menu.sub.LINK}">{menu.sub.TITLE}</a></div>
                                </div>
                            </td>
                        </tr>
                        <!-- END menu.sub -->
                    </tbody></table>
                </div>
            </div>
            <!-- END menu.has_child -->
            <div class="oActButtons"><a href="admin/menu/add/{menu.ID}" class="add">Добавить подпункт меню</a></div>
        </td>
    </tr>
    <!-- END menu -->
</tbody></table>