<!-- Modal -->
<div class="modal modal-lg fade" id="er_modal-excuse_slip" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="er_modal_label-excuse_slip" aria-hidden="true">
  
  <div class="modal-dialog">
    
    <div class="modal-content">
      
      <div class="modal-header">
        <span class="modal-title" id="er_modal_label-excuse_slip">Excuse Slip <span id="er_modal-excuse_slip-id"></span></span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>


      <form method="POST" id="er_modal-excuse_slip-form" action="">
        
        <div class="modal-body er_modal_body-excuse_slip">
          @include('Components.Admin.ERModal.Note')

          <input type="hidden" name="_token" id="er_modal-excuse_slip-form-_token" value="{{ csrf_token() }}">
          <input type="hidden" name="_method" id="er_modal-excuse_slip-form-_method" value="POST">

          <div class="row">
              <div class="col-12 mb-3">
                <label for="" class="form-label">Patient Name</label>
                <input type="text" class="form-control" id="er_modal-excuse_slip-form-patient_name" name="patient_name" value="">
                <span class="mt-1 invalid-feedback" id="er_modal-excuse_slip-form-patient_name-error"></span>
              </div>
          </div>

          <div class="row">

            <div class="col-lg-4 mb-3">
              <label for="" class="form-label">Date</label>
              <input type="date" class="form-control" id="er_modal-excuse_slip-form-date" name="date" value="">
              <span class="mt-1 invalid-feedback" id="er_modal-excuse_slip-form-date-error"></span>
            </div>

            <div class="col-lg-4 mb-3">
              <label for="" class="form-label">Age</label>
              <input type="number" class="form-control" id="er_modal-excuse_slip-form-age" name="age" value="">
              <span class="mt-1 invalid-feedback" id="er_modal-excuse_slip-form-age-error"></span>
            </div>

            <div class="col-lg-4 mb-3">
                <label for="" class="form-label">Department</label>
                <select class="form-select" id="er_modal-excuse_slip-form-department" name="department">
                    <option value="">--- Choose ---</option>
                    {!! $departments !!}
                </select>
               <span class="mt-1 invalid-feedback" id="er_modal-excuse_slip-form-department-error"></span>
            </div>

            <div class="col-lg-4 mb-3">
                <label for="" class="form-label">Program</label>
                <select class="form-select" id="er_modal-excuse_slip-form-program" name="program">
                    <option value="">--- Choose ---</option>
                    {!! $programs !!}
                </select>
               <span class="mt-1 invalid-feedback" id="er_modal-excuse_slip-form-program-error"></span>
            </div>
          </div>

          <div class="row">

            <div class="col-12 mb-4">
              <label for="" class="form-label">Authorized by</label>
              <input type="text" class="form-control" id="er_modal-excuse_slip-form-authorized_by" name="authorized_by" value="">
              <span class="mt-1 invalid-feedback" id="er_modal-excuse_slip-form-authorized_by-error"></span>
            </div>

            <div class="col-12 mb-3">
              <label for="" class="form-label">Complaints</label>
              <textarea class="form-control" 
                id="er_modal-excuse_slip-form-complaints" 
                name="complaints"
                rows="5" 
                disable ></textarea>
              <span class="mt-1 invalid-feedback" id="er_modal-excuse_slip-form-complaints-error"></span>
            </div>

            <div class="col-12 mb-3">
              <label for="" class="form-label">Diagnosis</label>
              <textarea class="form-control" 
                id="er_modal-excuse_slip-form-diagnosis" 
                name="diagnosis"
                rows="5" 
                disable ></textarea>
              <span class="mt-1 invalid-feedback" id="er_modal-excuse_slip-form-diagnosis-error"></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="er_modal-excuse_slip-form-submit">
            <label>Save</labe>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function delete_form_excuse_slip(btn_id, id){
    var btn_id = '#'+btn_id;
    var btn_val = $(btn_id).val();
    var url = "{{ route('Admin.ElectronicRecords.ExcuseSlip.Delete', ['es_id' => '%es_id%']) }}".replace('%es_id%', btn_val);
    
    swal({
        title: "Are you sure?",
        text: `Delete Medical Request Slip ${id}?`,
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

  function update_form_excuse_slip(btn_id, id){
    var btn_id = '#'+btn_id;
    var btn_val = $(btn_id).val();
    
    var form = '#er_modal-excuse_slip-form';
    var url = "{{ route('Admin.ElectronicRecords.ExcuseSlip.Details', ['es_id' => '%es_id%']) }}".replace('%es_id%', btn_val);
    
    $('#er_modal-excuse_slip-id').html(`#${id}`);

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
          var update_url = "{{ route('Admin.ElectronicRecords.ExcuseSlip.Update', ['es_id' => '%es_id%']) }}".replace('%es_id%', btn_val);
          $('#er_modal-excuse_slip-form-_method').val('PUT');
          // reset programs field and choose the programs passed to the data variable
          set_programs('#er_modal-excuse_slip-form-program', response.data.department, response.data.program);
          set_data_excuse_slip(response.data, update_url, true);
          $('#er_modal-excuse_slip').modal('show'); // show the form
        }
      },
      error: function(response){
        console.log(response);
      }
    }).always(function(){
        load_btn(btn_id, false);
    });
  };

  function set_data_excuse_slip(data, url, disable_all=false){
    console.log(data);
    var form = '#er_modal-excuse_slip-form';

    $(form+'-patient_name').val(data.patient_name);
    $(form+'-date').val(data.date);
    $(form+'-age').val(data.age);
    $(form+'-department').val(data.department);
    
    $(form+'-program').val(data.program);
    $(form+'-authorized_by').val(data.authorized_by);
    $(form+'-complaints').val(data.complaints);
    $(form+'-diagnosis').val(data.diagnosis);

    // update form action url
    $(form).prop('action', url);

    // reset errors from the form
    reset_input_errors(form);
    
    // disable if the form is empty
    disable_if_not_empty($('#er_modal-excuse_slip'), disable_all);
  }

  function reset_form_excuse_slip(){
    // remove id field
    $('#er_modal-excuse_slip-id').html('');

    var data = new Object();
    // variable from account details blade
    data['patient_name'] = "{{ $name }}"; 

    // comes from above php code
    data['date'] = "{{ $today }}";
    data['age'] = "{{ $age }}";

    data['department'] = "{{ $acc->dept_id }}";
    data['program'] = "{{ $acc->prog_id }}";

    //from the session variable
    data['authorized_by'] = "{{ $first_name.' '.$last_name }}";
     
    
    $('#er_modal-excuse_slip-form-_method').val('POST');
    var url = "{{ route('Admin.ElectronicRecords.ExcuseSlip.Create', ['acc_id' => request()->acc_id]) }}";
    
    // reset programs field and choose the programs passed to the data variable
    set_programs('#er_modal-excuse_slip-form-program', data['department'], data['program']);

    // first disable all fiels, because we do make the program values dynamic when 
    // the department have changed the program is not being disabled even if it has value.
    // to fix disable all fields, then enable other fields.
    set_data_excuse_slip(data, url, true);
    enable_input('#er_modal-excuse_slip-form-complaints, #er_modal-excuse_slip-form-diagnosis');

    console.log(data);
  }
    
  $(document).ready(function () {
    // if form-label is clicked
    $('.er_modal_body-excuse_slip > .row > div > .form-label').click(function(){
      un_lock_field($(this));
    });

    // if modal is open thru create new dropdown button
    $('a[data-bs-target="#er_modal-excuse_slip"][id="create_new-excuse_slip"]').click(function(){
      reset_form_excuse_slip();
    });

    // if btn form submit
    $('#er_modal-excuse_slip-form-submit').click(function(){
      var btn_id = '#er_modal-excuse_slip-form-submit';
      var form = '#er_modal-excuse_slip-form';

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
            $('#er_modal-excuse_slip').modal('hide'); // hide the form
            table.ajax.reload(null, false); // reset the table record
            reset_form_excuse_slip(); // reset the form
          }
        },
        error: function(response){
          console.log(response);
        }
      }).always(function(){
          load_btn(btn_id,false);
      });
    });

    $('#er_modal-excuse_slip-form-department').change(function(){
      set_programs('#er_modal-excuse_slip-form-program', $(this).val(), null);
    });
  });

 
</script>