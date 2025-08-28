<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Tugas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Daftar Tugas</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Manajemen Tugas</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTaskModal">
                                <i class="fas fa-plus"></i> Tambah Tugas
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tasksTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah Tugas -->
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tugas Baru</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="addTaskForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="judul">Judul Tugas</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Tugas -->
<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tugas</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editTaskForm">
                <input type="hidden" id="editTaskId" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editJudul">Judul Tugas</label>
                        <input type="text" class="form-control" id="editJudul" name="judul" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="editTaskStatusCheckbox">
                            <label class="custom-control-label" for="editTaskStatusCheckbox">
                                <span id="statusLabel">Tandai sebagai selesai</span>
                            </label>
                        </div>
                    </div>

                    <!-- Status Notification Area -->
                    <div id="statusNotification" class="alert d-none" role="alert">
                        <i class="fas fa-info-circle"></i>
                        <span id="statusMessage"></span>
                    </div>

                    <input type="hidden" id="editStatus" name="status" value="0">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#tasksTable').DataTable({
            processing: true,
            ajax: {
                url: '/tasks/data',
                type: 'GET'
            },
            columns: [{
                    data: 'id',
                    width: '5%'
                },
                {
                    data: 'judul',
                    width: '50%'
                },
                {
                    data: 'status',
                    width: '20%'
                },
                {
                    data: 'actions',
                    width: '20%',
                    orderable: false
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });

        // Fokus otomatis saat modal Tambah Tugas dibuka
        $('#addTaskModal').on('shown.bs.modal', function() {
            $('#judul').trigger('focus');
        });

        // Fokus otomatis saat modal Edit Tugas dibuka
        $('#editTaskModal').on('shown.bs.modal', function() {
            $('#editJudul').trigger('focus');
        });

        // Add Task
        $('#addTaskForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '/tasks',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000
                        });
                        $('#addTaskModal').modal('hide');
                        $('#addTaskForm')[0].reset();
                        table.ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    const response = JSON.parse(xhr.responseText);
                    let errorMsg = 'Terjadi kesalahan';
                    if (response.errors) {
                        errorMsg = Object.values(response.errors)[0];
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMsg
                    });
                }
            });
        });

        // Edit Task Modal
        $(document).on('click', '.edit-task', function() {
            const id = $(this).data('id');
            const judul = $(this).data('judul');
            const status = $(this).data('status');

            $('#editTaskId').val(id);
            $('#editJudul').val(judul);
            $('#editStatus').val(status);

            // Set checkbox berdasarkan status
            if (status == 1) {
                $('#editTaskStatusCheckbox').prop('checked', true);
                updateStatusNotification(true);
            } else {
                $('#editTaskStatusCheckbox').prop('checked', false);
                updateStatusNotification(false);
            }

            $('#editTaskModal').modal('show');
        });

        // Handle checkbox change di dalam modal
        $('#editTaskStatusCheckbox').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('#editStatus').val(isChecked ? 1 : 0);
            updateStatusNotification(isChecked);
        });

        // Function untuk update notifikasi status
        function updateStatusNotification(isCompleted) {
            const notification = $('#statusNotification');
            const message = $('#statusMessage');
            const label = $('#statusLabel');

            if (isCompleted) {
                notification.removeClass('d-none alert-warning alert-info')
                    .addClass('alert-success');
                message.html('<strong>Status:</strong> Tugas akan ditandai sebagai <strong>SELESAI</strong>');
                label.html('<strong>Tugas Selesai</strong> <i class="fas fa-check-circle text-success ml-1"></i>');
            } else {
                notification.removeClass('d-none alert-success alert-info')
                    .addClass('alert-warning');
                message.html('<strong>Status:</strong> Tugas akan ditandai sebagai <strong>BELUM SELESAI</strong>');
                label.html('<strong>Tandai sebagai selesai</strong> <i class="fas fa-clock text-warning ml-1"></i>');
            }

            // Show notification with fade effect
            notification.hide().fadeIn(300);
        }

        // Update Task
        $('#editTaskForm').on('submit', function(e) {
            e.preventDefault();

            const id = $('#editTaskId').val();
            const formData = {
                judul: $('#editJudul').val(),
                status: $('#editStatus').val()
            };

            // Show loading state
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...').prop('disabled', true);

            $.ajax({
                url: '/tasks/' + id,
                type: 'PUT',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#editTaskModal').modal('hide');
                        table.ajax.reload(null, false); // Reload table tanpa reset pagination
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    const response = JSON.parse(xhr.responseText);
                    let errorMsg = 'Terjadi kesalahan';
                    if (response.errors) {
                        errorMsg = Object.values(response.errors)[0];
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMsg
                    });
                },
                complete: function() {
                    // Reset button state
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });

        // Reset modal saat ditutup
        $('#editTaskModal').on('hidden.bs.modal', function() {
            $('#statusNotification').addClass('d-none');
            $('#editTaskForm')[0].reset();
        });

        // Delete Task
        $(document).on('click', '.delete-task', function() {
            const id = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Tugas yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/tasks/' + id,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: response.message,
                                    timer: 2000
                                });
                                table.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus tugas'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>