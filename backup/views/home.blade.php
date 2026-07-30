@extends('layouts.master')
@section('content')
<style type="text/css">
  .dashboard-container {
    position: relative;
    min-height: 80vh;
    padding: 20px;
  }

  /* Main Dashboard Grid for Cards - 4 cards per row */
  .dashboard-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 cards per row */
    gap: 25px;
    padding: 20px 0;
    min-height: 212px;
  }

  /* Software Panel */
  .software-panel {
    position: fixed;
    top: 49px;
    right: -400px;
    width: 380px;
    height: 100vh;
    background: white;
    box-shadow: -5px 0 25px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    transition: right 0.3s ease-in-out;
    overflow-y: auto;
  }

  .software-panel.active {
    right: 0;
  }

  /* Menu Panel */
  .menu-panel {
    position: fixed;
    top: 49px;
    left: -400px;
    width: 380px;
    height: 100vh;
    background: white;
    box-shadow: 5px 0 25px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    transition: left 0.3s ease-in-out;
    overflow-y: auto;
  }

  .menu-panel.active {
    left: 0;
  }

  .panel-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .panel-header h3 {
    margin: 0;
    font-weight: 600;
    font-size: 18px;
  }

  .close-panel {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    line-height: 1;
  }

  /* Menu List Section */
  .menu-list-section {
    padding: 15px;
  }

  .menu-list-section h4 {
    margin: 0 0 15px 0;
    color: #333;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .menu-list-section h4 i {
    color: #667eea;
  }

  .menu-list {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
  }

  .menu-item {
    display: flex;
    align-items: center;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
    background: #ffffff;
    position: relative;
  }

  /* SELECTED MENU - Highlighted */
  .menu-item.selected {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-color: #667eea;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
  }

  .menu-item:hover {
    transform: translateX(5px);
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  }

  /* Selection Indicator */
  .selection-indicator {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
  }

  .menu-item.selected .selection-indicator {
    background: #28a745;
    color: white;
  }

  .menu-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: white;
    font-size: 16px;
    flex-shrink: 0;
  }

  .menu-info {
    flex: 1;
  }

  .menu-info h5 {
    margin: 0 0 5px 0;
    font-size: 14px;
    color: #333;
    font-weight: 600;
  }

  .menu-info p {
    margin: 0;
    font-size: 12px;
    color: #666;
    line-height: 1.4;
  }

  /* CARD DESIGN */
  .menu-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #e9ecef;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    min-height: 140px;
    display: flex;
    flex-direction: column;
    cursor: pointer;
  }

  .menu-card.dragging {
    opacity: 0.5;
    transform: scale(0.98);
  }

  /* Card Left Border - Dynamic */
  .menu-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 5px;
    height: 100%;
  }

  .menu-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
  }

  /* হাতের আইকন (হোভারে দেখাবে) */
  .menu-card:hover::after {
    content: '\f0a7'; /* FontAwesome hand-pointer icon */
    font-family: 'FontAwesome';
    position: absolute;
    top: 15px;
    right: 15px;
    color: #667eea;
    font-size: 20px;
    opacity: 0.8;
  }

  /* Card Header */
  .card-header {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    flex: 1;
  }

  .card-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: white;
    font-size: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    flex-shrink: 0;
  }

  .card-title {
    flex: 1;
  }

  .card-title h4 {
    margin: 0 0 5px 0;
    font-size: 16px;
    color: #2c3e50;
    font-weight: 600;
  }

  .card-title p {
    margin: 0;
    font-size: 12px;
    color: #6c757d;
    line-height: 1.4;
  }

  /* Card Footer */
  .card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid rgba(0,0,0,0.08);
    margin-top: auto;
  }

  .card-actions {
    display: flex;
    gap: 10px;
  }

  .action-btn {
    padding: 6px 12px;
    border-radius: 6px;
    border: none;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .action-btn.remove {
    background: #fff;
    color: #dc3545;
    border: 1px solid #dc3545;
  }

  .action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }

  .action-btn.remove:hover {
    background: #dc3545;
    color: white;
  }

  /* Order Number Styling */
  .card-order {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 20px;
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(106, 17, 203, 0.2);
    transition: all 0.3s ease;
  }

  .card-order:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(106, 17, 203, 0.3);
  }

  .card-order .order-text {
    font-size: 10px;
    opacity: 0.9;
  }

  .card-order .order-number {
    font-size: 13px;
    font-weight: 700;
    background: white;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 3px;
  }

  /* Empty State for Dashboard */
  .empty-dashboard {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
    grid-column: 1 / -1;
  }

  .empty-dashboard i {
    font-size: 64px;
    color: #dee2e6;
    margin-bottom: 20px;
  }

  .empty-dashboard h4 {
    margin: 0 0 10px 0;
    color: #495057;
  }

  .empty-dashboard p {
    font-size: 15px;
    margin: 0;
  }

  /* Loading State */
  .loading-state {
    text-align: center;
    padding: 40px 20px;
    color: #6c757d;
    grid-column: 1 / -1;
  }

  .loading-state i {
    font-size: 48px;
    color: #667eea;
    margin-bottom: 20px;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  /* Auto Save Indicator */
  .save-indicator {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 1000;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 15px;
    background: #28a745;
    color: white;
    border-radius: 20px;
    font-size: 14px;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
  }
  
  .save-indicator.show {
    opacity: 1;
    transform: translateY(0);
  }
  
  .save-indicator.saving {
    background: #ffc107;
  }
  
  .save-indicator.error {
    background: #dc3545;
  }

  /* Icons Container */
  .icons-container {
    position: fixed;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    z-index: 999;
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  .menu-icon-btn {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    animation: pulse 2s infinite;
    position: relative;
  }

  .menu-icon-btn.software {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  }

  .menu-icon-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
  }

  .icon-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #e74c3c;
    color: white;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
  }

  /* Software List */
  .software-list {
    padding: 15px;
  }

  .software-item {
    display: flex;
    align-items: center;
    padding: 12px;
    border-bottom: 1px solid #eee;
    transition: background 0.3s ease;
    cursor: pointer;
  }

  .software-item:hover {
    background: #f8f9fa;
  }

  .software-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: white;
    font-size: 16px;
  }

  .software-info h4 {
    margin: 0 0 5px 0;
    font-size: 14px;
    color: #333;
    font-weight: 600;
  }

  .software-info p {
    margin: 0;
    font-size: 13px;
    color: #666;
  }

  /* Overlay */
  .panel-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
  }

  .panel-overlay.active {
    opacity: 1;
    visibility: visible;
  }

  /* Responsive */
  @media (max-width: 1200px) {
    .dashboard-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  @media (max-width: 992px) {
    .dashboard-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 768px) {
    .dashboard-container {
      padding: 10px;
    }
    
    .dashboard-grid {
      grid-template-columns: 1fr;
      gap: 15px;
    }
    
    .software-panel,
    .menu-panel {
      width: 320px;
    }
    
    .icons-container {
      right: 15px;
      bottom: 20px;
      top: auto;
      transform: none;
      flex-direction: row;
      gap: 10px;
    }
    
    .menu-icon-btn {
      width: 50px;
      height: 50px;
      font-size: 20px;
    }
    
    .icon-badge {
      width: 20px;
      height: 20px;
      font-size: 10px;
    }
    
    .menu-card {
      padding: 15px;
      min-height: 130px;
    }
    
    .card-icon {
      width: 45px;
      height: 45px;
      font-size: 18px;
    }
    
    .card-title h4 {
      font-size: 15px;
    }
    
    .save-indicator {
      bottom: 20px;
      right: 20px;
      font-size: 12px;
      padding: 6px 12px;
    }
  }

  @keyframes pulse {
    0% { box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); }
    50% { box-shadow: 0 4px 20px rgba(102, 126, 234, 0.8); }
    100% { box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); }
  }

  /* Drag and Drop Styles */
  .drop-zone {
    border: 2px dashed #667eea;
    background: rgba(102, 126, 234, 0.05);
  }

  .sortable-ghost {
    opacity: 0.4;
    background: #f8f9fa;
  }

  .sortable-chosen {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }

  .sortable-drag {
    opacity: 0.8;
    transform: rotate(5deg);
  }
