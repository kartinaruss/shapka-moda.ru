<!-- BEGIN cats1 --><!-- BEGIN widget.cats -->
<div class="cats w"><ul>
    <!-- BEGIN widget.cat -->
    <li<!-- BEGIN widget.cat.has_child --> class="active"<!-- END widget.cat.has_child -->>
        <span><a href="catalog/{widget.cat.KEY}">{widget.cat.NAME}</a></span>
        <!-- BEGIN widget.cat.has_child -->
        <ul>
            <!-- BEGIN widget.cat.sub -->
            <li<!-- BEGIN widget.cat.sub.has_child --> class="active"<!-- END widget.cat.sub.has_child -->>
                <span><a href="catalog/{widget.cat.sub.KEY}">{widget.cat.sub.NAME}</a></span>
                <!-- BEGIN widget.cat.sub.has_child -->
                <ul>
                    <!-- BEGIN widget.cat.sub.sub2 -->
                    <li><span><a href="catalog/{widget.cat.sub.sub2.KEY}">{widget.cat.sub.sub2.NAME}</a></span></li>
                    <!-- END widget.cat.sub.sub2 -->
                </ul>
                <!-- END widget.cat.sub.has_child -->
            </li>
            <!-- END widget.cat.sub -->
        </ul>
        <!-- END widget.cat.has_child -->
    </li>
    <!-- END widget.cat -->
</ul></div>
<!-- END widget.cats --><!-- END cats1 -->