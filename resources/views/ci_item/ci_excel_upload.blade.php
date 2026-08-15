@extends('layouts.master')
@section('content')
<style>
    /* ===== MODERN DESIGN SYSTEM ===== */
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --primary-light: #818cf8;
        --success: #10b981;
        --success-dark: #059669;
        --danger: #ef4444;
        --danger-dark: #dc2626;
        --warning: #f59e0b;
        --info: #0ea5e9;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.04);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.08), 0 4px 6px rgba(0,0,0,0.04);
        --radius: 8px;
        --radius-lg: 12px;
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body { background: #f1f5f9; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }

    /* ===== BOX ===== */
    .box {
        position: relative;
        border-radius: var(--radius-lg);
        background: #ffffff;
        border-top: 4px solid var(--primary);
        margin-bottom: 20px;
        width: 100%;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    .box.box-info { border-top-color: var(--primary); }

    /* ===== BOX HEADER ===== */
    .box-header.with-border {
        padding: 12px 18px;
        background: linear-gradient(135deg, var(--gray-50) 0%, #ffffff 100%);
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .box-header.with-border .header-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--gray-800);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .box-header.with-border .header-title i {
        color: var(--primary);
        font-size: 16px;
    }

    /* ===== BUTTONS ===== */
    .btn {
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 500;
        border-radius: var(--radius);
        border: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        line-height: 1.5;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        height: 28px;
    }

    .btn i { font-size: 12px; }

    .btn-info {
        background: linear-gradient(135deg, var(--info) 0%, #0284c7 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(14, 165, 233, 0.2);
    }
    .btn-info:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(14, 165, 233, 0.3);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }
    .btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(79, 70, 229, 0.3);
    }

    .btn-danger {
        background: linear-gradient(135deg, var(--danger) 0%, var(--danger-dark) 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
    }
    .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
    }

    .btn-flat { border-radius: var(--radius); }

    /* ===== UPLOAD SECTION ===== */
    .upload-section {
        padding: 20px 24px;
        background: white;
        text-align: center;
    }

    .upload-section .upload-icon {
        font-size: 56px;
        color: var(--primary);
        margin-bottom: 12px;
        display: block;
    }

    .upload-section .upload-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 4px;
    }

    .upload-section .upload-subtitle {
        font-size: 12px;
        color: var(--gray-500);
        margin-bottom: 20px;
    }

    /* ===== FILE UPLOAD ===== */
    .file-upload-wrapper {
        position: relative;
        border: 2px dashed var(--gray-300);
        border-radius: var(--radius-lg);
        padding: 40px 20px;
        background: var(--gray-50);
        transition: var(--transition);
        cursor: pointer;
        margin-bottom: 20px;
    }

    .file-upload-wrapper:hover {
        border-color: var(--primary);
        background: #eef2ff;
    }

    .file-upload-wrapper .file-icon {
        font-size: 40px;
        color: var(--gray-400);
        display: block;
        margin-bottom: 8px;
    }

    .file-upload-wrapper .file-text {
        font-size: 14px;
        font-weight: 500;
        color: var(--gray-700);
    }

    .file-upload-wrapper .file-hint {
        font-size: 11px;
        color: var(--gray-400);
        margin-top: 4px;
    }

    .file-upload-wrapper input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-upload-wrapper .file-name {
        margin-top: 10px;
        font-size: 12px;
        color: var(--primary);
        font-weight: 500;
        display: none;
    }

    .file-upload-wrapper.has-file {
        border-color: var(--success);
        background: #f0fdf4;
    }

    .file-upload-wrapper.has-file .file-name {
        display: block;
    }

    /* ===== FORM ===== */
    .form-group {
        margin-bottom: 12px;
    }

    .form-group label {
        font-size: 11px;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 3px;
        display: block;
        letter-spacing: 0.3px;
    }

    .form-group label .text-danger {
        color: var(--danger);
        margin-left: 2px;
    }

    .form-control {
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        padding: 5px 10px;
        font-size: 12px;
        height: 32px;
        transition: var(--transition);
        background: white;
        width: 100%;
        color: var(--gray-800);
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    .form-control:hover {
        border-color: var(--gray-400);
    }

    /* ===== HELP BLOCK ===== */
    .help-block {
        color: var(--danger);
        font-size: 11px;
        margin-top: 3px;
    }

    /* ===== BREADCRUMB ===== */
    .content-header > .breadcrumb {
        float: right;
        background: transparent;
        margin-top: 0;
        margin-bottom: 0;
        font-size: 12px;
        padding: 7px 5px;
        border-radius: 2px;
    }

    .content-header > .breadcrumb > li > a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .content-header > .breadcrumb > li > a:hover {
        color: var(--primary-dark);
    }

    .content-header h1 {
        font-size: 20px;
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 4px;
    }
    .content-header h1 small {
        font-size: 14px;
        color: var(--gray-500);
        font-weight: 400;
    }

    /* ===== CALL OUT ===== */
    .alert {
        border-radius: var(--radius);
        padding: 12px 18px;
        margin-bottom: 16px;
    }
    .alert-success {
        background: #ecfdf5;
        border-left: 4px solid var(--success);
        color: #065f46;
    }
    .alert-danger {
        background: #fef2f2;
        border-left: 4px solid var(--danger);
        color: #991b1b;
    }

    .alert .close {
        float: right;
        font-size: 18px;
        font-weight: 700;
        line-height: 1;
        color: inherit;
        opacity: 0.6;
        text-decoration: none;
        cursor: pointer;
    }
    .alert .close:hover {
        opacity: 1;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .box-header.with-border {
            flex-direction: column;
            align-items: stretch;
        }
        .upload-section {
            padding: 16px;
        }
        .upload-section .upload-icon {
            font-size: 40px;
        }
        .file-upload-wrapper {
            padding: 30px 15px;
        }
        .file-upload-wrapper .file-icon {
            font-size: 30px;
        }
        .content-header h1 {
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .upload-section .upload-title {
            font-size: 15px;
        }
        .file-upload-wrapper {
            padding: 20px 10px;
        }
        .file-upload-wrapper .file-text {
            font-size: 12px;
        }
        .btn {
            font-size: 10px;
            padding: 3px 10px;
            height: 24px;
        }
    }

    /* ===== SCROLLBAR ===== */
    ::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }
    ::-webkit-scrollbar-track {
        background: var(--gray-100);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb {
        background: var(--gray-300);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: var(--gray-400);
    }
</style>

<!-- ===== MAIN CONTENT ===== -->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        @if(Session::has('success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> {{ Session::get('success') }}
            </div> 
        @endif 
        @if(Session::has('danger'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Failed!</strong> {{ Session::get('danger') }}
            </div>
        @endif

        <div class="box box-info">
            <!-- ===== BOX HEADER ===== -->
            <div class="box-header with-border">
                <div class="header-title">
                    <i class="fa fa-file-excel-o"></i> Upload Excel File
                </div>
            </div>

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/ci_item/upload') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <div class="upload-section">
                    <i class="fa fa-file-excel-o upload-icon"></i>
                    <div class="upload-title">Upload Items</div>
                    <div class="upload-subtitle">Upload Excel file to import items in bulk</div>

                    <!-- ===== FILE UPLOAD ===== -->
                    <div class="file-upload-wrapper" id="fileUploadWrapper">
                        <i class="fa fa-cloud-upload file-icon"></i>
                        <div class="file-text">Drag & Drop or Click to Upload</div>
                        <div class="file-hint">Supported formats: .xlsx, .xls (Max 10MB)</div>
                        <input type="file" name="file" id="fileInput" accept=".xlsx,.xls" required>
                        <div class="file-name" id="fileName">📄 <span></span></div>
                    </div>

                    @if ($errors->has('file'))
                        <span class="help-block"><strong>{{ $errors->first('file') }}</strong></span>
                    @endif

                    <!-- ===== UPLOAD BUTTON ===== -->
                    <button type="submit" class="btn btn-info btn-flat">
                        <i class="fa fa-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- ===== SCRIPTS ===== -->
<!-- ============================================================ -->
<script>document.title = 'Upload | CI';</script>
<script type="text/javascript">
    setTimeout(function() { 
        $('.sr-only').click();
    }, 0.0001);

    $(document).ready(function() {
        // ===== FILE INPUT CHANGE =====
        $('#fileInput').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            var wrapper = $('#fileUploadWrapper');
            
            if (fileName) {
                wrapper.addClass('has-file');
                $('#fileName span').text(fileName);
                
                // File size validation (10MB = 10485760 bytes)
                if (this.files[0] && this.files[0].size > 10485760) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'File Too Large',
                        text: 'File size exceeds 10MB. Please choose a smaller file.',
                        confirmButtonColor: '#4f46e5'
                    });
                    $(this).val('');
                    wrapper.removeClass('has-file');
                    $('#fileName span').text('');
                }
            } else {
                wrapper.removeClass('has-file');
                $('#fileName span').text('');
            }
        });

        // ===== DRAG AND DROP =====
        var wrapper = document.getElementById('fileUploadWrapper');
        
        wrapper.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.style.borderColor = '#4f46e5';
            this.style.background = '#eef2ff';
        });

        wrapper.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.style.borderColor = '#cbd5e1';
            this.style.background = '#f8fafc';
        });

        wrapper.addEventListener('drop', function(e) {
            e.preventDefault();
            this.style.borderColor = '#cbd5e1';
            this.style.background = '#f8fafc';
            
            var files = e.dataTransfer.files;
            if (files.length > 0) {
                var input = document.getElementById('fileInput');
                input.files = files;
                $(input).trigger('change');
            }
        });
    });
</script>
@endsection