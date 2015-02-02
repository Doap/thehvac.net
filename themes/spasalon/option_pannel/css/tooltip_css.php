<style>
/* =Tooltips style
========================================================================*/

.icon {
	display: inline-block;
	width: 16px;
	height: 16px;
	position: relative;
	padding: 0 4px 0 0;	

	
	background: url(<?php echo get_template_directory_uri().'/option_pannel/images/icons.png'; ?>) no-repeat;
}

.tooltip {
	display: none;
	width: 200px;
	position: absolute;
	padding: 10px;
	line-height:20px;
	margin: 4px 0 0 4px;
	top: 0;
	
	left: 16px;
	border: 1px solid #464646;
	border-radius: 5px;
	background: #bedffe;
	font-size: 13px;
	box-shadow: 0 1px 2px -1px #21759B;
	z-index: 999;
}

/* Icons Sprite Position */

.help {
	background-position: 0 0;
	float:right;
}

.warning {
	background-position: -20px 0;
}

.error {
	background-position: -40px 0;
}

/* Tooltip Colors */

.help .tooltip {
	border-color: #464646;
	background-color: #FFFFFF;
	box-shadow-color: #21759B;
}

.warning .tooltip {
	border-color: #cca863;
	background-color: #ffff70;
	box-shadow-color: #ac8c4e;
}

.error .tooltip {
	border-color: #b50d0d;
	background-color: #e44d4e;
	box-shadow-color: #810606;
}

.icon:hover .tooltip {
	display: block;
}

#success_message_reset_1{
   display: none;
   margin: 15px 8px 0px 1px;
   padding: 13px 0px 15px 52px;
   background: url(<?php echo get_template_directory_uri().'/option_pannel/images/icon_check.png'; ?>) left no-repeat #5f5f5f;
   /*opacity:0.5;
   filter:alpha(opacity=50);*/
   background-position: 15px 15px;
   border: solid 1px #F22853;
   -webkit-border-radius: 15px;
   -moz-border-radius: 15px;
   border-radius: 15px;
   width: 220px;
   font-size: 20px;
   color: #ffffff;
   position: absolute;
   left: 500px;
   bottom: 20px;
   
}		
#success_message_save_1 {
   display: none;
   margin: 15px 8px 0px 1px;
   padding: 13px 0px 15px 52px;
   background: url(<?php echo get_template_directory_uri().'/option_pannel/images/icon_check.png'; ?>) left no-repeat #5f5f5f;

   background-position: 15px 15px;
   border: solid 1px #F22853;
   -webkit-border-radius: 15px;
   -moz-border-radius: 15px;
   border-radius: 15px;
   width: 220px;
   font-size: 20px;
   color: #ffffff;
   position: absolute;
   left: 500px;
   bottom: 20px;
   
}
#success_message_reset_2{
   display: none;
   margin: 15px 8px 0px 1px;
   padding: 13px 0px 15px 52px;
   background: url(<?php echo get_template_directory_uri().'/option_pannel/images/icon_check.png'; ?>) left no-repeat #5f5f5f;
   /*opacity:0.5;
   filter:alpha(opacity=50);*/
   background-position: 15px 15px;
   border: solid 1px #F22853;
   -webkit-border-radius: 15px;
   -moz-border-radius: 15px;
   border-radius: 15px;
   width: 220px;
   font-size: 20px;
   color: #ffffff;
   position: absolute;
   left: 500px;
   bottom: 20px;
   
}		
#success_message_save_2 {
   display: none;
   margin: 15px 8px 0px 1px;
   padding: 13px 0px 15px 52px;
   background: url(<?php echo get_template_directory_uri().'/option_pannel/images/icon_check.png'; ?>) left no-repeat #5f5f5f;

   background-position: 15px 15px;
   border: solid 1px #F22853;
   -webkit-border-radius: 15px;
   -moz-border-radius: 15px;
   border-radius: 15px;
   width: 220px;
   font-size: 20px;
   color: #ffffff;
   position: absolute;
   left: 500px;
   bottom: 20px;
   
}
#success_message_reset_3{
   display: none;
   margin: 15px 8px 0px 1px;
   padding: 13px 0px 15px 52px;
   background: url(<?php echo get_template_directory_uri().'/option_pannel/images/icon_check.png'; ?>) left no-repeat #5f5f5f;
   /*opacity:0.5;
   filter:alpha(opacity=50);*/
   background-position: 15px 15px;
   border: solid 1px #F22853;
   -webkit-border-radius: 15px;
   -moz-border-radius: 15px;
   border-radius: 15px;
   width: 220px;
   font-size: 20px;
   color: #ffffff;
   position: absolute;
   left: 500px;
   bottom: 20px;
   
}		
#success_message_save_3 {
   display: none;
   margin: 15px 8px 0px 1px;
   padding: 13px 0px 15px 52px;
   background: url(<?php echo get_template_directory_uri().'/option_pannel/images/icon_check.png'; ?>) left no-repeat #5f5f5f;

   background-position: 15px 15px;
   border: solid 1px #F22853;
   -webkit-border-radius: 15px;
   -moz-border-radius: 15px;
   border-radius: 15px;
   width: 220px;
   font-size: 20px;
   color: #ffffff;
   position: absolute;
   left: 500px;
   bottom: 20px;
   
}
#success_message_reset_4{
   display: none;
   margin: 15px 8px 0px 1px;
   padding: 13px 0px 15px 52px;
   background: url(<?php echo get_template_directory_uri().'/option_pannel/images/icon_check.png'; ?>) left no-repeat #5f5f5f;
   /*opacity:0.5;
   filter:alpha(opacity=50);*/
   background-position: 15px 15px;
   border: solid 1px #F22853;
   -webkit-border-radius: 15px;
   -moz-border-radius: 15px;
   border-radius: 15px;
   width: 220px;
   font-size: 20px;
   color: #ffffff;
   position: absolute;
   left: 500px;
   bottom: 20px;
   
}		
#success_message_save_4 {
   display: none;
   margin: 15px 8px 0px 1px;
   padding: 13px 0px 15px 52px;
   background: url(<?php echo get_template_directory_uri().'/option_pannel/images/icon_check.png'; ?>) left no-repeat #5f5f5f;

   background-position: 15px 15px;
   border: solid 1px #F22853;
   -webkit-border-radius: 15px;
   -moz-border-radius: 15px;
   border-radius: 15px;
   width: 220px;
   font-size: 20px;
   color: #ffffff;
   position: absolute;
   left: 500px;
   bottom: 20px;
   
}


</style>