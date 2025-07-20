<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener - Buat Link Singkat</title>
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
            display: flex;
            align-items: center;
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
            text-align: center;
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
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:disabled {
            background: #9ca3af;
            transform: none;
            box-shadow: none;
        }

        .result-card {
            background: linear-gradient(135deg, var(--success-color), #059669);
            color: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-top: 2rem;
            text-align: center;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .short-url {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 0.5rem;
            padding: 1rem;
            margin: 1rem 0;
            word-break: break-all;
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }

        .qr-code {
            background: white;
            border-radius: 0.5rem;
            padding: 1rem;
            display: inline-block;
            margin-top: 1rem;
        }

        .alert {
            border-radius: 0.75rem;
            border: none;
            padding: 1rem 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .optional-badge {
            background: #f3f4f6;
            color: #6b7280;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            margin-left: 0.5rem;
        }

        .loading-spinner {
            display: none;
            margin-right: 0.5rem;
        }

        .feature-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .feature-item {
            text-align: center;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 1rem;
            border: 1px solid var(--border-color);
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
                <div class="col-lg-8 col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h1 class="h3 mb-0">
                                        <i class="fas fa-link me-2"></i>
                                        URL Shortener
                                    </h1>
                                    <p class="mb-0 mt-2 opacity-75">Buat link singkat yang mudah dibagikan</p>
                                </div>
                                <a href="<?= site_url('url/dashboard') ?>" class="btn btn-light btn-sm">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Dashboard
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="shortenForm">
                                <div id="shortenAlert"></div>
                                
                                <div class="mb-3">
                                    <label for="original_url" class="form-label">
                                        <i class="fas fa-globe me-2"></i>URL Asli
                                    </label>
                                    <input type="url" 
                                           id="original_url" 
                                           name="original_url" 
                                           class="form-control" 
                                           placeholder="https://example.com/very-long-url" 
                                           required 
                                           autofocus>
                                </div>

                                <div class="mb-3">
                                    <label for="custom_url" class="form-label">
                                        <i class="fas fa-edit me-2"></i>Custom URL
                                        <span class="optional-badge">Opsional</span>
                                    </label>
                                    <input type="text" 
                                           id="custom_url" 
                                           name="custom_url" 
                                           class="form-control" 
                                           placeholder="nama-custom"
                                           pattern="[a-zA-Z0-9\-_]+"
                                           title="Hanya huruf, angka, tanda hubung (-), dan underscore (_) yang diperbolehkan">
                                    <div class="form-text">Hanya huruf, angka, tanda hubung (-), dan underscore (_). Biarkan kosong untuk generate otomatis</div>
                                </div>

                                <div class="mb-3">
                                    <label for="title" class="form-label">
                                        <i class="fas fa-heading me-2"></i>Judul
                                        <span class="optional-badge">Opsional</span>
                                    </label>
                                    <input type="text" 
                                           id="title" 
                                           name="title" 
                                           class="form-control" 
                                           placeholder="Judul untuk link ini">
                                </div>

                                <!-- <div class="mb-3">
                                    <label for="description" class="form-label">
                                        <i class="fas fa-align-left me-2"></i>Deskripsi
                                        <span class="optional-badge">Opsional</span>
                                    </label>
                                    <textarea id="description" 
                                              name="description" 
                                              class="form-control" 
                                              rows="3" 
                                              placeholder="Deskripsi singkat tentang link ini"></textarea>
                                </div> -->

                                <!-- <div class="mb-4">
                                    <label for="expired_at" class="form-label">
                                        <i class="fas fa-clock me-2"></i>Kadaluarsa
                                        <span class="optional-badge">Opsional</span>
                                    </label>
                                    <input type="datetime-local" 
                                           id="expired_at" 
                                           name="expired_at" 
                                           class="form-control">
                                    <div class="form-text">Biarkan kosong untuk kadaluarsa 30 hari</div>
                                </div> -->

                                <button type="submit" class="btn btn-primary w-100">
                                    <span class="loading-spinner">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                    <i class="fas fa-magic me-2"></i>
                                    Buat Link Singkat
                                </button>
                            </form>

                            <div id="resultBox" style="display:none">
                                <div class="result-card">
                                    <i class="fas fa-check-circle mb-3" style="font-size: 3rem;"></i>
                                    <h4>Link Singkat Berhasil Dibuat!</h4>
                                    <div class="short-url" id="shortUrlResult"></div>
                                    <div id="urlInfo" class="mt-3" style="display:none;">
                                        <div class="row text-start">
                                            <div class="col-md-6">
                                                <small><strong>Original URL:</strong></small><br>
                                                <small id="originalUrlInfo" class="text-light"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <small><strong>Kadaluarsa:</strong></small><br>
                                                <small id="expiredInfo" class="text-light"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="qr-code">
                                        <canvas id="qrCanvas"></canvas>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-light btn-sm me-2" onclick="copyToClipboard()">
                                            <i class="fas fa-copy me-1"></i>Salin Link
                                        </button>
                                        <button class="btn btn-light btn-sm me-2" onclick="downloadQR()">
                                            <i class="fas fa-download me-1"></i>Download QR
                                        </button>
                                        <button class="btn btn-light btn-sm" onclick="resetForm()">
                                            <i class="fas fa-plus me-1"></i>Buat Lagi
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="features-grid">
                                <div class="feature-item">
                                    <i class="fas fa-shield-alt feature-icon"></i>
                                    <h5>Aman & Terpercaya</h5>
                                    <p class="text-muted mb-0">Link aman dengan enkripsi</p>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-chart-line feature-icon"></i>
                                    <h5>Analytics Gratis</h5>
                                    <p class="text-muted mb-0">Pantau klik dan performa</p>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-mobile-alt feature-icon"></i>
                                    <h5>Responsif</h5>
                                    <p class="text-muted mb-0">Bekerja di semua perangkat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        let qrCode = null;
        let shortUrl = '';

        $('#shortenForm').submit(function(e){
            e.preventDefault();
            
            const $btn = $(this).find('button[type="submit"]');
            const $spinner = $btn.find('.loading-spinner');
            const $icon = $btn.find('.fa-magic');
            
            $btn.prop('disabled', true);
            $spinner.show();
            $icon.hide();
            $('#shortenAlert').html('');
            
            $.post('<?= site_url('url/shorten') ?>', $(this).serialize(), function(res){
                let data = JSON.parse(res);
                if(data.status === 'success'){
                    shortUrl = data.short_url;
                    $('#resultBox').show();
                    $('#shortUrlResult').html('<a href="'+data.short_url+'" target="_blank" class="text-white">'+data.short_url+'</a>');
                    
                    // Tampilkan informasi URL
                    $('#originalUrlInfo').text($('#original_url').val());
                    const expiredDate = $('#expired_at').val() ? new Date($('#expired_at').val()).toLocaleDateString('id-ID') : '30 hari dari sekarang';
                    $('#expiredInfo').text(expiredDate);
                    $('#urlInfo').show();
                    
                    qrCode = new QRious({
                        element: document.getElementById('qrCanvas'),
                        value: data.short_url,
                        size: 200,
                        background: '#ffffff',
                        foreground: '#000000'
                    });
                    
                    // Scroll to result
                    $('html, body').animate({
                        scrollTop: $('#resultBox').offset().top - 100
                    }, 500);
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Link singkat telah dibuat',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    $('#shortenAlert').html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>'+data.message+'</div>');
                }
            }).fail(function() {
                $('#shortenAlert').html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan. Silakan coba lagi.</div>');
            }).always(function() {
                $btn.prop('disabled', false);
                $spinner.hide();
                $icon.show();
            });
        });

        function copyToClipboard() {
            navigator.clipboard.writeText(shortUrl).then(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Tersalin!',
                    text: 'Link telah disalin ke clipboard',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }

        function downloadQR() {
            if (qrCode) {
                const link = document.createElement('a');
                link.download = 'qr-code.png';
                link.href = qrCode.toDataURL();
                link.click();
            }
        }

        function resetForm() {
            $('#shortenForm')[0].reset();
            $('#resultBox').hide();
            $('#urlInfo').hide();
            $('#shortenAlert').html('');
            $('#original_url').focus();
        }

        // Auto-format custom URL (hapus spasi dan karakter khusus)
        $('#custom_url').on('input', function() {
            let value = $(this).val();
            // Hapus semua karakter kecuali huruf, angka, tanda hubung, dan underscore
            value = value.replace(/[^a-zA-Z0-9\-_]/g, '');
            $(this).val(value);
        });

        // Auto-resize textarea
        $('#description').on('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    </script>
</body>
</html>