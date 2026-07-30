@extends('layouts.master')
@section('content') 
<style>
    .btn {
        padding: 3px 12px;
    }
    .table > thead > tr > th{
        padding: 8px;
    }
    .table > tbody > tr > td {
        padding: 5px;
        vertical-align: middle;
    }
    .table-bordered > thead > tr > th {
        border: 1px solid #c6c6c6 !important;
    }
    .table-bordered > tbody > tr > td {
        border: 1px solid #c6c6c6;
        font-size: 12px;
    }
    .role-badge {
        background: #00a65a;
        padding: 3px 8px;
        border-radius: 3px;
        color: white;
        font-size: 10px;
        margin-left: 5px;
    }
    .assigned-role-table {
        margin-top: 15px;
        max-height: 300px;
        overflow-y: auto;
    }
    .permission-table-container {
        max-height: 400px;
        overflow-y: auto;
        overflow-x: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .form-group {
       margin-bottom: 5px;
    }
    .table > tbody > tr > td {
        padding: 2px;
        vertical-align: middle;
    }
    .permission-table {
        width: 100%;
        margin-bottom: 0;
    }
    .permission-table thead th {
        position: sticky;
        top: 0;
        background: #3c8dbc;
        color: white;
        z-index: 10;
    }
    .save-permission-btn {
        margin-top: 15px;
        text-align: right;
        padding: 10px;
        background: #f9f9f9;
        border-radius: 3px;
    }
    .perm-checkbox {
        cursor: pointer;
        transform: scale(1.1);
    }
    .perm-checkbox:hover {
        transform: scale(1.2);
    }
    .menu-name-cell {
        font-weight: 600;
        color: #333;
    }
    .custom-badge {
        background: #ffc107;
        color: #333;
        font-size: 9px;
        padding: 2px 6px;
        border-radius: 3px;
        margin-left: 8px;
        white-space: nowrap;
    }
    #btnAssignRole {
        margin-left: 10px;
    }
    .box-header .box-title {
        font-size: 16px;
        font-weight: 600;
    }
    .selected-user-info {
        background: #3c8dbc;
        color: white;
        padding: 5px 10px;
        border-radius: 3px;
        font-size: 12px;
        display: inline-block;
    }
    .action-buttons {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }
    .check-all-group {
        transform: scale(1.1);
        margin-right: 5px;
    }
    .search-box {
        margin-bottom: 15px;
        background: #f9f9f9;
        border-radius: 3px;
    }
    .search-box input {
        width: 100%;
        max-width: 300px;
        padding: 5px 10px;
        border: 1px solid #ddd;
        border-radius: 3px;
    }
    .permission-stats {
        background: #f4f4f4;
        padding: 8px 12px;
        border-radius: 3px;
        margin-bottom: 15px;
        font-size: 12px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    .stat-badge {
        background: #3c8dbc;
        color: white;
        padding: 3px 10px;
        border-radius: 3px;
    }
    .stat-badge.custom {
        background: #ffc107;
        color: #333;
    }
    .stat-badge.total {
        background: #00a65a;
    }
    .loading-overlay {
        text-align: center;
        padding: 50px;
    }
    .table-status {
        margin-top: 10px;
        font-size: 11px;
        color: #666;
    }
    .filter-no-result {
        text-align: center;
        padding: 30px;
        color: #999;
    }
    .bootstrap-select > .dropdown-toggle.bs-placeholder{
        color: #222;
    }
    .bootstrap-select > .dropdown-toggle.bs-placeholder{
        color: #222;
        border: 1px solid #ccc;
    }

</style>

<section class="content-header" style="padding-top: 0px;">
    <h1>Role-Permission <small>User & Permission Management</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Role Permission</li>
    </ol>
    <br>
</section>

<div class="row">
    <!-- LEFT SIDE: User & Role Section -->
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-users"></i> User Role Assignment</h3>
            </div>
            <div class="box-body">
                <!-- User Select -->
                <div class="form-group">
                    <label for="user_id_role">Select User</label>
                    <select name="user_id" id="user_id_role" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1">
                        @foreach($users as $user)
                        <option value="{{$user->id}}" @if(request()->get('user_id') == $user->id) selected @endif>
                            {{$user->username}} - {{$user->name}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Role Assign Form -->
                <div class="form-group">
                    <label for="role_id">Assign New Role</label>
                    <div class="input-group">
                        <select name="role_id" id="role_id" data-live-search="true" class="form-control select2 selectpicker input-sm" required autofocus type="select"  value="1">
                            <option value="">Select</option>
                            @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        <span class="input-group-btn">
                            <button type="button" id="btnAssignRole" class="btn btn-primary">
                                <i class="fa fa-plus"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <hr>
                <!-- Assigned Roles Table -->
                <h4><i class="fa fa-tag"></i> Assigned Roles</h4>
                <div class="assigned-role-table">
                    <table class="table table-bordered table-condensed table-hover">
                        <thead>
                            <tr>
                                <th width="30">#</th>
                                <th>Role Name</th>
                                <th width="70">Action</th>
                            </tr>
                        </thead>
                        <tbody id="assignedRolesBody">
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    <i class="fa fa-info-circle"></i> Select a user first
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- RIGHT SIDE: Permission Details Section -->
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-lock"></i> Permission Details</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">
                <!-- Permission Table Container -->
                <div id="permissionTableContainer">
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle"></i> Please select a user to view permissions
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>document.title = 'Role Permission - User & Permission Management';
$(document).ready(function() {

    setTimeout(function() { $('.sr-only').click();}, 0.0001);
    var currentUserId = null;
    var currentMenusData = [];
    // Initialize select2
    if ($.fn.select2) {
        $('.select2').select2({
            placeholder: "-- Select User --",
            allowClear: true
        });
    }
    
    // Load assigned roles for selected user
    function loadAssignedRoles(userId) {
        $('#assignedRolesBody').html('<tr><td colspan="3" class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading roles...</td></tr>');
        
        $.ajax({
            type: 'GET',
            url: "{{ url('/json/getUserRoles') }}",
            data: { user_id: userId },
            success: function(response) {
                if (response.data && response.data.length > 0) {
                    var html = '';
                    $.each(response.data, function(index, role) {
                        html += '<tr>';
                        html += '<td>' + (index + 1) + '</td>';
                        html += '<td>' + role.role_name + '</td>';
                        html += '<td>';
                        html += '<button type="button" class="btn btn-danger btn-xs btn-remove-role" data-id="' + role.user_role_id + '" title="Remove Role">';
                        html += '<i class="fa fa-trash"></i>';
                        html += '</button>';
                        html += '</tr>';
                        html += '</tr>';
                    });
                    $('#assignedRolesBody').html(html);
                } else {
                    $('#assignedRolesBody').html('<tr><td colspan="3" class="text-center text-muted"><i class="fa fa-info-circle"></i> No roles assigned</td></tr>');
                }
            },
            error: function() {
                $('#assignedRolesBody').html('<tr><td colspan="3" class="text-center text-danger"><i class="fa fa-exclamation-triangle"></i> Error loading roles</td></tr>');
            }
        });
    }
    
    // Filter permissions based on search
    function filterPermissions(searchTerm) {
        var rows = $('#permissionsTableBody tr');
        var visibleCount = 0;
        
        if (!searchTerm || searchTerm === '') {
            rows.show();
            visibleCount = rows.length;
        } else {
            var term = searchTerm.toLowerCase();
            rows.each(function() {
                var menuName = $(this).data('menu-name').toLowerCase();
                if (menuName.indexOf(term) > -1) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });
        }
        
        // Show/hide no result message
        if (visibleCount === 0) {
            if ($('#noResultRow').length === 0) {
                $('#permissionsTableBody').append('<tr id="noResultRow"><td colspan="6" class="filter-no-result"><i class="fa fa-search"></i> No matching menus found</td></tr>');
            }
        } else {
            $('#noResultRow').remove();
        }
    }
    
    // Load permissions for selected user
    function loadPermissions(userId) {
        $('#permissionTableContainer').html(`
            <div class="loading-overlay">
                <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                <p><strong>Loading permissions...</strong></p>
                <small class="text-muted">Please wait while we fetch menu permissions</small>
            </div>
        `);
        
        $.ajax({
            type: 'GET',
            url: "{{ url('/json/getUserPermissions') }}",
            data: { user_id: userId },
            success: function(response) {
                currentUserId = userId;
                currentMenusData = response.menus || [];
                displayPermissionsTable(response);
                updateUserInfo(response);
            },
            error: function(xhr) {
                $('#permissionTableContainer').html(`
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle"></i> 
                        Error loading permissions. Please try again.
                        <br><small class="text-muted">${xhr.statusText || 'Unknown error'}</small>
                    </div>
                `);
            }
        });
    }
    
    // Update user info display
    function updateUserInfo(response) {

        var totalMenus = response.menus ? response.menus.length : 0;
        var customCount = response.menus ? response.menus.filter(m => m.has_custom).length : 0;
       
    }
    
    // Display permissions table (without DataTable)
    function displayPermissionsTable(data) {
        if (!data.menus || data.menus.length === 0) {
            $('#permissionTableContainer').html(`
                <div class="alert alert-warning">
                    <i class="fa fa-warning"></i> 
                    No menus found in the system.
                    <br><small>Please add menus first in Menu Management.</small>
                </div>
            `);
            return;
        }
        
        var totalMenus = data.menus.length;
        var customMenus = data.menus.filter(m => m.has_custom).length;
        
        // Build table HTML
        var html = '<div class="permission-section">';
        html += '<div class="permission-header" style="background:#3c8dbc;color:white;padding:10px;margin-bottom:15px;border-radius:3px;">';
        html += '<i class="fa fa-key"></i> Menu Permissions Management';
        html += '<div class="pull-right">';
        html += '<small><i class="fa fa-info-circle"></i> Check/Uncheck to override role defaults</small>';
        html += '</div>';
        html += '</div>';
        
        // Search box
        html += '<div class="search-box">';
        html += '<div class="row">';
        html += '<div class="col-md-6">';
        html += '<input type="text" id="searchMenuInput" class="form-control" placeholder="🔍 Search by menu name...">';
        html += '</div>';
        html += '<div class="col-md-6 text-right">';
        html += '<button type="button" id="resetPermissionsBtn" class="btn btn-danger btn-sm"><i class="fa fa-refresh"></i> Reset Permissions</button>';
        html += '<button type="button" id="savePermissionsBtn" class="btn btn-primary btn-sm" style="margin-left:10px;"><i class="fa fa-save"></i> Save Permissions</button>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        
        // Permission table with vertical scroll
        html += '<div class="permission-table-container">';
        html += '<table class="table table-bordered table-hover permission-table" id="permissionsTable">';
        html += '<thead>';
        html += '<tr style="background: #3c8dbc; color: white;">';
        html += '<th width="25%">Menu Name</th>';
        html += '<th width="15%" class="text-center"><input type="checkbox" id="checkAllVsbl" class="check-all-group"> Visible</th>';
        html += '<th width="15%" class="text-center"><input type="checkbox" id="checkAllCrat" class="check-all-group"> Create</th>';
        html += '<th width="15%" class="text-center"><input type="checkbox" id="checkAllRead" class="check-all-group"> Read</th>';
        html += '<th width="15%" class="text-center"><input type="checkbox" id="checkAllUpdt" class="check-all-group"> Update</th>';
        html += '<th width="15%" class="text-center"><input type="checkbox" id="checkAllDelt" class="check-all-group"> Delete</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody id="permissionsTableBody">';
        
        // Build table rows
        $.each(data.menus, function(index, menu) {
            // Determine final checked state
            var isVsblChecked = (menu.custom_vsbl !== null) ? (menu.custom_vsbl == '1') : (menu.wsmu_vsbl == '1');
            var isCratChecked = (menu.custom_crat !== null) ? (menu.custom_crat == '1') : (menu.wsmu_crat == '1');
            var isReadChecked = (menu.custom_read !== null) ? (menu.custom_read == '1') : (menu.wsmu_read == '1');
            var isUpdtChecked = (menu.custom_updt !== null) ? (menu.custom_updt == '1') : (menu.wsmu_updt == '1');
            var isDeltChecked = (menu.custom_delt !== null) ? (menu.custom_delt == '1') : (menu.wsmu_delt == '1');
            
            var hasCustom = menu.has_custom;
            
            html += '<tr data-menu-id="' + menu.menu_id + '" data-menu-name="' + menu.menu_name + '">';
            html += '<td class="menu-name-cell">';
            html += '<i class="fa ' + (menu.menu_icon || 'fa-bars') + '"></i> ' + menu.menu_name;
            html += '</td>';
            html += '<td class="text-center"><input type="checkbox" class="perm-checkbox perm-vsbl" data-perm="vsbl" ' + (isVsblChecked ? 'checked' : '') + '></td>';
            html += '<td class="text-center"><input type="checkbox" class="perm-checkbox perm-crat" data-perm="crat" ' + (isCratChecked ? 'checked' : '') + '></td>';
            html += '<td class="text-center"><input type="checkbox" class="perm-checkbox perm-read" data-perm="read" ' + (isReadChecked ? 'checked' : '') + '></td>';
            html += '<td class="text-center"><input type="checkbox" class="perm-checkbox perm-updt" data-perm="updt" ' + (isUpdtChecked ? 'checked' : '') + '></td>';
            html += '<td class="text-center"><input type="checkbox" class="perm-checkbox perm-delt" data-perm="delt" ' + (isDeltChecked ? 'checked' : '') + '></td>';
            html += '</tr>';
        });
        
        html += '</tbody>';
        html += '<\/table>';
        html += '</div>';
        html += '<div class="table-status">';
        html += '<small class="text-muted"><i class="fa fa-info-circle"></i> Tip: Check/Uncheck any permission to override role defaults. Custom badges indicate active overrides. Use scroll to view all menus.</small>';
        html += '</div>';
        html += '</div>';
        
        $('#permissionTableContainer').html(html);
        
        // Initialize search functionality
        $('#searchMenuInput').on('keyup', function() {
            filterPermissions($(this).val());
        });
        
        // Initialize check-all functionality
        initCheckAll();
        
        // Initialize save button
        $('#savePermissionsBtn').off('click').on('click', function() {
            saveCustomPermissions();
        });
        
        // Initialize reset button
        $('#resetPermissionsBtn').off('click').on('click', function() {
            resetCustomPermissions();
        });
    }
    
    // Check all functionality for each column
    function initCheckAll() {
        // Check All Visible
        $('#checkAllVsbl').off('change').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('.perm-vsbl').prop('checked', isChecked);
        });
        
        // Check All Create
        $('#checkAllCrat').off('change').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('.perm-crat').prop('checked', isChecked);
        });
        
        // Check All Read
        $('#checkAllRead').off('change').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('.perm-read').prop('checked', isChecked);
        });
        
        // Check All Update
        $('#checkAllUpdt').off('change').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('.perm-updt').prop('checked', isChecked);
        });
        
        // Check All Delete
        $('#checkAllDelt').off('change').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('.perm-delt').prop('checked', isChecked);
        });
    }
    
    // Save custom permissions
    function saveCustomPermissions() {
        
        // Check if user is selected
        if (!currentUserId) {
            Swal.fire({
                icon: 'warning',
                title: 'No User Selected',
                text: 'Please select a user first',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Collect all permissions
        var permissions = [];
        var totalMenus = 0;
        var customChanges = 0;
        
        $('#permissionsTableBody tr').each(function() {
            var menuId = $(this).data('menu-id');
            var menuName = $(this).data('menu-name');
            var vsbl = $(this).find('.perm-vsbl').is(':checked') ? '1' : '0';
            var crat = $(this).find('.perm-crat').is(':checked') ? '1' : '0';
            var read = $(this).find('.perm-read').is(':checked') ? '1' : '0';
            var updt = $(this).find('.perm-updt').is(':checked') ? '1' : '0';
            var delt = $(this).find('.perm-delt').is(':checked') ? '1' : '0';
            
            permissions.push({
                menu_id: menuId,
                vsbl: vsbl,
                crat: crat,
                read: read,
                updt: updt,
                delt: delt
            });
            
            totalMenus++;
            
            // Check if this menu has custom badge (existing custom)
            if ($(this).find('.custom-badge').length > 0) {
                customChanges++;
            }
        });
        
        // Show confirmation dialog
        Swal.fire({
            title: 'Save Permissions?',
            html: `
                <div style="text-align: left;">
                    <p><strong>User:</strong> ${$('#user_id_role option:selected').text()}</p>
                    <p><strong>Total Menus:</strong> ${totalMenus}</p>
                    <p><strong>Custom Overrides:</strong> ${customChanges}</p>
                    <hr>
                    <p class="text-info">This will save all custom permissions for this user.</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Save!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Saving...',
                    text: 'Please wait while saving permissions',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // AJAX request
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/json/saveUserPermissions') }}",
                    data: {
                        user_id: currentUserId,
                        permissions: permissions,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: "success",
                                title: "Saved!",
                                text: response.msg,
                                showConfirmButton: true,
                                confirmButtonColor: "#3085d6"
                            }).then(() => {
                                // Reload permissions to show updated state
                                loadPermissions(currentUserId);
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Save Failed!",
                                text: response.msg || "Something went wrong",
                                confirmButtonText: "OK"
                            });
                        }
                    },
                    error: function(xhr) {
                        var errorMsg = "Failed to save permissions";
                        if (xhr.responseJSON && xhr.responseJSON.msg) {
                            errorMsg = xhr.responseJSON.msg;
                        }
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: errorMsg,
                            confirmButtonText: "OK"
                        });
                    }
                });
            }
        });
    }
    
    // Reset custom permissions
    function resetCustomPermissions() {
        Swal.fire({
            title: "Reset Permissions?",
            text: "This will remove all custom overrides and revert to role defaults.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, reset it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Resetting...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/json/resetUserPermissions') }}",
                    data: {
                        user_id: currentUserId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Reset!",
                            text: response.msg,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        loadPermissions(currentUserId);
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "Failed to reset permissions",
                            timer: 1500
                        });
                    }
                });
            }
        });
    }
    
    // Assign role to user
    $('#btnAssignRole').click(function() {

        var userId = $('#user_id_role').val();
        var roleId = $('#role_id').val();
        if (!userId) {
            Swal.fire('Warning', 'Please select a user first', 'warning');
            return;
        }
        if (!roleId) {
            Swal.fire('Warning', 'Please select a role to assign', 'warning');
            return;
        }
        $.ajax({
            type: 'POST',
            url: "{{ url('/update/user_role') }}",
            data: {
                user_id: userId,
                role_id: roleId,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                Swal.fire({
                    icon: "success",
                    title: "Assigned!",
                    text: res.msg,
                    showConfirmButton: false,
                    timer: 1500
                });
                
                $('#role_id').val('');
                loadAssignedRoles(userId);
                loadPermissions(userId);
            },
            error: function(xhr) {
                var errorMsg = xhr.responseJSON?.msg || 'Failed to assign role';
                Swal.fire('Error', errorMsg, 'error');
            }
        });
    });
    
    // Remove role from user
    $(document).on('click', '.btn-remove-role', function() {

        var userRoleId = $(this).data('id');
        var userId = $('#user_id_role').val();
        Swal.fire({
            title: "Remove Role?",
            text: "Are you sure you want to remove this role?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, remove it!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/delete/user_role') }}",
                    data: {
                        id: userRoleId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {

                        if(res.status === 'success') {

                            Swal.fire({
                                icon: "success",
                                title: "Removed!",
                                text: res.msg,
                                showConfirmButton: true,
                                confirmButtonColor: "#3085d6"
                            }).then(() => {
                                // Reload both tables
                                loadAssignedRoles(userId);
                                loadPermissions(userId);
                            });
                            
                        } else {

                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: res.msg,
                                confirmButtonText: "OK"
                            });
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to remove role', 'error');
                    }
                });
            }
        });
    });
    
    // User selection change
    $('#user_id_role').change(function() {
        var userId = $(this).val();
        if (userId) {
            loadAssignedRoles(userId);
            loadPermissions(userId);
        } else {
            $('#assignedRolesBody').html('<tr><td colspan="3" class="text-center text-muted"><i class="fa fa-info-circle"></i> Select a user first</td></tr>');
            $('#permissionTableContainer').html(`
                <div class="alert alert-info text-center">
                    <i class="fa fa-info-circle"></i> 
                    <strong>No user selected</strong><br>
                    <small>Please select a user from the left panel to view and manage permissions</small>
                </div>
            `);
            currentUserId = null;
        }
    });
    
    // Trigger change on page load if user preselected
    if ($('#user_id_role').val()) {
        $('#user_id_role').trigger('change');
    }
});
</script>
@endsection