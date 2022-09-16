<?php $__env->startSection('main-content'); ?>
    <div id="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Nursing Notes </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Nursing Notes </li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>

        <div class="container">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?php echo e(__('Notes ')); ?></h3>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="observation-tab" data-toggle="tab" href="#observation"
                                role="tab" aria-controls="observation" aria-selected="true">Observation Chart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="treatment-tab" data-toggle="tab" href="#treatment" role="tab"
                                aria-controls="treatment" aria-selected="false">Treatment Sheet</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="io-tab" data-toggle="tab" href="#io" role="tab"
                                aria-controls="io" aria-selected="false">Intake/Output Chart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="labour-tab" data-toggle="tab" href="#labour" role="tab"
                                aria-controls="labour" aria-selected="false">Labour Records</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="observation" role="tabpanel"
                            aria-labelledby="observation-tab">
                            <form action="<?php echo e(route('nursing-note.store')); ?>" method="post" id="observation_form">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="note_type" value="1">
                                <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
                                <div class="form-group">
                                    <label for="pateintNoteReport" class="control-label">Observation Chart for
                                        <?php echo e($dependant->fullname ?? $patient->user->surname . ' ' . $patient->user->firstname . ' ' . $patient->user->othername); ?></label><br>
                                    <div style="border:1px solid black;" id="the-observation-note"
                                        class='the-observation-note'>
                                        <?php echo $observation_note->note ?? $observation_note_template->template; ?>
                                    </div>
                                    <textarea style="display: none" id="observation_text" name="the_text" class="form-control observation_text">
                                    </textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                            <form action="<?php echo e(route('nursing-note.new')); ?>" method="POST" class="form">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="note_type" value="1">
                                <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
                                <?php if(isset($dependant)): ?>
                                    <input type="hidden" name="dependant_id" value="<?php echo e($dependant->id); ?>">
                                <?php endif; ?>
                                <button type="submit"
                                    class="btn btn-success" style="float: right; margin-top:-40px">Save & Newbutton>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="treatment" role="tabpanel" aria-labelledby="treatment-tab">
                            <form action="<?php echo e(route('nursing-note.store')); ?>" method="post" id="treatment_form">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="note_type" value="2">
                                <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
                                <div class="form-group">
                                    <label for="pateintNoteReport" class="control-label">Treatment sheet for
                                        <?php echo e($dependant->fullname ?? $patient->user->surname . ' ' . $patient->user->firstname . ' ' . $patient->user->othername); ?></label><br>
                                    <div style="border:1px solid black;" id="the-treatment-note" class='the-treatment-note'>
                                        <?php echo $treatment_sheet->note ?? $treatment_sheet_template->template; ?>
                                    </div>
                                    <textarea style="display: none" id="treatment_text" name="the_text" class="form-control treatment_text">
                                    </textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                            <form action="<?php echo e(route('nursing-note.new')); ?>" method="POST" class="form">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="note_type" value="2">
                                <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
                                <?php if(isset($dependant)): ?>
                                    <input type="hidden" name="dependant_id" value="<?php echo e($dependant->id); ?>">
                                <?php endif; ?>
                                <button type="submit"
                                    class="btn btn-success" style="float: right; margin-top:-40px">Save & Newbutton>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="io" role="tabpanel" aria-labelledby="io-tab">
                            <form action="<?php echo e(route('nursing-note.store')); ?>" method="post" id="io_form">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="note_type" value="3">
                                <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
                                <div class="form-group">
                                    <label for="pateintNoteReport" class="control-label">Intake/Output Chart
                                        <?php echo e($dependant->fullname ?? $patient->user->surname . ' ' . $patient->user->firstname . ' ' . $patient->user->othername); ?></label><br>
                                    <div style="border:1px solid black;" id="the-io-note" class='the-io-note'>
                                        <?php echo $io_chart->note ?? $io_chart_template->template; ?>
                                    </div>
                                    <textarea style="display: none" id="io_text" name="the_text" class="form-control io_text">
                                    </textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                            <form action="<?php echo e(route('nursing-note.new')); ?>" method="POST" class="form">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="note_type" value="3">
                                <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
                                <?php if(isset($dependant)): ?>
                                    <input type="hidden" name="dependant_id" value="<?php echo e($dependant->id); ?>">
                                <?php endif; ?>
                                <button type="submit"
                                    class="btn btn-success" style="float: right; margin-top:-40px">Save & Newbutton>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="labour" role="tabpanel" aria-labelledby="labour-tab">
                            <form action="<?php echo e(route('nursing-note.store')); ?>" method="post" id="labour_form">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="note_type" value="4">
                                <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
                                <input type="hidden" id="close_after_save" value="0">
                                <div class="form-group">
                                    <label for="pateintDiagnosisReport" class="control-label">Labour Records
                                        <?php echo e($dependant->fullname ?? $patient->user->surname . ' ' . $patient->user->firstname . ' ' . $patient->user->othername); ?></label><br>
                                    <div style="border:1px solid black;" id="the-labour-note" class='the-labour-note'>
                                        <?php echo $labour_record->note ?? $labour_record_template->template; ?>
                                    </div>
                                    <textarea style="display: none" id="labour_text" name="the_text" class="form-control labour_text">
                                    </textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                            <form action="<?php echo e(route('nursing-note.new')); ?>" method="POST" class="form">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="note_type" value="4">
                                <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
                                <?php if(isset($dependant)): ?>
                                    <input type="hidden" name="dependant_id" value="<?php echo e($dependant->id); ?>">
                                <?php endif; ?>
                                <button type="submit"
                                    class="btn btn-success" style="float: right; margin-top:-40px">Save & Newbutton>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <!-- jQuery -->
    <script src="<?php echo e(asset('/plugins/dataT/jQuery-3.3.1/jquery-3.3.1.min.js')); ?>"></script>
    <!-- Bootstrap 4 -->
    <!-- DataTables -->
    <script src="<?php echo e(asset('/plugins/dataT/datatables.js')); ?>" defer></script>

    <script>
        $('#observation_form').on('submit', function(e) {
            e.preventDefault();
            var the_observation_note = $('#the-observation-note').html();
            document.getElementById('observation_text').innerHTML = the_observation_note;
            this.submit();
        })

        $('#treatment_form').on('submit', function(e) {
            e.preventDefault();
            var the_observation_note = $('#the-treatment-note').html();
            document.getElementById('treatment_text').innerHTML = the_observation_note;
            this.submit();
        })

        $('#io_form').on('submit', function(e) {
            e.preventDefault();
            var the_observation_note = $('#the-io-note').html();
            document.getElementById('io_text').innerHTML = the_observation_note;
            this.submit();
        })

        $('#labour_form').on('submit', function(e) {
            e.preventDefault();
            var the_observation_note = $('#the-labour-note').html();
            document.getElementById('labour_text').innerHTML = the_observation_note;
            this.submit();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mrapollos/Documents/database/resources/views/admin/nursing_notes/index.blade.php ENDPATH**/ ?>