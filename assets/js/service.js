$(function () {

    var root_url = window.location.origin+"/clis/";
    var current_url = window.location.href.match(/^.*\//);
    var check_id_url = ((window.location.href).substring((window.location.href).lastIndexOf('/') + 1)).match(/\d/g);
    var id_url = (check_id_url===null) ? null : check_id_url.toString();
    var json_lab_test = null;

    var workbook, excelIO, jsonData;

    // $('selector').on('event', function(){callback});


    //global

    $(document).on('click', '.close-table-daily-operation-monitoring', function(){

        $('#widget-content').prop('hidden', 'hidden');

        $('.stat-lab').each(function(index, value){
            $(value).removeClass('stat-lab-active');
        })

    })

    // end global

    // patient
    $('#new_patient').on('click', function(){
        $.ajax({

            url: root_url+'system/reception/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Patient_first_name              :   $('#new_patient_first_name').val(),
                Patient_middle_name             :   $('#new_patient_middle_name').val(),
                Patient_last_name               :   $('#new_patient_last_name').val(),
                Patient_sex                     :   $("input[name='sex']:checked").val(),
                Patient_date_of_birth           :   $('#new_patient_date_of_birth').val(),
                Patient_phone_number            :   $('#new_patient_phone_number').val(),
                Patient_email_address           :   $('#new_patient_email_address').val(),
                
                from        : 'reception',
                action      : 'new-patient'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                    location.reload();
                }
            }
        });
    })

    $('#search_patient').keyup(function(){
        var search  = $(this).val();

        $.ajax({
            url: root_url+'system/reception/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Search_patient              :   search,
                from                        : 'reception',
                action                      : 'search-patient'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
                    $('#patient-search-result-table').prop('hidden', '');
                    
                    if(data.length != 0 ){
                        $.each(data, function( index, value ) {
                            html+= '<tr>'+
                                        '<td>'+value.First_name+' '+value.Middle_name+' '+value.Last_name+'</td>'+
                                        '<td>'+value.Sex+'</td>'+
                                        '<td>'+calculateAge(value.Date_of_birth)+'</td>'+
                                        '<td>'+value.Date_of_birth+'</td>'+
                                        '<td class="td-actions td-more-actions" style="width:250px !important;">'+
                                            '<a class=" btn btn-small btn-success" href="'+current_url+'patient-details/index.php?id='+value.ID+'"><i class="fa fa-info-circle"></i> Details</a>'+
                                            '<a href="#patient_send_out_modal" role="button" class=" btn btn-small btn-success request_patient_modal_btn" data-patient-name="'+value.First_name+' '+value.Middle_name+' '+value.Last_name+'" data-patient-id="'+value.ID+'"  data-toggle="modal"><i class="fa fa-external-link-square-alt"></i> Send Out</a>'+
                                            '<a href="#patient_request_modal" role="button" class=" btn btn-small btn-success request_patient_modal_btn" data-patient-name="'+value.First_name+' '+value.Middle_name+' '+value.Last_name+'" data-patient-id="'+value.ID+'"  data-toggle="modal"><i class="fa fa-paper-plane"></i> Request</a>'+
                                        '</td>'+
                                    '</tr>';
                        });
                    }else{
                        html+= '<tr >'+
                                '<td colspan="2">NO FOUND PATIENT RECORD</td>'+
                                '</tr>';
                    }
                  
                    $('#patient-search-result-value').html(html)
                }
            }
        });

    })

    $('#search_patient_record').keyup(function(){
        var search  = $(this).val();

        $.ajax({
            url: root_url+'system/reception/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Search_patient              :  search,
                from                        : 'reception',
                action                      : 'search-patient'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
                    $('#patient-search-result-table').prop('hidden', '');
                    
                    if(data.length != 0 ){
                        $.each(data, function( index, value ) {
                            html+= '<tr>'+
                                        '<td>'+value.First_name+' '+value.Middle_name+' '+value.Last_name+'</td>'+
                                        '<td>'+value.Sex+'</td>'+
                                        '<td>'+calculateAge(value.Date_of_birth)+'</td>'+
                                        '<td>'+value.Date_of_birth+'</td>'+
                                        '<td class="td-actions td-more-actions">'+
                                            '<a class=" btn btn-small btn-success" href="'+current_url+'patient-details/index.php?id='+value.ID+'"><i class="fa fa-list"></i> View logs</a>'+
                                        '</td>'+
                                    '</tr>';
                        });
                    }else{
                        html+= '<tr >'+
                                '<td colspan="2">NO FOUND PATIENT RECORD</td>'+
                                '</tr>';
                    }
                  
                    $('#patient-search-result-value').html(html)
                }
            }
        });

    })

    $('#search_lab_logs').on('change',function(){
        var search  = $(this).val();
        $.ajax({
            url: root_url+'system/laboratory/patient-records/patient-details/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                search                      :  search,
                patient_id                  :  $('#patient_id').val(),
                from                        : 'lab-logs',
                action                      : 'search-lab-logs'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
                    $('#patient-search-result-table').prop('hidden', '');
                    
                    if(data.length != 0 ){
                        $.each(data, function( index, value ) {
                            html+= '<tr>'+
                                        '<td>'+value.Label+'</td>'+
                                        '<td>'+value.Coordinate+'</td>'+
                                        '<td>'+((value.Value!=undefined)? value.Value : "EMPTY") +'</td>'+
                                        '<td>'+value.Datetime_created+'</td>'+
                                    '</tr>';
                        });
                    }else{
                        html+= '<tr >'+
                                '<td colspan="2">NO FOUND LAB LOG</td>'+
                                '</tr>';
                    }
                    console.log(data);
                    $('#patient-lab-result').html(html)
                }
            }
        });

    })


    function calculateAge(date_of_birth){
        date_of_birth = new Date(date_of_birth);
        var today = new Date();
        var get_different  = today-date_of_birth;

        return Math.floor((get_different) / (365.25 * 24 * 60 * 60 * 1000));
    }


    var split_url = current_url[0].split('/');

    if(split_url[5]=="reception"){
        loadPatientRecords();
    }
    if(split_url[6]=="patient-records"){
        loadPatientRecordsLab();
    }

    // console.log(split_url);
    

    function loadPatientRecordsLab(){
        $.ajax({
            url: root_url+'system/reception/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Search_patient              :  "",
                from                        : 'reception',
                action                      : 'search-patient'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
                    $('#patient-search-result-table').prop('hidden', '');
                    
                    if(data.length != 0 ){
                        $.each(data, function( index, value ) {
                            html+= '<tr>'+
                                '<td>'+value.First_name+' '+value.Middle_name+' '+value.Last_name+'</td>'+
                                '<td>'+value.Sex+'</td>'+
                                '<td>'+calculateAge(value.Date_of_birth)+'</td>'+
                                '<td>'+value.Date_of_birth+'</td>'+
                                '<td class="td-actions td-more-actions">'+
                                '<a class=" btn btn-small btn-success" href="'+current_url+'patient-details/index.php?id='+value.ID+'"><i class="fa fa-list"></i> View logs</a>'+
                                '</td>'+
                            '</tr>';
                        });
                    }else{
                        html+= '<tr >'+
                                '<td colspan="2">NO FOUND PATIENT RECORD</td>'+
                                '</tr>';
                    }
                  
                    $('#patient-search-result-value').html(html)
                }
            }
        });
    }


    function loadPatientRecords(){
        $.ajax({
            url: root_url+'system/reception/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Search_patient              :  "",
                from                        : 'reception',
                action                      : 'search-patient'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
                    $('#patient-search-result-table').prop('hidden', '');
                    
                    if(data.length != 0 ){
                        $.each(data, function( index, value ) {
                            html+= '<tr>'+
                                        '<td>'+value.First_name+' '+value.Middle_name+' '+value.Last_name+'</td>'+
                                        '<td>'+value.Sex+'</td>'+
                                        '<td>'+calculateAge(value.Date_of_birth)+'</td>'+
                                        '<td>'+value.Date_of_birth+'</td>'+
                                        '<td class="td-actions td-more-actions" style="width:250px !important;">'+
                                            '<a class=" btn btn-small btn-success" href="'+current_url+'patient-details/index.php?id='+value.ID+'"><i class="fa fa-info-circle"></i> Details</a>'+
                                            '<a href="#patient_send_out_modal" role="button" class=" btn btn-small btn-success request_patient_modal_btn" data-patient-name="'+value.First_name+' '+value.Middle_name+' '+value.Last_name+'" data-patient-id="'+value.ID+'"  data-toggle="modal"><i class="fa fa-external-link-square-alt"></i> Send Out</a>'+
                                            '<a href="#patient_request_modal" role="button" class=" btn btn-small btn-success request_patient_modal_btn" data-patient-name="'+value.First_name+' '+value.Middle_name+' '+value.Last_name+'" data-patient-id="'+value.ID+'"  data-toggle="modal"><i class="fa fa-paper-plane"></i> Request</a>'+
                                        '</td>'+
                                    '</tr>';
                        });
                    }else{
                        html+= '<tr >'+
                                '<td colspan="2">NO FOUND PATIENT RECORD</td>'+
                                '</tr>';
                    }
                  
                    $('#patient-search-result-value').html(html)
                }
            }
        });
    }

    // Unused function, but not to remove.
    $('#search_patient_btn').on('click', function(){


        $.ajax({

            url: root_url+'system/reception/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Search_patient              :   $('#search_patient').val(),
                from        : 'reception',
                action      : 'search-patient'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
                    $('#patient-search-result-table').prop('hidden', '');
                if(data.length != 0 ){
                    $.each(data, function( index, value ) {
                        html+= '<tr>'+
                                    '<td>'+value.First_name+' '+value.Middle_name+' '+value.Last_name+'</td>'+
                                    '<td class="td-actions">'+
                                        '<a href="#patient_request_modal" role="button" class="btn-small btn-success request_patient_modal_btn" data-patient-name="'+value.First_name+' '+value.Middle_name+' '+value.Last_name+'" data-patient-id="'+value.ID+'"  data-toggle="modal"><i class="fa fa-paper-plane"></i> Request</a>'+
                                    '</td>'+
                                '</tr>';
                    });
                }else{
                    html+= '<tr >'+
                            '<td colspan="2">NO FOUND PATIENT RECORD</td>'+
                            '</tr>';
                }
                    $('#patient-search-result-value').html(html)
                }
            }
        });
    })

    $(document).on('click', '.request_patient_modal_btn', function(){
        var patient_id = $(this).data('patient-id');
        var patient_name = $(this).data('patient-name');

        $('#requesting_patient_name').text(patient_name);
        $('#sent_out_patient_name').text(patient_name);
        $('#requesting_receipt_patient_name').text(patient_name);

        $('.request_patient_btn').data('patient-id', patient_id);
        $('.sent_out_patient_btn').data('patient-id', patient_id);  
    })

    var cost = 0;

    $('.bill_test').on('click', function(){
        var mode_of_test_id = $(this).data('mode-of-test-id');
        var lab_test = $(this).data('lab-test');
        var lab_test_value = $(this).val();
        var lab_test_cost = $(this).data('lab-test-cost');
        var package_html = "";

        if(mode_of_test_id==1){
            if($(this).prop("checked") == true){
                cost+=lab_test_cost;
                $('#bill_summary').append('<h5 id="lab-test-id-'+lab_test_value+'">'+lab_test+'</h5>');
            }else{
                cost-=lab_test_cost;
                $("#lab-test-id-"+lab_test_value+"").remove();
            }
        }else{
            package_html = $('#package-lab-test-'+lab_test_value+'').html();
            if($(this).prop("checked") == true){
                cost+=lab_test_cost;
                $('#bill_summary').append('<div id="lab-package-test-id-'+lab_test_value+'">'+'₱'+lab_test_cost+' - '+lab_test+'<hr style="margin:0px">'+'<ol>'+package_html+'</ol>'+'<hr style="margin:0px"></div>');
            }else{
                cost-=lab_test_cost;
                $("#lab-package-test-id-"+lab_test_value+"").remove();
            }
    

        }
      


        $('#total_bill').text(cost);
    
    })


    $(document).on('click', '.request_patient_btn', function(){
        var patient_id = $(this).data('patient-id');

        var checkbox_single_lab_test = [];
        var checkbox_package_lab_test = [];

        $('.checkbox_single_lab_test').each(function(index, value){
            if($(this).is(":checked")){
                checkbox_single_lab_test.push($(this).val())
            }
        });

        $('.checkbox_package_lab_test').each(function(index, value){
            if($(this).is(":checked")){
                checkbox_package_lab_test.push($(this).val())
            }
        });


        $.ajax({
            url: root_url+'system/reception/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Patient_id                  : patient_id,
                Lab_single_test_id          : JSON.stringify(checkbox_single_lab_test),
                Lab_package_test_id         : JSON.stringify(checkbox_package_lab_test),
                from                        : 'reception',
                action                      : 'patient-request'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    
                    alert(data.message);
                    // location.reload(true);
                    $('#view_receipt').modal();
                    $('#load_receipt').attr('src', 'http://localhost/clis/system/reception/receipt/index.php?tran_num='+data.tran_number);
                }

            }
        });
    
    })

    $(document).on('click', '.sent_out_patient_btn', function(){
        var patient_id = $(this).data('patient-id');

        $.ajax({
            url: root_url+'system/reception/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Patient_id                  : patient_id,
                user_id                     : $('#user_id').val(),
                lab_test_name               : $('#lab_test').val(),
                clinic_lab                  : $('#clinic_lab').val(),
                clinic_location             : $('#clinic_location').val(), 
                clinic_price                : $('#clinic_price').val(),                   
                from                        : 'reception',
                action                      : 'patient-send-out'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    
                    alert(data.message);
                    location.reload(true);
                    // $('#view_receipt').modal();
                    // $('#load_receipt').attr('src', 'http://localhost/clis/system/reception/receipt/index.php?tran_num='+data.tran_number);
                }

            }
        });
    
    })

    $(document).on('click', '.sentout_patient_btn', function(){
        var patient_id = $(this).data('patient-id');

        var checkbox_single_lab_test = [];
        var checkbox_package_lab_test = [];

        $('.checkbox_single_lab_test').each(function(index, value){
            if($(this).is(":checked")){
                checkbox_single_lab_test.push($(this).val())
            }
        });

        $('.checkbox_package_lab_test').each(function(index, value){
            if($(this).is(":checked")){
                checkbox_package_lab_test.push($(this).val())
            }
        });

        $.ajax({
            url: root_url+'system/reception/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Patient_id                  : patient_id,
                Lab_single_test_id          : JSON.stringify(checkbox_single_lab_test),
                Lab_package_test_id         : JSON.stringify(checkbox_package_lab_test),
                from                        : 'reception',
                action                      : 'patient-request-send-out'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                }

            }
        });
    
    })

    $('#update_patient_details').on('click', function(){
        $.ajax({
            url: root_url+'system/reception/patient-details/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Patient_id                      :   id_url,
                Patient_first_name              :   $('#patient_record_update_first_name').val(),
                Patient_middle_name             :   $('#patient_record_update_middle_name').val(),
                Patient_last_name               :   $('#patient_record_update_last_name').val(),
                Patient_sex                     :   $("input[name='sex']:checked").val(),
                Patient_date_of_birth           :   $('#patient_record_update_date_of_birth').val(),
                Patient_phone_number            :   $('#patient_record_update_phone_number').val(),
                Patient_email_address           :   $('#patient_record_update_email_address').val(),
                from                            :  'reception-patient-record',
                action                          :  'update-patient-details'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                    location.reload(true);
                }
            }
        });
    })

    $('.reprint-receipt').on('click', function(){
        var transaction_number = $(this).data('transaction-number');
        $('#reprint_receipt').modal();
        $('#load_reprint_receipt').attr('src', 'http://localhost/clis/system/reception/receipt/index.php?tran_num='+transaction_number);
    })


    // end patient

    // user management

    $('#new_user').on('click', function(){


        $.ajax({

            url: root_url+'system/admin/user-management/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                User_username                :   $('#new_user_username').val(),
                User_password                :   $('#new_user_password').val(),
                User_first_name              :   $('#new_user_first_name').val(),
                User_middle_name             :   $('#new_user_middle_name').val(),
                User_last_name               :   $('#new_user_last_name').val(),
                User_position                :   $('#new_user_position').val(),
                User_sex                     :   $("input[name='sex']:checked").val(),
                User_date_of_birth           :   $('#new_user_date_of_birth').val(),
                User_phone_number            :   $('#new_user_phone_number').val(),
                User_email_address           :   $('#new_user_email_address').val(),
                from        : 'admin-user-management',
                action      : 'new-user'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                }
            }
        });
    })

    $('#search_user').keyup(function(){
        var search  = $(this).val();

        $.ajax({

            url: root_url+'system/admin/user-management/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Search                  : search,
                from                    : 'admin-user-management',
                action                  : 'search-user'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
                    $('#user-search-result-table').prop('hidden', '');
                    if(data.length != 0 ){
                    $.each(data, function( index, value ) {
                        var status=(value.Active==1)?'ACITVE':'DEACTIVITED'; 
                        html+= '<tr>'+
                                    '<td>'+value.Username+'</td>'+
                                    '<td>'+value.First_name+' '+value.Middle_name+' '+value.Last_name+'</td>'+
                                    '<td>'+value.Position+'</td>'+
                                    '<td>'+status+'</td>'+
                                    '<td class="td-actions">'+
                                        '<a class="btn btn-small btn-success" href="'+current_url+'profile/index.php?id='+value.ID+'" role="button" ><i class="fa fa-edit"></i> Edit</a>'+
                                    '</td>'+
                                '</tr>';
                    });
                }else{
                    html+=  '<tr >'+
                                '<td colspan="5">NO FOUND USER ACCOUNT</td>'+
                            '</tr>';
                }

                $('#user-search-result-value').html(html)
                }
            }
        });
    })
    // Unused function, but not to remove
    $('#search_user_btn').on('click', function(){
        $.ajax({

            url: root_url+'system/admin/user-management/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Search                  : $('#search_user').val(),
                from                    : 'admin-user-management',
                action                  : 'search-user'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
                    $('#user-search-result-table').prop('hidden', '');
                    $.each(data, function( index, value ) {
                        html+= '<tr>'+
                                    '<td>'+value.Username+'</td>'+
                                    '<td>'+value.First_name+' '+value.Middle_name+' '+value.Last_name+'</td>'+
                                    '<td>'+value.Position+'</td>'+
                                    '<td class="td-actions">'+
                                        '<a class="btn btn-small btn-danger" href="#" role="button" ><i class="fa fa-ban"></i> Deactivate</a>'+
                                    '</td>'+
                                '</tr>';
                    });
                    $('#user-search-result-value').html(html)
                }
            }
        });
    })

    $('#search_user_position').keyup(function(){
        var search  = $(this).val();
        
        $.ajax({

            url: root_url+'system/admin/user-management/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Search                  : $('#search_user_position').val(),
                from                    : 'admin-user-management',
                action                  : 'search-user-position'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
                    $('#user-position-search-result-table').prop('hidden', '');
                    if(data.length != 0 ){
                    $.each(data, function( index, value ) {
                        html+= '<tr>'+
                                    '<td>'+value.Position+'</td>'+
                                    '<td class="td-actions">'+
                                        '<a class="btn btn-small btn-danger" href="#" role="button" ><i class="fa fa-ban"></i> Delete</a>'+
                                    '</td>'+
                                '</tr>';
                    });
                    }else{
                        html+=  '<tr >'+
                                    '<td colspan="2">NO FOUND POSITION</td>'+
                                '</tr>';
                    }
                    $('#user-position-search-result-value').html(html)
                }
            }
        });

    })
    // Unused function, but not to remove
    $('#search_user_position_btn').on('click', function(){
        $.ajax({

            url: root_url+'system/admin/user-management/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Search                  : $('#search_user_position').val(),
                from                    : 'admin-user-management',
                action                  : 'search-user-position'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
                    $('#user-position-search-result-table').prop('hidden', '');
                    $.each(data, function( index, value ) {
                        html+= '<tr>'+
                                    '<td>'+value.Position+'</td>'+
                                    '<td class="td-actions">'+
                                        '<a class="btn btn-small btn-danger" href="#" role="button" ><i class="fa fa-ban"></i> Delete</a>'+
                                    '</td>'+
                                '</tr>';
                    });
                    $('#user-position-search-result-value').html(html)
                }
            }
        });
    })


    $('#new_user_position_btn').on('click', function(){

        $.ajax({

            url: root_url+'system/admin/user-management/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Add_position            : $('#new_add_user_position').val(),
                from                    : 'admin-user-management',
                action                  : 'add-position'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
                    $('#user-position-search-result-table').prop('hidden', '');
                    $.each(data, function( index, value ) {
                        html+= '<tr>'+
                                    '<td>'+value.Position+'</td>'+
                                    '<td class="td-actions">'+
                                        '<a class="btn btn-small btn-danger" href="#" role="button" ><i class="fa fa-ban"></i> Delete</a>'+
                                    '</td>'+
                                '</tr>';
                    });
                    $('#user-position-search-result-value').html(html)
                }
            }
            
        });

    })

    $('#search_clinic_test').keyup(function(){

        var search = $(this).val();

        $.ajax({
            url: root_url+'system/admin/configuration/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Search                  : search,
                from                    : 'admin-configuration',
                action                  : 'search-clinic-test'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
                    $('#clinic-test-result-table').prop('hidden', '');
                if(data.length != 0 ){
                    $.each(data, function( index, value ) {
                        html+= '<tr>'+
                                    '<td>'+(index+1)+'</td>'+
                                    '<td>'+value.Abbreviation+'</td>'+
                                    '<td>'+value.Description+'</td>'+
                                    '<td>'+value.Price+'</td>'+
                                    '<td>'+ ((value.Available==1) ? "YES" : "NO" )+'</td>'+
                                    '<td>'+value.Datetime_created+'</td>'+
                                    '<td class="td-actions">'+
                                        '<a class="btn btn-small btn-primary" href="'+root_url+'system/admin/configuration/edit-lab-test/index.php?id='+value.ID+'" role="button" ><i class="fa fa-edit"></i> Edit</a>'+
                                    '</td>'+
                                '</tr>';
                    });
                }else{
                    html+=  '<tr >'+
                                '<td colspan="7">NO FOUND LAB TEST</td>'+
                            '</tr>';
                }
                    $('#clinic-test-result-value').html(html)
                }
            }
        });

    })
   // Unused function, but not to remove.
    $('#search_clinic_test_btn').on('click', function(){
        $.ajax({
            url: root_url+'system/admin/configuration/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Search                  : $('#search_clinic_test').val(),
                from                    : 'admin-configuration',
                action                  : 'search-clinic-test'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
                    $('#clinic-test-result-table').prop('hidden', '');
                    $.each(data, function( index, value ) {
                        html+= '<tr>'+
                                    '<td>'+(index+1)+'</td>'+
                                    '<td>'+value.Abbreviation+'</td>'+
                                    '<td>'+value.Description+'</td>'+
                                    '<td>'+value.Price+'</td>'+
                                    '<td>'+ ((value.Available==1) ? "YES" : "NO" )+'</td>'+
                                    '<td>'+value.Datetime_created+'</td>'+
                                    '<td class="td-actions">'+
                                        '<a class="btn btn-small btn-primary" href="'+root_url+'system/admin/configuration/edit-lab-test/index.php?id='+value.ID+'" role="button" ><i class="fa fa-edit"></i> Edit</a>'+
                                    '</td>'+
                                '</tr>';
                    });
                    $('#clinic-test-result-value').html(html)
                }
            }
        });
    })

    $('#new_clinic_test_btn').on('click', function(e){
        $('#lab_test_form').submit();
    })

    $('#lab_test_form').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: root_url+'system/admin/configuration/service.php',
            type: "POST",
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData:false,
            data: new FormData(this),
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                    // window.location.href = root_url+"account/profile/dashboard"; 
                }
            }
        });
    })

    var raw_price = 0;
    
    $('.checkbox_clinic_test').on('click', function(){
    
        if($(this).is(":checked")){
            raw_price+= $(this).data('price');
        }else{
            raw_price-= $(this).data('price');
        }

        $('#package_raw_price').text(raw_price);
        
    })

    $('#new_clinic_package_test_btn').on('click', function(){
        var insert_into_array = [];

        $('.checkbox_clinic_test').each(function(index, value){
            if($(this).is(":checked")){
                insert_into_array.push($(this).val());
            }
        });

        $.ajax({
            url: root_url+'system/admin/configuration/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Package_name                    : $('#new_add_clinic_package_test').val(),
                Price                           : $('#new_add_clinic_package_price').val(),
                Lab_test_id                     : JSON.stringify(insert_into_array),
                from                            : 'admin-configuration',
                action                          : 'add-clinic-package-test'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    location.reload(true);
                    alert(data.message);
                }
            }
        });


    })


    $('#search_clinic_package_test').keyup(function(){

        var search = $(this).val();


        $.ajax({
            url: root_url+'system/admin/configuration/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Search                  : search,
                from                    : 'admin-configuration',
                action                  : 'search-clinic-package-test'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
             
                    $('#clinic-package-test-result-table').prop('hidden', '');
                    if(data.length != 0 ){
                    $.each(data, function( index, value ) {
                        
                        html+= '<tr>'+
                                    '<td>'+(index+1)+'</td>'+
                                    '<td>'+value.Package_name+'</td>'+
                                    '<td>'+Package_list_test(value, 'list')+'</td>'+
                                    '<td>'+value.Price+'</td>'+
                                    '<td>'+ ((value.Available==1) ? "YES" : "NO" )+'</td>'+
                                    '<td>'+value.Datetime_created+'</td>'+
                                    // '<td class="td-actions">'+
                                    //     '<a class="btn btn-small btn-primary" href="'+root_url+'system/admin/configuration/edit-lab-package-test?id='+value.ID+'" role="button" ><i class="fa fa-edit"></i> Edit</a>'+
                                    // '</td>'+
                                '</tr>';

                    });
                }else{
                    html+=  '<tr >'+
                                '<td colspan="7">NO FOUND PACKAGE TEST</td>'+
                            '</tr>';
                }
                    $('#clinic-package-test-result-value').html(html)
                }
            }
        });

    })

    // Unused function, but not to remove
    $('#search_clinic_package_test_btn').on('click', function(){
        $.ajax({
            url: root_url+'system/admin/configuration/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Search                  : $('#search_clinic_test').val(),
                from                    : 'admin-configuration',
                action                  : 'search-clinic-package-test'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    var html = "";
             
                    $('#clinic-package-test-result-table').prop('hidden', '');
                    $.each(data, function( index, value ) {
                        
                        html+= '<tr>'+
                                    '<td>'+(index+1)+'</td>'+
                                    '<td>'+value.Package_name+'</td>'+
                                    '<td>'+Package_list_test(value, 'list')+'</td>'+
                                    '<td>'+value.Price+'</td>'+
                                    '<td>'+ ((value.Available==1) ? "YES" : "NO" )+'</td>'+
                                    '<td>'+value.Datetime_created+'</td>'+
                                    '<td class="td-actions">'+
                                        '<a class="btn btn-small btn-primary" href="'+root_url+'system/admin/configuration/edit-lab-test" role="button" ><i class="fa fa-edit"></i> Edit</a>'+
                                    '</td>'+
                                '</tr>';

                    });
                    $('#clinic-package-test-result-value').html(html)
                }
            }
        });
    })

    function Package_list_test(value, request){
        var html = "";
        html+='<ol>';

        $(value.Package_list_test).each(function(index, value){
            html+='<li>'+'P'+value.Price+' - '+value.Abbreviation+' ('+value.Description+')'+'</li>'
        })

        html+='</ol>';
      
        return html;
    }


    $('#template_add_label_btn').on('click', function(){

        var id = $(this).data('id');

        $.ajax({
            url: root_url+'system/admin/configuration/edit-lab-test/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                id                      : id,
                label                   : $('#template_add_label').val(),
                coordinate              : $('#template_add_label_coordinate').val(),
                from                    : 'edit-lab-test',
                action                  : 'add-label'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    $('#template_add_label').val('')
                    $('#template_add_label_coordinate').val('')
                    alert(data.message);
                }
            }
        });

    })

    $('#search_label').keyup(function(){
        var id = $(this).data('id');

        $.ajax({
            url: root_url+'system/admin/configuration/edit-lab-test/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                id                      : id,
                search                  : $(this).val(),
                from                    : 'edit-lab-test',
                action                  : 'search-label'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    lab_test(data);
                }
            }
        });

    })

    // Unused function, but to remove.
    $('#search_label_btn').on('click', function(){
        var id = $(this).data('id');

        $.ajax({
            url: root_url+'system/admin/configuration/edit-lab-test/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                id                      : id,
                search                  : $('#search_label').val(),
                from                    : 'edit-lab-test',
                action                  : 'search-label'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    lab_test(data);
                }
            }
        });
    })

    $(document).on('click','.delete-label', function(){

        var id = $(this).data('id');
        var lab_test_id = $(this).data('lab-test-id');
        
        $.ajax({
            url: root_url+'system/admin/configuration/edit-lab-test/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                id                      : id,
                lab_test_id             : lab_test_id,
                from                    : 'edit-lab-test',
                action                  : 'delete-label'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    lab_test(data);
                }
            }
        });

    })

    $(document).on('click','.update-label', function(){
        var id = $(this).data('id');
        $('#update-label-'+id).removeClass('btn-primary');
        $('#update-label-'+id).addClass('btn-success');

        $('#update-label-'+id).removeClass('update-label');
        $('#update-label-'+id).addClass('save-label');

        $('#update-label-'+id).prop('id', 'save-label-'+id);

        $('#btn-text-label-'+id).text('Save');
        $('#btn-icon-label-'+id).removeClass('fa-edit');
        $('#btn-icon-label-'+id).addClass('fa-save');


        $('#current-label-'+id).css('display', 'none');
        $('#current-value-'+id).css('display', 'none');
        $('#current-coordinate-'+id).css('display', 'none');
        

        $('#edit-label-'+id).css('display', 'block');
        $('#edit-value-'+id).css('display', 'block');
        $('#edit-coordinate-'+id).css('display', 'block');


        // alert(id);

    })

    $(document).on('click','.save-label', function(){

        var id = $(this).data('id');
        var lab_test_id = $(this).data('lab-test-id');

        $.ajax({
            url: root_url+'system/admin/configuration/edit-lab-test/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                id                      : id,
                lab_test_id             : lab_test_id,
                label                   : $('#edit-label-'+id).val(),
                value                   : $('#edit-value-'+id).val(),
                coordinate              : $('#edit-coordinate-'+id).val(),
                from                    : 'edit-lab-test',
                action                  : 'update-label'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);

                }else{

                    lab_test(data);
                }
            }
        });

        $('#save-label-'+id).removeClass('btn-success');
        $('#save-label-'+id).addClass('btn-primary');

        $('#save-label-'+id).removeClass('save-label');
        $('#save-label-'+id).addClass('update-label');

        $('#save-label-'+id).prop('id', 'update-label-'+id);

        $('#btn-text-label-'+id).text('Update');
        $('#btn-icon-label-'+id).removeClass('fa-save');
        $('#btn-icon-label-'+id).addClass('fa-edit');

        $('#current-label-'+id).css('display', 'block');
        $('#current-coordinate-'+id).css('display', 'block');
        
        $('#edit-label-'+id).css('display', 'none');
        $('#edit-coordinate-'+id).css('display', 'none');


    })

    function lab_test(data){
        var html = "";

        if(data.length!=0){ 
            $('#label-result-table').prop('hidden', '');
            $.each(data, function( index, value ) {
                html+= '<tr>'+
                            '<td>'+(index+1)+'</td>'+
                            '<td>'
                                +'<p id="current-label-'+value.ID+'">'+value.Label+'</p>'
                                +'<input type="text" class="" id="edit-label-'+value.ID+'" value="'+value.Label+'" style="display:none" ></input>'
                                +
                            '</td>'+
                            '<td>'
                                +'<p id="current-coordinate-'+value.ID+'">'+value.Coordinate+'</p>'
                                +'<input type="text" class="" id="edit-coordinate-'+value.ID+'" value="'+value.Coordinate+'" style="display:none"></input>'
                                +
                            '</td>'+
                            '<td>'+value.Datetime_created+'</td>'+
                            '<td class="td-actions"><button class="btn btn-small '+((value.Show_field==1)?"btn-primary":"btn-danger")+'  show-label" id="delete-label-'+value.ID+'" data-id="'+value.ID+'" data-show-field="'+value.Show_field+'" role="button" ><i class="fa fa-eye"></i> '+((value.Show_field==1)?"Visible":"Invisible")+'</button></td>'+
                            '<td class="td-actions td-more-actions">'+
                                '<button class="btn btn-small btn-danger delete-label" id="delete-label-'+value.ID+'" data-id="'+value.ID+'" role="button" ><i class="fa fa-trash"></i> Delete</button>'+
                                '<button class="btn btn-small btn-primary update-label" id="update-label-'+value.ID+'" data-lab-test-id="'+value.Lab_test_id+'" data-id="'+value.ID+'" role="button" ><i id="btn-icon-label-'+value.ID+'" class="fa fa-edit"></i> <span id="btn-text-label-'+value.ID+'"> Update</button>'+
                            '</td>'+
                        '</tr>';
            });
        }else{
            html+=  '<tr >'+
                        '<td colspan="6">NO FOUND LABEL</td>'+
                    '</tr>';
        }

       
        
        $('#label-result-value').html(html);
    }
    
    $(document).on('click', '.show-label', function(){

        var id = $(this).data('id');
        var show_field = $(this).data('show-field');

        $.ajax({
            url: root_url+'system/admin/configuration/edit-lab-test/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                id                           :   id,
                show_field                   :   show_field,
                User_username                :   $('#user_profile_update_username').val(),
                from                         :  'edit-lab-test',
                action                       :  'update-displays'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                    location.reload(true);
                }
            }
        });
    })

    $('#update_user_details').on('click', function(){
        $.ajax({
            url: root_url+'system/admin/user-management/profile/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                User_id                      :   id_url,
                User_username                :   $('#user_profile_update_username').val(),
                User_first_name              :   $('#user_profile_update_first_name').val(),
                User_middle_name             :   $('#user_profile_update_middle_name').val(),
                User_last_name               :   $('#user_profile_update_last_name').val(),
                User_position                :   $('#user_profile_update_position_id').val(),
                User_sex                     :   $("input[name='sex']:checked").val(),
                User_date_of_birth           :   $('#user_profile_update_date_of_birth').val(),
                User_phone_number            :   $('#user_profile_update_phone_number').val(),
                from                         :  'admin-user-management-profile',
                action                       :  'update-user-details'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                    location.reload(true);
                }
            }
        });
    })

    $('#user_deactivition').on('click', function(){
        $.ajax({
            url: root_url+'system/admin/user-management/profile/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                User_id                      :   id_url,
                User_status                  :   $('#user_profile_update_status').val(),
                from                         :  'admin-user-management-profile',
                action                       :  'update-user-status'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                    location.reload(true);
                }
            }
        });
    })

    $('.btn-upload').on('click', function(){
        $('.file-upload').click();
    })

    $('#user_profile_update_picture, .upload-btn-wrapper, .picture_message').mouseover(function(){
        $('#user_profile_update_picture').css({
            "background-color" : "rgba(228, 228, 228, 0.6)",
            "opacity" : "0.5",
        });

        $('.upload-btn-wrapper').css({
            'display':'block'
        });
        $('#picture_message').css('display','block');
    })

    $('#user_profile_update_picture, .upload-btn-wrapper, .picture_message').mouseout(function(){
        $('#user_profile_update_picture').css({
            "background-color" : "unset",
            "opacity" : "unset",
        });
        $('.upload-btn-wrapper').css({
            'display':'none'
        });
        $('#picture_message').css('display','none');   
    })
    
    $(document).on('change', '#user_picture', function(e){
        $('#user_picture_form').submit();
    });

    $('#user_picture_form').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: root_url+'system/admin/user-management/profile/service.php',
            type: "POST",
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData:false,
            data: new FormData(this),
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                }
                location.reload(true);
            }
        });
    })

    // end user management


    // start lab 


    $('.supply_status').on('click', function(){
        var id = $(this).data('id');
        var available = $(this).data('available');

        $.ajax({

            url: root_url+'system/laboratory/test-supply/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Lab_test_id             : id,
                Available               : available,
                from                    : 'laboratory',
                action                  : 'supply-status'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                    location.reload(true);
                }
            }
            
        });

    })


    $('.stat-lab').on('click', function(){

        var request_type_id = $(this).data('id');

        $('#widget-content').prop('hidden', '');

        $('.stat-lab').each(function(index, value){
            $(value).removeClass('stat-lab-active');
        })

        if(request_type_id==1){
            $('#lab-request-patient').prop('hidden', '');
            $('#lab-ongoing-patient').prop('hidden', 'hidden');
            $('#lab-release-patient').prop('hidden', 'hidden');
            $('#lab-pickup-patient').prop('hidden', 'hidden');
            $('#request_type_label').text("REQUEST");
            // $('#request_type_label').prepend("<i class='fa fa-paper-plane'</i> ");
            $(this).addClass('stat-lab-active');
        }
        if(request_type_id==2){
            $('#lab-ongoing-patient').prop('hidden', '');
            $('#lab-request-patient').prop('hidden', ' hidden');
            $('#lab-release-patient').prop('hidden', 'hidden');
            $('#lab-pickup-patient').prop('hidden', 'hidden');
            $('#request_type_label').text("ONGOING");
            $(this).addClass('stat-lab-active');
        }
        if(request_type_id==3){
            $('#lab-release-patient').prop('hidden', '');
            $('#lab-request-patient').prop('hidden', ' hidden');
            $('#lab-ongoing-patient').prop('hidden', 'hidden');
            $('#lab-pickup-patient').prop('hidden', 'hidden');
            $('#request_type_label').text("RELEASE");
            $(this).addClass('stat-lab-active');
        }
        if(request_type_id==4){
            $('#lab-pickup-patient').prop('hidden', '');
            $('#lab-release-patient').prop('hidden', 'hidden');
            $('#lab-request-patient').prop('hidden', ' hidden');
            $('#lab-ongoing-patient').prop('hidden', 'hidden');
            $('#request_type_label').text("PICK UP");
            $(this).addClass('stat-lab-active');
        }

    })

    $(this).keyup(function(e){
        var keycode = e.which;
        if(keycode == 13 && $('#confirmation_modal').is(":visible")){
            $('.proceed_confirm').click();
        }

    })

    workbook = new GC.Spread.Sheets.Workbook(document.getElementById("lab-test-template"));

    $('.proceed_confirm').on('click', function(){
        var lab_transaction_id = $(this).data('lab-transaction-id');
        var patient_id = $(this).data('patient-id');
        var lab_test_id = $(this).data('lab-test-id');
        var confirm_type = $(this).data('confirm-type');
        var json = JSON.stringify(workbook.toJSON());  
        var get_result = [];

        $('.lab-test-template').each(function(index, value){
            get_result.push(
                [
                    $(this).data('coordinate'),
                    $(this).val()
                ]);
        })
        // alert(lab_test_id);

        if(confirm_type=="accept"){
            $.ajax({
                url: root_url+'system/laboratory/transaction/service.php',
                type: "POST",
                dataType: "JSON",
                data: {
                    Lab_transaction_id      : lab_transaction_id,
                    Patient_id              : patient_id,
                    Lab_test_id             : lab_test_id,
                    from                    : 'laboratory',
                    action                  : 'accept-request'
                },
                success: function(data) {
                    if(data.error){
                        alert(data.message);
                    }else{
                        alert(data.message);
                        location.reload(true);
                    }
                }
            });
        }
        else if (confirm_type == "release"){
            
            $.ajax({
                url: root_url+'system/laboratory/transaction/service.php',
                type: "POST",
                dataType: "JSON",
                data: {
                    Lab_transaction_id      : lab_transaction_id,
                    Patient_id              : patient_id,
                    Lab_test_id             : lab_test_id,
                    Lab_result              : JSON.stringify(get_result),
                    from                    : 'laboratory',
                    action                  : 'release-result'
                },
                success: function(data) {
                    if(data.error){
                        alert(data.message);
                    }else{
                        alert(data.message);
                        location.reload(true);
                    }
                }
            });

        }
    })
    
    $('.confirming').on('click', function(){

        var lab_transaction_id = $(this).data('lab-transaction-id');
        var patient_id = $(this).data('patient-id');
        var lab_test_id = $(this).data('lab-test-id');
        var patient_name = $(this).data('patient-name');
        var confirm_type = $(this).data('confirm-type');

        $('#confirmation_modal').modal();
        $('#confirmation_patient_name').text(patient_name);
        
        if(confirm_type=="accept"){

            $('.proceed_confirm').attr('data-confirm-type', confirm_type);
            $('.proceed_confirm').attr('data-patient-id', patient_id);
            $('.proceed_confirm').attr('data-lab-transaction-id', lab_transaction_id);
            $('.proceed_confirm').attr('data-lab-test-id', lab_test_id);
            $('#confirmation_message').text('Would you like to proceed and accept this patient?');

        }else if(confirm_type=="release"){

            $('.proceed_confirm').attr('data-confirm-type', confirm_type);
            $('.proceed_confirm').attr('data-patient-id', patient_id);
            $('.proceed_confirm').attr('data-lab-transaction-id', lab_transaction_id);
            $('.proceed_confirm').attr('data-lab-test-id', lab_test_id);
            $('#confirmation_message').text('Would you like proceed and release the result of this patient?');

        }
        
    })

    // Unused function, but not to remove.
    $('.lab_accept').on('click', function(){

        var lab_transaction_id = $('.confirming').data('lab-transaction-id');
        var patient_id = $('.confirming').data('patient-id');
        $.ajax({
            url: root_url+'system/laboratory/transaction/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Lab_transaction_id      : lab_transaction_id,
                Patient_id              : patient_id,
                from                    : 'laboratory',
                action                  : 'accept-request'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                    location.reload(true);
                }
            }
        });

    })


    $(document).on('click', '.lab_release', function(){

        $('#patient_releasing_modal').modal();

        var patient_id = $(this).data('patient-id');
        var lab_test_id = $(this).data('lab-test-id');
        var patient_name = $(this).data('patient-name');
        var lab_transaction_id = $(this).data('lab-transaction-id');

        $('#releasing_patient_name').text(patient_name);

        $('.releasing_patient_btn').data('patient-id', patient_id);
        $('.releasing_patient_btn').data('lab-transaction-id', lab_transaction_id);


        $('.confirming').attr('data-lab-test-id', lab_test_id);
        $('.confirming').attr('data-patient-name', patient_name);
        $('.confirming').attr('data-patient-id', patient_id);
        $('.confirming').attr('data-lab-transaction-id', lab_transaction_id);

        $.ajax({
            url: root_url+'system/laboratory/transaction/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Patient_id              : patient_id,
                Lab_test_id             : lab_test_id,
                Lab_transaction_id      : lab_transaction_id,
                from                    : 'laboratory',
                action                  : 'lab-test-template'
            },
            success: function(data) {

                var flag = true;
                var html = "";

                $(data).each(function(index, value){

                    html+= '<div class="control-group" style="margin:0 auto;">'+								
                                '<label class="control-label" for="'+value.Label+'">'+value.Label+' :</label>'+
                                '<div class="controls">'+
                                    '<input type="text" class="span5 lab-test-template" data-coordinate="'+value.Coordinate+'" data-lab-test-template-id="'+value.ID+'" value="" placeholder="Enter value.">'+
                                '</div>'+
                            '</div>';
                    
                }); 
                // console.log(html);
                $('#lab-test-template').html(html);

                // setInterval(function(){ 
                //     if(flag){
                //         template(data);
                //         flag=false;
                //     }
                // }, 400);
                
            }
        });

    })




    // var spreadsheet = new GC.Spread.Sheets.Workbook(document.getElementById("lab-test-template-preview"),{sheetCount:1});

    // start grape city admin side
    // var filename = $('#excel_template').data('filename');


    var workbooks = new GC.Spread.Sheets.Workbook(document.getElementById("lab-test-template-preview"),{sheetCount:3});  
    var workbooks_export;
    var workbooks_import;
    var activeSheet = workbooks.getActiveSheet();

    $(document).on('click', '.lab_ready_to_pick_up_preview', function(){

        $.support.cors = true;
        // alert();
        // var activeSheet = workbooks.getActiveSheet();
        excelIO = new GC.Spread.Excel.IO();

        // var activeSheet = spreadsheet.getActiveSheet();
        var patient_id = $(this).data('patient-id');
        var lab_test_id = $(this).data('lab-test-id');
        var patient_name = $(this).data('patient-name');
        var lab_transaction_id = $(this).data('lab-transaction-id');
        $('#releasing_patient_name_preview').text(patient_name);
        $('.releasing_patient_btn').data('patient-id', patient_id);
        $('.releasing_patient_btn').data('lab-transaction-id', lab_transaction_id);

        $.ajax({
            url: root_url+'system/laboratory/transaction/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Lab_test_id             : lab_test_id,
                Patient_id              : patient_id,
                Lab_transaction_id      : lab_transaction_id,
                from                    : 'laboratory',
                action                  : 'lab-test-template-preview'
            },
            success: function(data) {
                var flag = true;

                $('#patient_releasing_modal_preview').modal();

                // setInterval(function(){ 
                //     if(flag){
                //         activeSheet.suspendPaint();
                //         // spreadsheet.fromJSON(JSON.parse(data.Json));
                //         activeSheet.getCell(10,02).text("HELLO"); 
                //         activeSheet.resumePaint();
                //         flag=false;
                //     }
                // }, 500);
                // console.log(data);
                var excelUrl = root_url+"assets/microsoft-office/excel-template/"+data[0].File_name;
    
                var oReq = new XMLHttpRequest();
            
                oReq.open('get', excelUrl, true);
                oReq.responseType = 'blob';
                oReq.onload = function () {
                    var blob = oReq.response;   
            
                    excelIO.open(blob, function(json){
                        jsonData = json;

                        setInterval(function(){ 
                            if(flag){

                                activeSheet.suspendPaint();

                                
                                workbooks.fromJSON(json);

                                workbooks_export = JSON.stringify(workbooks.getSheet(1).toJSON());
                                activeSheet.resumePaint();
                                
                                workbooks.removeSheet(0);
                                workbooks.setActiveSheet("1");

                                // activeSheet.getCell(05,10).text("HELLO");

                                flag=false;
                            }
                        }, 500);
                        workbooks.refresh();
                        resolve(workbook);
                    });

                };
                oReq.send();


                var flag1 = true; 
                var today = new Date();
                var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                setInterval(function(){ 
                    if(flag1){
                        var activeSheet = workbooks.getActiveSheet();
                        var requirement = ["Name", "Date", "Age", "Gender", "Medtech"];
                        var alphabet = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
                        $(data).each(function(index,value){

                            var split = (value.Coordinate).split(',');

                            var letterPosition = alphabet.indexOf(split[0]);

                            if(value.Label=="Name"){
                                value.Value = patient_name 
                            }
                            if(value.Label=="Date"){
                                value.Value =  date;
                            }
                            if(value.Label=="Age"){
                                value.Value = calculateAge(value.Date_of_birth);
                            }
                            if(value.Label=="Gender"){
                                value.Value = "Male" 
                            }
                            if(value.Label=="Medtech"){
                                value.Value = ($('#medtech').val()).toUpperCase()+", RMT";
                            }

                            // console.log(split[1]+","+letterPosition+" - "+value.Value);
                            // activeSheet.setValue(14, 4, "SAMPLE");

                            // if(value.Type == "Gender"){
                            //     if(value.Sex == "Male"){
                            //         split[1] = parseInt(split[1]);
                            //     }
                            //     else if (value.Sex == "Female"){
                            //         split[1] = parseInt(split[1])+1;
                            //     }
                            // }
                            // console.log(split[1]);
                            // var column = 0;
                            // if(value.Abbreviation=="CBC"){
                            //     column = (split[1]);
                            //     // console.log(value.Abbreviation);
                            // }else{
                            //     column = (split[1]-1);
                            // }

                            column = (split[1]-1);
                            activeSheet.setValue( column , letterPosition, value.Value);

                        });

                        // activeSheet.setValue(13, 4, "SAMPLE");
                        
                        // activeSheet.setValue(1, 1, "HELLO");


                        // var activeSheet = workbooks.getActiveSheet();

                        // // sheet.options.gridline = {color:"red", showVerticalGridline: true, showHorizontalGridline: false};
                        // // activeSheet.options.gridline.showHorizontalGridline = false;
                        // // activeSheet.options.gridline.showVGridline = false;
                        // activeSheet.options.rowHeaderVisible = false;
                        // activeSheet.options.colHeaderVisible = false;

                        // console.log(activeSheet.options.gridline);   

                        flag1=false;
                    }
                }, 1000);

            }
        });
    })


    $('#print_excel').on('click', function(){

        // if($('#lab-test-template-preview').length){
            
        //     $(this).attr("id","lab-test-template-preview-new");
        //     // $(this).attr("id","lab-test-template-preview-new");

            
        // }
        // var workbooks1 = new GC.Spread.Sheets.Workbook(document.getElementById("lab-test-template-preview-new"),{sheetCount:3});  


        // var activeSheet = workbooks1.getActiveSheetIndex();

        // var printInfo = activeSheet.printInfo();
        // printInfo.showGridLine(false);
        // activeSheet.(false);
        // activeSheet.options.setColumnHeaderVisible(false);
        // activeSheet.options.gridline.showHorizontalGridline = false;
        // activeSheet.options.gridline.showVerticalGridline = false;
        // console.log(activeSheet.options.gridline);

        
        // workbooks1.getSheet(1).fromJSON(JSON.parse(workbooks_export));


        // activeSheet.options.rowHeaderVisible = false;
        // activeSheet.options.colHeaderVisible = false;

        var activeSheet = workbooks.getActiveSheet();
        activeSheet.options.gridline.showHorizontalGridline = false;
        activeSheet.options.gridline.showVerticalGridline = false;
 
        // activeSheet.options.gridline = true;
        // console.log( activeSheet ); 

        
        // activeSheet
        workbooks.print(0);
    })


    //unused
    function loadJSON(file, callback) {  
        var xobj = new XMLHttpRequest();  
        xobj.overrideMimeType("application/txt");  
        xobj.open('GET', file, true);  
        xobj.onreadystatechange = function () {  
            if (xobj.readyState == 4 && xobj.status == "200") {  
                // Required use of an anonymous callback as .open will NOT return a value but simply returns undefined in asynchronous mode  
                callback(xobj.responseText);  
            }  
        };  
        xobj.send(null);  
    }  



    function template(data){
        
        $.support.cors = true;
       
        excelIO = new GC.Spread.Excel.IO();

        var excelUrl = root_url+"assets/microsoft-office/excel-template/"+data[0].File_name;
        var activeSheet = workbook.getActiveSheet();

        var oReq = new XMLHttpRequest();
        // console.log(oReq);
        oReq.open('get', excelUrl, true);
        oReq.responseType = 'blob';
        oReq.onload = function () {
            var blob = oReq.response;   
    
            excelIO.open(blob, function(json){
                jsonData = json;
                // console.log(jsonData);
                activeSheet.suspendPaint();  
                
                workbook.fromJSON(json);
                workbook.removeSheet(0);
                workbook.setActiveSheet("1");


                activeSheet.resumePaint(); 
                resolve(workbook);
            }, function (message) {
                // console.log(message);
            });
        };
        oReq.send();

        setCellValueByCoordinate(workbook, data);
    }

    function setCellValueByCoordinate(workbook, data, mergeCell=null){

        var require = [
            "Name", 
            "Date",
            "Age",
            "Gender",
            "Time taken",
            "Medtech name",
            "Medtech license no.",
            "Medtech position"
        ];

        var flag = true;
        setInterval(function(){ 
            if(flag){

                $(data).each(function(index, value){
                    if(value.Label==require[index]){

                        var activeSheet = workbook.getActiveSheet();
                        var split_coordinate = (value.Coordinate).split(',');
                        var y = parseInt(split_coordinate[0]);
                        var x = parseInt(split_coordinate[1]);

                        activeSheet.getCell(y,x).text("HELLO"); 

                 
                    }
                })

                flag=false;
            }
        }, 500);
    }



    $('.releasing_patient_btn').on('click', function(){
        var patient_id = $(this).data('patient-id');
        var lab_transaction_id = $(this).data('lab-transaction-id');
        
        var json = JSON.stringify(workbook.toJSON());  
        $.ajax({
            url: root_url+'system/laboratory/transaction/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Lab_transaction_id      : lab_transaction_id,
                Patient_id              : patient_id,
                Json                    : json ,
                from                    : 'laboratory',
                action                  : 'release-result'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                    location.reload(true);
                }
            }
        });


    })

    // var spreadsheet = new GC.Spread.Sheets.Workbook(document.getElementById("ss"));

    $('#test-test').on('click', function(){ 

        // alert("1");
        // var json = JSON.stringify($(this).data('json'));  
        // console.log(JSON.parse(json));
        // spreadsheet.suspendPaint();  
        // spreadsheet.fromJSON(JSON.parse(json));
        // spreadsheet.resumePaint();  
      })

      function export2txt(originalData) {

      
        const a = document.createElement("a");
        a.href = URL.createObjectURL(new Blob([JSON.stringify(originalData, null, 2)], {
          type: "text/plain"
        }));
        a.setAttribute("download", "data.json");
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
      }
    

      $('.notify').on('click', function(){
        var patient_id = $(this).data('patient-id');
        $.ajax({
            url: root_url+'system/laboratory/transaction/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                patient_id              : patient_id,
                from                    : 'laboratory',
                action                  : 'notify'
            },
            beforeSend: function(data){
                $('#loading').css('display', 'block');
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                    // sendStatus("OK");
                    // location.reload(true);

                }
            }
            
        });
    });

    $('.lab_ready_to_pick_up').on('click', function(){

        var lab_transaction_id = $(this).data('lab-transaction-id');
        var lab_test_id = $(this).data('lab-test-id');
        var patient_id = $(this).data('patient-id');
        $.ajax({

            url: root_url+'system/laboratory/transaction/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Lab_test_id             : lab_test_id,
                Lab_transaction_id      : lab_transaction_id,
                Patient_id              : patient_id,
                from                    : 'laboratory',
                action                  : 'ready-to-pickup'
            },
            beforeSend: function(data){
                $('#loading').css('display', 'block');
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);

                    var $a = $("<a>");
                    $a.attr("href",data.file);
                    $("body").append($a);
                    $a.attr("download",data.filename);
                    $a[0].click();
                    $a.remove();
                    
                    sendStatus("OK");
                    
                    // location.reload(true);
                }
            }
            
        });

        // var spreadsheetToprint = new GC.Spread.Sheets.Workbook(document.getElementById("lab-test-template-preview"),{sheetCount:1});
        // var activeSheetToprint = spreadsheetToprint.getActiveSheet();
        // var printInfoToprint = new GC.Spread.Sheets.Print.PrintInfo();
        // var lab_transaction_id = $(this).data('lab-transaction-id');
        // var lab_test_id = $(this).data('lab-test-id');
        // var patient_id = $(this).data('patient-id');

        
        // var reader = new FileReader();

        // activeSheetToprint.suspendPaint();

        // $.ajax({
        //     url: root_url+'system/laboratory/transaction/service.php',
        //     type: "POST",
        //     dataType: "JSON",
        //     data: {
        //         Lab_test_id             : lab_test_id,
        //         Lab_transaction_id      : lab_transaction_id,
        //         Patient_id              : patient_id,
        //         from                    : 'laboratory',
        //         action                  : 'ready-to-pickup'
        //     },
        //     beforeSend: function(data){
        //         $('#loading').css('display', 'block');
        //     },
        //     success: function(data) {
        //         if(data.error){
        //             alert(data.message);
        //         }else{
                    
        //             spreadsheetToprint.fromJSON(JSON.parse(data.Json));
        //             activeSheetToprint.resumePaint();

        //             // spreadsheetToprint.savePDF(function (blob) {
        //             //     reader.onload = function () {     
        //             //         var b64 = reader.result.replace(/^data:.+;base64,/, '');                                
        //             //         var datauri = "data:application/pdf;base64," + b64;
        //             //         // Email.send({
        //             //         //     Host : "smtp.gmail.com",
        //             //         //     Username : "clis.st.ezekiel.moreno@gmail.com",
        //             //         //     Password : "T^vYhhp$aeqOfE^6@O#7CXK$BRoCvQaSMtwdJ80nMJgKowna%!",
        //             //         //     To : data.Email_address,
        //             //         //     From : "clis.st.ezekiel.moreno@gmail.com",
        //             //         //     Subject : "RESULT - St. Ezekiel Moreno Clinic Laboratory ",
        //             //         //     Body : "Hi, Good day. We sent your "+data.Abbreviation+" ("+data.Description+")"
        //             //         //     +" as a result taken in our laboratory and serve your soft copy.",
        //             //         //     Attachments : [
        //             //         //         {
        //             //         //             name : data.Abbreviation+" ("+data.Description+")"+".pdf",
        //             //         //             data : datauri
        //             //         //         }],
        //             //         // }).then(
        //             //         //     message => done(message)
        //             //         // );
        //             //     };
        //             //     reader.readAsDataURL(blob);
        //             // }, function (error) {
        //             //     console.log(error); 
        //             // });

        //             sendStatus("OK");

        //             printInfoToprint.showRowHeader(GC.Spread.Sheets.Print.PrintVisibilityType.hide);
        //             printInfoToprint.showColumnHeader(GC.Spread.Sheets.Print.PrintVisibilityType.hide);
                    
        //             spreadsheetToprint.print(0);
                            
        //         }
        //     }
        // });
    })


    function sendStatus(message){
        var flag = true;
   
        if(message=="OK"){
            $('#loading_text').css('display', 'none');
            $('#email_sending').css('display', 'none');
            $('#sms_sending').css('display', 'none');
            
            $('#email_sent').css('display', 'block');
            $('#sms_sent').css('display', 'block');
        }else{
            $('#loading_text').css('display', 'none');
            $('#email_sending').css('display', 'none');
            $('#sms_sending').css('display', 'none');
            
            $('#email_failed').css('display', 'block');
            $('#sms_failed').css('display', 'block');
        }

        setInterval(function(){ 
            if(flag){
                location.reload(true);
                flag=false;
            }
        }, 2000);
    }


    $('#check_package_test').on('click', function(){
        if($(this).is(":checked")){

            $('#single_test').prop('hidden', 'hidden');
            $('#package_test').prop('hidden', '');

        }else{

            $('#single_test').prop('hidden', '');
            $('#package_test').prop('hidden', 'hidden');

        }
    })


    $('.redo').on('click', function(){
        var patient_name = $(this).data('patient-name');
        var redo_type = $(this).data('redo-type');
        var patient_id = $(this).data('patient-id');
        var lab_transaction_id = $(this).data('lab-transaction-id');

        $('#redo_modal').modal();

        $('.redo_process_patient_name').text(patient_name);
        $('.proceed_redo').data('redo-type', redo_type);

        $('.proceed_redo').attr('data-redo-type', redo_type);
        $('.proceed_redo').attr('data-patient-id', patient_id);
        $('.proceed_redo').attr('data-lab-transaction-id', lab_transaction_id);
    })

    $('.proceed_redo').on('click',function(){

        var redo_type = $(this).data('redo-type');

        var lab_transaction_id = $(this).data('lab-transaction-id');
        var patient_id = $(this).data('patient-id');

        var redo_username_authorize = $('#redo_username_authorize').val();
        var redo_username_password = $('#redo_username_password').val();
        var lab_test_status_id = 0;

        if(redo_type == "accept"){
            lab_test_status_id = 1;
        }
        else if (redo_type == "ongoing"){
            lab_test_status_id = 2;
        }

        $.ajax({
            url: root_url+'system/laboratory/transaction/service.php',
            type: "POST",
            dataType: "JSON",
            data: {      
                Lab_transaction_status_id   : lab_test_status_id,
                Lab_transaction_id          : lab_transaction_id,
                Patient_id                  : patient_id,
                User_username               : redo_username_authorize,
                User_password               : redo_username_password,
                from                        : 'laboratory',
                action                      : 'redo-lab-test'
            },
            success: function(data) {

                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                    
                    location.reload(true);
                }
              
            }
        });

    })



    // end lab 


    // report
    var previous_data = [];
    $('#generate_total_sales').on('click', function(){

        var lab_transaction_id = $(this).data('lab-transaction-id');
        var patient_id = $(this).data('patient-id');
        $.ajax({

            url: root_url+'system/report/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                Lab_test_single_id      : $('#single_lab_test').val(),
                Date_from               : $('#generate_total_sales_date_from').val(),
                Date_to                 : $('#generate_total_sales_date_to').val(),
                from                    : 'report',
                action                  : 'total-sales'
            },
            success: function(data) {
   
                var graph_label = [];
                var graph_value = [];
                var html = '';
                var income = 0;
                var expenses = 1000;
                var total_sales = 0;
                var total_expenses = 0;
                var total_income = 0;

                $(data).each(function(index, value){
                    graph_label.push(value.Abbreviation);
                    graph_value.push(parseInt(value.Price));
                    income  = value.Price - expenses;
                    html+= '<tr>'+
                                '<td>'+(index+1)+'</td>'+
                                '<td>'+value.Abbreviation+'</td>'+
                                '<td>'+value.Qty+'</td>'+
                                '<td>'+value.Price+'</td>'+
                            '</tr>';

                            total_sales+= parseInt(value.Price);
                            total_expenses+=parseInt(expenses);
                            total_income+=parseInt(income);

                            if (index === data.length - 1) {
                            html+=  '<tr>'+
                                        '<td></td>'+
                                        '<td></td>'+
                                        '<td></td>'+
                                        '<td>'+total_sales+' overall</td>'+
                                    '</tr>';
                            }
                        
                })

                // console.log(html);
                $('#lab-test-reports').html(html);
                // console.log(graph_label);
                // console.log(graph_value);

                var barChartData = {
                    labels: graph_label,
                    datasets: [
                            {
                                fillColor: "rgba(151,187,205,0.5)",
                                strokeColor: "rgba(151,187,205,1)",
                                data: graph_value
                            }
                        ]
                }

                // console.log(graph_value);
       
                var generate = true;
                $(previous_data).each(function (index, value){
                    if(value[index]==graph_value[index]){
                        generate = false;
                    }
                    // console.log(value[index]==graph_value[index]);
                })

                if(data.length!=0){
                    new Chart(document.getElementById("bar-chart").getContext("2d")).Bar(barChartData);
                    $('#lab_test_total_sales').prop('hidden','');

                }
                generate = true;
                previous_data.push(graph_value);

            }
        });

    })

    // end report

    // start settings 

    $('#change_password').on('click', function(){

        $.ajax({

            url: root_url+'system/settings/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
                User_account_id         : id_url,
                Old_password            : $('#old-password').val(),
                New_password            : $('#new-password').val(),
                Retype_new_password     : $('#retype-new-password').val(),
                from                    : 'settings',
                action                  : 'change-password'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    alert(data.message);
                    
                    location.reload(true);
                }
            }
            
        });

    })

    // end settings


    // start grape city admin side
    var filename = $('#excel_template').data('filename');

    if(filename !== undefined){
        $.support.cors = true;
        workbook = new GC.Spread.Sheets.Workbook(document.getElementById("excel_template"),{sheetCount:3});
        var activeSheet = workbook.getActiveSheet();
    
        excelIO = new GC.Spread.Excel.IO();

        var excelUrl = root_url+"assets/microsoft-office/excel-template/"+filename;
    
        var oReq = new XMLHttpRequest();
    
        oReq.open('get', excelUrl, true);
        oReq.responseType = 'blob';
        oReq.onload = function () {
            var blob = oReq.response;   
    
            excelIO.open(blob, function(json){
                jsonData = json;

                activeSheet.suspendPaint();
                workbook.fromJSON(json);
                
                activeSheet.resumePaint();     
                
                workbook.removeSheet(0);
                workbook.setActiveSheet("1");

                workbook.refresh();
                resolve(workbook);
            });

        };
        oReq.send();
    }

    // $('#clickme').on('click', function(){
 
    //     var activeSheet = workbook.getActiveSheet();
    //     activeSheet.getCell(29, 1).value("Any characters pushed outside the cell width are displayed as overflows.");

  
 
    // })




    // end grape city admin side
})
