@extends('layouts.master')
@section('content')
<style type="text/css">
  /* ============================================
     EXISTING DASHBOARD STYLES (KEPT INTACT)
     ============================================ */
  .dashboard-container {
    position: relative;
    min-height: 80vh;
    padding: 20px;
  }

  .dashboard-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
    padding: 20px 0;
    min-height: 212px;
    margin-top: -22px;
  }

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
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .panel-header h3 {
    margin: 0;
    font-weight: 600;
    font-size: 18px;
  }

  .panel-header h3 .total-count {
    font-size: 13px;
    font-weight: normal;
    opacity: 0.8;
    margin-left: 5px;
  }

  .close-panel {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    line-height: 1;
  }

  .software-search {
    padding: 12px 15px;
    border-bottom: 1px solid #e9ecef;
    background: white;
    position: sticky;
    top: 55px;
    z-index: 9;
  }

  .search-wrapper {
    display: flex;
    align-items: center;
    background: #d9e2ee;
    padding: 1px 15px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    font-weight: normal;
  }

  .search-wrapper:focus-within {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }

  .search-wrapper i {
    color: #999;
    margin-right: 3px;
    margin-left: 10px;
  }

  .search-wrapper input {
    border: none;
    background: none;
    flex: 1;
    padding: 5px 0;
    font-size: 14px;
    outline: none;
  }

  .clear-search {
    background: none;
    border: none;
    color: #999;
    cursor: pointer;
    padding: 0 5px;
  }

  .clear-search:hover {
    color: #333;
  }

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

  .menu-item.selected {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-color: #667eea;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
  }

  .menu-item:hover {
    transform: translateX(5px);
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  }

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

  .menu-card:hover::after {
    content: '\f0a7';
    font-family: 'FontAwesome';
    position: absolute;
    top: 15px;
    right: 15px;
    color: #667eea;
    font-size: 20px;
    opacity: 0.8;
  }

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

  /* ============================================
     RIGHT SIDE ICONS - UPDATED POSITION
     ============================================ */
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

  /* ============================================
     AI CHATBOT - COMPLETE CHAT SYSTEM
     ============================================ */

  /* Container */
  .ai-chatbot-container {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px;
  }

  /* Main Button */
  .ai-chatbot-btn {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    font-size: 28px;
    cursor: pointer;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.45);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    animation: aiFloat 3s ease-in-out infinite;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .ai-chatbot-btn::before {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    opacity: 0.3;
    filter: blur(15px);
    z-index: -1;
    animation: aiGlowPulse 2.5s ease-in-out infinite;
  }

  @keyframes aiGlowPulse {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(1.15); }
  }

  .ai-chatbot-btn:hover {
    transform: scale(1.10) rotate(-6deg);
    box-shadow: 0 12px 48px rgba(102, 126, 234, 0.6);
  }

  @keyframes aiFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
  }

  /* Ripple Effect */
  .ai-chatbot-btn .ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    transform: scale(0);
    animation: aiRipple 2.5s infinite;
    pointer-events: none;
  }
  .ai-chatbot-btn .ripple:nth-child(1) { width: 100%; height: 100%; animation-delay: 0s; }
  .ai-chatbot-btn .ripple:nth-child(2) { width: 150%; height: 150%; animation-delay: 0.8s; }
  .ai-chatbot-btn .ripple:nth-child(3) { width: 200%; height: 200%; animation-delay: 1.6s; }

  @keyframes aiRipple {
    0% { transform: scale(0); opacity: 1; }
    100% { transform: scale(1.3); opacity: 0; }
  }

  /* Status Dot */
  .ai-chatbot-btn .ai-status-dot {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 14px;
    height: 14px;
    background: #2ecc71;
    border-radius: 50%;
    border: 2px solid white;
    animation: aiStatusBlink 1.5s ease-in-out infinite;
    box-shadow: 0 0 12px rgba(46, 204, 113, 0.5);
  }

  @keyframes aiStatusBlink {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.3; transform: scale(0.8); }
  }

  /* Tooltip */
  .ai-chatbot-btn .tooltip {
    position: absolute;
    right: 78px;
    background: rgba(26, 35, 50, 0.92);
    backdrop-filter: blur(12px);
    color: white;
    padding: 8px 18px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    pointer-events: none;
    box-shadow: 0 8px 30px rgba(0,0,0,0.25);
    border: 1px solid rgba(255,255,255,0.08);
    opacity: 1;
    transform: translateX(0);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .ai-chatbot-btn .tooltip .tooltip-emoji { font-size: 16px; }
  .ai-chatbot-btn .tooltip .tooltip-badge {
    background: rgba(255,255,255,0.15);
    padding: 2px 10px;
    border-radius: 50px;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    color: #a29bfe;
  }

  .ai-chatbot-btn .tooltip::after {
    content: '';
    position: absolute;
    right: -8px;
    top: 50%;
    transform: translateY(-50%);
    border-left: 8px solid rgba(26, 35, 50, 0.92);
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
  }

  .ai-chatbot-btn:hover .tooltip {
    transform: translateX(-4px) scale(1.02);
  }

  /* ============================================
     AI CHATBOT POPUP - CHAT INTERFACE
     ============================================ */

  .ai-chatbot-popup {
    position: fixed;
    bottom: 114px;
    right: 30px;
    width: 370px;
    max-height: 500px;
    background: #ffffff;
    border-radius: 24px;
    box-shadow: 0 30px 70px rgba(0, 0, 0, 0.18);
    z-index: 9998;
    opacity: 0;
    visibility: hidden;
    transform: translateY(20px) scale(0.96);
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    border: 1px solid rgba(255, 255, 255, 0.25);
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }

  .ai-chatbot-popup.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
  }

  /* Popup Header */
  .ai-chatbot-popup .popup-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
  }

  .ai-chatbot-popup .popup-header h4 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .ai-chatbot-popup .popup-header h4 i {
    background: rgba(255, 255, 255, 0.15);
    padding: 5px;
    border-radius: 8px;
    font-size: 15px;
  }

  .ai-chatbot-popup .popup-header .ai-badge {
    font-size: 8px;
    background: rgba(255, 255, 255, 0.2);
    padding: 2px 10px;
    border-radius: 30px;
    text-transform: uppercase;
    font-weight: 400;
    letter-spacing: 0.3px;
  }

  .ai-chatbot-popup .popup-header .close-popup {
    background: rgba(255, 255, 255, 0.15);
    border: none;
    color: #fff;
    font-size: 16px;
    border-radius: 8px;
    padding: 3px 10px;
    transition: 0.2s;
    cursor: pointer;
  }

  .ai-chatbot-popup .popup-header .close-popup:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
  }

  /* ===== CHAT MESSAGES AREA ===== */
  .ai-chat-messages {
    flex: 1;
    padding: 12px 14px;
    overflow-y: auto;
    background: #f8f9fc;
    min-height: 220px;
    max-height: 300px;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .ai-chat-messages::-webkit-scrollbar {
    width: 4px;
  }
  .ai-chat-messages::-webkit-scrollbar-track {
    background: #eef0f5;
    border-radius: 10px;
  }
  .ai-chat-messages::-webkit-scrollbar-thumb {
    background: #c5cbd4;
    border-radius: 10px;
  }

  /* Individual message */
  .ai-message {
    max-width: 85%;
    padding: 8px 12px;
    border-radius: 14px;
    font-size: 12.5px;
    line-height: 1.5;
    word-wrap: break-word;
    animation: aiMsgFadeIn 0.3s ease;
  }

  @keyframes aiMsgFadeIn {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .ai-message.user {
    align-self: flex-end;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    border-bottom-right-radius: 3px;
    box-shadow: 0 2px 8px rgba(102,126,234,0.15);
  }

  .ai-message.assistant {
    align-self: flex-start;
    background: #ffffff;
    color: #1a2332;
    border: 1px solid #e6ecf3;
    border-bottom-left-radius: 3px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
  }

  .ai-message .ai-msg-time {
    font-size: 8px;
    opacity: 0.4;
    margin-top: 3px;
    display: block;
  }

  .ai-message.user .ai-msg-time { color: rgba(255,255,255,0.6); }
  .ai-message.assistant .ai-msg-time { color: #8899aa; }

  /* Typing indicator */
  .ai-typing-indicator {
    align-self: flex-start;
    background: #ffffff;
    padding: 10px 16px;
    border-radius: 14px;
    border-bottom-left-radius: 3px;
    border: 1px solid #e6ecf3;
    display: none;
    gap: 4px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    margin: 0 14px 4px 14px;
  }
  .ai-typing-indicator.active { display: flex; }

  .ai-typing-indicator span {
    width: 7px;
    height: 7px;
    background: #667eea;
    border-radius: 50%;
    animation: aiTypingBounce 1.2s ease-in-out infinite;
  }
  .ai-typing-indicator span:nth-child(2) { animation-delay: 0.15s; }
  .ai-typing-indicator span:nth-child(3) { animation-delay: 0.3s; }

  @keyframes aiTypingBounce {
    0%, 60%, 100% { transform: translateY(0); opacity: 0.3; }
    30% { transform: translateY(-5px); opacity: 1; }
  }

  /* ===== INPUT AREA ===== */
  .ai-popup-input-area {
    padding: 10px 14px 12px 14px;
    border-top: 1px solid #edf2f8;
    background: #ffffff;
    flex-shrink: 0;
  }

  .ai-input-group-custom {
    display: flex;
    gap: 6px;
    background: #f4f6fb;
    border-radius: 14px;
    padding: 3px;
    border: 1px solid #e6ecf3;
    transition: 0.2s;
  }

  .ai-input-group-custom:focus-within {
    border-color: #667eea;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(102,126,234,0.08);
  }

  .ai-input-group-custom input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 7px 10px;
    font-size: 12.5px;
    font-family: 'Inter', sans-serif;
    outline: none;
    color: #1a2332;
  }

  .ai-input-group-custom input::placeholder {
    color: #9aabb8;
    font-size: 12px;
  }

  .ai-input-group-custom .ai-send-btn {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    color: #fff;
    font-size: 14px;
    cursor: pointer;
    transition: 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .ai-input-group-custom .ai-send-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 14px rgba(102,126,234,0.3);
  }

  .ai-input-group-custom .ai-send-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    transform: none;
  }

  .ai-input-meta {
    display: flex;
    justify-content: space-between;
    margin-top: 5px;
  }

  .ai-input-meta span {
    font-size: 8px;
    color: #9aabb8;
  }

  .ai-model-selector {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 8px;
    color: #667eea;
    font-weight: 600;
  }

  .ai-model-selector select {
    border: 1px solid #e6ecf3;
    border-radius: 6px;
    padding: 1px 4px;
    font-size: 8px;
    font-weight: 500;
    background: #fff;
    color: #1a2332;
    outline: none;
    font-family: 'Inter', sans-serif;
    height: 18px;
  }

  .ai-model-selector i { font-size: 9px; }

  .ai-chatbot-popup .popup-footer {
    padding: 5px 14px;
    border-top: 1px solid #edf2f8;
    background: #fafcff;
    display: flex;
    justify-content: space-between;
    flex-shrink: 0;
    font-size: 9px;
    color: #8899aa;
  }
  .ai-chatbot-popup .popup-footer i { color: #667eea; }

  /* ============================================
     AI NOTIFICATION TOAST
     ============================================ */

  .ai-notification-toast {
    position: fixed;
    top: 24px;
    left: 50%;
    transform: translateX(-50%) translateY(-30px);
    padding: 12px 20px;
    background: rgba(40, 167, 69, 0.95);
    backdrop-filter: blur(10px);
    color: #fff;
    border-radius: 14px;
    box-shadow: 0 16px 48px rgba(0,0,0,0.15);
    z-index: 10001;
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    font-size: 13px;
    font-family: 'Inter', sans-serif;
    max-width: 480px;
    width: auto;
    min-width: 240px;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
  }

  .ai-notification-toast.show {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }

  .ai-notification-toast .toast-icon {
    font-size: 18px;
    flex-shrink: 0;
  }
  .ai-notification-toast .toast-content {
    flex: 1;
    text-align: left;
  }
  .ai-notification-toast .toast-title {
    font-size: 10px;
    font-weight: 600;
    opacity: 0.7;
    text-transform: uppercase;
    letter-spacing: 0.4px;
  }
  .ai-notification-toast .toast-message {
    font-size: 13px;
    font-weight: 500;
    line-height: 1.3;
  }
  .ai-notification-toast .toast-close {
    background: rgba(255,255,255,0.1);
    border: none;
    color: #fff;
    border-radius: 8px;
    padding: 2px 8px;
    font-size: 14px;
    cursor: pointer;
    transition: 0.2s;
  }
  .ai-notification-toast .toast-close:hover { background: rgba(255,255,255,0.2); }

  .ai-notification-toast.info { background: rgba(23, 162, 184, 0.95); }
  .ai-notification-toast.success { background: rgba(40, 167, 69, 0.95); }
  .ai-notification-toast.error { background: rgba(220, 53, 69, 0.95); }

  .software-list-container {
    padding: 8px 12px 15px 12px;
  }

  .accordion-item {
    margin-bottom: 8px;
    border-radius: 8px;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    border: 1px solid #eef2f7;
  }

  .accordion-item:hover {
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.10);
  }

  .accordion-header {
    display: flex;
    align-items: center;
    padding: 4px 14px;
    cursor: grab;
    transition: all 0.3s ease;
    background: #f8fafc;
    user-select: none;
    border-left: 4px solid #4A90D9;
  }

  .accordion-header:active {
    cursor: grabbing;
  }

  .accordion-header:hover {
    background: #f0f4ff;
  }

  .category-icon {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    color: white;
    font-size: 13px;
    flex-shrink: 0;
    background: #4A90D9;
  }

  .category-info {
    flex: 1;
  }

  .category-info h4 {
    margin: 0;
    font-size: 13px;
    font-weight: 600;
    color: #1a2332;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
  }

  .category-info h4 .item-count {
    font-size: 10px;
    font-weight: 400;
    color: #6b7a8f;
    background: #eef2f7;
    padding: 1px 8px;
    border-radius: 10px;
  }

  .accordion-arrow {
    font-size: 12px;
    color: #8a9aa8;
    transition: all 0.3s ease;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #eef2f7;
    flex-shrink: 0;
  }

  .accordion-arrow.open {
    transform: rotate(180deg);
    background: #4A90D9;
    color: white;
  }

  .drag-handle {
    opacity: 0.2;
    transition: all 0.3s ease;
    margin-left: 8px;
    color: #999;
    font-size: 14px;
    flex-shrink: 0;
  }

  .accordion-header:hover .drag-handle {
    opacity: 0.8;
    color: #667eea;
  }

  .accordion-body {
    padding: 4px 10px 10px 10px;
    display: none;
    background: #ffffff;
  }

  .accordion-body.open {
    display: block;
    animation: slideDown 0.30s ease;
  }

  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-8px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .software-item {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    border-radius: 6px;
    margin-top: 6px;
    cursor: pointer;
    transition: all 0.25s ease;
    border: 1px solid transparent;
    background: #fafbfc;
    position: relative;
  }

  .software-item:first-child {
    margin-top: 0;
  }

  .software-item:hover {
    background: linear-gradient(135deg, #f0f7ff 0%, #e8f0fe 100%);
    border-color: #4A90D9;
    transform: translateX(3px);
    box-shadow: 0 2px 8px rgba(74, 144, 217, 0.10);
  }

  .software-icon-wrapper {
    width: 30px;
    height: 30px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    flex-shrink: 0;
    background: #eef3ff;
    border: 1px solid #dbe4ef;
    transition: all 0.3s ease;
  }

  .software-item:hover .software-icon-wrapper {
    border-color: #4A90D9;
    background: #dce6ff;
  }

  .software-icon-wrapper i {
    font-size: 14px;
    color: #4A90D9;
    transition: all 0.3s ease;
  }

  .software-item:hover .software-icon-wrapper i {
    transform: scale(1.10);
    color: #2c6abf;
  }

  .software-info {
    flex: 1;
    min-width: 0;
    line-height: 1.3;
  }

  .software-info .project-title {
    font-size: 11px;
    font-weight: 700;
    color: #1a2332;
    background: linear-gradient(135deg, #1a2332 0%, #2c3e50 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: 0.3px;
  }

  .software-info .staff-name {
    font-size: 10px;
    font-weight: 600;
    color: #6c5ce7;
    background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .software-info .separator {
    color: #dce3ea;
    margin: 0 4px;
    font-weight: 300;
    -webkit-text-fill-color: #dce3ea;
  }

  .software-info .remarks {
    display: inline-block;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 2px 10px;
    border-radius: 12px;
    background: linear-gradient(135deg, #00b894 0%, #00cec9 100%);
    color: #ffffff;
    box-shadow: 0 2px 6px rgba(0, 206, 201, 0.25);
    transition: all 0.3s ease;
    margin-top: 2px;
  }

  .software-item:hover .remarks {
    transform: scale(1.03);
    box-shadow: 0 3px 10px rgba(0, 206, 201, 0.35);
  }

  .software-info .staff-info {
    display: block;
    font-size: 10px;
    color: #6b7a8f;
    margin-top: 2px;
    font-weight: 500;
  }

  .software-info .staff-info i {
    color: #4A90D9;
    margin-right: 3px;
    font-size: 10px;
  }

  .software-action {
    color: #8a9aa8;
    font-size: 12px;
    margin-left: 8px;
    opacity: 0.3;
    transition: all 0.3s ease;
    width: 26px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #eef2f7;
    flex-shrink: 0;
    cursor: grab;
  }

  .software-item:hover .software-action {
    opacity: 1;
  }

  .software-action:hover {
    background: #4A90D9;
    color: white;
    transform: scale(1.08);
    cursor: grabbing;
  }

  .software-info .project-title,
  .software-info .staff-name,
  .software-info .remarks,
  .software-info .staff-info {
    text-transform: uppercase;
  }

  .software-info .separator {
    text-transform: none;
  }

  .software-item:nth-child(even) {
    background: #f7f9fc;
  }

  .software-item:nth-child(even):hover {
    background: linear-gradient(135deg, #eef6ff 0%, #e3edff 100%);
  }

  .software-item.sortable-ghost {
    opacity: 0.4;
    background: #f0f7ff !important;
    border: 2px dashed #4A90D9 !important;
  }

  .software-item.sortable-chosen {
    box-shadow: 0 5px 20px rgba(74, 144, 217, 0.25) !important;
    transform: scale(1.02);
  }

  .software-item.sortable-drag {
    opacity: 0.8;
    transform: rotate(2deg) scale(1.05);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important;
  }

  .accordion-item.sortable-ghost {
    opacity: 0.4;
    background: #f0f7ff !important;
    border: 2px dashed #4A90D9 !important;
    border-radius: 8px;
  }

  .accordion-item.sortable-chosen {
    box-shadow: 0 5px 20px rgba(74, 144, 217, 0.25) !important;
    transform: scale(1.02);
  }

  .accordion-item.sortable-drag {
    opacity: 0.8;
    transform: rotate(2deg) scale(1.05);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important;
  }

  #noResultMessage {
    animation: fadeIn 0.3s ease;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

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

  .empty-state {
    text-align: center;
    padding: 50px 20px;
    color: #6c757d;
  }

  .empty-state i {
    font-size: 48px;
    color: #dee2e6;
    margin-bottom: 15px;
  }

  .empty-state h4 {
    margin: 0 0 8px 0;
    color: #495057;
    font-size: 18px;
  }

  .empty-state p {
    margin: 0;
    font-size: 14px;
    color: #6c757d;
  }

  /* ============================================
     RESPONSIVE UPDATES
     ============================================ */

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
      width: 100%;
      right: -100%;
    }

    .software-panel.active {
      right: 0;
    }
    
    .icons-container {
      right: 15px;
      bottom: 100px;
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

    .ai-chatbot-container {
      bottom: 20px;
      right: 20px;
    }

    .ai-chatbot-btn {
      width: 56px;
      height: 56px;
      font-size: 24px;
    }

    .ai-chatbot-btn .tooltip {
      right: 68px;
      padding: 6px 14px;
      font-size: 11px;
    }
    .ai-chatbot-btn .tooltip .tooltip-badge { display: none; }
    
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

    .software-list-container {
      padding: 6px 10px 12px 10px;
    }
    
    .accordion-header {
      padding: 8px 12px;
    }
    
    .category-icon {
      width: 28px;
      height: 28px;
      font-size: 12px;
      margin-right: 8px;
    }
    
    .category-info h4 {
      font-size: 12px;
    }
    
    .accordion-body {
      padding: 3px 8px 8px 8px;
    }
    
    .software-item {
      padding: 6px 10px;
    }
    
    .software-icon-wrapper {
      width: 26px;
      height: 26px;
      margin-right: 8px;
    }
    
    .software-icon-wrapper i {
      font-size: 12px;
    }
    
    .software-info .project-title {
      font-size: 12px;
    }
    
    .software-info .staff-name {
      font-size: 11px;
    }
    
    .software-info .remarks {
      font-size: 9px;
      padding: 1px 8px;
    }
    
    .software-info .staff-info {
      font-size: 9px;
    }
    
    .software-action {
      width: 22px;
      height: 22px;
      font-size: 10px;
    }

    .ai-chatbot-popup {
      width: calc(100% - 32px);
      right: 16px;
      bottom: 90px;
      max-height: 420px;
      border-radius: 20px;
    }
    .ai-chatbot-popup .popup-header { padding: 10px 14px; }
    .ai-chatbot-popup .popup-header h4 { font-size: 13px; }
    .ai-chat-messages {
      min-height: 160px;
      max-height: 220px;
      padding: 10px 12px;
    }
    .ai-message { font-size: 12px; padding: 6px 10px; }
    .ai-popup-input-area { padding: 8px 12px 10px 12px; }
    .ai-input-group-custom input { font-size: 12px; padding: 5px 8px; }
    .ai-input-group-custom .ai-send-btn { width: 30px; height: 30px; font-size: 12px; }

    .ai-notification-toast {
      max-width: calc(100% - 32px);
      min-width: unset;
      width: calc(100% - 32px);
      top: 16px;
      padding: 10px 14px;
      font-size: 13px;
      border-radius: 12px;
      flex-wrap: wrap;
      gap: 8px;
    }
    .ai-notification-toast .toast-message { font-size: 13px; }
  }

  @media (max-width: 480px) {
    .panel-header h3 {
      font-size: 15px;
    }

    .panel-header h3 .total-count {
      font-size: 11px;
    }

    .software-search {
      padding: 10px 12px;
    }

    .search-wrapper {
      padding: 6px 12px;
    }

    .search-wrapper input {
      font-size: 13px;
    }

    .accordion-header {
      padding: 6px 10px;
    }
    
    .category-icon {
      width: 24px;
      height: 24px;
      font-size: 10px;
      margin-right: 6px;
    }
    
    .category-info h4 {
      font-size: 11px;
    }
    
    .category-info h4 .item-count {
      font-size: 9px;
      padding: 1px 6px;
    }
    
    .accordion-arrow {
      width: 20px;
      height: 20px;
      font-size: 10px;
    }
    
    .accordion-body {
      padding: 2px 6px 6px 6px;
    }
    
    .software-item {
      padding: 5px 8px;
      margin-top: 4px;
    }
    
    .software-icon-wrapper {
      width: 22px;
      height: 22px;
      margin-right: 6px;
    }
    
    .software-icon-wrapper i {
      font-size: 10px;
    }
    
    .software-info .project-title {
      font-size: 11px;
    }
    
    .software-info .staff-name {
      font-size: 10px;
    }
    
    .software-info .remarks {
      font-size: 8px;
      padding: 1px 6px;
    }
    
    .software-info .staff-info {
      font-size: 8px;
    }
    
    .software-action {
      width: 20px;
      height: 20px;
      font-size: 9px;
    }

    .ai-chatbot-container {
      bottom: 15px;
      right: 15px;
    }

    .ai-chatbot-btn {
      width: 54px;
      height: 54px;
      font-size: 22px;
    }

    .ai-chatbot-btn .tooltip {
      right: 65px;
      padding: 4px 12px;
      font-size: 10px;
    }
    .ai-chatbot-btn .tooltip .tooltip-emoji { font-size: 14px; }

    .ai-chatbot-popup {
      max-height: 380px;
      bottom: 80px;
      border-radius: 16px;
    }
    .ai-chat-messages {
      min-height: 120px;
      max-height: 180px;
      padding: 8px 10px;
    }
    .ai-message { font-size: 11px; padding: 5px 8px; max-width: 92%; }
    .ai-message .ai-msg-time { font-size: 7px; }
    .ai-popup-input-area { padding: 6px 10px 8px 10px; }
    .ai-input-group-custom input { font-size: 11px; padding: 4px 8px; }
    .ai-input-group-custom .ai-send-btn { width: 28px; height: 28px; font-size: 11px; }
    .ai-model-selector select { font-size: 7px; height: 16px; padding: 0 3px; }
    .ai-notification-toast { padding: 8px 12px; font-size: 12px; }
    .ai-notification-toast .toast-message { font-size: 12px; }
  }

  @keyframes pulse {
    0% { box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); }
    50% { box-shadow: 0 4px 25px rgba(102, 126, 234, 0.8); }
    100% { box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); }
  }

  .drop-zone {
    border: 2px dashed #667eea;
    background: rgba(102, 126, 234, 0.05);
  }

  .software-panel::-webkit-scrollbar {
    width: 6px;
  }

  .software-panel::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }

  .software-panel::-webkit-scrollbar-thumb {
    background: #c1c7cd;
    border-radius: 10px;
  }

  .software-panel::-webkit-scrollbar-thumb:hover {
    background: #a8b0b8;
  }
</style>

<div class="dashboard-container">
  <!-- Auto Save Indicator -->
  <div class="save-indicator" id="saveIndicator">
    <i class="fa fa-check-circle"></i>
    <span>Dashboard Updated</span>
  </div>
  <p>Quick Access</p>
  
  <!-- Dashboard Grid for Menu Cards -->
  <div class="dashboard-grid" id="dashboardGrid">
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

  <!-- Right Side Icons (Menu & Software) -->
  <div class="icons-container">
    <div class="menu-icon-btn" onclick="toggleMenuPanel()" title="Top 10 Menus">
      <i class="fa fa-star"></i>
      <div class="icon-badge" id="menuBadge">0</div>
    </div>
    
    <div class="menu-icon-btn software" onclick="toggleSoftwarePanel()" title="Software Applications">
      <i class="fa fa-th-large"></i>
      <div class="icon-badge" id="softwareBadge">0</div>
    </div>
  </div>

  <!-- AI Chatbot - Bottom Right -->
  {{-- <div class="ai-chatbot-container">
    <button class="ai-chatbot-btn" onclick="toggleAIChatbot()">
      <span class="ripple"></span>
      <span class="ripple"></span>
      <span class="ripple"></span>
      <span class="ai-status-dot"></span>
      <i class="fa fa-robot"></i>
      <span class="tooltip">
        <span class="tooltip-text">🤖Ask AI</span>
        <span class="tooltip-badge">Live</span>
      </span>
    </button>
  </div> --}}

  <!-- AI Chatbot Popup - Full Chat Interface -->
  <div class="ai-chatbot-popup" id="aiChatbotPopup">
    <!-- Header -->
    <div class="popup-header">
      <h4><i class="fa fa-robot"></i> AI Chat <span class="ai-badge">OpenRouter</span></h4>
      <button class="close-popup" onclick="toggleAIChatbot()"><i class="fa fa-times"></i></button>
    </div>

    <!-- Chat Messages Area -->
    <div class="ai-chat-messages" id="aiChatMessages">
      <!-- Welcome message -->
      <div class="ai-message assistant">
        👋 Hello! I'm your AI assistant. Ask me anything!
        <span class="ai-msg-time">Just now</span>
      </div>
    </div>

    <!-- Typing Indicator -->
    <div class="ai-typing-indicator" id="aiTypingIndicator">
      <span></span><span></span><span></span>
    </div>

    <!-- Input Area -->
    <div class="ai-popup-input-area">
      <div class="ai-input-group-custom">
        <input type="text" id="aiChatInput" placeholder="Ask anything..." onkeydown="if(event.key==='Enter') sendAIMessage()">
        <button class="ai-send-btn" id="aiSendBtn" onclick="sendAIMessage()"><i class="fa fa-paper-plane"></i></button>
      </div>
      <div class="ai-input-meta">
        <span><i class="fa fa-key"></i> OpenRouter API</span>
        <div class="ai-model-selector">
          <i class="fa fa-cube"></i>
          <select id="aiModelSelect">
              {{-- <option value="openai/gpt-oss-120b:free">gpt-oss</option>
              <option value="meta-llama/llama-3.3-70b-instruct:free">llama-3.3</option>
              <option value="nvidia/nemotron-3-super-120b-a12b:free">nvidia</option>
              <option value="liquid/lfm-2.5-1.2b-thinking:free">LiquidAI</option>
              <option value="google/gemma-4-31b-it:free">gemma-4</option> --}}
          </select>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="popup-footer">
      <small><i class="fa fa-shield"></i> Encrypted</small>
      <small><i class="fa fa-clock-o"></i> 24/7</small>
    </div>
  </div>

  <!-- AI Notification Toast -->
  <div class="ai-notification-toast" id="aiNotificationToast">
    <div class="toast-icon"><i class="fa fa-check-circle"></i></div>
    <div class="toast-content">
      <div class="toast-title" id="aiToastTitle">Success</div>
      <div class="toast-message" id="aiToastMessage">Message</div>
    </div>
    <button class="toast-close" onclick="closeAIToast()"><i class="fa fa-times"></i></button>
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

  <!-- Software Panel (Right Side) -->
  <div class="software-panel" id="softwarePanel">
    <div class="panel-header">
      <h3>
        <i class="fa fa-th-large"></i> App List
        <span class="total-count" id="totalCount"></span>
      </h3>
      <button class="close-panel" onclick="toggleSoftwarePanel()">
        <i class="fa fa-times"></i>
      </button>
    </div>
    
    <!-- Search Box -->
    <div class="software-search">
      <div class="search-wrapper">
        <i class="fa fa-search"></i>
        <input type="text" id="softwareSearch" placeholder="Search applications..." onkeyup="filterSoftware()">
        <button class="clear-search" id="clearSearchBtn" onclick="clearSoftwareSearch()" style="display:none;">
          <i class="fa fa-times"></i>
        </button>
      </div>
    </div>
    
    <!-- Software List Container -->
    <div class="software-list-container" id="softwareListContainer">
      
      <!-- Loading State -->
      <div class="empty-state" id="softwareLoadingState" style="display: none;">
        <i class="fa fa-spinner fa-spin"></i>
        <h4>Loading Applications...</h4>
        <p>Please wait while we load the application list</p>
      </div>
      
      <!-- Accordion will be rendered here -->
      <div id="accordionContainer"></div>
      
      <!-- Empty State -->
      <div class="empty-state" id="emptyState" style="display: none;">
        <i class="fa fa-folder-open"></i>
        <h4>No Applications Found</h4>
        <p>No software applications are available</p>
      </div>
    </div>
  </div>
  <!-- Overlay -->
  <div class="panel-overlay" id="panelOverlay" onclick="closeAllPanels()"></div>
</div>
<script src="{{asset('js/sortable.min.js')}}"></script>
<script>
  // ============================================
// AI CHATBOT - COMPLETE CHAT SYSTEM WITH OPENROUTER
// ============================================

// 🔑 CONFIG - Add your OpenRouter API Key here
const OPENROUTER_API_KEY = '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'; // CHANGE THIS
const OPENROUTER_URL = 'https://openrouter.ai/api/v1/chat/completions';

// DOM Refs
const aiChatMessages = document.getElementById('aiChatMessages');
const aiTypingIndicator = document.getElementById('aiTypingIndicator');
const aiChatInput = document.getElementById('aiChatInput');
const aiSendBtn = document.getElementById('aiSendBtn');
const aiModelSelect = document.getElementById('aiModelSelect');

// ========== TOGGLE POPUP ==========
function toggleAIChatbot() {
    var popup = document.getElementById('aiChatbotPopup');
    var btn = document.querySelector('.ai-chatbot-btn');
    if (!popup || !btn) return;
    
    popup.classList.toggle('active');
    
    if (popup.classList.contains('active')) {
        btn.classList.add('hidden');
        setTimeout(() => aiChatInput.focus(), 300);
    } else {
        btn.classList.remove('hidden');
    }
}

// ========== ADD MESSAGE TO CHAT ==========
function addAIMessage(role, content) {
    const div = document.createElement('div');
    div.className = `ai-message ${role}`;
    
    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    div.innerHTML = `
        ${content}
        <span class="ai-msg-time">${time}</span>
    `;
    
    aiChatMessages.appendChild(div);
    aiChatMessages.scrollTop = aiChatMessages.scrollHeight;
}

// ========== SHOW/HIDE TYPING ==========
function setAITyping(visible) {
    aiTypingIndicator.classList.toggle('active', visible);
    if (visible) {
        aiChatMessages.scrollTop = aiChatMessages.scrollHeight;
    }
}

// ========== SEND MESSAGE ==========
async function sendAIMessage() {
    const question = aiChatInput.value.trim();
    if (!question) {
        showAIToast('Please enter a question!', 'info', '💡 Tip');
        return;
    }

    aiChatInput.value = '';
    aiSendBtn.disabled = true;

    addAIMessage('user', question);
    setAITyping(true);

    try {
        const model = aiModelSelect.value;
        const response = await callOpenRouterAPI(question, model);
        setAITyping(false);
        addAIMessage('assistant', response);
    } catch (error) {
        setAITyping(false);
        console.error('OpenRouter Error:', error);
        addAIMessage('assistant', '⚠️ Sorry, I encountered an error. Please try again.');
        showAIToast(error.message || 'API Error', 'error', '❌ Error');
    } finally {
        aiSendBtn.disabled = false;
        aiChatInput.focus();
    }
}

// ========== CALL OPENROUTER API ==========
async function callOpenRouterAPI(question, model) {

    if(!OPENROUTER_API_KEY || OPENROUTER_API_KEY === '') {
        
        await new Promise(resolve => setTimeout(resolve, 1200));
        return getDemoResponse(question);
    }

    try {
       
        const response = await fetch(OPENROUTER_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${OPENROUTER_API_KEY}`,
                'HTTP-Referer': window.location.origin,
                'X-Title': 'AI Assistant Chat'
            },
            body: JSON.stringify({
                model: model || 'openai/gpt-4o',
                messages: [
                    { 
                        role: 'system', 
                        content: 'You are a helpful AI assistant. Answer concisely and clearly with a professional tone.' 
                    },
                    { 
                        role: 'user', 
                        content: question 
                    }
                ],
                max_tokens: 500,
                temperature: 0.7
            })
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.error?.message || `HTTP ${response.status}`);
        }

        const data = await response.json();
        return data.choices?.[0]?.message?.content || 'No response received.';
    } catch (error) {
        console.error('❌ API Call Error:', error);
        throw error;
    }
}

// ========== DEMO RESPONSE ==========
function getDemoResponse(question) {
    const responses = [
        `🤖 Here's my response to: "${question}"\n\nThis is a demo response. To get real AI answers, please add your OpenRouter API key in the JavaScript code.`,
        `💡 Interesting question! "${question}"\n\nIn demo mode, I can only show placeholder responses. Add your OpenRouter API key to unlock full AI capabilities.`,
        `🌟 Great question! "${question}"\n\nOpenRouter lets you access multiple AI models through one API. Please add your API key in the code to start using it.`
    ];
    return responses[Math.floor(Math.random() * responses.length)];
}

// ========== TOAST NOTIFICATION ==========
function showAIToast(message, type, title) {
    var toast = document.getElementById('aiNotificationToast');
    var toastTitle = document.getElementById('aiToastTitle');
    var toastMessage = document.getElementById('aiToastMessage');
    var toastIcon = toast.querySelector('.toast-icon i');
    if (!toast || !toastTitle || !toastMessage) return;

    toast.classList.remove('show', 'info', 'success', 'error');
    toastTitle.textContent = title || 'Info';
    toastMessage.textContent = message;

    if (type === 'success') { 
        toast.classList.add('success'); 
        toastIcon.className = 'fa fa-check-circle'; 
    } else if (type === 'error') {
        toast.classList.add('error'); 
        toastIcon.className = 'fa fa-exclamation-circle'; 
    } else {
        toast.classList.add('info'); 
        toastIcon.className = 'fa fa-info-circle'; 
    }

    toast.classList.add('show');
    clearTimeout(toast._timeout);
    toast._timeout = setTimeout(function() { 
        toast.classList.remove('show'); 
    }, 4000);
}

function closeAIToast() {
    var toast = document.getElementById('aiNotificationToast');
    if (toast) { 
        toast.classList.remove('show'); 
        clearTimeout(toast._timeout); 
    }
}

// ========== CLOSE POPUP ON OUTSIDE CLICK ==========
document.addEventListener('click', function(e) {
    var popup = document.getElementById('aiChatbotPopup');
    var btn = document.querySelector('.ai-chatbot-btn');
    if (!popup || !btn) return;
    if (popup.classList.contains('active')) {
        var isInside = popup.contains(e.target) || btn.contains(e.target);
        if (!isInside) {
            popup.classList.remove('active');
            btn.classList.remove('hidden');
        }
    }
});

// ========== KEYBOARD SHORTCUTS ==========
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === '/') {
        e.preventDefault();
        toggleAIChatbot();
    }
    if (e.key === 'Escape') {
        closeAllPanels();
        closeAIToast();
        var popup = document.getElementById('aiChatbotPopup');
        var btn = document.querySelector('.ai-chatbot-btn');
        if (popup && popup.classList.contains('active')) {
            popup.classList.remove('active');
            if (btn) btn.classList.remove('hidden');
        }
    }
});

