<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Planner Pro - Home</title>
    <style>
        body {
            margin: 0;
            padding-top: 40px; 
            font-family: Arial, sans-serif;
        }

        .top-bar {
            width: 100%;
            background-color: #8EC3C1; 
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-sizing: border-box;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .site-name {
            font-size: 32px;
            font-weight: bold;
            color: white; 
        }
        .nav-buttons {
            display: flex;
            gap: 20px;
        }
        .nav-buttons a {
            text-decoration: none;
            color: white; 
            font-size: 20px;
            padding: 12px 24px; 
            border-radius: 30px; 
            background-color: #0B827C;
            transition: background-color 0.3s, transform 0.3s;
        }
        .nav-buttons a:hover {
            background-color: #0a7973; 
            transform: scale(1.1); 
        }

        .bottom-bar {
            width: 100%;
            background-color: #8EC3C1; 
            padding: 40px 60px; 
            display: flex;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
            position: fixed;
            bottom: 0;
            left: 0;
            z-index: 1000;
        }
        .bottom-bar p {
            font-size: 20px;
            color: white; 
        }

        .content {
            display: flex;
            justify-content: start; 
            align-items: center; 
            padding: 0 40px; 
            height: calc(100vh - 120px); 
            gap: 20px; 
        }

        .content img {
            max-height: calc(100vh - 120px); 
            width: 1200px; 
        }

        .content p {
            margin: 0;
            font-size: 100px; 
            font-weight: bold;
            color: #333;
            line-height: 1.3;
            text-align: left; 
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="site-name">Exam Planner Pro</div>
        <div class="nav-buttons">
            <a href="#home">Home</a>
            <a href="{{ route('features') }}">Features</a>
            <a href="#search">Search</a>
            <a href="{{ route('login') }}">Sign In</a>
        </div>
    </div>

    <div class="content">
        <img src="https://i.ibb.co/nMxLtx9/book-icon.png" alt="Book Icon">
        <div>
            <p>Lifting</p>
            <p>the weight of exams,</p>
            <p>one step at a time.</p>
        </div>
    </div>

    <div class="bottom-bar">
        <p>Contact us at support@examplannerpro.com | All rights reserved</p>
    </div>
</body>
</html>