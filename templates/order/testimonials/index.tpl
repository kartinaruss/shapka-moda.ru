<!-- INCLUDE header.tpl -->
<div class="testimonials w border2">
    <h2>Отзывы</h2>
    <!-- BEGIN tst -->
    <div class="item">
        <!-- BEGIN tst.picture --><div class="L"><a href="images/people/l/{tst.picture.SRC}" class="fancybox"><img src="images/people/s/{tst.picture.SRC}" alt=""/></a></div><!-- END tst.picture -->
        <div<!-- BEGIN tst.picture --> class="R"<!-- END tst.picture -->>
            <div class="text">&laquo;{tst.MESSAGE}&raquo;</div>
            <!-- BEGIN tst.audio -->
            <div class="audio">
                <object height="25" width="250" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,32,18" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" wmode="transparent">
                    <param name="FlashVars" value="playerID=1&amp;bg=0xB01A33&amp;leftbg=0xB3B3B3&amp;lefticon=0xoooooo&amp;rightbg=0xB01A33&amp;rightbghover=0x999999&amp;rightcon=0xoooooo&amp;righticonhover=0xffffff&amp;text=0xffffff&amp;slider=0x8CA4C0&amp;track=0x8CA4C0&amp;border=0x666666&amp;loader=0x9FFFB8&amp;loop=no&amp;autostart=no&amp;soundFile=files/{tst.audio.SRC}&amp;">
                    <param name="quality" value="high">
                    <param name="menu" value="false">
                    <param name="wmode" value="transparent">
                    <param name="src" value="flash/player.swf">
                    <embed height="25" width="250" src="flash/player.swf" wmode="transparent" menu="false" quality="high" flashvars="playerID=1&amp;bg=0xB01A33&amp;leftbg=0xB3B3B3&amp;lefticon=0xoooooo&amp;rightbg=0xB01A33&amp;rightbghover=0x999999&amp;rightcon=0xoooooo&amp;righticonhover=0xffffff&amp;text=0xffffff&amp;slider=0x8CA4C0&amp;track=0x8CA4C0&amp;border=0x666666&amp;loader=0x9FFFB8&amp;loop=no&amp;autostart=no&amp;soundFile=files/{tst.audio.SRC}&amp;" type="application/x-shockwave-flash">
                </object>
            </div>
            <!-- END tst.audio -->
            <div class="author">{tst.NAME},<br/><!-- BEGIN tst.duties -->{tst.DUTIES}, <!-- END tst.duties -->{tst.CITY}
                <!-- BEGIN tst.website --><br/><a href="http://{tst.WEBSITE}" target="_blank" rel="nofollow">{tst.WEBSITE}</a><!-- END tst.website -->
            </div>
        </div>
    </div>
    <!-- END tst -->
    <div class="button gray write"><span>Оставить отзыв</span></div>
</div>
<!-- INCLUDE footer.tpl -->