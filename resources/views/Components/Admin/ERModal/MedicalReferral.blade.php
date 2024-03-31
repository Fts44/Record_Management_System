<!-- Modal -->
<div class="modal modal-lg fade" id="er_modal-medical_referral" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="er_modal_label-medical_referral" aria-hidden="true">
  
  <div class="modal-dialog">
    
    <div class="modal-content">
      
      <div class="modal-header">
        <span class="modal-title" id="er_modal_label-medical_referral">Medical Referral <span id="er_modal-medical_referral-id"></span> </span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>


      <form method="POST" id="er_modal-medical_referral-form" action="">
        
        <div class="modal-body er_modal_body-medical_referral">
          @include('Components.Admin.ERModal.Note')
          <input type="hidden" name="_token" id="er_modal-medical_referral-form-_token" value="{{ csrf_token() }}">
          <input type="hidden" name="_method" id="er_modal-medical_referral-form-_method" value="POST">
        
          <div class="row">
            <div class="col-lg-4 mb-3 ">
              <label for="" class="form-label">Date</label>
              <input type="date" class="form-control" id="er_modal-medical_referral-form-date" name="date" value="" disable>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_referral-form-date-error"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-12 mb-3 ">
              <label for="" class="form-label">Patient Name</label>
              <input type="text" class="form-control" id="er_modal-medical_referral-form-patient_name" name="patient_name" value="" disable>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_referral-form-patient_name-error"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-4 mb-3">
              <label for="" class="form-label">Age</label>
              <input type="number" class="form-control" id="er_modal-medical_referral-form-age" name="age" value="" disable>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_referral-form-age-error"></span>
            </div>

            <div class="col-lg-4 mb-3">
              <label for="" class="form-label">Sex</label>
              <select class="form-select" id="er_modal-medical_referral-form-sex" name="sex" disable>
                <option value="">--- Choose ---</option>
                @foreach($sexes as $sex)
                  <option value="{{ $sex }}">{{ ucwords($sex) }}</option>
                @endforeach
              </select>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_referral-form-sex-error"></span>
            </div>

            <div class="col-lg-4 mb-3">
                <label for="" class="form-label">Department</label>
                <select class="form-select" id="er_modal-medical_referral-form-department" name="department">
                    <option value="">--- Choose ---</option>
                    {!! $departments !!}
                </select>
               <span class="mt-1 invalid-feedback" id="er_modal-medical_referral-form-department-error"></span>
            </div>

            <div class="col-lg-4 mb-3">
                <label for="" class="form-label">Program</label>
                <select class="form-select" id="er_modal-medical_referral-form-program" name="program">
                    <option value="">--- Choose ---</option>
                    {!! $programs !!}
                </select>
               <span class="mt-1 invalid-feedback" id="er_modal-medical_referral-form-program-error"></span>
            </div>
            
          </div>

          <div class="row">
            <div class="col-12 mb-3">
              <label for="" class="form-label">To</label>
              <input type="text" class="form-control" id="er_modal-medical_referral-form-to" name="to" value="" disable>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_referral-form-to-error"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-12 mb-3">
              <label for="" class="form-label">Evaluation Type</label>
              <textarea class="form-control" 
                id="er_modal-medical_referral-form-evaluation_type" 
                name="evaluation_type"
                rows="5" 
                disable ></textarea>
              <span class="mt-1 invalid-feedback" id="er_modal-medical_referral-form-evaluation_type-error"></span>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="er_modal-medical_referral-form-submit">
            <label>Save</labe>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function delete_form_medical_referral(btn_id, id){
    var btn_id = '#'+btn_id;
    var btn_val = $(btn_id).val();
    var url = "{{ route('Admin.ElectronicRecords.MedicalReferral.Delete', ['mr_id' => '%mr_id%']) }}".replace('%mr_id%', btn_val);
    
    swal({
        title: "Are you sure?",
        text: `Delete Medical Referral ${id}?`,
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

  function update_form_medical_referral(btn_id, id){
    var btn_id = '#'+btn_id;
    var btn_val = $(btn_id).val();
    
    var form = '#er_modal-medical_referral-form';
    var url = "{{ route('Admin.ElectronicRecords.MedicalReferral.Details', ['mr_id' => '%mr_id%']) }}".replace('%mr_id%', btn_val);
    
    $('#er_modal-medical_referral-id').html(`#${id}`);

    reset_input_errors(form);
    load_btn(btn_id, true);
    
    $.ajax({
      type: "POST",
      url: url,
      async: true,
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
          var update_url = "{{ route('Admin.ElectronicRecords.MedicalReferral.Update', ['mr_id' => '%mr_id%']) }}".replace('%mr_id%', btn_val);
          $('#er_modal-medical_referral-form-_method').val('PUT');

          // reset programs field and choose the programs passed to the data variable
          set_programs('#er_modal-medical_referral-form-program', response.data.department, response.data.program);
          
          set_data_medical_referral(response.data, update_url, true);
          $('#er_modal-medical_referral').modal('show'); // hide the form
        }
      },
      error: function(response){
        console.log(response);
      }
    }).always(function(){
        load_btn(btn_id, false);
    });
  };

  function set_data_medical_referral(data, url, disable_all=false){
    var form = '#er_modal-medical_referral-form';

    $(form+'-date').val(data.date);
    $(form+'-patient_name').val(data.patient_name);
    $(form+'-age').val(data.age);
    $(form+'-sex').val(data.sex); 
    $(form+'-department').val(data.department); 
    $(form+'-program').val(data.program); 
    $(form+'-to').val(data.to); 
    $(form+'-evaluation_type').val(data.evaluation_type);
    
    // update form action url
    $(form).prop('action', url);

    // reset errors from the form
    reset_input_errors(form);
    
    // disable if the form is empty
    disable_if_not_empty($(form), disable_all);
  }

  function reset_form_medical_referral(){
    // remove id field
    $('#er_modal-medical_referral-id').html('');

    var data = new Object();

    data['date'] = "{{ $today }}";
    // variable from account details blade
    data['patient_name'] = "{{ $name }}"; 
    data['sex'] = "{{ $acc->pi_sex }}"; // from account details blade

    // comes from above php code
    data['age'] = "{{ $age }}";
    data['sex'] = "{{ $acc->pi_sex }}"; // from account details blade
    data['department'] = "{{ $acc->dept_id }}";
    data['program'] = "{{ $acc->prog_id }}";
    
    data['to'] = "";
    data['evaluation_type'] = "";
    
    $('#er_modal-medical_referral-form-_method').val('POST');
    var url = "{{ route('Admin.ElectronicRecords.MedicalReferral.Create', ['acc_id' => request()->acc_id]) }}";
    
    // reset programs field and choose the programs passed to the data variable
    set_programs('#er_modal-medical_referral-form-program', data['department'], data['program']);

    // first disable all fiels, because we do make the program values dynamic when 
    // the department have changed the program is not being disabled even if it has value.
    // to fix disable all fields, then enable other fields.
    set_data_medical_referral(data, url, true);
    enable_input('#er_modal-medical_referral-form-to, #er_modal-medical_referral-form-evaluation_type');

    console.log(data);
  }
    
  $(document).ready(function () {
    // if form-label is clicked
    $('.er_modal_body-medical_referral > .row > div > .form-label').click(function(){
      un_lock_field($(this));
    });

    // if modal is open thru create new dropdown button
    $('a[data-bs-target="#er_modal-medical_referral"][id="create_new-medical_referral"]').click(function(){
      reset_form_medical_referral();
    });

    // if btn form submit
    $('#er_modal-medical_referral-form-submit').click(function(){
      var btn_id = '#er_modal-medical_referral-form-submit';
      var form = '#er_modal-medical_referral-form';

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
            $('#er_modal-medical_referral').modal('hide'); // hide the form
            table.ajax.reload(null, false); // reset the table record
            reset_form_medical_referral(); // reset the form
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

    $('#er_modal-medical_referral-form-department').change(function(){
      set_programs('#er_modal-medical_referral-form-program', $(this).val(), null);
    });
  });
</script>