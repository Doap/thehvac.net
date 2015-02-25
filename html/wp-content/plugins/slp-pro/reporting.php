<?php
/****************************************************************************
 ** file: reporting.php
 **
 ** The reporting system
 ***************************************************************************/
 
global $slplus_plugin, $wpdb;

//===========================================================================
// Supporting Functions
//===========================================================================


/**************************************
 ** function: DetailDataSection()
 **
 ** Create a standard details section with a data table based on a MySQL Query
 **
 **/
function DetailDataSection($tag, $theQuery, $SectionHeader, $columnHeaders, $columnDataLines, $Qryname) {
    global $wpdb;
    $thisDataset = $wpdb->get_results($theQuery);
    $thisQryname = strtolower(preg_replace('/\s/','_',$Qryname));
    $thisQryvalue= htmlspecialchars($tag,ENT_QUOTES,'UTF-8');
    
    $thisSectionDesc =
        '<div id="wpcsl_settings_group-settings" class="section_column wpcsl-group">' .
        '<div id="rb_details" class="reportblock">' .
            '<div class="rb_column">'.
                '<h2>' . $SectionHeader . '</h2>' .
                '<input type="hidden" name="'.$thisQryname.'" value="'.$thisQryvalue.'">' .
                '<table id="'.$Qryname.'_table" cellpadding="0" cellspacing="0">' .
                    '<thead>' .
                        '<tr>';
                        
    foreach ($columnHeaders as $columnHeader) {                        
       $thisSectionDesc .= "<th>$columnHeader</th>";
    }                            
                            
    $thisSectionDesc .=  '</tr>' .
                    '</thead>' .
                    '<tbody>';

    $slpReportRowClass = 'rowon';                    
    foreach ($thisDataset as $thisDatapoint) {
        $slpReportRowClass = ($slpReportRowClass === 'rowoff') ? 'rowon' : 'rowoff';
        $thisSectionDesc .= '<tr>';
        foreach ($columnDataLines as $columnDataLine) {            
            $columnName = $columnDataLine['columnName'];
            $columnClass= $columnDataLine['columnClass'];
            $thisSectionDesc .= sprintf(
                '<td class="%s %s">%s</td>',
                $columnClass,
                $slpReportRowClass,
                $thisDatapoint->$columnName
                );           
        }
        $thisSectionDesc .= '</tr>';
    }
    
    $thisSectionDesc .=
                    '</tbody>' .
                '</table>'.
            '</div>' .
        '</div>' .
        '</div>'
        ;   
        
    return $thisSectionDesc;        
}


//===========================================================================
// Main Processing
//===========================================================================

// Data Settings
//
$slpQueryTable     = $wpdb->prefix . 'slp_rep_query';
$slpResultsTable   = $wpdb->prefix . 'slp_rep_query_results';
$slpLocationsTable = $wpdb->prefix . 'store_locator';
 
// Instantiate the form rendering object
//
$slpReportSettings = new wpCSL_settings__slplus(
    array(
            'prefix'            => $slplus_plugin->prefix,
            'url'               => $slplus_plugin->url,
            'name'              => $slplus_plugin->name . __(' - Reporting','csa-slp-pro'),
            'plugin_url'        => $slplus_plugin->plugin_url,
            'render_csl_blocks' => false,
            'form_action'       => admin_url().'admin.php?page=slp-pro/reporting.php',
            'save_text'         => __('Run Report','csa-slp-pro')
        )
 ); 

//-------------------------
// Navbar Section
//-------------------------    
global $slplus_plugin;
$slpReportSettings->add_section(
    array(
        'name' => 'Navigation',
        'div_id' => 'navbar_wrapper',
        'description' => $slplus_plugin->AdminUI->create_Navbar(),
        'is_topmenu' => true,
        'auto' => false,
        'headerbar'     => false              
    )
);
 
