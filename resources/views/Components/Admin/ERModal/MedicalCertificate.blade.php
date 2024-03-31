<!-- Modal -->
<div class="modal modal-lg fade" id="er_modal-medical_certificate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="er_modal_label-medical_certificate" aria-hidden="true">
  
  <div class="modal-dialog">
    
    <div class="modal-content">
      
      <div class="modal-header">
        <span class="modal-title" id="er_modal_label-medical_certificate">Medical Certificate <span id="er_modal-medical_certificate-id"></span> </span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>


      <form method="POST" id="er_modal-medical_certificate-form" action="">
        
        <div class="modal-body er_modal_body-medical_certificate">
          @include('Components.Admin.ERModal.Note')
          <input type="hidden" name="_token" id="er_modal-medical_certificate-form-_token" value="{{ csrf_token() }}">
          <input type="hidden" name="_method" id="er_modal-medical_certificate-form-_method" value="POST">
        
          <div class="row">
            <div class="col-6 mb-3">
              <label for="" class="form-label">Control No.</label>
              <input type="text" class="form-control" id="er_modal-medical_certificate-form-control_no" name="control_no" value="" disable>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_certificate-form-control_no-error"></span>
            </div>

            <div class="col-lg-6 mb-3 ">
              <label for="" class="form-label">Date</label>
              <input type="date" class="form-control" id="er_modal-medical_certificate-form-date" name="date" value="" disable>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_certificate-form-date-error"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-12 mb-3 ">
              <label for="" class="form-label">Patient Name</label>
              <input type="text" class="form-control" id="er_modal-medical_certificate-form-patient_name" name="patient_name" value="" disable>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_certificate-form-patient_name-error"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-4 mb-3">
              <label for="" class="form-label">Age</label>
              <input type="number" class="form-control" id="er_modal-medical_certificate-form-age" name="age" value="" disable>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_certificate-form-age-error"></span>
            </div>

            <div class="col-lg-4 mb-3">
              <label for="" class="form-label">Sex</label>
              <select class="form-select" id="er_modal-medical_certificate-form-sex" name="sex" disable>
                <option value="">--- Choose ---</option>
                @foreach($sexes as $sex)
                  <option value="{{ $sex }}">{{ ucwords($sex) }}</option>
                @endforeach
              </select>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_certificate-form-sex-error"></span>
            </div>

            <div class="col-lg-4 mb-3">
              <label for="" class="form-label">Civil Status</label>
              <select class="form-select" id="er_modal-medical_certificate-form-civil_status" name="civil_status" disable>
                <option value="">--- Choose ---</option>
                @foreach($civil_status as $cs)
                  <option value="{{ $cs }}">{{ ucwords($cs) }}</option>
                @endforeach
              </select>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_certificate-form-civil_status-error"></span>
            </div>
            
          </div>

          <div class="row">
            <div class="col-12 mb-3">
              <label for="" class="form-label">Date Examined/Confined/Consulted</label>
              <input type="date" class="form-control" id="er_modal-medical_certificate-form-date_examined" name="date_examined" value="" disable>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_certificate-form-date_examined-error"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-12 mb-3">
              <label for="" class="form-label">Address</label>
              <input type="text" class="form-control" id="er_modal-medical_certificate-form-address" name="address" value="" disable>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_certificate-form-address-error"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-12 mb-3">
              <label for="" class="form-label">Diagnosis</label>
              <textarea class="form-control" 
                id="er_modal-medical_certificate-form-diagnosis" 
                name="diagnosis"
                rows="5" 
                disable ></textarea>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_certificate-form-diagnosis-error"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-12 mb-3">
              <label for="" class="form-label">Remarks</label>
              <textarea class="form-control" 
                id="er_modal-medical_certificate-form-remarks" 
                name="remarks"
                rows="5" 
                disable ></textarea>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_certificate-form-remarks-error"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-12 mb-3">
              <label for="" class="form-label">Purpose</label>
              <input type="text" class="form-control" id="er_modal-medical_certificate-form-purpose" name="purpose" value="" disable>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_certificate-form-purpose-error"></span>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="er_modal-medical_certificate-form-submit">
            <label>Save</labe>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function delete_form_medical_certificate(btn_id, id){
    var btn_id = '#'+btn_id;
    var btn_val = $(btn_id).val();
    var url = "{{ route('Admin.ElectronicRecords.MedicalCertificate.Delete', ['mc_id' => '%mc_id%']) }}".replace('%mc_id%', btn_val);
    
    swal({
        title: "Are you sure?",
        text: `Delete Medical Certificate ${id}?`,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
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
    });
  }

  function update_form_medical_certificate(btn_id, id){
    var btn_id = '#'+btn_id;
    var btn_val = $(btn_id).val();
    
    var form = '#er_modal-medical_certificate-form';
    var url = "{{ route('Admin.ElectronicRecords.MedicalCertificate.Details', ['mc_id' => '%mc_id%']) }}".replace('%mc_id%', btn_val);
    
    $('#er_modal-medical_certificate-id').html(`#${id}`);

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
          var update_url = "{{ route('Admin.ElectronicRecords.MedicalCertificate.Update', ['mc_id' => '%mc_id%']) }}".replace('%mc_id%', btn_val);
          $('#er_modal-medical_certificate-form-_method').val('PUT');
          set_data_medical_certificate(response.data, update_url, true);
          $('#er_modal-medical_certificate').modal('show'); // hide the form
        }
      },
      error: function(response){
        console.log(response);
      }
    }).always(function(){
        load_btn(btn_id, false);
    });
  };

  function set_data_medical_certificate(data, url, disable_all=false){
    var form = '#er_modal-medical_certificate-form';

    $(form+'-control_no').val(data.control_no);
    $(form+'-date').val(data.date);
    $(form+'-patient_name').val(data.patient_name);
    $(form+'-age').val(data.age);
    $(form+'-sex').val(data.sex); 
    $(form+'-civil_status').val(data.civil_status); 
    $(form+'-address').val(data.address);
    $(form+'-date_examined').val(data.date_examined);
    $(form+'-diagnosis').val(data.diagnosis);
    $(form+'-remarks').val(data.remarks);
    $(form+'-purpose').val(data.purpose);

    // update form action url
    $(form).prop('action', url);

    // reset errors from the form
    reset_input_errors(form);
    
    // disable if the form is empty
    disable_if_not_empty($(form), disable_all);
  }

  function reset_form_medical_certificate(){
    // remove id field
    $('#er_modal-medical_certificate-id').html('');

    var data = new Object();

    data['control_no'] = "";
    data['date'] = "{{ $today }}";
    // variable from account details blade
    data['patient_name'] = "{{ $name }}"; 
    data['sex'] = "{{ $acc->pi_sex }}"; // from account details blade
    data['civil_status'] = "{{ $acc->pi_civil_status }}"; // from account details blade

    // comes from above php code
    data['age'] = "{{ $age }}";
    data['sex'] = "{{ $acc->pi_sex }}"; // from account details blade
    data['address'] = "{{ $address }}";
    data['diagnosis'] = "";
    data['remarks'] = "";
    data['purpose'] = "";
    
    $('#er_modal-medical_certificate-form-_method').val('POST');
    var url = "{{ route('Admin.ElectronicRecords.MedicalCertificate.Create', ['acc_id' => request()->acc_id]) }}";
    set_data_medical_certificate(data, url);
    console.log(data);
  }
    
  $(document).ready(function () {
    // if form-label is clicked
    $('.er_modal_body-medical_certificate > .row > div > .form-label').click(function(){
      un_lock_field($(this));
    });

    // if modal is open thru create new dropdown button
    $('a[data-bs-target="#er_modal-medical_certificate"][id="create_new-medical_certificate"]').click(function(){
      reset_form_medical_certificate();
    });

    // if btn form submit
    $('#er_modal-medical_certificate-form-submit').click(function(){
      var btn_id = '#er_modal-medical_certificate-form-submit';
      var form = '#er_modal-medical_certificate-form';

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
            $('#er_modal-medical_certificate').modal('hide'); // hide the form
            table.ajax.reload(null, false); // reset the table record
            reset_form_medical_certificate(); // reset the form
          }
        },
        error: function(response){
          console.log(response);
        }
      }).always(function(){
          load_btn(btn_id,false);
      });
    console.log(form_to_json($(form)));
    });
  });
</script>