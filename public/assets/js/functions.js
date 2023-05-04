// ====================================================================================
// By: Joseph E. Calma
// 
// Date Updated: 1/29/23
// 
// ====================================================================================

function show_password(input_selector){
    const pass_type = $(input_selector).attr('type');
    
    if(pass_type == "password"){
        $('.show-password-icon').removeClass('bi-eye-slash');
        $('.show-password-icon').addClass('bi-eye');
        $(input_selector).attr('type', 'text');
    }
    else{
        $('.show-password-icon').removeClass('bi-eye');
        $('.show-password-icon').addClass('bi-eye-slash');
        $(input_selector).attr('type', 'password');
    }
}

function load_btn(btn, disable){
    if(disable==false){
        $(btn+' .loader').remove();
        $(btn+' label').removeClass('d-none');
        $(btn).prop('disabled', false);
    }
    else{
        $(btn).append('<div class="spinner-border spinner-border-sm text-light loader"></div>');
        $(btn+' label').addClass('d-none');
        $(btn).prop('disabled', true);
    }
}

function toast(title, message, icon){
    $.toast({
        heading: title,
        text: message,
        icon: icon,
        showHideTransition: 'slide',
        position: 'top-left',
    });
}

function reset_input_errors(){
    $('.invalid-feedback').html('');
    $('.form-select, .form-control').removeClass('is-invalid');
    $('.my-invalid-feedback').html('');
}

function clear_select(input, default_text){
    $(input).empty();
    $(input).append($('<option>', {
        value: '',
        text: default_text
    }));
}

function ucwords(str){
	var result = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    	return letter.toUpperCase();
	});
	return result;
}

function set_municipality(select_mun, mun_code, prov_code, select_brgy){
    $(select_mun).empty();
    clear_select(select_mun,'--- choose ---');
    clear_select(select_brgy,'--- choose ---');
    $.ajax({
        url: window.location.origin+"/populate/municipality/"+prov_code,
        type: "GET",
        success: function (response) {      
            $.each( response, function( key, item ) {
                $(select_mun).append($('<option>', { 
                    value: item.mun_code,
                    text : item.mun_name,
                    selected: (item.mun_code==mun_code) ? true : false
                }));
            });
        },
        error: function(response) {
            console.log(response);
        }
    });
};

function set_barangay(select_brgy, brgy_code, mun_code){
    $(select_brgy).empty();
    clear_select(select_brgy,'--- choose ---');
    $.ajax({
        url: window.location.origin+"/populate/barangay/"+mun_code,
        type: "GET",
        success: function (response) {      
            $.each( response, function( key, item ) {
                $(select_brgy).append($('<option>', { 
                    value: item.brgy_code,
                    text : item.brgy_name,
                    selected: (item.brgy_code==brgy_code) ? true : false
                }));
            });
        },
        error: function(response) {
            console.log(response);
        }
    });
};

function set_department(select_dept, dept_id, gl_id, select_program){
    $(select_dept).empty();
    $(select_program).empty();
    clear_select(select_dept,'--- choose ---');
    clear_select(select_program,'--- choose ---');
    $.ajax({
        url: window.location.origin+"/populate/department/"+gl_id,
        type: "GET",
        success: function (response) {      
            $.each( response, function( key, item ) {
                $(select_dept).append($('<option>', { 
                    value: item.dept_id,
                    text : item.dept_code,
                    selected: (item.dept_id==dept_id) ? true : false
                }));
            });
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function set_program(select_prog, prog_id, dept_id){
    $(select_prog).empty();
    clear_select(select_prog,'--- choose ---');
    $.ajax({
        url: window.location.origin+"/populate/program/"+dept_id,
        type: "GET",
        success: function (response) {      
            $.each( response, function( key, item ) {
                $(select_prog).append($('<option>', { 
                    value: item.prog_id,
                    text : item.prog_code,
                    selected: (item.prog_id==prog_id) ? true : false
                }));
            });
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function set_year_level(select_year_level, yl_id, gl_id){
    $(select_year_level).empty();
    clear_select(select_year_level,'--- choose ---');
    $.ajax({
        url: window.location.origin+"/populate/yearlevel/"+gl_id,
        type: "GET",
        success: function (response) {      
            $.each( response, function( key, item ) {
                $(select_year_level).append($('<option>', { 
                    value: item.yl_id,
                    text : item.yl_name,
                    selected: (item.yl_id==yl_id) ? true : false
                }));
            });
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function clear_input(input_id){
    $(input_id).val('');
}

function disable_input(input_id){
    $(input_id).attr('disabled', true);
    $(input_id).removeClass('is-invalid', true);
}

function enable_input(input_id){
    $(input_id).attr('disabled', false);
}

function clear_disable_enable_input(basis_input_id, input_id){
    basis = $(basis_input_id).val();

    if(basis=="yes" || basis==true){
        enable_input(input_id);
    }
    else{
        clear_input(input_id);
        disable_input(input_id);
    }
}

function clear_select(input, default_text){
    $(input).empty();
    $(input).append($('<option>', {
        value: '',
        text: default_text
    }));
}

function ucwords(str){
	var result = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    	return letter.toUpperCase();
	});
	return result;
}

function set_municipality(select_mun, mun_code, prov_code, select_brgy){
    $(select_mun).empty();
    clear_select(select_mun,'--- choose ---');
    clear_select(select_brgy,'--- choose ---');
    $.ajax({
        url: window.location.origin+"/populate/municipality/"+prov_code,
        type: "GET",
        success: function (response) {      
            $.each( response, function( key, item ) {
                $(select_mun).append($('<option>', { 
                    value: item.mun_code,
                    text : item.mun_name,
                    selected: (item.mun_code==mun_code) ? true : false
                }));
            });
        },
        error: function(response) {
            console.log(response);
        }
    });
};

function set_barangay(select_brgy, brgy_code, mun_code){
    $(select_brgy).empty();
    clear_select(select_brgy,'--- choose ---');
    $.ajax({
        url: window.location.origin+"/populate/barangay/"+mun_code,
        type: "GET",
        success: function (response) {      
            $.each( response, function( key, item ) {
                $(select_brgy).append($('<option>', { 
                    value: item.brgy_code,
                    text : item.brgy_name,
                    selected: (item.brgy_code==brgy_code) ? true : false
                }));
            });
        },
        error: function(response) {
            console.log(response);
        }
    });
};

function set_department(select_dept, dept_id, gl_id, select_program){
    $(select_dept).empty();
    $(select_program).empty();
    clear_select(select_dept,'--- choose ---');
    clear_select(select_program,'--- choose ---');
    $.ajax({
        url: window.location.origin+"/populate/department/"+gl_id,
        type: "GET",
        success: function (response) {      
            $.each( response, function( key, item ) {
                $(select_dept).append($('<option>', { 
                    value: item.dept_id,
                    text : item.dept_code,
                    selected: (item.dept_id==dept_id) ? true : false
                }));
            });
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function set_program(select_prog, prog_id, dept_id){
    $(select_prog).empty();
    clear_select(select_prog,'--- choose ---');
    $.ajax({
        url: window.location.origin+"/populate/program/"+dept_id,
        type: "GET",
        success: function (response) {      
            $.each( response, function( key, item ) {
                $(select_prog).append($('<option>', { 
                    value: item.prog_id,
                    text : item.prog_code,
                    selected: (item.prog_id==prog_id) ? true : false
                }));
            });
        },
        error: function(response) {
            console.log(response);
        }
    });
}