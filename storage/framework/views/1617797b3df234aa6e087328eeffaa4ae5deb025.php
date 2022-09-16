<?php $__env->startSection('main-content'); ?>
    <div id="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Registration Fee</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Registration Fee</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <div class="content">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><span class="badge badge-sm badge-dark"><?php echo e($patient); ?> </span>
                                Registration Fee (Returning)</h3>
                        </div>

                        <div class="card-body">
                            <?php echo Form::open(['route' => 'returningPatientCardPayment', 'method' => 'POST', 'role' => 'form', 'enctype' => 'multipart/form-data']); ?>

                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="id" value="<?php echo e($userid); ?>" readonly="1">
                            <input type="hidden" name="patient" value="<?php echo e($patient); ?>" readonly="1">
                            <input type="hidden" name="dependant_id" value="<?php echo e($dependant->id ?? ''); ?>" readonly="1">

                            <div class="form-group row" id="trans">
                                <label for="trans"
                                    class="col-md-4 col-form-label text-md-right"><?php echo e(__('Transaction No ')); ?></label>
                                <div class="col-md-6">
                                    <input id="trans" type="text"
                                        class="form-control<?php echo e($errors->has('trans') ? ' is-invalid' : ''); ?>" name="trans"
                                        value="<?php echo e($trans); ?> " readonly="1">
                                    <?php if($errors->has('trans')): ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($errors->first('trans')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="clinic"
                                    class="col-md-4 col-form-label text-md-right"><?php echo e(__('Clinic: ')); ?></label>
                                <div class="col-md-6">
                                    <?php echo Form::select('clinic', $clinic, null, ['id' => 'clinic_name', 'name' => 'clinic_name', 'class' => 'form-control', 'data-live-search' => 'true', 'placeholder' => 'Pick a Value', 'required' => 'true']); ?>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="clinic"
                                    class="col-md-4 col-form-label text-md-right"><?php echo e(__('Payment Item: ')); ?></label>
                                <div class="col-md-6">
                                    <?php echo Form::select('payment_items', $payment_items, null, ['id' => 'payment_items', 'name' => 'payment_items', 'placeholder' => 'Select Payment Item', 'class' => 'form-control', 'data-live-search' => 'true', 'required' => 'true']); ?>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="total_amount"
                                    class="col-md-4 col-form-label text-md-right"><?php echo e(__('Amount ₦ ')); ?></label>
                                <div class="col-md-6">
                                    <input type="text" id="total_amount" name="total_amount" class="form-control"
                                        required readonly />
                                    <span class="text-danger" id="discount_text"></span>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="use_hmo"
                                    class="col-md-4 col-form-label text-md-right"><?php echo e(__('Use Hmo')); ?></label>
                                <div class="col-md-6">
                                    <input type="checkbox" id="use_hmo" name="use_hmo" class=""
                                        onclick="cal_tot(this)" value="<?php echo e($hmo->discount); ?>" checked required />
                                        <?php echo e($hmo->discount); ?>% Discount - <?php echo e($hmo->name); ?>

                                    <input type="hidden" name="hmo" value="<?php echo e($hmo->id); ?>">
                                </div>
                            </div>

                            <div class="form-group row" id="payment_mode">
                                <label for="mode"
                                    class="col-md-4 col-form-label text-md-right"><?php echo e(__('Mode of Payment: ')); ?></label>
                                <div class="col-md-6">
                                    
                                    <select name="payment_mode" id="payment_mode" placeholder="Pick a Value"
                                        class="form-control">
                                        <option value="">--Select payment mode</option>
                                        <?php $__currentLoopData = $payment_mode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$mode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>"><?php echo e($mode); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php if(isset($patient_account)): ?>
                                            <option value="from_account">Patient Account (₦<?php echo e($patient_account->deposit - $patient_account->creadit); ?>)</option>
                                        <?php endif; ?>
                                    </select>
                                    <?php if(isset($patient_account)): ?>
                                        <input type="hidden" name="from_account_id" value="<?php echo e($patient_account->id); ?>">
                                    <?php endif; ?>
                                </div>
                            </div>


                            <div class="form-group row" id="dropMe" style="display: none;">
                                <label for="amount"
                                    class="col-md-4 col-form-label text-md-right"><?php echo e(__('Payment Rreference Id(teller/POS etc) ')); ?></label>

                                <div class="col-md-6">
                                    <input id="payment_id" type="text"
                                        class="form-control<?php echo e($errors->has('amount') ? ' is-invalid' : ''); ?>"
                                        name="payment_id" value="" autofocus>

                                    <?php if($errors->has('payment_id')): ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($errors->first('payment_id')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="box-footer" align="center">
                                <a href="<?php echo e(route('returningPatients')); ?>" class="btn btn-success"> Back</a>
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-send"></i> Save</button>
                            </div>
                            <br>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>


<script src="<?php echo e(asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js')); ?>"></script>
<script type="text/javascript">
    function cal_tot(obj) {
        if ($('#use_hmo').is(':checked')) {
            discount = $(obj).val();
            discount = (parseFloat(discount) / 100) * parseFloat($('#total_amount').val());
            discount_text = parseFloat($('#total_amount').val()) - discount;
            $('#discount_text').text('You pay ₦' + discount_text);
        } else {
            discount = $(obj).val();
            discount_text = "You pay ₦" + $('#total_amount').val();
            $('#discount_text').text(discount_text);
        }
    }
    $(document).ready(function() {
        $('select[name="payment_items"]').on('change', function() {
            var id = $(this).val();
            //alert(id);
            if (id) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
                    },
                    url: '<?php echo e(url('/myItem/ajaxprice')); ?>/' + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        // console.log(data);
                        // alert(data.amount);
                        $('#total_amount').val(data.amount);

                        if ($('#use_hmo').is(':checked')) {
                            discount = $('#use_hmo').val();
                            discount = (parseFloat(discount) / 100) * parseFloat($(
                                '#total_amount').val());
                            discount_text = parseFloat($('#total_amount').val()) - discount;
                            $('#discount_text').text('You pay ₦' + discount_text);
                        } else {
                            discount = $('#use_hmo').val();
                            discount_text = "You pay ₦" + $('#total_amount').val();
                            $('#discount_text').text(discount_text);
                        }
                    }

                });

            } else {

                // $('#total_amount').val("");
            }
        });

        $('select[name="payment_mode"]').on('change', function() {
            $('#dropMe').slideDown(300);
        });

    });
</script>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mrapollos/Documents/database/resources/views/admin/patients/returningPatients/returningPatientsFee.blade.php ENDPATH**/ ?>