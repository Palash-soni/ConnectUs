<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Comments</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background: linear-gradient(135deg, #9da192 0%, #b4b5aa 40%, #6b6d61 100%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
    }

    /* ===== HEADER (Same as Feed Page) ===== */
    header {
      width: 100%;
      padding: 12px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
      background: rgba(255, 255, 255, 0.35);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    }

    header h2 {
      font-size: 20px;
      font-weight: 600;
      color: #333;
    }

    .chat-btn {
      background: linear-gradient(45deg, #f56040, #fcaf45);
      border: none;
      border-radius: 50%;
      width: 38px;
      height: 38px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      color: #fff;
      cursor: pointer;
      transition: 0.3s ease;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .chat-btn:hover {
      transform: scale(1.1);
    }

    /* ===== COMMENT BOX ===== */
    .comment-section {
      width: 100%;
      max-width: 480px;
      height: 800px;
      margin: 30px auto 80px;
      background: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border-radius: 16px;
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      overflow: hidden;
      animation: fadeUp 0.4s ease;
    }

    .comment-header {
      display: flex;
      align-items: center;
      padding: 12px 16px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.08);
      background: rgba(255, 255, 255, 0.4);
    }

    .comment-header h3 {
      flex: 1;
      text-align: center;
      font-size: 16px;
      color: #333;
    }

    .back-btn {
      color: #333;
      text-decoration: none;
      font-size: 22px;
      background: rgba(255, 255, 255, 0.4);
      border-radius: 50%;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: 0.3s;
    }

    .back-btn:hover {
      background: linear-gradient(45deg, #f56040, #fcaf45);
      color: #fff;
      transform: scale(1.1);
    }

    /* ===== COMMENT LIST ===== */
    .comment-list {
      flex: 1;
      overflow-y: auto;
      padding: 12px 16px;
    }

    .comment {
      display: flex;
      align-items: flex-start;
      margin-bottom: 14px;
    }

    .comment img {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .comment-body {
      background: rgba(255, 255, 255, 0.9);
      padding: 8px 12px;
      border-radius: 12px;
      box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
    }

    .comment-body p {
      margin: 0;
      font-size: 14px;
      color: #333;
    }

    .comment-body span {
      font-size: 12px;
      color: #777;
      margin-top: 3px;
      display: block;
    }

    /* ===== INPUT BOX ===== */
    .comment-input {
      display: flex;
      align-items: center;
      padding: 10px 14px;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
      background: rgba(255, 255, 255, 0.6);
    }

    .comment-input input {
      flex: 1;
      border: none;
      border-radius: 20px;
      padding: 10px 14px;
      font-size: 14px;
      background: rgba(255, 255, 255, 0.9);
      outline: none;
    }

    .comment-input button {
      margin-left: 8px;
      background: linear-gradient(135deg, #9da192 0%, #b4b5aa 40%, #6b6d61 100%);
      color: #fff;
      border: none;
      padding: 7px 14px;
      border-radius: 18px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .comment-input button:hover {
      transform: scale(1.05);
    }

    /* ===== NAV BAR (Same as Feed) ===== */
    .bottom-nav {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      display: flex;
      justify-content: space-around;
      align-items: center;
      padding: 10px 0;
      background: rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-top: 1px solid rgba(255, 255, 255, 0.3);
      z-index: 100;
    }

    .bottom-nav a {
      color: #555;
      text-decoration: none;
      font-size: 22px;
      transition: 0.3s;
    }

    .bottom-nav a:hover {
      color: #000000;
      transform: scale(1.2);
    }

    /* Animation */
    @keyframes fadeUp {
      from {
        transform: translateY(40px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }
  </style>
</head>
<body>

  <!-- ===== HEADER ===== -->
  <header>
    <h2>Comments</h2>
    
  </header>

  <!-- ===== COMMENT SECTION ===== -->
  <div class="comment-section">
    <div class="comment-header">
      <a href="post.html" class="back-btn">←</a>
      <h3>Post Comments</h3>
    </div>

    <div class="comment-list">
      <div class="comment">
        <img src="https://i.pravatar.cc/40?img=15" alt="">
        <div class="comment-body">
          <p><strong>@arjun_music</strong> This song hits different 🔥</p>
          <span>2h ago</span>
        </div>
      </div>

      <div class="comment">
        <img src="https://i.pravatar.cc/40?img=25" alt="">
        <div class="comment-body">
          <p><strong>@sona_rhythm</strong> So peaceful ✨</p>
          <span>5h ago</span>
        </div>
      </div>

      <div class="comment">
        <img src="https://i.pravatar.cc/40?img=30" alt="">
        <div class="comment-body">
          <p><strong>@raj_music</strong> Love the composition ❤️</p>
          <span>1d ago</span>
        </div>
      </div>
    </div>
    

    <div class="comment-input">
      <input type="text" placeholder="Add a comment..." />
      <button>Post</button>
    </div>
  </div>

  <!-- ===== NAV BAR ===== -->
  <div class="bottom-nav">
    <a href="feed.html">🏠</a>
    <a href="search.html">🔍</a>
    <a href="post.html">➕</a>
    <a href="notification.html">❤️</a>
    <a href="profile.html">👤</a>
  </div>

</body>
</html>
