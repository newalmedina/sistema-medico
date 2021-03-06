
<div class="modal fade" id="edit_personal_modal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div id="" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('base.Editar personal')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="personal_edit_form" class="modal-body form-row p-">
            <!-- SmartWizard html -->
            <div class="form-group col-md-6">
                <label for="name" class="col-form-label">@lang('base.Nombre')</label>
                <input type="text" name="name" class="form-control" id="">
                <div name='name_error' class="text-danger font-italic "></div>
            </div>
            <div class="form-group col-md-6">
                <label for="surname" class="col-form-label">@lang('base.Apellidos')</label>
                <input type="text" name="surnames" class="form-control" id="">
                <div name='surnames_error' id="surname_error" class="text-danger font-italic "></div>
            </div>
            <div class="form-group col-3 col-md-3">
                <label for="is_admin" class="col-form-label d-block">@lang('base.Admin')</label>
                <input type="checkbox" value="1" name="is_admin" class="form-control switch" id="">
                <div name='is_admin_error' class="text-danger font-italic "></div>
            </div>
            <div class="form-group col-6 col-md-3">
                <label for="is_active" class="col-form-label d-block">@lang('base.Activo')</label>
                <input type="checkbox" value="1" name="is_active" class="form-control switch" id="">
                <div name='is_active_error' class="text-danger font-italic "></div>
            </div>
            <div class="form-group col-sm-12 col-md-6">
                <label for="employee_type" class="col-form-label">@lang('base.Cargo')</label>
                <select  name="employee_type" class="form-control select2" >
                    <option value="">@lang('base.Seleccionar elemento')</option>
                    <option value="0">@lang('base.Secretaria')</option>
                    <option value="1">@lang('base.Medico')</option>
                </select>
                <div name='empoyee_type_error' class="text-danger font-italic "></div>
            </div>
            <div id="edit_smartwizard" class="mt-4" style="width: 100%">
                <ul class="nav">
                   <li>
                       <a class="nav-link" href="#step-1">
                          @lang('base.Otros datos')
                       </a>
                   </li>
                   <li class="specialty_update_container">
                       <a class="nav-link" href="#step-2">
                          @lang('base.especialidades')
                       </a>
                   </li>
                </ul>

                <div class="tab-content p-3">
                   <div id="step-1" class="tab-pane form-row" role="tabpanel">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="identification" class="col-form-label">@lang('base.Identificacion')</label>
                                <input type="text" name="identification" class="form-control" id="">
                                <div name='identification_error' class="text-danger font-italic "></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="col-form-label">@lang('base.Correo')</label>
                                <input type="email" name="email" class="form-control" id="">
                                <div name='email_error' class="text-danger font-italic "></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="phone_number" class="col-form-label">@lang('base.Telefono')</label>
                                <input type="tel" name="phone_number" class="form-control mask" id="">
                                <div name='phone_number_error' class="text-danger font-italic "></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="born_date" class="col-form-label">@lang('base.Fecha nacimiento')</label>
                                <input type="date" name="born_date" class="form-control"  id="">
                                <div name='born_date_error' class="text-danger font-italic "></div>
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="gender" class="col-form-label">@lang('base.Genero')</label>
                                <select  name="gender" class="form-control select2" >
                                    <option value="">@lang('base.Seleccionar elemento')</option>
                                    <option value="M">@lang('base.Masculino')</option>
                                    <option value="F">@lang('base.Femenino')</option>
                                </select>
                                <div name='gender_error' class="text-danger font-italic "></div>
                            </div>
                            <div class="form-group col-12">
                                <label for="direction" class="col-form-label">@lang('base.Direccion')</label>
                                <textarea name="direction" class="form-control" cols="30" rows="2"></textarea>
                                <div name='direction_error' class="text-danger font-italic "></div>
                            </div>
                        </div>
                   </div>
                   <div id="step-2"  class="tab-pane specialty_update_container" role="tabpanel">
                       <div class="row ">
                            <div class="col-12">
                                <label for="specialties" class="col-form-label ">@lang('base.Seleccione las especializaciones')</label>
                                <select  name="specialties[]"  id="" class="form-control select2 specialties " multiple="multiple" >
                                   @foreach ($specialties as $specialty)
                                   <option value="{{$specialty->id}}">{{$specialty->description}}</option>
                                   @endforeach
                                </select>
                            </div>
                       </div>
                    </div>
                </div>
            </div>

        </form>
        <div class="modal-footer">
          <button type="submit" id="save_btn" form="personal_edit_form" class="btn btn-success">@lang('base.Guardar')</button>
        </div>
    </div>
    </div>
  </div>
  @push('js')
