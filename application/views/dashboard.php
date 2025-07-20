<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - URL Shortener</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #3730a3;
            --secondary-color: #f8fafc;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --text-color: #1f2937;
            --border-color: #e5e7eb;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-color);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .main-content {
            padding: 2rem 0;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            border-radius: 1rem 1rem 0 0 !important;
            padding: 1.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #059669);
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color), #d97706);
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .stats-card {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .url-status {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-active {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .status-expired {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        .status-inactive {
            background: rgba(156, 163, 175, 0.1);
            color: #6b7280;
        }

        .table {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .table th {
            background: #f8fafc;
            border: none;
            font-weight: 600;
            color: var(--text-color);
        }

        .table td {
            border: none;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .url-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .url-link:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .original-url {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            border-radius: 1rem 1rem 0 0;
        }

        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 0.5rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
            margin: 0 0.25rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white !important;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem 0;
            }
            
            .card-body {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-link me-2"></i>
                URL Shortener
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user me-1"></i>
                    <?= $admin ?>
                </span>
                <a class="btn btn-outline-danger btn-sm" href="<?= site_url('welcome/logout') ?>">
                    <i class="fas fa-sign-out-alt me-1"></i>
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="container">
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number" id="total-urls">-</div>
                        <div>Total URLs</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, var(--success-color), #059669);">
                        <div class="stats-number" id="total-clicks">-</div>
                        <div>Total Klik</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, var(--warning-color), #d97706);">
                        <div class="stats-number" id="active-urls">-</div>
                        <div>URL Aktif</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="background: linear-gradient(135deg, var(--danger-color), #dc2626);">
                        <div class="stats-number" id="inactive-urls">-</div>
                        <div>URL Nonaktif</div>
                    </div>
                </div>
            </div>

                        <!-- Main Content -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Daftar URL
                    </h5>
                    <a href="<?= site_url('url/shorten') ?>" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i>
                        Tambah URL
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="urlsTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Short URL</th>
                                    <th>Original URL</th>
                                    <th>Judul</th>
                                    <th>Klik</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th>Kadaluarsa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan dimuat via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>
                        Edit URL
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_original_url" class="form-label">URL Asli</label>
                                <input type="url" id="edit_original_url" name="original_url" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_custom_url" class="form-label">Custom URL</label>
                                <input type="text" 
                                       id="edit_custom_url" 
                                       name="custom_url" 
                                       class="form-control"
                                       pattern="[a-zA-Z0-9\-_]+"
                                       title="Hanya huruf, angka, tanda hubung (-), dan underscore (_) yang diperbolehkan">
                                <div class="form-text">Hanya huruf, angka, tanda hubung (-), dan underscore (_)</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_title" class="form-label">Judul</label>
                                <input type="text" id="edit_title" name="title" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="edit_description" class="form-label">Deskripsi</label>
                                <textarea id="edit_description" name="description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_expired_at" class="form-label">Kadaluarsa</label>
                                <input type="datetime-local" id="edit_expired_at" name="expired_at" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_is_active" class="form-label">Status</label>
                                <select id="edit_is_active" name="is_active" class="form-select">
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Load stats
            loadStats();
            
            // Initialize DataTable
            var table = $('#urlsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= site_url('url/get_urls_data') ?>',
                    type: 'POST',
                    data: function(d) {
                        // Tambahkan CSRF token jika diperlukan
                        d.<?= $this->security->get_csrf_token_name() ?> = '<?= $this->security->get_csrf_hash() ?>';
                    },
                    error: function(xhr, error, thrown) {
                        console.error('DataTables AJAX error:', xhr.responseText);
                        Swal.fire('Error', 'Gagal memuat data tabel. Silakan cek koneksi atau hubungi admin.', 'error');
                    }
                },
                columns: [
                    { data: 0 }, // Short URL
                    { data: 1 }, // Original URL
                    { data: 2 }, // Title
                    { data: 3 }, // Clicks
                    { data: 4 }, // Status
                    { data: 5 }, // Created
                    { data: 6 }, // Expired
                    { data: 7 }  // Actions
                ],
                order: [[5, 'desc']], // Sort by created date descending
                pageLength: 25,
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                columnDefs: [
                    {
                        targets: [0, 1, 7], // Short URL, Original URL, Actions columns
                        orderable: false
                    }
                ]
            });
        });

        function loadStats() {
            $.get('<?= site_url('url/get_stats') ?>')
                .done(function(res) {
                    let response;
                    try {
                        response = (typeof res === 'object') ? res : JSON.parse(res);
                    } catch (e) {
                        console.error('Error parsing stats response:', e);
                        return;
                    }
                    if (response.status === 'success') {
                        $('#total-urls').text(response.data.total_urls);
                        $('#total-clicks').text(response.data.total_clicks);
                        $('#active-urls').text(response.data.active_urls);
                        $('#inactive-urls').text(response.data.inactive_urls);
                    }
                })
                .fail(function() {
                    console.error('Failed to load stats');
                });
        }

        function refreshData() {
            $('#urlsTable').DataTable().ajax.reload();
            loadStats();
        }

        // Auto-format custom URL di form edit
        $('#edit_custom_url').on('input', function() {
            let value = $(this).val();
            // Hapus semua karakter kecuali huruf, angka, tanda hubung, dan underscore
            value = value.replace(/[^a-zA-Z0-9\-_]/g, '');
            $(this).val(value);
        });

        function editUrl(id) {
            // Load URL data via AJAX
            $.get('<?= site_url('url/get_url_info') ?>/' + id)
                .done(function(res) {
                    let response;
                    try {
                        response = (typeof res === 'object') ? res : JSON.parse(res);
                    } catch (e) {
                        Swal.fire('Error', 'Session Anda habis atau terjadi error. Silakan login ulang.', 'error');
                        return;
                    }
                    if (response.status === 'success') {
                        $('#edit_id').val(id);
                        $('#edit_original_url').val(response.data.original_url);
                        $('#edit_custom_url').val(response.data.short_code);
                        $('#edit_title').val(response.data.title || '');
                        $('#edit_description').val(response.data.description || '');
                        $('#edit_expired_at').val(response.data.expired_at || '');
                        $('#edit_is_active').val(response.data.is_active || 1);
                        
                        $('#editModal').modal('show');
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                })
                .fail(function() {
                    Swal.fire('Error', 'Session Anda habis atau terjadi error. Silakan login ulang.', 'error');
                });
        }

        let isEditing = false;
        
        $('#editForm').submit(function(e) {
            e.preventDefault();
            
            // Cek apakah sedang dalam proses edit
            if (isEditing) {
                return false;
            }
            
            const id = $('#edit_id').val();
            const formData = $(this).serialize();
            const $form = $(this);
            const $btn = $form.find('button[type="submit"]');
            
            // Set flag editing
            isEditing = true;
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...');
            $form.find('input, textarea, select').prop('disabled', true);

            $.post('<?= site_url('url/edit') ?>/' + id, formData)
                .done(function(res) {
                    let response;
                    try {
                        response = (typeof res === 'object') ? res : JSON.parse(res);
                    } catch (e) {
                        Swal.fire('Error', 'Session Anda habis atau terjadi error. Silakan login ulang.', 'error');
                        return;
                    }
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            refreshData();
                            $('#editModal').modal('hide');
                        });
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                })
                .fail(function() {
                    Swal.fire('Error', 'Session Anda habis atau terjadi error. Silakan login ulang.', 'error');
                })
                .always(function() {
                    // Reset flag dan enable kembali
                    isEditing = false;
                    $btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i>Simpan');
                    $form.find('input, textarea, select').prop('disabled', false);
                });
        });

        function copyUrl(url) {
            navigator.clipboard.writeText(url).then(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Tersalin!',
                    text: 'URL telah disalin ke clipboard',
                    showConfirmButton: false,
                    timer: 1500
                });
            }).catch(function() {
                // Fallback untuk browser lama
                const textArea = document.createElement('textarea');
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Tersalin!',
                    text: 'URL telah disalin ke clipboard',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }

        let isDeleting = false;
        
        function deleteUrl(id) {
            // Cek apakah sedang dalam proses delete
            if (isDeleting) {
                return false;
            }
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus URL ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set flag deleting
                    isDeleting = true;
                    
                    $.post('<?= site_url('url/delete') ?>/' + id)
                        .done(function(res) {
                            let response;
                            try {
                                response = (typeof res === 'object') ? res : JSON.parse(res);
                            } catch (e) {
                                Swal.fire('Error', 'Session Anda habis atau terjadi error. Silakan login ulang.', 'error');
                                return;
                            }
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    refreshData();
                                });
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        })
                        .fail(function() {
                            Swal.fire('Error', 'Session Anda habis atau terjadi error. Silakan login ulang.', 'error');
                        })
                        .always(function() {
                            // Reset flag
                            isDeleting = false;
                        });
                }
            });
        }
    </script>
</body>
</html>