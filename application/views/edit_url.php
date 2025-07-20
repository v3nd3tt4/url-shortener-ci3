<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit URL - URL Shortener</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #3730a3;
            --secondary-color: #f8fafc;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --text-color: #1f2937;
            --border-color: #e5e7eb;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-color);
        }

        .main-container {
            min-height: 100vh;
            padding: 2rem 0;
        }

        .card {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            border-radius: 1.5rem 1.5rem 0 0 !important;
            padding: 2rem;
        }

        .card-body {
            padding: 2.5rem;
        }

        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            background: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            border: none;
            border-radius: 0.75rem;
            padding: 0.875rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .btn-secondary {
            background: #6b7280;
            border: none;
            border-radius: 0.75rem;
            padding: 0.875rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .alert {
            border-radius: 0.75rem;
            border: none;
            padding: 1rem 1.5rem;
        }

        .loading-spinner {
            display: none;
            margin-right: 0.5rem;
        }

        .url-preview {
            background: #f8fafc;
            border: 2px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .url-preview strong {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .card-header {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">
                                    <i class="fas fa-edit me-2"></i>
                                    Edit URL
                                </h4>
                                <a href="<?= site_url('url/dashboard') ?>" class="btn btn-light btn-sm">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="url-preview">
                                <strong>Short URL:</strong> <?= base_url($url->short_code) ?><br>
                                <strong>Original URL:</strong> <?= $url->original_url ?>
                            </div>

                            <form id="editForm">
                                <div id="editAlert"></div>
                                
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="original_url" class="form-label">
                                            <i class="fas fa-globe me-2"></i>URL Asli
                                        </label>
                                        <input type="url" 
                                               id="original_url" 
                                               name="original_url" 
                                               class="form-control" 
                                               value="<?= $url->original_url ?>"
                                               required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="custom_url" class="form-label">
                                            <i class="fas fa-edit me-2"></i>Custom URL
                                        </label>
                                        <input type="text" 
                                               id="custom_url" 
                                               name="custom_url" 
                                               class="form-control" 
                                               value="<?= $url->custom_url ?>"
                                               placeholder="Biarkan kosong untuk generate otomatis">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="title" class="form-label">
                                            <i class="fas fa-heading me-2"></i>Judul
                                        </label>
                                        <input type="text" 
                                               id="title" 
                                               name="title" 
                                               class="form-control" 
                                               value="<?= $url->title ?>"
                                               placeholder="Judul untuk link ini">
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">
                                            <i class="fas fa-align-left me-2"></i>Deskripsi
                                        </label>
                                        <textarea id="description" 
                                                  name="description" 
                                                  class="form-control" 
                                                  rows="3" 
                                                  placeholder="Deskripsi singkat tentang link ini"><?= $url->description ?></textarea>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="expired_at" class="form-label">
                                            <i class="fas fa-clock me-2"></i>Kadaluarsa
                                        </label>
                                        <input type="datetime-local" 
                                               id="expired_at" 
                                               name="expired_at" 
                                               class="form-control"
                                               value="<?= $url->expired_at ? date('Y-m-d\TH:i', strtotime($url->expired_at)) : '' ?>">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="is_active" class="form-label">
                                            <i class="fas fa-toggle-on me-2"></i>Status
                                        </label>
                                        <select id="is_active" name="is_active" class="form-select">
                                            <option value="1" <?= $url->is_active == 1 ? 'selected' : '' ?>>Aktif</option>
                                            <option value="0" <?= $url->is_active == 0 ? 'selected' : '' ?>>Nonaktif</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="loading-spinner">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </span>
                                        <i class="fas fa-save me-2"></i>
                                        Simpan Perubahan
                                    </button>
                                    <a href="<?= site_url('url/dashboard') ?>" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>
                                        Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        $('#editForm').submit(function(e) {
            e.preventDefault();
            
            const $btn = $(this).find('button[type="submit"]');
            const $spinner = $btn.find('.loading-spinner');
            const $icon = $btn.find('.fa-save');
            
            $btn.prop('disabled', true);
            $spinner.show();
            $icon.hide();
            $('#editAlert').html('');
            
            $.post('<?= site_url('url/edit/' . $url->id) ?>', $(this).serialize(), function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = '<?= site_url('url/dashboard') ?>';
                    });
                } else {
                    $('#editAlert').html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>'+response.message+'</div>');
                    $btn.prop('disabled', false);
                    $spinner.hide();
                    $icon.show();
                }
            }).fail(function() {
                $('#editAlert').html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan. Silakan coba lagi.</div>');
                $btn.prop('disabled', false);
                $spinner.hide();
                $icon.show();
            });
        });

        // Auto-resize textarea
        $('#description').on('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    </script>
</body>
</html> 