</style>

<div class="dashboard-container">
  <!-- Auto Save Indicator -->
  <div class="save-indicator" id="saveIndicator">
    <i class="fa fa-check-circle"></i>
    <span>Dashboard Updated</span>
  </div>
  
  <!-- Dashboard Grid for Menu Cards -->
  <div class="dashboard-grid" id="dashboardGrid">
    <!-- Loading state initially -->
    <div class="loading-state" id="loadingState">
      <i class="fa fa-spinner"></i>
      <h4>Loading Dashboard...</h4>
      <p>Please wait while we load your menu items</p>
    </div>
  </div>
  
  <!-- Empty Dashboard Message -->
  <div class="empty-dashboard" id="emptyDashboard" style="display: none;">
    <i class="fa fa-clipboard"></i>
    <h4>No Menu Selected</h4>
    <p>Select menus from the menu panel to display cards here</p>
  </div>

  <!-- Menu Icons Container -->
  <div class="icons-container">
    <div class="menu-icon-btn" onclick="toggleMenuPanel()" title="Top 10 Menus">
      <i class="fa fa-star"></i>
      <div class="icon-badge" id="menuBadge">0</div>
    </div>
    
    <div class="menu-icon-btn software" onclick="toggleSoftwarePanel()" title="Software Applications">
      <i class="fa fa-th-large"></i>
      <!-- Fixed: Using ternary operator instead of ?? -->
      <div class="icon-badge">{{ isset($results) && count($results) > 0 ? count($results) : 0 }}</div>
    </div>
  </div>

  <!-- Top 10 Menu Panel (Left Side) -->
  <div class="menu-panel" id="menuPanel">
    <div class="panel-header">
      <h3><i class="fa fa-star"></i> Top 10 Menus</h3>
      <button class="close-panel" onclick="toggleMenuPanel()">
        <i class="fa fa-times"></i>
      </button>
    </div>
    
    <!-- Menu List -->
    <div class="menu-list-section">
      <h4><i class="fa fa-list"></i> Select Your Menus (Max: 10)</h4>
      <div class="menu-list" id="menuList">
        <div class="loading-state" id="menuLoadingState">
          <i class="fa fa-spinner"></i>
          <p>Loading menus...</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Software Panel (Right Side) - Top 10 Help Software List -->
  <div class="software-panel" id="softwarePanel">
    <div class="panel-header">
      <h3><i class="fa fa-th-large"></i> Helping App List</h3>
      <button class="close-panel" onclick="toggleSoftwarePanel()">
        <i class="fa fa-times"></i>
      </button>
    </div>
    <div class="software-list">
      @if(isset($results) && count($results) > 0)
        @foreach($results as $result)
          <div class="software-item" onclick="redirectURL('{{ asset($result->url) }}')">
            <div class="software-icon">
              <!-- Fixed: Using ternary operator instead of ?? -->
              <i class="{{ isset($result->icon) ? $result->icon : 'fa fa-cube' }}"></i>
            </div>
            <div class="software-info">
              <h4>{{ $result->name }}</h4>
              <!-- Fixed: Using ternary operator instead of ?? -->
              <p>{{ isset($result->description) ? $result->description : 'Software Application' }}</p>
            </div>
          </div>
        @endforeach
      @else
        <div class="empty-dashboard">
          <i class="fa fa-th-large"></i>
          <h4>No Software Available</h4>
          <p>Software applications will appear here</p>
        </div>
      @endif
    </div>
  </div>
  <!-- Overlay -->
  <div class="panel-overlay" id="panelOverlay" onclick="closeAllPanels()"></div>
