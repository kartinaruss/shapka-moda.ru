<!-- BEGIN cats2 --><!-- BEGIN widget.cats -->
<div class="cats2 w3 border2">
    <div style="width:100%; height:32px; color:#ffffff; margin: 0px;"><h2><a href="./">Каталог</a></h2></div>
    <ul>
    <!-- BEGIN widget.cat -->
    <li  {widget.cat.ACTM} <!-- BEGIN widget.cat.has_child --> <!-- END widget.cat.has_child --> style="padding-left:13px;" id="ncat{widget.cat.ID}">
        <a href="catalog/{widget.cat.KEY}"><span style="width:100%;">{widget.cat.NAME}</span></a>
        <!-- BEGIN widget.cat.has_child -->
    </li>
            <!-- BEGIN widget.cat.sub -->
            <li {widget.cat.sub.ACTM} style="padding-left: 27px; display:{widget.cat.sub.ACTIV};"<!-- BEGIN widget.cat.sub.has_child --> <!-- END widget.cat.sub.has_child --> id="nparent{widget.cat.sub.IDPAR}_{widget.cat.sub.ID}">
                <a href="catalog/{widget.cat.sub.KEY}"><span>{widget.cat.sub.NAME}</span></a>
                <!-- BEGIN widget.cat.sub.has_child -->
            </li>
                    <!-- BEGIN widget.cat.sub.sub2 -->
                    <li {widget.cat.sub.sub2.ACTM} style="padding-left: 45px; display:{widget.cat.sub.sub2.ACTIV};" id="nparent{widget.cat.sub.sub2.IDPAR}_{widget.cat.sub.sub2.ID}"><span><a href="catalog/{widget.cat.sub.sub2.KEY}">{widget.cat.sub.sub2.NAME}</a></span></li>
                    <!-- END widget.cat.sub.sub2 -->

                <!-- END widget.cat.sub.has_child -->

            <!-- END widget.cat.sub -->

        <!-- END widget.cat.has_child -->

    <!-- END widget.cat -->
</ul></div>
<!-- END widget.cats --><!-- END cats2 -->