<?php
echo '<div id=ediciones-anteriores-home>';
echo '<a style="position:relative;float:left;" href="http://noticias.laprensa.com.ni/2014">';
echo '<div style="position:relative;margin-top:50px;">';
echo do_shortcode('[doap_button url="/2014/" style="soft" background="#eee" color="#369" size="2" icon="icon: calendar" icon_color="#369" text_shadow="0px 0px 0px #369" class="daves-sample-menu-item"]<div style="position:relative;float:right;width:210px;">Ediciones Anteriores</div>[/doap_button]');
echo '<div style="width:100%;padding-left:5px;padding-right:5px;margin-top:6px;width:100%;font-family:Arial;font-size:13px;text-align:justify;">Seleccione la edicion y haga clic en "Ir".</div></div>';
//echo '<div style="width:100%;padding-left:5px;padding-right:5px;max-width:90%;text-align:justify;">Haga clic al calendario y seleccione la edicion.  Para ediciones anteriores al 30 de Octubre del 2009 clic <a href=http://archivo.laprensa.com.ni/archivo/servicios/edicionesanteriores/index.php?month=10&year=2009 style=color:blue>aqui</a>.</div></div>';

echo ' <div style="position:relative;">
    
<form name="form1" method="GET" action="/" id="form1" style="position:relative;top:-40px;left:10px;">
    
<input style="display:none;" name="txtDate" type="text" id="txtDate" />
<br>    
    <p><span src="/someimage.jpg"><input id="fullDate" type="hidden" /></span></p>
    <select id="month" name="monthnum" style="width:70px;">
        <option value="01">Enero</option> 
        <option value="02">Febrero</option>
        <option value="03">Marzo</option>
        <option value="04">Abril</option>
        <option value="05">Mayo</option>
        <option value="06">Junio</option>
        <option value="07">Julio</option>
        <option value="08">Augosto</option>
        <option value="09">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Deciembre</option>
    </select>
    <select id="day" name="day">
        <option value="01">1</option>
        <option value="02">2</option>
        <option value="03">3</option>
        <option value="04">4</option>
        <option value="05">5</option>
        <option value="06">6</option>
        <option value="07">7</option>
        <option value="08">8</option>
        <option value="09">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
    </select>
    <select id="year" name="year">
        <option value="2014">2014</option>
        <option value="2013">2013</option>
        <option value="2012">2012</option>
        <option value="2011">2011</option>
        <option value="2010">2010</option>
        <option value="2009">2009</option>
        <option value="2008">2008</option>
        <option value="2007">2007</option>
        <option value="2006">2006</option>
        <option value="2005">2005</option>
        <option value="2004">2004</option>
        <option value="2003">2003</option>
        <option value="2002">2002</option>
        <option value="2001">2001</option>
    </select>
    <input type="hidden" id="datepicker" /> 
    <input type="submit" id="searchsubmit" value="Ir" />

    </form>
</div> ';
echo '</div>';
?>
