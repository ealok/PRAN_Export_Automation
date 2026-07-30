    //@@@@---Active Menu 
    var currentURL = window.location.href;
    var status=1;
    $('.treeview a').each(function() {
    
        if($(this).attr('href') === currentURL){
            
            $(this).closest('.treeview').addClass('active');
            $(this).closest('.treeview a').css("background-color","#070908");
            status=0;

        }
    
    });
    
    if(status=='1'){
        
        $( "a[href='" +currentURL+ "']" ).css("background-color", "#070908");

    } 

    //@@@End

    //@@@@@@--Golobal Form Reset
    window.resetForm = function() {

        $('#bapa_rcv').trigger('reset');
        $('#invoice_id').val('').selectpicker('refresh');
        $('#company_id').val('').selectpicker('refresh');
        
    } //@@@@ End
    
    //@@@@--Date Picker 
    $('.datepicker').datepicker({
        format    : "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true
    }); //@@@End
    
    ///@@@--Datatable
    $('#example1').DataTable({
        "order": [[ 0, "DESC" ]],
        "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100,"All"]]
    }); //@@@end Datatable  