//------------------------------------
// Create The Report Parameters Panel
//  
$slpReportSettings->add_section(
    array(
            'name'          => __('Report Parameters','csa-slp-pro'),
            'description'   => __('Use these settings to select which data to report on.','csa-slp-pro'),
            'auto'          => true
        )
 );

// Start of date range to report on
// default: 30 days ago
//
$slpReportStartDate = isset($_POST[SLPLUS_PREFIX.'-start_date']) ?
    $_POST[SLPLUS_PREFIX.'-start_date'] :
    date('Y-m-d',time() - (30 * 24 * 60 * 60));
$slpReportSettings->add_item(
    __('Report Parameters','csa-slp-pro'),
    __('Start Date: ','csa-slp-pro'),
    'start_date',    
    'text',
    null,
    null,
    null,
    $slpReportStartDate
); 

// Start of date range to report on
// default: today
//
$slpReportEndDate = (isset($_POST[SLPLUS_PREFIX.'-end_date'])) ?
    $_POST[SLPLUS_PREFIX.'-end_date'] :
    date('Y-m-d',time()) . ' 23:59:59';
    if (!preg_match('/\d\d:\d\d$/',$slpReportEndDate)) {
        $slpReportEndDate .= ' 23:59:59';
    }
    
$slpReportSettings->add_item(
    __('Report Parameters','csa-slp-pro'),
    __('End Date: ','csa-slp-pro'),
    'end_date',    
    'text',
    null,
    null,
    null,
    $slpReportEndDate
);     

// How many detail records to report back
// default: 10
//
$slpReportLimit = isset($_POST[SLPLUS_PREFIX.'-report_limit']) ?
    $_POST[SLPLUS_PREFIX.'-report_limit'] :
    '10';
$slpReportSettings->add_item(
    __('Report Parameters','csa-slp-pro'),
    __('How many detail records? ','csa-slp-pro'),
    'report_limit',    
    'text',
    false,
    __('Determines how many detail records are reported. ' .
       'More records take longer to report. '.
       '(Default: 10, recommended maximum: 500)',
       'csa-slp-pro'
       ),
    null,
    $slpReportLimit
);

$slpReportSettings->add_item(
    __('Report Parameters','csa-slp-pro'),
    '',   
    'runreport',    
    'submit_button',
    null,
    null,
    null,
    __('Run Report','csa-slp-pro')
);     

// Total results each day
// select 
//      count(*) as TheCount, 
//      sum((select count(*) from wp_slp_rep_query_results RES 
//                  where slp_repq_id = QRY2.slp_repq_id)) as TheResults,
//      DATE(slp_repq_time) as TheDate 
// from wp_slp_rep_query QRY2 group by TheDate;
//
$slpReportQuery = sprintf(
    "select count(*) as QueryCount," . 
        "sum((select count(*) from %s ". 
                    "where slp_repq_id = qry2.slp_repq_id)) as ResultCount," .
        "DATE(slp_repq_time) as TheDate " .        
        "FROM %s qry2 " .
        "WHERE slp_repq_time > '%s' AND " .
        "      slp_repq_time <= '%s' " .       
        "GROUP BY TheDate",
    $slpResultsTable,
    $slpQueryTable,
    $slpReportStartDate,
    $slpReportEndDate
    );
$slpReportDataset = $wpdb->get_results($slpReportQuery);

$slpGoogleChartRows = 0;
$slpGoogleChartData = '';
$slpRepTotalQueries = 0;
$slpRepTotalResults = 0;
foreach ($slpReportDataset as $slpReportDatapoint) {
    $slpGoogleChartData .= sprintf(
        "data.setValue(%d, 0, '%s');".
        "data.setValue(%d, 1, %d);".
        "data.setValue(%d, 2, %d);",
        $slpGoogleChartRows,
        $slpReportDatapoint->TheDate,
        $slpGoogleChartRows,
        $slpReportDatapoint->QueryCount,
        $slpGoogleChartRows,        
        $slpReportDatapoint->ResultCount
        );
    $slpGoogleChartRows++;        
    $slpRepTotalQueries += $slpReportDatapoint->QueryCount;
    $slpRepTotalResults += $slpReportDatapoint->ResultCount;
}    