// ============================================
// MENU DASHBOARD FUNCTIONS
// ============================================

var topMenus = [];
var selectedMenus = [];
var menuOrder = [];
var sortableInstance = null;
var saveTimeout = null;
var isSaving = false;

var softwareCategories = [];
var totalSoftwareCount = 0;
var isSoftwareLoaded = false;
var isSoftwareLoading = false;
var softwareSortables = [];
var accordionSortableInstance = null;
var originalCategories = [];

var cardColors = [
    { 
        primary: '#667eea',
        gradient: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        border: '#667eea'
    },
    { 
        primary: '#11998e',
        gradient: 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)',
        border: '#11998e'
    },
    { 
        primary: '#f46b45',
        gradient: 'linear-gradient(135deg, #f46b45 0%, #eea849 100%)',
        border: '#f46b45'
    },
    { 
        primary: '#ff9a9e',
        gradient: 'linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%)',
        border: '#ff9a9e'
    },
    { 
        primary: '#4facfe',
        gradient: 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
        border: '#4facfe'
    },
    { 
        primary: '#a463f2',
        gradient: 'linear-gradient(135deg, #a463f2 0%, #ff6ec7 100%)',
        border: '#a463f2'
    },
    { 
        primary: '#f7971e',
        gradient: 'linear-gradient(135deg, #f7971e 0%, #ffd200 100%)',
        border: '#f7971e'
    },
    { 
        primary: '#6a11cb',
        gradient: 'linear-gradient(135deg, #6a11cb 0%, #2575fc 100%)',
        border: '#6a11cb'
    },
    { 
        primary: '#ff5858',
        gradient: 'linear-gradient(135deg, #ff5858 0%, #f09819 100%)',
        border: '#ff5858'
    },
    { 
        primary: '#17ead9',
        gradient: 'linear-gradient(135deg, #17ead9 0%, #6078ea 100%)',
        border: '#17ead9'
    }
];

