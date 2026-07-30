@extends('layouts.master')
@section('content')
 <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .upload-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            /* box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); */
            padding: 30px;
            box-shadow: rgba(6, 24, 44, 0.4) 0px 0px 0px 2px, rgba(6, 24, 44, 0.65) 0px 4px 6px -1px, rgba(255, 255, 255, 0.08) 0px 1px 0px inset;
        }
        .page-header {
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        .page-header h1 {
            color: #2c3e50;
            font-weight: 600;
        }
        .page-header p {
            color: #7f8c8d;
            font-size: 16px;
        }
        .drop-area {
            border: 2px dashed #3498db;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            margin-bottom: 20px;
            position: relative;
            min-height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .drop-area.highlight {
            border-color: #2ecc71;
            background-color: rgba(46, 204, 113, 0.1);
        }
        .drop-area i {
            font-size: 64px;
            color: #3498db;
        }
        .drop-area h3 {
            color: #2c3e50;
        }
        .drop-area p {
            color: #7f8c8d;
        }
        .btn-upload {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        .btn-upload:hover {
            background-color: #2980b9;
        }
        .file-input {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
        }
        .file-list {
            margin-top: 20px;
        }
        .file-list .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .file-list .file-name {
            flex-grow: 1;
            margin-right: 15px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .file-list .file-size {
            color: #7f8c8d;
            font-size: 12px;
            margin-right: 15px;
        }
        .file-list .file-remove {
            color: #e74c3c;
            cursor: pointer;
        }
        .progress {
            height: 8px;
            margin-top: 5px;
            margin-bottom: 0;
        }
        .instructions {
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin-top: 30px;
            border-radius: 4px;
        }
        .instructions h4 {
            color: #2c3e50;
            margin-top: 0;
        }
        .instructions ul {
            padding-left: 20px;
            margin-bottom: 0;
        }
        .instructions li {
            color: #7f8c8d;
            margin-bottom: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #7f8c8d;
            font-size: 14px;
        }
        .browse-btn-container {
            position: relative;
            z-index: 2;
        }
    </style>
    <div class="upload-container">
        <div class="page-header">
            <h1><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel File Upload</h1>
            <p>Upload your Excel files for processing</p>
        </div>
        
        <div class="drop-area" id="dropArea">
            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
            <p>Supported formats: <span style="color: #0ca5aa;">.xls, .xlsx, .xlsm</span></p>
            <div class="browse-btn-container">
                <button class="btn-upload" id="browseBtn">Browse Files</button>
                <input type="file" id="fileInput" class="file-input" accept=".xls,.xlsx,.xlsm">
            </div>
        </div>
        <div class="file-list">
            <div class="list-group" id="fileList">
                <!-- Files will be listed here -->
            </div>
        </div>
        
        <button class="btn btn-primary btn-block" id="uploadBtn" disabled style="margin-top: 20px;">
            <i class="fa fa-upload" aria-hidden="true"></i> Upload Files
        </button>
    </div>  
    <script>document.title = 'Upload | Items';</script>
    <script>
        setTimeout(function() { $('.sr-only').click();}, 0.001);
        $(document).ready(function() {
            const dropArea = document.getElementById('dropArea');
            const fileInput = document.getElementById('fileInput');
            const browseBtn = document.getElementById('browseBtn');
            const fileList = document.getElementById('fileList');
            const uploadBtn = document.getElementById('uploadBtn');
            
            // Click event for browse button
            browseBtn.addEventListener('click', () => {
                fileInput.click();
            });
            
            // Change event for file input
            fileInput.addEventListener('change', handleFiles);
            
            // Drag and drop events
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropArea.classList.add('highlight');
            }
            
            function unhighlight() {

                dropArea.classList.remove('highlight');
            }
            
            dropArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFiles({ target: { files } });
            }
            
            function handleFiles(e) {
                const files = e.target.files;
                
                if (files.length === 0) return;
                
                // Clear previous files
                fileList.innerHTML = '';
                
                // Process each file
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    
                    // Check if file is Excel
                    if (!isExcelFile(file)) {
                        alert('Only Excel files are allowed!');
                        continue;
                    }
                    
                    // Add file to list
                    addFileToList(file);
                }
                
                // Enable upload button if we have files
                if (fileList.children.length > 0) {
                    uploadBtn.disabled = false;
                }
            }
            
            function isExcelFile(file) {

                const allowedExtensions = ['.xls', '.xlsx', '.xlsm'];
                const fileExtension = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();
                return allowedExtensions.includes(fileExtension);
            }
            
            function addFileToList(file) {

                const listItem = document.createElement('div');
                listItem.className = 'list-group-item';
                const fileSize = formatFileSize(file.size);
                listItem.innerHTML = `
                    <div class="file-name">${file.name}</div>
                    <div class="file-size">${fileSize}</div>
                    <div class="file-remove" onclick="removeFile(this)"><i class="fa fa-times"></i></div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                    </div>
                `;

                fileList.appendChild(listItem);
            }
            
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
            
            // Upload button event
            uploadBtn.addEventListener('click', function() {
                 
                // Simulate upload process
                simulateUpload();
            });
            
            function simulateUpload() {

                const fileInput = document.getElementById('fileInput');
                const uploadBtn = document.getElementById('uploadBtn');

                // Upload Button Click Event
                uploadBtn.addEventListener('click', function () {

                    const file = fileInput.files[0]; 
                    if (!file) {
                        alert("Please select an Excel file first!");
                        return;
                    }

                    let formData = new FormData();
                    formData.append('excel_file', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    // AJAX Request
                    $.ajax({
                        url: "/upload/party_items", 
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            uploadBtn.disabled = true;
                            uploadBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Uploading...';
                        },
                        success: function (response) {

                            // alert(response.message);
                            // resetUploader();
                        },
                        error: function (xhr) {
                            alert("Upload failed! Check your file format.");
                        },
                        complete: function () {
                            uploadBtn.disabled = false;
                            uploadBtn.innerHTML = '<i class="fa fa-upload"></i> Upload Files';
                        }
                    });
                });
                
            }
            
            function resetUploader() {
                fileList.innerHTML = '';
                fileInput.value = '';
                const uploadBtn = document.getElementById('uploadBtn');
                uploadBtn.disabled = true;
                uploadBtn.innerHTML = '<i class="fa fa-upload" aria-hidden="true"></i> Upload Files';
            }
            
            // Make removeFile function available globally
            window.removeFile = function(element) {
                const listItem = element.closest('.list-group-item');
                listItem.remove();
                
                // Disable upload button if no files left
                if (fileList.children.length === 0) {
                    uploadBtn.disabled = true;
                }
            };
        });
    </script>
@endsection