$slpGoogleChartType = ($slpGoogleChartRows < 2)  ?
    'ColumnChart' :
    'AreaChart';


//------------------------------------
// The Summary Data Panel
//
// Get the total searches in this time span
//
// select count(*) from wp_slp_rep_query 
//      where slp_repq_time > '2011-05-17' and 
//            slp_repq_time <= '2011-06-16 23:59:59';
//
$slpReportQuery = sprintf(
    "SELECT count(*) FROM %s " .
        "WHERE slp_repq_time > '%s' AND " .
        "      slp_repq_time <= '%s' ",
    $slpQueryTable,
    $slpReportStartDate,
    $slpReportEndDate
    );
$slpReportDatapoint = $wpdb->get_var($slpReportQuery);

$slpSectionDesc = sprintf(
    '<div class="reportline total">' .
        __('Total searches: <strong>%s</strong>', 'csa-slp-pro'). "<br/>" .
        __('Total results: <strong>%s</strong>', 'csa-slp-pro').
    '</div>',
     $slpRepTotalQueries,
     $slpRepTotalResults
    );    



//------------------------------------
// The Details Data Panel
//

//....
//
// What are the top addresses searched?
//
// SELECT slp_repq_address,count(*) as QueryCount 
//      FROM wp_slp_rep_query 
//      WHERE slp_repq_time > '%s' AND slp_repq_time <= '%s'
//      GROUP BY slp_repq_address 
//      ORDER BY QueryCount DESC;
//
//
$slpReportQuery = sprintf(
    "SELECT slp_repq_address, count(*)  as QueryCount FROM %s " .
        "WHERE slp_repq_time > '%s' AND " .
        "      slp_repq_time <= '%s' " .
        "GROUP BY slp_repq_address ".
        "ORDER BY QueryCount DESC " .
        "LIMIT %s"
        ,
    $slpQueryTable,
    $slpReportStartDate,
    $slpReportEndDate,
    $slpReportLimit
    );
$slpSectionHeader = sprintf(__('Top %s Addresses Searched', 'csa-slp-pro'),$slpReportLimit);
$slpColumnHeaders = array(
    __('Address','csa-slp-pro'),
    __('Total','csa-slp-pro')
    );
$slpDataLines = array(
        array('columnName' => 'slp_repq_address', 'columnClass'=> ''            ),
        array('columnName' => 'QueryCount',       'columnClass'=> 'alignright'  ),
    );
$slpSectionDesc .= DetailDataSection("addr,$slpReportStartDate,$slpReportEndDate,$slpReportLimit",
                $slpReportQuery, $slpSectionHeader, 
                $slpColumnHeaders, $slpDataLines, 
                __('topsearches','csa-slp-pro')
                );

//....
//
// What are the top results returned?
//
// SELECT sl_store,sl_city,sl_state, sl_zip, sl_tags, count(*) as ResultCount 
//      FROM wp_slp_rep_query_results res 
//          LEFT JOIN wp_store_locator sl 
//              ON (res.sl_id = sl.sl_id)  
//      WHERE slp_repq_time > '%s' AND slp_repq_time <= '%s'
//      GROUP BY sl_store,sl_city,sl_state,sl_zip,sl_tags
//      ORDER BY ResultCount DESC
//      LIMIT %s
//
$slpReportQuery = sprintf(
    "SELECT sl_store,sl_city,sl_state, sl_zip, sl_tags, count(*) as ResultCount " . 
        "FROM %s res ".
            "LEFT JOIN %s sl ". 
                "ON (res.sl_id = sl.sl_id) ".  
            "LEFT JOIN %s qry ". 
                "ON (res.slp_repq_id = qry.slp_repq_id) ".  
            "WHERE slp_repq_time > '%s' AND slp_repq_time <= '%s' ".
        "GROUP BY sl_store,sl_city,sl_state,sl_zip,sl_tags ".
        "ORDER BY ResultCount DESC ".
        "LIMIT %s"
        ,
    $slpResultsTable,
    $slpLocationsTable,
    $slpQueryTable,
    $slpReportStartDate,
    $slpReportEndDate,
    $slpReportLimit
    );
