<?php
if ( current_user_can('manage_options') ) {
//echo do_shortcode('[loggedin][xyz-ips snippet="doap-server-info"][/loggedin]');
echo do_shortcode('[doap_spoiler title="Doap.com Systems Monitor" style="simple" icon="chevron" anchor="recent-tags"][doap_tabs style="modern-dark" class="product-library"]<h2>DOAP Ecosystem Health</h2>

 [doap_tab title="Server Info"] 
<div class="server-graphs-small">Window must be at least 680px wide to show graphs.</div>
<div style="margin-left:15px;" class="server-graphs">
[xyz-ips snippet="server-info"] 
</div>
<div class="lp-sprite-v8cropped-default-logo2 alignright"></div>

[/doap_tab]
  
[doap_tab title="Fleet Servers"] <h5>Fleet Servers</h5>

<div class="server-graphs-small">Window must be at least 680px wide to show graphs.</div>
<div style="margin-left:15px;" class="server-graphs">
<iframe src="https://app.datadoghq.com/graph/embed?token=d6f80ab041c8373da9414fe191b7ce62516357dd90b601f710b369a1caba197b&height=300&width=600&legend=false" width="600" height="300" frameborder="0"></iframe>
</div>
<img src="http://doap.sinkjuice.com/wp-content/uploads/sites/12/2014/07/cropped-default-logo2.png" width="100" height="30" alt="DevOps and Platforms" class="alignright">
[/doap_tab]
          
  [doap_tab title="Database"]<h5>Database Activity</h5> <div class="server-graphs-small">Window must be at least 680px wide to show graphs.</div>
<div style="margin-left:15px;" class="server-graphs">
<iframe src="https://app.datadoghq.com/graph/embed?token=57ef15698b48a59972715d71c05a42fbce88bdfba530ab5dd00c6306000ff04f&height=300&width=600&legend=false" width="600" height="300" frameborder="0"></iframe>
</div>  
<img src="http://doap.sinkjuice.com/wp-content/uploads/sites/12/2014/07/cropped-default-logo2.png" width="100" height="30" alt="DevOps and Platforms" class="alignright">[/doap_tab]
  [doap_tab title="Load Balancer"]<h5>Load Balancer Stats</h5>
<div class="server-graphs-small">Window must be at least 680px wide to show graphs.</div>
<div style="margin-left:15px;" class="server-graphs">
<iframe src="https://app.datadoghq.com/graph/embed?token=b088c37b119e73ac6907a2d01ab4c554597522fda242426575093a6534df4645&height=300&width=600&legend=true" width="600" height="300" frameborder="0"></iframe>
</div> 
<img src="http://doap.sinkjuice.com/wp-content/uploads/sites/12/2014/07/cropped-default-logo2.png" width="100" height="30" alt="DevOps and Platforms" class="alignright">[/doap_tab]

[/doap_tabs]
[/doap_spoiler]'); 
}   
?>  

