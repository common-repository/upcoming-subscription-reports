
//jquery product filter calender-picker
jQuery(document).ready(function($){
    $.fn.dataTable.ext.search.push(
    function (settings, data, dataIndex) {
        var min = $('#uspr_min_value_text').datepicker("getDate");
        var max = $('#uspr_max_value_text').datepicker("getDate");
       
        var sel_pay_method = $("#payment-selector-top").val();
          
       
          if(sel_pay_method == 'all'){
            var columnDate1 = new Date(data[4]);
            var columnDate2 = new Date(data[5]);

            if (min == null && max == null) { return true; }
            if (min == null && (columnDate1 <= max || columnDate2 <= max)) { return true;}
            if(max == null && (columnDate1 >= min || columnDate2 >= min)) {return true;}
            if ((columnDate1 <= max && columnDate1 >= min) || (columnDate2 <= max && columnDate2 >= min)) { return true; }
          }else{
            var columnDate = new Date(data[sel_pay_method]);
            if (min == null && max == null) { return true; }
            if (min == null && columnDate <= max) { return true;}
            if(max == null && columnDate >= min) {return true;}
            if (columnDate <= max && columnDate >= min) { return true; }
          }
        
        
        return false;
    }
    );

   
        $("#uspr_min_value_text").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
        $("#uspr_max_value_text").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
        var table = $('#uspr-thead-table').DataTable({
          "language": {
            search: "_INPUT_",
            searchPlaceholder: "Search..."
        }
        });

        // Event listener to the two range filtering inputs to redraw on input
        $('#uspr_min_value_text, #uspr_max_value_text').change(function () {
            table.draw();
        });

        $('#payment-selector-top').on('change', function() {
            $('#uspr_min_value_text').val('');
            $('#uspr_max_value_text').val('');
        });

});


//loading button on refresh
   function RefreshButton() {

  
   
        jQuery( "button.upsr_button_refresh_data" ).animate({
          opacity: 0.25,
          left: "+=50",
          height: "toggle"
        }, 2000, function() {
          // Animation complete.
        });
        jQuery("button.upsr_button_refresh_data").css('background-color', '#326c19');
       
       window.location.reload();

   }

    //clearfield function for clear button

    function ClearFields() {

        document.getElementById("uspr_min_value_text").value = "";
        document.getElementById("uspr_max_value_text").value = "";
        jQuery('#uspr-thead-table').dataTable().fnDraw();
   }

   //end