$slpSectionHeader = sprintf(__('Top %s Results Returned', 'csa-slp-pro'),$slpReportLimit);
$slpColumnHeaders = array(
    __('Store'  ,'csa-slp-pro'),
    __('City'   ,'csa-slp-pro'),
    __('State'  ,'csa-slp-pro'),
    __('Zip'    ,'csa-slp-pro'),
    __('Tags'   ,'csa-slp-pro'),
    __('Total'  ,'csa-slp-pro')
    );
$slpDataLines = array(
        array('columnName' => 'sl_store',   'columnClass'=> ''            ),
        array('columnName' => 'sl_city',    'columnClass'=> ''            ),
        array('columnName' => 'sl_state',   'columnClass'=> ''            ),
        array('columnName' => 'sl_zip',     'columnClass'=> ''            ),
        array('columnName' => 'sl_tags',    'columnClass'=> ''            ),
        array('columnName' => 'ResultCount','columnClass'=> 'alignright'  ),
    );
$slpSectionDesc .= DetailDataSection("top,$slpReportStartDate,$slpReportEndDate,$slpReportLimit",
                $slpReportQuery, $slpSectionHeader, 
                $slpColumnHeaders, $slpDataLines,
                __('topresults','csa-slp-pro')
                );

$slpSectionDesc .= '
    <div id="wpcsl_settings_group-settings" class="section_column wpcsl-group">
    <div id="rb_details" class="reportblock">
        <div class="rb_column">
          <h2>' . __('Export To CSV','csa-slp-pro') . '</h2>
          <div class="form_entry">
              <label for="export_all">'.__('Export all records','csa-slp-pro').'</label>
              <input id="export_all" type="checkbox"  name="export_all" value="1">
          </div>
          <div class="form_entry">
              <input id="export_searches" class="button-secondary button-export" type="button" value="'.__('Top Searches','csa-slp-pro').'"><br/>
              <input id="export_results"  class="button-secondary button-export" type="button" value="'.__('Top Results','csa-slp-pro').'">
          </div>
        </div>
        <iframe id="secretIFrame" src="" style="display:none; visibility:hidden;"></iframe>
    </div>
    </div>
    ';

//------------------------------------
// The Report Panel
//
$slpReportSettings->add_section(
    array(
            'name'          => __('Search Report','csa-slp-pro'),
            'description'   =>
                '<div id="chart_div"></div>' .
                $slpSectionDesc,
            'auto'          => true,
            'innerdiv'      => true
        )
 );




//----------------------------
// If we have data to report on
//
if ($slpRepTotalQueries > 0) {
    ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('number', 'Queries');
        data.addColumn('number', 'Results');
        data.addRows(<?php echo $slpGoogleChartRows; ?>);
        <?php echo $slpGoogleChartData; ?>
        var chart = new google.visualization.<?php echo $slpGoogleChartType; ?>(document.getElementById('chart_div'));
        chart.draw(data, {width: 800, height: 400, pointSize: 4});
      }
    </script>
<?php

// No Data Yet - Tell Them
//
} else {
    ?>
<script type="text/javascript">
    jQuery(document).ready(       
            function($) {
                  $("#chart_div").html("<p><?php echo __('No data recorded yet. ','csa-slp-pro');
                    echo __('Chart will be available after a Store Locator Plus search has been performed.','csa-slp-pro');
                    ?></p>");
            }
        );
</script>    
<?php    
}

$slpReportSettings->render_settings_page();
