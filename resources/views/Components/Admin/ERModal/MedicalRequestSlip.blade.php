<!-- Modal -->
<div class="modal modal-lg fade" id="er_modal-medical_request_slip" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="er_modal_label-medical_request_slip" aria-hidden="true">
  
  <div class="modal-dialog">
    
    <div class="modal-content">
      
      <div class="modal-header">
        <span class="modal-title" id="er_modal_label-medical_request_slip">Medical Request Slip</span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>


      <form method="POST" id="er_modal-medical_request_slip-form" action="">
        
        <div class="modal-body er_modal_body-medical_request_slip">
          @include('Components.Admin.ERModal.Note')
          <input type="hidden" name="_token" id="er_modal-medical_request_slip-form-_token" value="{{ csrf_token() }}">
          <input type="hidden" name="_method" id="er_modal-medical_request_slip-form-_method" value="POST">

          <div class="row">
              @php 
                if($acc->pi_firstname && $acc->pi_lastname){
                  $name = $acc->pi_firstname.(($acc->pi_middlename) ? ' '.$acc->pi_middlename[0].'. ' : ' ').$acc->pi_lastname;
                }
                else{
                  $name = null;
                }
              @endphp
              <div class="col-12 mb-3">
                <label for="" class="form-label">Patient Name</label>
                <input type="text" class="form-control" id="er_modal-medical_request_slip-form-patient_name" name="patient_name" value="">
                <span class="mt-1 invalid-feedback" id="er_modal-medical_request_slip-form-patient_name-error"></span>
              </div>
          </div>

          <div class="row">

            <div class="col-lg-4 mb-3">
              <label for="" class="form-label">Date</label>
              <input type="date" class="form-control" id="er_modal-medical_request_slip-form-date" name="date" value="">
              <span class="mt-1 invalid-feedback" id="er_modal-medical_request_slip-form-date-error"></span>
            </div>

            <div class="col-lg-4 mb-3">
              <label for="" class="form-label">Age</label>
              <input type="number" class="form-control" id="er_modal-medical_request_slip-form-age" name="age" value="">
              <span class="mt-1 invalid-feedback" id="er_modal-medical_request_slip-form-age-error"></span>
            </div>

            <div class="col-lg-4 mb-3">
              <label for="" class="form-label">Sex</label>
              <select class="form-select" id="er_modal-medical_request_slip-form-sex" name="sex">
                <option value="">--- choose ---</option>
                  @foreach(['female', 'male'] as $sex)
                    <option value="{{ $sex }}">
                        {{ ucwords($sex) }}
                    </option>
                  @endforeach
              </select>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_request_slip-form-sex-error"></span>
            </div>

          </div>

          <div class="row">

            <div class="col-12 mb-4">
              <label for="" class="form-label">Requested by</label>
              <input type="text" class="form-control" id="er_modal-medical_request_slip-form-requested_by" name="requested_by" value="">
              <span class="mt-1 invalid-feedback" id="er_modal-medical_request_slip-form-requested_by-error"></span>
            </div>

          </div>

          <div class="row">

            <div class="col-12 mb-3">
              <label class="form-label">Request for</label>

              <div class="form-check">
                <input class="form-check-input er_modal-medical_request_slip-form-request" type="checkbox" id="er_modal-medical_request_slip-form-chest_xray" name="chest_xray">
                <label class="form-check-label" for="er_modal-medical_request_slip-form-chest_xray">Chest X-ray</label>
              </div>

              <div class="form-check">
                <input class="form-check-input er_modal-medical_request_slip-form-request" type="checkbox" id="er_modal-medical_request_slip-form-cbc" name="cbc">
                <label class="form-check-label" for="er_modal-medical_request_slip-form-cbc">CBC</label>
              </div>

              <div class="form-check">
                <input class="form-check-input er_modal-medical_request_slip-form-request" type="checkbox" id="er_modal-medical_request_slip-form-urinalysis" name="urinalysis">
                <label class="form-check-label" for="er_modal-medical_request_slip-form-urinalysis">Urinalysis</label>
              </div>

              <div class="form-check">
                <input class="form-check-input er_modal-medical_request_slip-form-request" type="checkbox" id="er_modal-medical_request_slip-form-fecalysis" name="fecalysis">
                <label class="form-check-label" for="er_modal-medical_request_slip-form-fecalysis">Fecalysis</label>
              </div>

              <div class="form-check">
                <input class="form-check-input er_modal-medical_request_slip-form-request" type="checkbox" id="er_modal-medical_request_slip-form-drug_test" name="drug_test">
                <label class="form-check-label" for="er_modal-medical_request_slip-form-drug_test">Drug Test</label>
              </div>

              <div class="form-check">
                <input class="form-check-input er_modal-medical_request_slip-form-request" type="checkbox" id="er_modal-medical_request_slip-form-blood_typing" name="blood_typing">
                <label class="form-check-label" for="er_modal-medical_request_slip-form-blood_typing">Blood Typing</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <label for="" class="form-label">Others</label>
              <input type="text" class="form-control" id="er_modal-medical_request_slip-form-others" name="others" value="">
              <span class="mt-1 invalid-feedback" id="er_modal-medical_request_slip-form-others-error"></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="er_modal-medical_request_slip-form-submit">
            <label>Save</labe>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function delete_form_medical_request_slip(btn_id){
    var btn_id = '#'+btn_id;
    var btn_val = $(btn_id).val();
    var url = "{{ route('Admin.ElectronicRecords.MedicalRequestSlip.Delete', ['mrs_id' => '%mrs_id%']) }}".replace('%mrs_id%', btn_val);
    load_btn(btn_id, true);
    
    $.ajax({
      type: "POST",
      url: url,
      data : {
        '_token': '{{ csrf_token() }}',
        '_method': 'DELETE'
      },
      enctype: 'multipart/form-data',
      success: function(response){
        response = JSON.parse(response);
        console.log(response);
        toast(response.title, response.message, response.icon);
        if(response.status == 200){
          table.ajax.reload(null, false); // reset the table record
        }
      },
      error: function(response){
        console.log(response);
      }
    }).always(function(){
        load_btn(btn_id, false);
    });
  }

  function update_form_medical_request_slip(btn_id){
    var btn_id = '#'+btn_id;
    var btn_val = $(btn_id).val();
    
    var form = '#er_modal-medical_request_slip-form';
    var url = "{{ route('Admin.ElectronicRecords.MedicalRequestSlip.Details', ['mrs_id' => '%mrs_id%']) }}".replace('%mrs_id%', btn_val);

    reset_input_errors(form);
    load_btn(btn_id, true);
    
    $.ajax({
      type: "POST",
      url: url,
      data : {
        '_token': '{{ csrf_token() }}'
      },
      enctype: 'multipart/form-data',
      success: function(response){
        response = JSON.parse(response);
        console.log(response);
        if(response.status == 400){
          toast('Error!', 'Unable to retrieve form data!', 'error');
        }
        else{
          var update_url = "{{ route('Admin.ElectronicRecords.MedicalRequestSlip.Update', ['mrs_id' => '%mrs_id%']) }}".replace('%mrs_id%', btn_val);
          $('#er_modal-medical_request_slip-form-_method').val('PUT');
          set_data_medical_request_slip(response.data, update_url, true);
          $('#er_modal-medical_request_slip').modal('show'); // hide the form
        }
      },
      error: function(response){
        console.log(response);
      }
    }).always(function(){
        load_btn(btn_id, false);
    });
  };

  function set_data_medical_request_slip(data, url, disable_all=false){
    var form = '#er_modal-medical_request_slip-form';

    $(form+'-patient_name').val(data.patient_name);
    $(form+'-date').val(data.date);
    $(form+'-age').val(data.age);
    $(form+'-sex').val(data.sex);

    (data.chest_xray) ? $(form+'-chest_xray').prop('checked', true) : $(form+'-chest_xray').prop('checked', false);
    (data.cbc) ? $(form+'-cbc').prop('checked', true) : $(form+'-cbc').prop('checked', false);
    (data.urinalysis) ? $(form+'-urinalysis').prop('checked', true) : $(form+'-urinalysis').prop('checked', false);
    (data.fecalysis) ? $(form+'-fecalysis').prop('checked', true) : $(form+'-fecalysis').prop('checked', false);
    (data.drug_test) ? $(form+'-drug_test').prop('checked', true) : $(form+'-drug_test').prop('checked', false);
    (data.blood_typing) ? $(form+'-blood_typing').prop('checked', true) : $(form+'-blood_typing').prop('checked', false);

    $(form+'-others').val(data.others);
    $(form+'-requested_by').val(data.requested_by);

    // update form action url
    $(form).prop('action', url);

    // reset errors from the form
    reset_input_errors(form);
    
    // disable if the form is empty
    disable_if_not_empty($(form), disable_all);
  }

  function reset_form_medical_request_slip(){
    @php 
      //session variable
      $first_name = ucwords(\Crypt::decrypt(Session::get('hsp_user_data')['first_name']));
      $middle_name = ucwords(\Crypt::decrypt(Session::get('hsp_user_data')['middle_name'])); 
      $last_name = ucwords(\Crypt::decrypt(Session::get('hsp_user_data')['last_name'])); 

      // variable in account details blade
      $birthdate = $acc->pi_birthdate; 
      $today = date('Y-m-d');
      $age = date_diff(date_create($birthdate), date_create($today))->format('%y');
    @endphp 

    var data = new Object();
    // variable from account details blade
    data['patient_name'] = "{{ ($acc->pi_firstname.(' '.$acc->pi_middlename.' ' ?: ' ').$acc->pi_lastname) ?: '' }}"; 
    data['sex'] = "{{ $acc->pi_sex }}"; // from account details blade

    // comes from above php code
    data['date'] = "{{ $today }}";
    data['age'] = "{{ $age }}";

    // set to 0 for not checked
    data['chest_xray'] = 0;
    data['cbc'] = 0;
    data['urinalysis'] = 0;
    data['fecalysis'] = 0;
    data['drug_test'] = 0;
    data['blood_typing'] = 0;
    data['others'] = '';

    //from the session variable
    data['requested_by'] = "{{ $first_name.' '.$last_name }}"; 
    
    $('#er_modal-medical_request_slip-form-_method').val('POST');
    var url = "{{ route('Admin.ElectronicRecords.MedicalRequestSlip.Create', ['acc_id' => request()->acc_id]) }}";
    set_data_medical_request_slip(data, url);
    console.log(data);
  }
    
  $(document).ready(function () {
    // if form-label is clicked
    $('.er_modal_body-medical_request_slip > .row > div > .form-label').click(function(){
      un_lock_field($(this));
    });

    // if modal is open thru create new dropdown button
    $('a[data-bs-target="#er_modal-medical_request_slip"][id="create_new-medical_request_slip"]').click(function(){
      reset_form_medical_request_slip();
    });

    // if btn form submit
    $('#er_modal-medical_request_slip-form-submit').click(function(){
      var btn_id = '#er_modal-medical_request_slip-form-submit';
      var form = '#er_modal-medical_request_slip-form';

      reset_input_errors(form);
      load_btn(btn_id, true);
      
      $.ajax({
        type: "POST",
        url: $(form).attr('action'),
        data : form_to_json($(form)),
        enctype: 'multipart/form-data',
        success: function(response){
          response = JSON.parse(response);
          console.log(response);
          toast(response.title, response.message, response.icon);
          if(response.status == 400){
            $.each(response.errors, function(key, err_values){
                $(form+'-'+key+'-error').html(err_values);
                $(form+'-'+key).addClass('is-invalid');
            });
          }
          else{
            $('#er_modal-medical_request_slip').modal('hide'); // hide the form
            table.ajax.reload(null, false); // reset the table record
            reset_form_medical_request_slip(); // reset the form
          }
        },
        error: function(response){
          console.log(response);
        }
      }).always(function(){
          load_btn(btn_id,false);
      });
    });
  });
</script>