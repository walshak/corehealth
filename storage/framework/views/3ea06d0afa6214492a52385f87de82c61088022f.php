<?php $__env->startSection('main-content'); ?>
    <div class="content-fluid spark-screen">
        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-default card-solid">
                    <div class="card-header with-border">
                        <h3 class="card-title"><?php echo e(trans('Returning Patient')); ?></h3>
                        <div class="card-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        </div>

                    </div>
                    <div class="card-body">
                        
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <h5>Search Parameter: <span class="text-danger"></span></h5>
                                <form action="" method="get" id="patients_search_form">
                                    <div class="input-group">
                                        <input type="text" name="q" id="q" required class="form-control"
                                            placeholder="Enter Card Number or Name to Search..." required>
                                        <span class="input-group-btn">
                                            <button id="btnFiterSubmitSearch" class="btn btn-info"
                                                type="submit">Go!</button>
                                        </span>
                                        <div class="help-block"></div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                        <br><br>
                        <hr>

                        <div class="row">

                            <div class="form-group col-md-12">
                                <div class="table-responsive" style="display:none" id="showMe">
                                    <table id="ghaji" class="table table-sm table-responsive table-striped">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Card Number:</th>
                                                <th>Fullname</th>
                                                <th>Date of Birth</th>
                                                <th>Blood Group</th>
                                                <th>Genotype</th>
                                                <th>HMO/Insurance</th>
                                                <th>HMO Number</th>
                                                <th>A/C Bal.</th>
                                                <th>Phone</th>
                                                
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to edit a user -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send For Vital Sign</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="<?php echo e(route('receptionists.store')); ?>" method="POST" role="form"
                        id="dependants_form">
                        <?php echo e(csrf_field()); ?>

                        <div class="form-group">
                            <h4 class="text-center">Check to Send for vital sign to the nurse station</h4>
                            <hr>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="id_edit" name="id_edit">
                                <input type="hidden" class="form-control" id="user_id_edit" name="user_id_edit">
                                <input type="hidden" class="form-control" id="file_no_edit" name="file_no_edit">
                                <input type="hidden" class="form-control" id="receptionist_id_edit"
                                    name="receptionist_id_edit">
                                <div class="checkbox">
                                    <div class="form-group" id="dependants_list">

                                    </div>
                                    <p class="errorPaymentValidation text-center alert alert-danger hidden"></p>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="myButtonForPaymentValidation" type="button" class="btn btn-primary edit"
                        data-dismiss="modal">
                        <span class='glyphicon glyphicon-check'></span> Continue
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <!-- jQuery -->
    <script src="<?php echo e(asset('plugins/datatables/jquery-3.3.1.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- DataTables -->
    <script src="<?php echo e(asset('plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/dataTables.select.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatables/dataTables.buttons.min.js')); ?>"></script>
    


    <script>
        // jQuery.noConflict();
        jQuery(function($) {



            var table = $('#ghaji').DataTable({
                "initComplete": function(settings, json) {
                    $('div.loading').remove();
                },
                dom: 'Bfrtip',
                select: true,
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "<?php echo e(url('listReturningPatients')); ?>",
                    "type": "GET",
                    "data": function(data) {
                        data.q = $('#q').val();

                    }
                    // ,
                    // "success": function(data) {

                    // }
                },
                columnDefs: [{
                    orderable: false,
                    //className: 'select-checkbox',
                    data: null,
                    defaultContent: '',
                    targets: 0
                }],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        'visible': false
                    },
                    {
                        data: 'file_no',
                        name: 'file_no'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'dob',
                        name: 'dob'
                    },
                    {
                        data: 'blood_group_id',
                        name: 'blood_group_id'
                    },
                    {
                        data: 'genotype',
                        name: 'genotype'
                    },
                    {
                        data: 'hmo',
                        name: 'hmo'
                    },
                    {
                        data: 'hmo_no',
                        name: 'hmo_no'
                    },
                    {
                        data: 'acc_bal',
                        name: 'acc_bal'
                    },
                    {
                        data: 'phone',
                        data: 'phone'
                    },
                    // { data: 'payment_validation', name: 'payment_validation' },
                    {
                        data: 'process',
                        name: 'process'
                    }

                ],
                
                responsive: true,
                order: [
                    [1, 'asc']
                ],
                paging: true,
                lengthChange: false,
                searchable: false,
                "info": true,
                "autoWidth": false,
                buttons: [
                    'selected',
                    'selectedSingle',
                    'selectAll',
                    'selectNone',
                    'selectRows',
                    //'selectColumns',
                    //'selectCells'
                    
                    
                ]

            });

            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            $('#ghaji tbody').on('click', 'tr', function() {
                $(this).toggleClass('selected');
            });

            $('#button').click(function() {
                alert(table.rows('.selected').data().length + ' row(s) selected');
            });

            // 
            // $(document).on('click', '#btnFiterSubmitSearch', function() {
            //     $('#showMe').show();
            //     $('#ghaji').DataTable().draw(true);
            // });



            $("#patients_search_form").on('submit', function(e) {
                e.preventDefault();
                $('#showMe').show();
                $('#ghaji').DataTable().draw(true);
            });
        });



        // Edit a User
        $(document).on('click', '.edit-modal', function() {
            //   $('.modal-title').text('Edit');
            $('#id_edit').val($(this).data('id'));
            $('#user_id_edit').val($(this).data('user_id'));
            $('#file_no_edit').val($(this).data('file_no'));
            $('#receptionist_id_edit').val($(this).data('receptionist_id'));
            //   $('#payment_validation_edit').val($(this).data('payment_validation'));
            id = $('#id_edit').val();
            var user_id = $('#user_id_edit').val();

            //make an ajax call and get all dependants of the selected patient
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "<?php echo e(url('getMyDependants')); ?>/" + user_id,
                data: {
                    // 'id': $("#id_edit").val(),
                    // 'user_id': $("#user_id_edit").val(),
                    // 'file_no': $('#file_no_edit').val(),
                    // 'receptionist_id': $('#receptionist_id_edit').val(),
                    // 'payment_validation': $('#payment_validation_edit').val(),
                },
                success: function(data) {
                    //console.log(data);
                    data = JSON.parse(data);
                    $('#dependants_list').html('');
                    $('#dependants_list').append(`<label>
                                        <input type="checkbox" id="payment_validation_edit" class="checkbox selected_dependants" name = 'selected_dependants[]'
                                            value="001"> Principal
                                    </label> &nbsp; &nbsp;`)
                    for (var i = 0; i < data.length; i++) {
                        $('#dependants_list').append(`
                                    <label>
                                        <input type="checkbox" id="" class="checkbox selected_dependants" name = 'selected_dependants[]'
                                            value="${data[i].id}"> ${data[i].fullname}
                                    </label> &nbsp; &nbsp;`);
                    }

                },
            });

            // This onclick is to make sure that the checkbox is checked to Comfirm that you actually proccessed that information
            $('#payment_validation_edit').on('click', function() {
                $("#myButtonForPaymentValidation").attr("disabled", !this.checked);
            });

            $('#editModal').modal('show');
        });

        $(document).on('click', '.edit', function(e) {
            //   alert(id);

            var form_data = $("#dependants_form").serialize();
            //console.log(form_data);
            //$("#dependants_form").submit();
            // //if ($('.selected_dependants :checkbox:checked').length > 0) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "<?php echo e(route('receptionists.store')); ?>",
                data: form_data,
                success: function(data) {
                    //   $('.errorPaymentValidation').addClass('hidden');
                    // $('.errorGuard_name').addClass('hidden');
                    console.log(data);
                    if ((data.errors)) {
                        // Swal.fire({
                        //   position: 'top-end',
                        //   icon: 'warning',
                        //   title: 'Oops...',
                        //   text: data.errors,
                        //   showConfirmButton: false,
                        // //   timer: 3000
                        // // });

                        Swal.fire({
                            title: 'Patient information cannot be sent, record pending at nurse station',
                            icon: 'warning',
                            text: data.errors,
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: `Next`,
                            denyButtonText: `Don't next`,
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                Swal.fire('Enter next patient information!', '', 'success')
                                window.location.reload();
                            } else if (result.isDenied) {
                                Swal.fire('You cannot procceed for now', '', 'info')
                                window.location.reload();
                            }
                        });

                        $('#editModal').modal('show');

                        if (data.errors.payment_validation) {
                            $('.errorPaymentValidation').removeClass('hidden');
                            $('.errorPaymentValidation').text(data.errors.payment_validation);
                        }
                        // window.location.reload();
                        // if (data.errors.permission) {
                        //     $('.errorPermission').removeClass('hidden');
                        //     $('.errorPermission').text(data.errors.permission);
                        // }

                    } else {

                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Successfully Sent for Vital Sign',
                            showConfirmButton: true,
                            //   timer: 3000
                        });
                        //window.location.href = "<?php echo route('receptionists.index'); ?>";
                    }
                }
            });
            // }else{
            //     alert('Please select at least one item');
            // }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mrapollos/Documents/database/resources/views/admin/receptionists/create.blade.php ENDPATH**/ ?>