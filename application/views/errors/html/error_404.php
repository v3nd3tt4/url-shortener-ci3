<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #3730a3;
            --text-color: #1f2937;
            --border-color: #e5e7eb;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-color);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            text-align: center;
            max-width: 500px;
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 3rem 2rem;
        }

        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .error-icon {
            font-size: 4rem;
            color: #ef4444;
            margin-bottom: 1rem;
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

        .btn-outline-secondary {
            border: 2px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 0.875rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            color: var(--text-color);
        }

        .btn-outline-secondary:hover {
            background: var(--border-color);
            transform: translateY(-2px);
        }

        @media (max-width: 576px) {
            .error-code {
                font-size: 4rem;
            }
            
            .error-icon {
                font-size: 3rem;
            }
            
            .card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="card">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="error-code">404</div>
            <h2 class="mb-3">Halaman Tidak Ditemukan</h2>
            <p class="text-muted mb-4">
                Maaf, halaman yang Anda cari tidak ditemukan atau mungkin telah dipindahkan.
            </p>
            
            <div class="d-flex gap-2 justify-content-center flex-wrap">
                <a href="<?= base_url() ?>" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>
                    Kembali ke Beranda
                </a>
                <a href="<?= site_url('url/shorten') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-link me-2"></i>
                    Buat URL Singkat
                </a>
            </div>
        </div>
    </div>
</body>
</html>