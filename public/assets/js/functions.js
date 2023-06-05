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

function alert_show(icon, message, type){
    $('#live-alert').html("");

    switch(icon) {
        case 'success':
            icon = '<i class="bi bi-check-circle-fill"></i>';
            type = "success";
            break;
        case 'error':
            icon = '<i class="bi bi-x-circle-fill"></i>';
            type = "danger";
            break;
        case 'warning':
            icon = '<i class="bi bi-exclamation-circle-fill"></i>';
            type = "warning";
            break;
        default:
            icon = '<i class="bi bi-question-circle-fill"></i>';
            type = "primary";
            break;
    }

    const wrapper = document.createElement('div');

    wrapper.innerHTML = [
        `<div class="alert alert-${type} alert-dismissible" role="alert" id="alert">`,
        `   <div>${icon} ${message}</div>`,
        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
        '</div>'
    ].join('')

    $('#live-alert').append(wrapper);

    setTimeout(function() {
        $("#alert").fadeTo(1000, 500).slideUp(500, function(){
            $("#alert").alert('close');
        });
    }, 3000);
}

function reset_input_errors(id=null){
    if(id==null){
        $('.invalid-feedback').html('');
        $('.form-select, .form-control, .my-form-control').removeClass('is-invalid');
        $('.my-invalid-feedback').html('');
    }
    else{
        $(id+' .invalid-feedback').html('');
        $(id+' .form-select, .form-control, .my-form-control').removeClass('is-invalid');
        $(id+' .my-invalid-feedback').html('');
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

function leftPad(number, targetLength) {
    var output = number + '';
    while (output.length < targetLength) {
        output = '0' + output;
    }
    return output;
}

function set_municipalities(select_mun, prov_id, mun_id, select_brgy){
    $(select_mun).empty();
    clear_select(select_mun,'--- Choose City ---');
    clear_select(select_brgy,'--- Choose Barangay ---');
    prov_id = (prov_id=="") ? null : prov_id;
    $.ajax({
        url: window.location.origin+"/populate/municipalities/"+prov_id+"/"+mun_id+"/true",
        type: "GET",
        success: function (response) {      
            $(select_mun).append(response);
        },
        error: function(response) {
            console.log(response);
        }
    });
};

function set_barangays(select_brgy, mun_id, brgy_id){
    $(select_brgy).empty();
    clear_select(select_brgy,'--- Choose Barangay ---');
    mun_id = (mun_id=="") ? null : mun_id;
    $.ajax({
        url: window.location.origin+"/populate/barangays/"+mun_id+"/"+brgy_id+"/true",
        type: "GET",
        success: function (response) {      
            $(select_brgy).append(response);
        },
        error: function(response) {
            console.log(response);
        }
    });
};

function set_departments(select_dept, gl_id, dept_id, select_program){
    $(select_dept).empty();
    $(select_program).empty();
    clear_select(select_dept,'--- Choose ---');
    clear_select(select_program,'--- Choose ---');
    gl_id = (gl_id=="") ? null : gl_id;
    $.ajax({
        url: window.location.origin+"/populate/departments/"+gl_id+"/"+dept_id+"/true",
        type: "GET",
        success: function (response) {      
            $(select_dept).append(response);
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function set_programs(select_prog, dept_id, prog_id){
    $(select_prog).empty();
    clear_select(select_prog,'--- Choose ---');
    dept_id = (dept_id=="") ? null : dept_id;
    $.ajax({
        url: window.location.origin+"/populate/programs/"+dept_id+"/"+prog_id+"/true",
        type: "GET",
        success: function (response) {      
            $(select_prog).append(response);
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