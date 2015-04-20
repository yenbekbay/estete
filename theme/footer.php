 </section>
 
 <footer id="footer">
 <section id="footer-notes">
 
 <ul class="social">
  <div id="social-footer">
  <li><a class="rss" href="http://estete.net/feed/" title="RSS фид"></a></li>
  <li><a class="tw" href="http://twitter.com/estete_net/" title="Twitter"></a></li>
  <li><a class="vk" href="http://vk.com/estete_net" title="ВКонтакте"></a></li>
  <li><a class="fb" href="http://facebook.com/estete.net/" title="Facebook"></a></li>
  </div>
 </ul> 
 
 <ul class="footer_links">
  <li><a href="http://estete.net/about/" title="">О проекте</a>/</li>
  <li><a href="http://estete.net/archives/" title="">Архив</a>/</li>
  <li><a href="http://estete.net/sitemap/" title="">Карта сайта</a>/</li>
  <li><a href="http://estete.net/copiny/" title="">Вопросы/отзывы</a></li>
 </ul> 
 
 <div id="footer-notes-inner">
 <div class="copyright"><a class="copyright-image" href="http://estete.net/"></a>© 2011-2012, Estete.
 <p>Использование материалов с сайта разрешено только при наличии активной ссылки на источник.</p></div> 
 
 <div id="like-buttons">
 
  <div id="google">
  <div class="g-plusone" data-size="medium" data-href="<?php echo get_option('home'); ?>"></div>
  </div>
  
  <div id="fb">
  <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Ffacebook.com%2Festete.net&amp;layout=button_count&amp;show_faces=true&amp;width=100&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=21&amp;locale=en_US" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
  </div>
  
  <div id="vk">
  <div id="vk_like-footer"></div>
  <script type="text/javascript">
   VK.Widgets.Like("vk_like-footer", {type: "mini", height: 20, pageUrl: "<?php echo get_option('home'); ?>"});
  </script>
  </div> 
  
 </div>
 
 <script type="text/javascript">
 (function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter8392273 = new Ya.Metrika({id:8392273,
                    clickmap:true,
                    accurateTrackBounce:true});
        } catch(e) {}
    });
    
    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f);
    } else { f(); }
 })(document, window, "yandex_metrika_callbacks");
 </script>
 
 <noscript><div><img src="//mc.yandex.ru/watch/8392273" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
 <?php global $user_ID; if( $user_ID ) : ?>
 <?php if( current_user_can('level_2') ) : ?>
 <div class="metrika">
 <a href="http://metrika.yandex.ru/stat/?id=8392273&amp;from=informer"
 target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/8392273/3_0_FFFFFFFF_FFFFFFFF_0_pageviews"
 style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:8392273,type:0,lang:'ru'});return false}catch(e){}"/></a>
 </div>
 <?php else : ?>
 <?php endif; ?>
 <?php endif; ?> 
 
 </section>
 </footer>
 
 <div id="wp_footer">
 <?php wp_footer(); ?>
 </div>
 
 </div>
</body>
</html>