<script>

 $( document ).ready(function() {


  /* var x = [4,3,5,6,7,8,9];
    $("#personal_edit_form .specialties").val(x).change();*/

    // Smart Wizard
    $('#edit_smartwizard').smartWizard({
        selected: 0,
        theme: 'default', // default, arrows, dots, progress
        // darkMode: true,
        keyNavigation: false, // Enable/Disable key navigation(left and right keys are used if enabled)
        enableAllSteps: true,  // Enable/Disable all steps on first load
        transitionEffect: 'fade',
        anchorSettings: {
            anchorClickable: true, // Enable/Disable anchor navigation
            enableAllAnchors: true, // Activates all anchors clickable all times
            markDoneStep: true, // add done css
            enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
        },
        lang: {
            next: 'Siguiente',
            previous: 'Anterior'
        }
    });
    $("#edit_smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
        if(stepPosition === 'last') {
        }
    });
    $("#edit_smartwizard").smartWizard("reset");
    $(".specialty_update_container").addClass("d-none");
    $("#personal_edit_form .toolbar-bottom").addClass("d-none");
});

$(document).on('click', '.edit_personal', function(e){
    e.preventDefault();
    let id = $(this).attr('data-id');
    $.ajax({
        type: "get",
        url: '{{ url('backoffice/personal-show/') }}'+'/'+id,
        beforeSend: function() {
            loading();
        },
        success: function(data) {
            $('#personal_edit_form').attr('data-id', data.id);
            $("#personal_edit_form input[name=name]").val(data.name);
            $("#personal_edit_form input[name=surnames]").val(data.surnames);
            $("#personal_edit_form input[name=identification]").val(data.identification);
            $("#personal_edit_form input[name=email]").val(data.email);
            $("#personal_edit_form input[name=phone_number]").val(data.phone_number);
            $("#personal_edit_form input[name=born_date]").val(data.born_date);
            $("#personal_edit_form select[name=gender]").val(data.gender).change();
            $("#personal_edit_form textarea[name=direction]").val(data.direction);
            if(data.active==1){
                $("#personal_edit_form input[name=is_active]").bootstrapSwitch("state",true);
            }else{
                $("#personal_edit_form input[name=is_active]").bootstrapSwitch("state",false);
            }
            if(data.is_admin==1){
                $("#personal_edit_form input[name=is_admin]").bootstrapSwitch("state",true);
            }else{
                $("#personal_edit_form input[name=is_admin]").bootstrapSwitch("state",false);
            }
            if(data.is_doctor==1){
                $("#personal_edit_form select[name=employee_type]").val(1).change();
            }
            if(data.is_secretary==1){
                $("#personal_edit_form select[name=employee_type]").val(0).change();
            }
            $('#edit_personal_modal').modal('toggle');

            swal.close();
        },
        error: function (response) {
            alertMessage('error',' No se ha podido procesar la operacion contacte con el programador');
        },
        complete: function() {
        }
    });
});
$('#personal_edit_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
            type: "post",
            url: '{{ route('personal.store') }}',
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                loading();
                $("#personal_edit_form div[name=surnames_error]").text("");
                $("#personal_edit_form div[name=name_error]").text("");
                $("#personal_edit_form div[name=email_error]").text("");
                $("#personal_edit_form div[name=identification_error]").text("");
                $("#personal_edit_form div[name=born_date_error]").text("");
                $("#personal_edit_form div[name=phone_number_error]").text("");
                $("#personal_edit_form div[name=gender_error]").text("");
                $("#personal_edit_form div[name=empoyee_type_error]").text("");
            },
            success: function(data) {
                alertMessage('success',' Operacion realizada correctamente');
               // clearFieldsSpecialty("personal_edit_form");
               // closeModal("add_specialty_modal");
                reLoadUserTables();
                clearFieldsPersonal("personal_edit_form");
            },
            error: function (response) {

            if (response.status == 422) { // when status code is 422, it's a validation issue
                //console.log(response.responseJSON.errors);
               // $("#personal_edit_form div[name_error]").html(response.responseJSON.errors.name);
                $("#personal_edit_form div[name=surnames_error]").text(response.responseJSON.errors.surnames);
                $("#personal_edit_form div[name=name_error]").text(response.responseJSON.errors.name);
                $("#personal_edit_form div[name=email_error]").text(response.responseJSON.errors.email);
                $("#personal_edit_form div[name=identification_error]").text(response.responseJSON.errors.identification);
                $("#personal_edit_form div[name=born_date_error]").text(response.responseJSON.errors.bonr_date);
                $("#personal_edit_form div[name=phone_number_error]").text(response.responseJSON.errors.phone_number);
                $("#personal_edit_form div[name=gender_error]").text(response.responseJSON.errors.gender);
                $("#personal_edit_form div[name=empoyee_type_error]").text(response.responseJSON.errors.employee_type);
                // display errors on each form field
                alertMessage('error',' Tienes algunos errores de validación');
                return false;
            }

            alertMessage('error',' No se ha podido procesar la operacion contacte con el programador');
            },
            complete: function() {
            }
        });
    });
    $(document).on('change', '#personal_edit_form select[name=employee_type]', function(e){
      // alert($(this).val());

      $(".specialty_update_container").addClass("d-none");
      $("#personal_edit_form .toolbar-bottom").addClass("d-none");
      if($(this).val()==1){
        $(".specialty_update_container").removeClass("d-none");
        $("#personal_edit_form .toolbar-bottom").removeClass("d-none");
      }else{
        $("#edit_smartwizard").smartWizard("reset");
      }
    });


</script>

@endpush




