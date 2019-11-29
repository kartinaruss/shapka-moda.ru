<table class="list" id="list" rel="main"><tbody>
    <!-- BEGIN criteria -->
    <tr id="{criteria.ID}">
        <td class="move move_main" title="Переместить"><i>&nbsp;</i></td>
        <td><div class="actions">
            <a href="admin/product/criteria/edit/{criteria.ID}" class="edit" title="Редактировать"><i>Редактировать</i></a>
            <a href="admin/product/criteria/disable/{criteria.ID}" class="show" title="Скрыть с сайта" <!-- BEGIN criteria.disabled -->style="display:none;"<!-- END criteria.disabled -->><i>Скрыть с сайта</i></a>
            <a href="admin/product/criteria/enable/{criteria.ID}" class="hide" title="Показывать на сайте"<!-- BEGIN criteria.enabled -->style="display:none;"<!-- END criteria.enabled -->><i>Показывать на сайте</i></a>
            <a href="admin/product/criteria/delete/{criteria.ID}" class="del" title="Удалить"><i>Удалить</i></a>
        </div></td>
        <td>
            <div class="parent">
                <div class="name iName"><a href="javascript:;">{criteria.NAME}</a></div>
            </div>
            <!-- BEGIN criteria.has_child -->
            <div class="slaves">
                <div class="master oEditor">
                    <table class="list" id="list" rel="sub"><tbody>
                        <!-- BEGIN criteria.sub -->
                        <tr id="{criteria.sub.ID}">
                            <td class="move move_sub" title="Переместить"><i>&nbsp;</i></td>
                            <td><div class="actions">
                                <a href="admin/product/criteria/edit/{criteria.sub.ID}" class="edit" title="Редактировать"><i>Редактировать</i></a>
                                <a href="admin/product/criteria/disable/{criteria.sub.ID}" class="show" title="Скрыть с сайта" <!-- BEGIN criteria.sub.disabled -->style="display:none;"<!-- END criteria.sub.disabled -->><i>Скрыть с сайта</i></a>
                                <a href="admin/product/criteria/enable/{criteria.sub.ID}" class="hide" title="Показывать на сайте"<!-- BEGIN criteria.sub.enabled -->style="display:none;"<!-- END criteria.sub.enabled -->><i>Показывать на сайте</i></a>
                                <a href="admin/product/criteria/delete/{criteria.sub.ID}" class="del" title="Удалить"><i>Удалить</i></a>
                            </div></td>
                            <td>
                                <div class="parent">
                                    <div class="name iName"><a href="javascript:;">{criteria.sub.NAME}</a></div>
                                </div>
                                <!-- BEGIN criteria.sub.has_child -->
                                <div class="slaves">
                                    <div class="master oEditor">
                                        <table class="list" id="list" rel="subsub"><tbody>
                                            <!-- BEGIN criteria.sub.far -->
                                            <tr id="{criteria.sub.far.ID}">
                                                <td class="move move_subsub" title="Переместить"><i>&nbsp;</i></td>
                                                <td><div class="actions">
                                                    <a href="admin/product/criteria/edit/{criteria.sub.far.ID}" class="edit" title="Редактировать"><i>Редактировать</i></a>
                                                    <a href="admin/product/criteria/disable/{criteria.sub.far.ID}" class="show" title="Скрыть с сайта" <!-- BEGIN criteria.sub.far.disabled -->style="display:none;"<!-- END criteria.sub.far.disabled -->><i>Скрыть с сайта</i></a>
                                                    <a href="admin/product/criteria/enable/{criteria.sub.far.ID}" class="hide" title="Показывать на сайте"<!-- BEGIN criteria.sub.far.enabled -->style="display:none;"<!-- END criteria.sub.far.enabled -->><i>Показывать на сайте</i></a>
                                                    <a href="admin/product/criteria/delete/{criteria.sub.far.ID}" class="del" title="Удалить"><i>Удалить</i></a>
                                                </div></td>
                                                <td>
                                                    <div class="parent">
                                                        <div class="name iName"><a href="admin/product/{criteria.sub.far.ID}">{criteria.sub.far.NAME}</a></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- END criteria.sub.far -->
                                        </tbody></table>
                                    </div>
                                </div>
                                <!-- END criteria.sub.has_child -->
                            </td>
                        </tr>
                        <!-- END criteria.sub -->
                    </tbody></table>
                </div>
            </div>
            <!-- END criteria.has_child -->
            <div class="oActButtons"><a href="admin/product/criteria/add/{criteria.ID}" class="add">Добавить критерий</a></div>
        </td>
    </tr>
    <!-- END criteria -->
</tbody></table>