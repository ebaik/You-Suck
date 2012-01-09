
/**
 * This is ugly, i haven't find a way to include the google jsapi in the analytics controller,
 * will update it later
 */

google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
    // load data 
    //console.log($.query.get('company'), $.query.get('scale'));
    youSuck.use('jquery.query', function() {
        var company = $.query.get('company');
        var scale = $.query.get('scale');
        $.getJSON('/analytics/getdata?company='+company+'&scale='+scale, function(response) {
            //console.log(response);
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Day');
            data.addColumn('number', 'Complaints');

    //        var i=0, size=response.length;
    //        var rows = [];
    //        for(;i<size;i++) 
    //        {
    //            rows.push
    //        }    
            data.addRows(response);
    //        data.addRows([
    //            ['2004', 1000],
    //            ['2005', 1170],
    //            ['2006',  860],
    //            ['2007', 1030]
    //        ]);

            var options = {
                width: 600, height: 340,
                title: 'Complaints per '+scale+' for '+company
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart'));
            chart.draw(data, options);        
        });
    });
    
    
}

/////////////////////////////////////////////////////////////////////////////////////////////


youSuck.controllers.analytics_show = new function() {
    //console.log('in analytics show');
    
    /**
     * redering the search box and complaints list
     */
    youSuck.use('modules-search_box', 'modules-complaints_list', 'common-utils', function(youSuck) {   
        var search_box_id = 'search_box';
        var search_box =  new youSuck.modules.search_box(search_box_id, youSuck.common.utils.getPageControllerObjectName());
        search_box.render();
        
    });
    /**
     * end redering the search box and complaints list
     */
};