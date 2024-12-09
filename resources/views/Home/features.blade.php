<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Planner Pro - Features</title>
    <style>
        body {
            margin: 0;
            padding-top: 80px; /* Spațiu pentru bara de sus */
            padding-bottom: 80px; /* Spațiu pentru bara de jos */
            font-family: Arial, sans-serif;
            box-sizing: border-box;
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
            padding: 40px 60px;
            box-sizing: border-box;
        }

        .content h1 {
            font-size: 40px;
            color: #333;
            margin-bottom: 20px;
        }

        .features-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .features-list li {
            font-size: 24px;
            margin-bottom: 15px;
            padding: 10px;
            border-left: 4px solid #8EC3C1;
            background-color: #f9f9f9;
        }

        .features-list li:hover {
            background-color: #e0f5f4;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="site-name">Exam Planner Pro</div>
        <div class="nav-buttons">
            <a href="{{ route('home') }}">Home</a>
            <a href="#features">Features</a>
            <a href="#search">Search</a>
            <a href="{{ route('login') }}" class="button">Sign In</a>
        </div>
    </div>

    <div class="content">
        <h1>Site Features</h1>
        <ul class="features-list">
            <li>Automated exam scheduling for students and faculty.</li>
            <li>Role-based access control for administrators, teachers, and students.</li>
            <li>Search and filter options for managing exam schedules.</li>
            <li>Responsive design for accessibility on all devices.</li>
            <li>Email notifications and reminders for upcoming exams.</li>
            <li>Secure login with role-based dashboard features.</li>
            <li>Multi-language support for international users.</li>
        </ul>
    </div>

    <div class="bottom-bar">
        <p>Contact us at support@examplannerpro.com | All rights reserved</p>
    </div>
</body>
</html>