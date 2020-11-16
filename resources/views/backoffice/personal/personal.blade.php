@php
    $props = [
        'titulo' => "Areas y especializaciones"
    ];
@endphp
@extends('layout.backoffice.app')

@push('modals')
    @include('backoffice.personal.add_personal')
    @include('backoffice.personal.edit_personal')
@endpush

@section('content')



<div class="content-wrapper p-5">
    <!-- Content Header (Page header) -->
    <div class="content-header">

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('base.Personal hospitalario')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">@lang('base.Inicio')</a></li>
              <li class="breadcrumb-item active">@lang('base.Area / Specializaciones')</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex justify-content-end mb-5">
                <button class="btn btn-info" data-toggle="modal" data-target="#add_personal_modal" ><i class="fas fa-spinner"></i> @lang('base.Nuevo personal')</button>
            </div>
        </div>
      <div class="row">
        {{---Begin Medicos section---}}
        <div class="col-md-12 mt-4">
            <div class="card border-top border-warning " style="border-top-width: medium;">
                <div class="card-header">
                  <h3 class="card-title">@lang('base.Medicos')</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>

                  </div>
                </div>
                <div class="card-body text-center" >
                    <table  id="doctorDataTable" class="table table-bordered table-striped text-left">
                        <thead>
                        <tr>
                          <th>@lang('base.Nombre')</th>
                          <th>@lang('base.Correo')</th>
                          <th  width="15">@lang('base.Acciones')</th>
                        </tr>
                        </thead>
                        <tbody class="" >

                        </tbody>
                      </table>
                </div>
                <!-- /.card-footer-->
            </div>
        </div>
        {{---End Medicos section---}}
        {{---Begin secretaria section---}}
        <div class="col-md-12 mt-4">
            <div class="card border-top border-warning " style="border-top-width: medium;">
                <div class="card-header">
                  <h3 class="card-title">@lang('base.Secretaria')</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>

                  </div>
                </div>
                <div class="card-body text-center" >
                    <table  id="secretaryDataTable" class="table table-bordered table-striped text-left">
                        <thead>
                        <tr>
                          <th>@lang('base.Nombre')</th>
                          <th>@lang('base.Correo')</th>
                          <th  width="15">@lang('base.Acciones')</th>
                        </tr>
                        </thead>
                        <tbody class="" >

                        </tbody>
                      </table>
                </div>
                <!-- /.card-footer-->
            </div>
        </div>
        {{---End secretaria section---}}

      </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
@push('js')
<script>

    $( document ).ready(function() {
        getDoctors();
        getSecretaries();
    });


    $(document).on('click', '.delete_personal', function(e){
        e.preventDefault();
        let id = $(this).attr('data-id');

        Swal.fire({
            title: "{{ __('base.¿Estás segur@?') }}",
            text: "{{ __('base.Esta acción no se puede deshacer') }}",
        icon: "warning",
            showCancelButton: true,
            confirmButtonText: "{{ __('base.Sí, borrar') }}",
            cancelButtonText: "{{ __('base.Cancelar') }}",
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "get",
                    url: '{{ url('backoffice/specialty-delete/') }}'+'/'+id,
                    beforeSend: function() {
                        loading();
                    },
                    success: function(data) {
                        alertMessage('success',' Operacion realizada correctamente');
                        reLoadSpecialty();
                    },
                    error: function (response) {
                        alertMessage('error',' No se ha podido procesar la operacion contacte con el programador');
                    },
                    complete: function() {
                    }
                });
            }
        });
    });


    function getDoctors() {
        $("#doctorDataTable").DataTable({
            ajax: {
                url: "{{route('personal.getDoctors')}}",
                dataSrc: ""
                },
            responsive: true,
            autoWidth: false,
            language: dataTableEspañol(),
            fnRowCallback: function( row, data, iDisplayIndex, iDisplayIndexFull ) {
                if(data.active==0){
                    $(row).css("text-decoration", "line-through");
                }

            },
            columns: [
                { data: null, render: function ( data, type, row ) {
                    $(row).addClass( 'bg-info' );
                    var admin="";
                    if(data.is_admin==1){
                        admin = '<i class="fas fa-user text-success"></i>';
                    }
                     return admin+' '+ucfirst(data.name)+' '+ucfirst(data.surnames);
                    }
                },
                { data: null, render: function ( data, type, row ) {
                     return data.email;
                    }
                },
                { data: null, render: function ( data, type, row ) {
                // Combine the first and last names into a single table field
                return '<div class="text-center"><a data-toggle="tooltip"  title="Editar" href="" data-id="'+data.id+'" class="edit_personal text-info"><i class="fas fa-edit"></i></a>\
                        <a href="" data-id="'+data.id+'" class="delete_personal text-danger" data-toggle="tooltip"  title="Eliminar"><i class="fas fa-trash-alt"></i></a></div>'
                } },
            ]
        });
    }
    function getSecretaries() {
        $("#secretaryDataTable").DataTable({
            ajax: {
                url: "{{route('personal.getSecretaries')}}",
                dataSrc: ""
                },
                responsive: true,
            autoWidth: false,
            language: dataTableEspañol(),
            fnRowCallback: function( row, data, iDisplayIndex, iDisplayIndexFull ) {
                if(data.active==0){
                    $(row).css("text-decoration", "line-through");
                }

            },
            columns: [
                { data: null, render: function ( data, type, row ) {
                    $(row).addClass( 'bg-info' );
                    var admin="";
                    if(data.is_admin==1){
                        admin = '<i class="fas fa-user text-success"></i>';
                    }
                     return admin+' '+ucfirst(data.name)+' '+ucfirst(data.surnames);
                    }
                },
                { data: null, render: function ( data, type, row ) {
                     return data.email;
                    }
                },
                { data: null, render: function ( data, type, row ) {
                // Combine the first and last names into a single table field
                return '<div class="text-center"><a data-toggle="tooltip"  title="Editar" href="" data-id="'+data.id+'" class="edit_personal text-info"><i class="fas fa-edit"></i></a>\
                        <a href="" data-id="'+data.id+'" class="delete_personal text-danger" data-toggle="tooltip"  title="Eliminar"><i class="fas fa-trash-alt"></i></a></div>'
                } },
            ]
        });
    }


  function reLoadUserTables() {
        $("#adminDataTable").DataTable().ajax.reload();
        $("#secretaryDataTable").DataTable().ajax.reload();
        $("#doctorDataTable").DataTable().ajax.reload();
    }
  function clearFieldsPersonal(form){
    $("#"+form+" input[name=name]").val("");
    $("#"+form+" input[name=surnames]").val("");
    $("#"+form+" input[name=is_admin]").bootstrapSwitch('state', false);
    $("#"+form+" input[name=is_active]").bootstrapSwitch('state', false);
    $("#"+form+" input[name=identification]").val("");
    $("#"+form+" input[name=email]").val("");
    $("#"+form+" input[name=phone_number]").val("");
    $("#"+form+" input[name=born_date]").val("");
    $("#"+form+" select[name=gender]").val("").change();
    $("#"+form+" select[name=employee_type]").val("").change();
    $("#"+form+" .specialties").val("").change();

    $("#"+form+" textarea[name=direction]").val("");

   }


</script>

@endpush

