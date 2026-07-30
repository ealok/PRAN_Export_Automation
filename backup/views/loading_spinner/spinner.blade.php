<div class="spinner-container" id="spinner-container" style="display: none;">
    <div class="spinner-box">
        <div class="spinner"></div>
        <div class="loading-message" id="loading-message">Loading...</div>
    </div>
</div>
<style>
     body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: Arial, sans-serif;
  }

  .container {
    width: 80%;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ccc;
    position: relative;
  }

  .spinner-container {
    position: fixed;
    top: 84%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none; /* Hidden by default */
    z-index: 9999; /* Ensure it appears above other elements */
  }

  #loading-message {
    margin-top: 10px;
    font-size: 16px;
    text-align: center;
}

  .spinner-box {
    background: #f7f5f5;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(155, 127, 127, 0.1);
    margin-top: -320px;
    width: 232px;
    height: 227px;
  }

  .spinner {
    margin: 0 auto 20px;
    width: 60px;
    height: 60px;
    border: 6px solid #f3f3f3;
    border-radius: 50%;
    border-top: 6px solid #3498db;
    border-right: 6px solid #e74c3c;
    border-bottom: 6px solid #f1c40f;
    border-left: 6px solid #2ecc71;
    -webkit-animation: spin 1s linear infinite;
    animation: spin 1s linear infinite;
  }

  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  .loading-message {
    font-size: 12px;
    color: #333;
    animation: fade 1s ease-in-out infinite;
    font-weight: bolder;
  }

  @keyframes fade {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
  }
</style>
