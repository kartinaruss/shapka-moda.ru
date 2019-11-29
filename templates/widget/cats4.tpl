<!-- BEGIN cats4 --><!-- BEGIN widget.cats -->
<div class="widget catalog">
    <div class="widget-title">
        <h2><a>Каталог</a></h2>
    </div>

    <ul>
    <!-- BEGIN widget.cat -->
    <li>
        <div class="L">
            <!-- BEGIN widget.cat.picture --><a href="catalog/{widget.cat.KEY}"><img src="images/product/category/{widget.cat.picture.SRC}" alt="{widget.cat.NAME}"/></a><!-- END widget.cat.picture -->
        </div>
        <div class="R">
            <a href="catalog/{widget.cat.KEY}"><b>{widget.cat.NAME}</b></a><br/>
            <!-- BEGIN widget.cat.has_child -->
            <!-- BEGIN widget.cat.sub [SEPARATOR=, ] --><a href="catalog/{widget.cat.sub.KEY}">{widget.cat.sub.NAME}</a><!-- END widget.cat.sub -->
            <!-- END widget.cat.has_child -->
        </div>
    </li>
    <!-- END widget.cat -->
</ul></div>
<!-- END widget.cats --><!-- END cats4 -->