document.addEventListener('DOMContentLoaded', function() {
    loadDashboardData();
    loadSoftwareList();
});

function loadDashboardData() {
    showLoadingState();
    $.ajax({
        url: '/api/top-menus',
        type: 'GET',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.success && response.data) {
                topMenus = response.data.map(function(item) {
                    return {
                        id: item.id,
                        name: item.name,
                        description: (item.description !== undefined && item.description !== null) ? item.description : item.name,
                        icon: (item.icon !== undefined && item.icon !== null) ? item.icon : 'fa fa-cube',
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

function loadUserDashboard() {
    $.ajax({
        url: '/api/user-dashboard',
        type: 'GET',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.success && response.data) {
                var savedMenuIds = response.data.map(function(item) {
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

// ============================================
// SOFTWARE LIST - COMPLETE SOLUTION
// ============================================

function loadSoftwareList() {
    var loadingState = document.getElementById('softwareLoadingState');
    var accordionContainer = document.getElementById('accordionContainer');
    var emptyState = document.getElementById('emptyState');
    
    if (isSoftwareLoading) return;
    
    isSoftwareLoading = true;
    loadingState.style.display = 'block';
    accordionContainer.style.display = 'none';
    emptyState.style.display = 'none';
    
    $.ajax({
        url: '/software/list',
        type: 'POST',
        data: {
            staffId: '334052'
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            isSoftwareLoading = false;
            loadingState.style.display = 'none';
            
            console.log('✅ Software Data Loaded:', response);
            
            if (response.success && response.data) {
                softwareCategories = response.data;
                totalSoftwareCount = response.total || 0;
                isSoftwareLoaded = true;
                
                originalCategories = JSON.parse(JSON.stringify(softwareCategories));
                
                updateSoftwareBadge(totalSoftwareCount);
                updateTotalCount(totalSoftwareCount);
                
                renderSoftwareAccordion(softwareCategories);
            } else {
                emptyState.style.display = 'block';
                showNotification(response.message || 'No applications found', 'error');
            }
        },
        error: function(xhr, status, error) {
            isSoftwareLoading = false;
            loadingState.style.display = 'none';
            emptyState.style.display = 'block';
            console.error('❌ AJAX Error:', error);
            showNotification('Failed to connect to server', 'error');
        }
    });
}

function renderSoftwareAccordion(categories) {
    var container = document.getElementById('accordionContainer');
    var emptyState = document.getElementById('emptyState');
    
    if (!categories || categories.length === 0) {
        container.style.display = 'none';
        emptyState.style.display = 'block';
        return;
    }
    
    container.style.display = 'block';
    emptyState.style.display = 'none';
    
    var categoryColors = [
        '#4A90D9', '#E74C3C', '#2ECC71', '#F39C12', '#9B59B6',
        '#1ABC9C', '#E67E22', '#3498DB', '#E74C3C', '#2ECC71',
        '#F1C40F', '#2980B9', '#C0392B', '#27AE60', '#8E44AD'
    ];
    
    function toUpperCase(str) {
        return (str || 'N/A').toString().toUpperCase();
    }
    
    var itemIdCounter = 0;
    var html = '';
    
    categories.forEach(function(category, index) {
        var itemCount = category.items ? category.items.length : 0;
        var color = categoryColors[index % categoryColors.length];
        var categoryId = 'cat_' + index;
        var categoryName = category.name || 'Uncategorized';
        
        html += `
            <div class="accordion-item" data-category-id="${categoryId}" data-category-index="${index}">
                <div class="accordion-header" onclick="toggleSoftwareAccordion('${categoryId}')" style="border-left: 4px solid ${color};">
                    <div class="category-icon" style="background: ${color};">
                        <i class="fa fa-folder"></i>
                    </div>
                    <div class="category-info">
                        <h4>
                            ${toUpperCase(categoryName)}
                            <span class="item-count">(${itemCount})</span>
                        </h4>
                    </div>
                    <div class="accordion-arrow" id="softwareArrow_${categoryId}">
                        <i class="fa fa-chevron-down"></i>
                    </div>
                    <div class="drag-handle">
                        <i class="fa fa-grip-vertical"></i>
                    </div>
                </div>
                <div class="accordion-body" id="softwareBody_${categoryId}">
        `;
        
        if (category.items && category.items.length > 0) {
            var sortedItems = [...category.items].sort(function(a, b) {
                var titleA = (a.project_title || a.projecT_TITLE || '').toUpperCase();
                var titleB = (b.project_title || b.projecT_TITLE || '').toUpperCase();
                return titleA.localeCompare(titleB);
            });
            
            sortedItems.forEach(function(item) {
                itemIdCounter++;
                var itemId = 'item_' + itemIdCounter;
                
                var projectTitle = (item.project_title || item.projecT_TITLE || 'UNKNOWN PROJECT').toString().toUpperCase();
                var staffName = (item.responsible_staff || item.responsiblE_STAFF || 'N/A').toString().toUpperCase();
                var remarks = (item.remarks || 'NO REMARKS').toString().toUpperCase();
                var url = item.url || '#';
                
                html += `
                    <div class="software-item" data-item-id="${itemId}" data-category-id="${categoryId}" onclick="openSoftwareUrl('${url}')">
                        <div class="software-icon-wrapper">
                            <i class="fa fa-code"></i>
                        </div>
                        <div class="software-info">
                            <div>
                                <span class="project-title">${projectTitle}</span>
                                <span class="separator">|</span>
                                <span class="staff-name">${staffName}</span>
                            </div>
                            <div>
                                <span class="remarks">${remarks}</span>
                            </div>
                        </div>
                        <div class="software-action">
                            <i class="fa fa-grip-vertical"></i>
                        </div>
                    </div>
                `;
            });
        } else {
            html += `
                <div style="padding: 15px; text-align: center; color: #999; font-size: 12px;">
                    <i class="fa fa-inbox"></i> No applications in this category
                </div>
            `;
        }
        
        html += `
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    
    // Initialize sortable
    setTimeout(function() {
        initSoftwareSortable();
        initAccordionSortable();
    }, 100);
}

// ========== TOGGLE SOFTWARE ACCORDION ==========
function toggleSoftwareAccordion(categoryId) {
    var body = document.getElementById('softwareBody_' + categoryId);
    var arrow = document.getElementById('softwareArrow_' + categoryId);
    
    if (!body) return;
    
    // Close all other accordions
    document.querySelectorAll('#accordionContainer .accordion-body').forEach(function(b) {
        var id = b.id.replace('softwareBody_', '');
        if (id !== categoryId) {
            b.classList.remove('open');
            var otherArrow = document.getElementById('softwareArrow_' + id);
            if (otherArrow) {
                otherArrow.classList.remove('open');
            }
        }
    });
    
    // Toggle current accordion
    body.classList.toggle('open');
    if (arrow) {
        arrow.classList.toggle('open');
    }
}

// ========== INIT SOFTWARE SORTABLE ==========
function initSoftwareSortable() {
    // Destroy existing sortables
    if (softwareSortables) {
        softwareSortables.forEach(function(sortable) {
            if (sortable && sortable.destroy) {
                sortable.destroy();
            }
        });
        softwareSortables = [];
    }
    
    var accordionBodies = document.querySelectorAll('#accordionContainer .accordion-body');
    
    accordionBodies.forEach(function(body) {
        var sortable = Sortable.create(body, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            handle: '.software-action',
            onEnd: function(evt) {
                saveSoftwareOrder();
            }
        });
        softwareSortables.push(sortable);
    });
}

// ========== INIT ACCORDION SORTABLE ==========
function initAccordionSortable() {
    var container = document.getElementById('accordionContainer');
    if (!container) return;
    
    if (accordionSortableInstance) {
        accordionSortableInstance.destroy();
        accordionSortableInstance = null;
    }
    
    accordionSortableInstance = Sortable.create(container, {
        animation: 200,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag',
        handle: '.accordion-header',
        onEnd: function(evt) {
            saveCategoryOrder();
        }
    });
}

function saveCategoryOrder() {
    var container = document.getElementById('accordionContainer');
    if (!container) return;
    
    var categories = container.querySelectorAll('.accordion-item');
    var categoryIds = [];
    var categoryNames = [];
    
    categories.forEach(function(category) {

      var categoryId = category.dataset.categoryId;
      var categoryName = category.querySelector('.category-info h4').textContent.trim();
      
      if (categoryId) {
          categoryIds.push(categoryId);
          categoryNames.push(categoryName);
      }

    });
    
    $.ajax({
        url: '/api/save-category-order',
        type: 'POST',
        data: {
            categoryIds: JSON.stringify(categoryIds),
            category_names: categoryNames
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                console.log('✅ Category order saved to database');
            } else {
                console.error('Failed to save category order:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error saving category order:', error);
        }
    });
}

function saveSoftwareOrder() {
    var orderData = [];
    
    document.querySelectorAll('#accordionContainer .accordion-item').forEach(function(accordion) {
        var categoryId = accordion.dataset.categoryId;
        var items = accordion.querySelectorAll('.software-item');
        var itemIds = [];
        
        items.forEach(function(item) {
            itemIds.push(item.dataset.itemId);
        });
        
        orderData.push({
            categoryId: categoryId,
            itemIds: itemIds
        });
    });
    
    $.ajax({
        url: '/api/save-item-order',
        type: 'POST',
        data: {
            orderData: JSON.stringify(orderData)
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                console.log('✅ Item order saved to database');
            } else {
                console.error('Failed to save item order:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error saving item order:', error);
        }
    });
}

function filterSoftware() {
    var searchTerm = document.getElementById('softwareSearch').value.trim().toLowerCase();
    var clearBtn = document.getElementById('clearSearchBtn');
    
    if (searchTerm.length > 0) {
        clearBtn.style.display = 'block';
    } else {
        clearBtn.style.display = 'none';
    }
    
    if (searchTerm.length === 0) {
        document.querySelectorAll('#accordionContainer .software-item').forEach(function(item) {
            item.style.display = 'flex';
        });
        
        document.querySelectorAll('#accordionContainer .accordion-body').forEach(function(body) {
            body.classList.remove('open');
        });
        
        document.querySelectorAll('#accordionContainer .accordion-arrow').forEach(function(arrow) {
            arrow.classList.remove('open');
        });
        
        var noResult = document.getElementById('noResultMessage');
        if (noResult) noResult.remove();
        
        document.querySelectorAll('#accordionContainer .accordion-item').forEach(function(item) {
            item.style.display = 'block';
        });
        
        updateTotalCount(totalSoftwareCount);
        return;
    }
    
    var accordionItems = document.querySelectorAll('#accordionContainer .accordion-item');
    var totalFound = 0;
    
    accordionItems.forEach(function(accordion) {
        var categoryName = accordion.querySelector('.category-info h4').textContent.toLowerCase();
        var items = accordion.querySelectorAll('.software-item');
        var categoryHasMatch = false;
        
        items.forEach(function(item) {
            var itemText = item.textContent.toLowerCase();
            var matches = itemText.includes(searchTerm) || categoryName.includes(searchTerm);
            
            if (matches) {
                item.style.display = 'flex';
                categoryHasMatch = true;
                totalFound++;
            } else {
                item.style.display = 'none';
            }
        });
        
        var body = accordion.querySelector('.accordion-body');
        var arrow = accordion.querySelector('.accordion-arrow');
        
        if (categoryHasMatch || categoryName.includes(searchTerm)) {
            body.classList.add('open');
            if (arrow) arrow.classList.add('open');
            accordion.style.display = 'block';
        } else {
            body.classList.remove('open');
            if (arrow) arrow.classList.remove('open');
            accordion.style.display = 'none';
        }
    });
    
    var noResult = document.getElementById('noResultMessage');
    if (totalFound === 0) {
        if (!noResult) {
            var container = document.getElementById('accordionContainer');
            var msg = document.createElement('div');
            msg.id = 'noResultMessage';
            msg.className = 'empty-state';
            msg.innerHTML = `
                <i class="fa fa-search"></i>
                <h4>No Results Found</h4>
                <p>No applications match your search: "${searchTerm}"</p>
            `;
            container.appendChild(msg);
        }
    } else {
        if (noResult) noResult.remove();
    }
    
    updateTotalCount(totalFound);
}

function clearSoftwareSearch() {
    document.getElementById('softwareSearch').value = '';
    document.getElementById('clearSearchBtn').style.display = 'none';
    filterSoftware();
    
    document.querySelectorAll('#accordionContainer .accordion-body').forEach(function(body) {
        body.classList.remove('open');
    });
    document.querySelectorAll('#accordionContainer .accordion-arrow').forEach(function(arrow) {
        arrow.classList.remove('open');
    });
    
    var noResult = document.getElementById('noResultMessage');
    if (noResult) noResult.remove();
    
    updateTotalCount(totalSoftwareCount);
}

function toggleSoftwarePanel() {
    var panel = document.getElementById('softwarePanel');
    var overlay = document.getElementById('panelOverlay');
    if (!panel || !overlay) return;
    panel.classList.toggle('active');
    overlay.classList.toggle('active');
    document.body.style.overflow = panel.classList.contains('active') ? 'hidden' : '';
}

function toggleMenuPanel() {
    var panel = document.getElementById('menuPanel');
    var overlay = document.getElementById('panelOverlay');
    if (!panel || !overlay) return;
    panel.classList.toggle('active');
    overlay.classList.toggle('active');
    document.body.style.overflow = panel.classList.contains('active') ? 'hidden' : '';
}

function closeAllPanels() {
    document.querySelectorAll('.software-panel, .menu-panel').forEach(function(panel) {
        panel.classList.remove('active');
    });
    
    var overlay = document.getElementById('panelOverlay');
    if (overlay) {
        overlay.classList.remove('active');
    }
    
    document.body.style.overflow = '';
}

function openSoftwareUrl(url) {
    if (url && url !== '#') {
        window.open(url, '_blank');
    }
}

function updateSoftwareBadge(count) {
    var badge = document.getElementById('softwareBadge');
    if (badge) {
        badge.textContent = count || 0;
    }
}

function updateTotalCount(count) {
    var element = document.getElementById('totalCount');
    if (element) {
        element.textContent = count > 0 ? '(' + count + ')' : '';
    }
}

function showNotification(message, type) {
    var notification = document.createElement('div');
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
    
    setTimeout(function() {
        notification.classList.remove('show');
        setTimeout(function() {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

function showErrorMessage(message) {
    console.error('Error:', message);
    showNotification(message, 'error');
}

function showLoadingState() {
    var loadingState = document.getElementById('loadingState');
    var emptyDashboard = document.getElementById('emptyDashboard');
    
    if (loadingState) loadingState.style.display = 'block';
    if (emptyDashboard) emptyDashboard.style.display = 'none';
}

function hideLoadingState() {
    var loadingState = document.getElementById('loadingState');
    if (loadingState) loadingState.style.display = 'none';
}

function renderMenuList() {
    var menuList = document.getElementById('menuList');
    var menuLoadingState = document.getElementById('menuLoadingState');
    
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
        var isSelected = selectedMenus.some(function(m) {
            return m.id === menu.id;
        });
        var gradient = cardColors[0].gradient;
        var menuItem = document.createElement('div');
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

function toggleMenuSelection(menu) {
    var menuIndex = selectedMenus.findIndex(function(m) {
        return m.id === menu.id;
    });
    
    if (menuIndex === -1) {
        if (selectedMenus.length >= 10) {
            showNotification('Maximum 10 menus allowed!', 'error');
            return;
        }
        
        selectedMenus.push(menu);
        menuOrder.push(menu.id);
        console.log('Added menu:', menu.name);
    } else {
        selectedMenus.splice(menuIndex, 1);
        var orderIndex = menuOrder.indexOf(menu.id);
        if (orderIndex > -1) {
            menuOrder.splice(orderIndex, 1);
        }
        console.log('Removed menu:', menu.name);
    }
    
    renderMenuList();
    renderDashboardCards();
    updateMenuBadge();
    autoSaveDashboard();
}

function renderDashboardCards() {
    var dashboardGrid = document.getElementById('dashboardGrid');
    var emptyDashboard = document.getElementById('emptyDashboard');
    if (!dashboardGrid || !emptyDashboard) return;
    dashboardGrid.innerHTML = '';
    if (selectedMenus.length === 0) {
        emptyDashboard.style.display = 'block';
        return;
    }
    emptyDashboard.style.display = 'none';
    var sortedMenus = menuOrder
        .map(function(id) {
            return selectedMenus.find(function(menu) {
                return menu.id === id;
            });
        })
        .filter(function(menu) {
            return menu !== undefined;
        });
    
    sortedMenus.forEach(function(menu, index) {
        var colorSet = cardColors[index % cardColors.length];
        var gradient = colorSet.gradient;
        var borderColor = colorSet.border;
        var primaryColor = colorSet.primary;
        
        var card = document.createElement('div');
        card.className = 'menu-card';
        card.setAttribute('data-menu-id', menu.id);
        card.setAttribute('data-menu-url', menu.url);
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
        
        var leftBorder = document.createElement('div');
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

function initSortable() {
    var dashboardGrid = document.getElementById('dashboardGrid');
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
                var newOrder = [];
                var cards = dashboardGrid.querySelectorAll('.menu-card');
                
                cards.forEach(function(card) {
                    var menuId = parseInt(card.getAttribute('data-menu-id'));
                    newOrder.push(menuId);
                });
                
                menuOrder = newOrder;
                updateCardOrderNumbers();
                autoSaveDashboard();
            }
        });
    }
}

function updateCardOrderNumbers() {
    var cards = document.querySelectorAll('.menu-card');
    cards.forEach(function(card, index) {
        var orderElement = card.querySelector('.card-order .order-number');
        if (orderElement) {
            orderElement.textContent = index + 1;
        }
    });
}

function removeMenuFromCard(menuId) {
    console.log('Removing menu from card:', menuId);
    
    var index = selectedMenus.findIndex(function(m) {
        return m.id === menuId;
    });
    if (index !== -1) {
        selectedMenus.splice(index, 1);
        var orderIndex = menuOrder.indexOf(menuId);
        if (orderIndex > -1) {
            menuOrder.splice(orderIndex, 1);
        }
        
        renderMenuList();
        renderDashboardCards();
        updateMenuBadge();
        autoSaveDashboard();
    }
}

function updateMenuBadge() {
    var badge = document.getElementById('menuBadge');
    if (badge) {
        badge.textContent = selectedMenus.length;
    }
}

function openMenu(menuId) {
    var menu = topMenus.find(function(m) {
        return m.id === menuId;
    });
    if (menu && menu.url && menu.url !== '#') {
        console.log('Redirecting to:', menu.url);
        window.location.href = menu.url;
    } else {
        console.log('Menu not found or no URL defined for menu ID:', menuId);
    }
}

function autoSaveDashboard() {
    if (isSaving) return;
    if (saveTimeout) {
        clearTimeout(saveTimeout);
    }
    saveTimeout = setTimeout(function() {
        saveDashboard();
    }, 1500);
}

function saveDashboard() {
    if (isSaving) return;
    isSaving = true;
    showSaveIndicator('saving');
    var selectedMenuIds = selectedMenus.map(function(m) {
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
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
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

function showSaveIndicator(type) {
    var indicator = document.getElementById('saveIndicator');
    var icon = indicator.querySelector('i');
    var text = indicator.querySelector('span');
    
    indicator.classList.remove('show', 'saving', 'error');
    
    if (type === 'saving') {
        indicator.classList.add('show', 'saving');
        icon.className = 'fa fa-spinner fa-spin';
        text.textContent = 'Saving...';
    } else if (type === 'success') {
        indicator.classList.add('show');
        icon.className = 'fa fa-check-circle';
        text.textContent = 'Dashboard Updated';
        
        setTimeout(function() {
            indicator.classList.remove('show');
        }, 2000);
    } else if (type === 'error') {
        indicator.classList.add('show', 'error');
        icon.className = 'fa fa-exclamation-circle';
        text.textContent = 'Save failed';
        
        setTimeout(function() {
            indicator.classList.remove('show');
        }, 3000);
    }
}
</script>
@endsection