</div>
<script src="{{asset('js/sortable.min.js')}}"></script>
<script>
  // Global variables
  let topMenus = [];
  let selectedMenus = [];
  let menuOrder = [];
  let sortableInstance = null;
  let saveTimeout = null;
  let isSaving = false;

  // Predefined colorful gradients for 10 positions
  const cardColors = [
    // Color 1: Vibrant Purple-Pink
    { 
      primary: '#667eea',
      gradient: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
      border: '#667eea'
    },
    // Color 2: Fresh Green
    { 
      primary: '#11998e',
      gradient: 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)',
      border: '#11998e'
    },
    // Color 3: Sunset Orange
    { 
      primary: '#f46b45',
      gradient: 'linear-gradient(135deg, #f46b45 0%, #eea849 100%)',
      border: '#f46b45'
    },
    // Color 4: Pink Love
    { 
      primary: '#ff9a9e',
      gradient: 'linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%)',
      border: '#ff9a9e'
    },
    // Color 5: Blue Ocean
    { 
      primary: '#4facfe',
      gradient: 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
      border: '#4facfe'
    },
    // Color 6: Purple Magenta
    { 
      primary: '#a463f2',
      gradient: 'linear-gradient(135deg, #a463f2 0%, #ff6ec7 100%)',
      border: '#a463f2'
    },
    // Color 7: Golden Yellow
    { 
      primary: '#f7971e',
      gradient: 'linear-gradient(135deg, #f7971e 0%, #ffd200 100%)',
      border: '#f7971e'
    },
    // Color 8: Deep Blue
    { 
      primary: '#6a11cb',
      gradient: 'linear-gradient(135deg, #6a11cb 0%, #2575fc 100%)',
      border: '#6a11cb'
    },
    // Color 9: Coral Red
    { 
      primary: '#ff5858',
      gradient: 'linear-gradient(135deg, #ff5858 0%, #f09819 100%)',
      border: '#ff5858'
    },
    // Color 10: Teal Cyan
    { 
      primary: '#17ead9',
      gradient: 'linear-gradient(135deg, #17ead9 0%, #6078ea 100%)',
      border: '#17ead9'
    }
  ];

  // Initialize
  document.addEventListener('DOMContentLoaded', function() {
    loadDashboardData();
  });

  // Load Dashboard Data via AJAX - FIXED
  function loadDashboardData() {
    
    showLoadingState();
    $.ajax({
      url: '/api/top-menus',
      type: 'GET',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      success: function(response) {
        
        if(response.success && response.data) {

          topMenus = response.data.map(function(item) {
            return {
              id: item.id,
              name: item.name,
              // Fixed: Using ternary operator instead of ??
              description: (item.description !== undefined && item.description !== null) ? item.description : item.name,
              // Fixed: Using ternary operator instead of ??
              icon: (item.icon !== undefined && item.icon !== null) ? item.icon : 'fa fa-cube',
              // Fixed: Using ternary operator instead of ??
              url: (item.url !== undefined && item.url !== null) ? item.url : '#'
            };
          });          

          loadUserDashboard();

        } else {
          showErrorMessage('Failed to load menus. Please try again.');
        }

      },
      error: function(xhr, status, error) {
        console.error('AJAX error:', error);
        showErrorMessage('Failed to load menus.');
      }
    });
  }

  // Load user's saved dashboard from database - FIXED
  function loadUserDashboard() {

    $.ajax({
      url: '/api/user-dashboard',
      type: 'GET',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      success: function(response) {
 
        if(response.success && response.data) {
          
          const savedMenuIds = response.data.map(function(item) {
            return item.id;
          });            
          selectedMenus = topMenus.filter(function(menu) {
            return savedMenuIds.includes(menu.id);
          });
          menuOrder = response.data.map(function(item) {
            return item.id;
          });

        } else {
          
          selectedMenus = [];  
          menuOrder = []; 
          
        }
        
        renderMenuList();
        renderDashboardCards();
        updateMenuBadge();
        initSortable();
        hideLoadingState();
        
      },
      error: function(xhr, status, error) {
        console.error('Failed to load user dashboard:', error);
        // If error, start fresh
        selectedMenus = [];
        menuOrder = [];
        
        renderMenuList();
        renderDashboardCards();
        updateMenuBadge();
        initSortable();
        hideLoadingState();
      }
    });
  }

  // AUTO SAVE FUNCTION - FIXED
  function autoSaveDashboard() {

    if(isSaving) return;
    // Clear existing timeout
    if(saveTimeout) {
      clearTimeout(saveTimeout);
    }

    // Set new timeout (debounce 1.5 seconds)
    saveTimeout = setTimeout(function() {
      saveDashboard();
    }, 1500);
  }

  // Save dashboard to database - FIXED
  function saveDashboard() {

    if (isSaving) return;
    isSaving = true;
    showSaveIndicator('saving');  
    const selectedMenuIds = selectedMenus.map(function(m) {
      return m.id;
    });
  
    $.ajax({
      url: '/api/save-user-menus',
      type: 'POST',
      data: {
        selectedMenus: selectedMenuIds,
        menuOrder: menuOrder
      },
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      success: function(response) {
        if(response.success) {
          showSaveIndicator('success');
        } else {
          showSaveIndicator('error');
          console.error('Save failed:', response.message);
        }
        isSaving = false;
      },
      error: function(xhr, status, error) {
        console.error('Save error:', error);
        showSaveIndicator('error');
        isSaving = false;
      }
    });
  }

  // Show save indicator
  function showSaveIndicator(type) {
    const indicator = document.getElementById('saveIndicator');
    const icon = indicator.querySelector('i');
    const text = indicator.querySelector('span');
    
    indicator.classList.remove('show', 'saving', 'error');
    
    if (type === 'saving') {
      indicator.classList.add('show', 'saving');
      icon.className = 'fa fa-spinner fa-spin';
      text.textContent = 'Saving...';
    } else if (type === 'success') {
      indicator.classList.add('show');
      icon.className = 'fa fa-check-circle';
      text.textContent = 'Dashboard Updated';
      
      // Hide after 2 seconds
      setTimeout(function() {
        indicator.classList.remove('show');
      }, 2000);
    } else if (type === 'error') {
      indicator.classList.add('show', 'error');
      icon.className = 'fa fa-exclamation-circle';
      text.textContent = 'Save failed';
      
      // Hide after 3 seconds
      setTimeout(function() {
        indicator.classList.remove('show');
      }, 3000);
    }
  }

  // Get color for menu card based on position
  function getCardColor(index) {
    // Use modulo to cycle through colors if more than 10 cards
    return cardColors[index % cardColors.length];
  }

  // Toggle Menu Selection - FIXED
  function toggleMenuSelection(menu) {
    const menuIndex = selectedMenus.findIndex(function(m) {
      return m.id === menu.id;
    });
    
    if (menuIndex === -1) {
      // Maximum 10 menus allowed
      if (selectedMenus.length >= 10) {
        showNotification('Maximum 10 menus allowed!', 'error');
        return;
      }
      
      selectedMenus.push(menu);
      menuOrder.push(menu.id);
      console.log('Added menu:', menu.name);
    } else {
      selectedMenus.splice(menuIndex, 1);
      const orderIndex = menuOrder.indexOf(menu.id);
      if (orderIndex > -1) {
        menuOrder.splice(orderIndex, 1);
      }
      console.log('Removed menu:', menu.name);
    }
    
    renderMenuList();
    renderDashboardCards();
    updateMenuBadge();
    
    // AUTO SAVE
    autoSaveDashboard();
  }

  // Remove Menu from Card button - FIXED
  function removeMenuFromCard(menuId) {
    console.log('Removing menu from card:', menuId);
    
    const index = selectedMenus.findIndex(function(m) {
      return m.id === menuId;
    });
    if (index !== -1) {
      selectedMenus.splice(index, 1);
      const orderIndex = menuOrder.indexOf(menuId);
      if (orderIndex > -1) {
        menuOrder.splice(orderIndex, 1);
      }
      
      renderMenuList();
      renderDashboardCards();
      updateMenuBadge();
      
      // AUTO SAVE
      autoSaveDashboard();
    }
  }

  // Render Menu List - FIXED
  function renderMenuList() {
    const menuList = document.getElementById('menuList');
    const menuLoadingState = document.getElementById('menuLoadingState');
    
    if (!menuList) return;
    
    if (menuLoadingState) {
      menuLoadingState.style.display = 'none';
    }
    
    if (!topMenus || topMenus.length === 0) {
      menuList.innerHTML = '<div class="empty-dashboard"><p>No menus available</p></div>';
      return;
    }
    
    menuList.innerHTML = '';
    topMenus.forEach(function(menu) {
      
      const isSelected = selectedMenus.some(function(m) {
        return m.id === menu.id;
      });
      // Use first color for menu list items
      const gradient = cardColors[0].gradient;
      const menuItem = document.createElement('div');
      menuItem.className = 'menu-item ' + (isSelected ? 'selected' : '');
      menuItem.innerHTML = `
        <div class="menu-icon" style="background: ${gradient};">
          <i class="${menu.icon}"></i>
        </div>
        <div class="menu-info">
          <h5>${menu.name}</h5>
          <p>${menu.description}</p>
        </div>
        <div class="selection-indicator">
          ${isSelected ? '<i class="fa fa-check"></i>' : ''}
        </div>
      `;
      
      menuItem.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleMenuSelection(menu);
      });
      menuList.appendChild(menuItem);

    });
  }

  // Render Dashboard Cards with Dynamic Styling - FIXED
  function renderDashboardCards() {

    const dashboardGrid = document.getElementById('dashboardGrid');
    const emptyDashboard = document.getElementById('emptyDashboard');
    if (!dashboardGrid || !emptyDashboard) return;
    dashboardGrid.innerHTML = '';
    if (selectedMenus.length === 0) {
      emptyDashboard.style.display = 'block';
      return;
    }
    emptyDashboard.style.display = 'none';
    const sortedMenus = menuOrder
      .map(function(id) {
        return selectedMenus.find(function(menu) {
          return menu.id === id;
        });
      })
      .filter(function(menu) {
        return menu !== undefined;
      });
    
    console.log('Sorted menus for rendering:', sortedMenus.map(function(m) {
      return m.name;
    }));
    
    sortedMenus.forEach(function(menu, index) {
      const colorSet = getCardColor(index);
      const gradient = colorSet.gradient;
      const borderColor = colorSet.border;
      const primaryColor = colorSet.primary;
      
      const card = document.createElement('div');
      card.className = 'menu-card';
      card.setAttribute('data-menu-id', menu.id);
      card.setAttribute('data-menu-url', menu.url);      
      // Apply dynamic styles
      card.style.borderLeftColor = borderColor;
      card.addEventListener('click', function(e) {
        if (!e.target.closest('.action-btn.remove')) {
          openMenu(menu.id);
        }
      });

      card.innerHTML = `
        <div class="card-header">
          <div class="card-icon" style="background: ${gradient};">
            <i class="${menu.icon}"></i>
          </div>
          <div class="card-title">
            <h4>${menu.name}</h4>
            <p>${menu.description}</p>
          </div>
        </div>
        <div class="card-footer">
          <div class="card-actions">
            <button class="action-btn remove" onclick="event.stopPropagation(); removeMenuFromCard(${menu.id})">
              <i class="fa fa-times"></i> Remove
            </button>
          </div>
          <div class="card-order" style="background: ${gradient};">
            <span class="order-text">Order:</span>
            <span class="order-number" style="color: ${primaryColor};">${index + 1}</span>
          </div>
        </div>
      `;
      
      // Apply dynamic left border using inline style
      const leftBorder = document.createElement('div');
      leftBorder.style.position = 'absolute';
      leftBorder.style.left = '0';
      leftBorder.style.top = '0';
      leftBorder.style.width = '5px';
      leftBorder.style.height = '100%';
      leftBorder.style.background = borderColor;
      leftBorder.style.zIndex = '1';
      card.appendChild(leftBorder);
      
      dashboardGrid.appendChild(card);
    });
    initSortable();

  }

  // Open Menu
  function openMenu(menuId) {

    const menu = topMenus.find(function(m) {
      return m.id === menuId;
    });
    if (menu && menu.url && menu.url !== '#') {
      console.log('Redirecting to:', menu.url);
      window.location.href = menu.url;
    } else {
      console.log('Menu not found or no URL defined for menu ID:', menuId);
    }

  }

  // Update Badge
  function updateMenuBadge() {

    const badge = document.getElementById('menuBadge');
    if (badge) {
      badge.textContent = selectedMenus.length;
    }

  }

  // Initialize Sortable drag and drop
  function initSortable() {

    const dashboardGrid = document.getElementById('dashboardGrid');
    if (!dashboardGrid) return;
    
    if (sortableInstance) {
      sortableInstance.destroy();
    }
    
    if (selectedMenus.length > 0) {
      sortableInstance = Sortable.create(dashboardGrid, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag',
        onEnd: function(evt) {
          const newOrder = [];
          const cards = dashboardGrid.querySelectorAll('.menu-card');
          
          cards.forEach(function(card) {
            const menuId = parseInt(card.getAttribute('data-menu-id'));
            newOrder.push(menuId);
          });
          
          menuOrder = newOrder;
          updateCardOrderNumbers();
          
          // AUTO SAVE
          autoSaveDashboard();
        }
      });
    }
  }

  // Update card order numbers
  function updateCardOrderNumbers() {
    const cards = document.querySelectorAll('.menu-card');
    cards.forEach(function(card, index) {
      const orderElement = card.querySelector('.card-order .order-number');
      if (orderElement) {
        orderElement.textContent = index + 1;
      }
    });
  }

  // Panel Functions
  function toggleMenuPanel() {
  
    const panel = document.getElementById('menuPanel');
    const overlay = document.getElementById('panelOverlay');  
    if (!panel || !overlay) return;
    panel.classList.toggle('active');
    overlay.classList.toggle('active');
    document.body.style.overflow = panel.classList.contains('active') ? 'hidden' : '';

  }

  function toggleSoftwarePanel() {

    const panel = document.getElementById('softwarePanel');
    const overlay = document.getElementById('panelOverlay');
    if (!panel || !overlay) return;
    panel.classList.toggle('active');
    overlay.classList.toggle('active');
    document.body.style.overflow = panel.classList.contains('active') ? 'hidden' : '';

  }

  function closeAllPanels() {
    document.querySelectorAll('.software-panel, .menu-panel').forEach(function(panel) {
      panel.classList.remove('active');
    });
    
    const overlay = document.getElementById('panelOverlay');
    if (overlay) {
      overlay.classList.remove('active');
    }
    
    document.body.style.overflow = '';
  }

  function redirectURL(url) {
    if (url) {
      window.open(url, '_blank');
    }
    return false;
  }

  // Show notification
  function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'save-indicator ' + (type === 'error' ? 'error' : '');
    notification.innerHTML = `
      <i class="fa ${type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
      <span>${message}</span>
    `;
    
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    
    document.body.appendChild(notification);
    notification.classList.add('show');
    
    // Remove after 3 seconds
    setTimeout(function() {
      notification.classList.remove('show');
      setTimeout(function() {
        if (document.body.contains(notification)) {
          document.body.removeChild(notification);
        }
      }, 300);
    }, 3000);
  }

  // Show loading state
  function showLoadingState() {
    const loadingState = document.getElementById('loadingState');
    const emptyDashboard = document.getElementById('emptyDashboard');
    
    if (loadingState) loadingState.style.display = 'block';
    if (emptyDashboard) emptyDashboard.style.display = 'none';
  }

  // Hide loading state
  function hideLoadingState() {
    const loadingState = document.getElementById('loadingState');
    if (loadingState) loadingState.style.display = 'none';
  }

  // Show error message
  function showErrorMessage(message) {
    console.error('Error:', message);
    showNotification(message, 'error');
  }

  // Close panels with Escape key
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
      closeAllPanels();
    }
  });

</script>
@endsection