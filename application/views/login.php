<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - URL Shortener</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
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
            padding: 2rem;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control:focus {
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

        .input-group-text {
            background: #f9fafb;
            border: 2px solid var(--border-color);
            border-right: none;
            border-radius: 0.75rem 0 0 0.75rem;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 0.75rem 0.75rem 0;
        }

        .loading-spinner {
            display: none;
            margin-right: 0.5rem;
        }

        .brand-logo {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .welcome-text {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 1rem;
            }
            
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
    <div class="login-container">
        <div class="card">
            <div class="card-header">
                <div class="brand-logo">
                    <i class="fas fa-link"></i>
                </div>
                <h3 class="mb-2">Admin Login</h3>
                <p class="welcome-text mb-0">Masuk ke dashboard URL Shortener</p>
            </div>
            <div class="card-body">
                <form id="loginForm">
                    <div id="loginAlert"></div>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-user me-2"></i>Username
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   class="form-control" 
                                   placeholder="Masukkan username" 
                                   required 
                                   autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-control" 
                                   placeholder="Masukkan password" 
                                   required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <span class="loading-spinner">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Login
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="<?= site_url('url/shorten') ?>" class="text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali ke URL Shortener
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        $('#loginForm').submit(function(e){
            e.preventDefault();
            
            const $btn = $(this).find('button[type="submit"]');
            const $spinner = $btn.find('.loading-spinner');
            const $icon = $btn.find('.fa-sign-in-alt');
            
            $btn.prop('disabled', true);
            $spinner.show();
            $icon.hide();
            $('#loginAlert').html('');
            
            $.post('<?= site_url('welcome/login') ?>', $(this).serialize(), function(res){
                let data = JSON.parse(res);
                if(data.status === 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil!',
                        text: 'Mengalihkan ke dashboard...',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    $('#loginAlert').html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>'+data.message+'</div>');
                    $btn.prop('disabled', false);
                    $spinner.hide();
                    $icon.show();
                }
            }).fail(function() {
                $('#loginAlert').html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan. Silakan coba lagi.</div>');
                $btn.prop('disabled', false);
                $spinner.hide();
                $icon.show();
            });
        });

        // Add enter key support
        $('#username, #password').keypress(function(e) {
            if (e.which == 13) {
                $('#loginForm').submit();
            }
        });
    </script>
</body>
</html>