<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
$is_logged_in = isset($_SESSION['student_id']);

// Get event ID from URL
$event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$event_id) {
    header("Location: event.php");
    exit();
}

try {
    // Get event details with category
    $stmt = $pdo->prepare("
        SELECT e.*, ec.category_name 
        FROM events e 
        LEFT JOIN event_categories ec ON e.category_id = ec.category_id 
        WHERE e.event_id = ?
    ");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$event) {
        header("Location: event.php");
        exit();
    }
    
} catch (PDOException $e) {
    header("Location: event.php");
    exit();
}

// Check if user is registered for this event
$is_registered = false;
if ($is_logged_in) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM student_events WHERE student_id = ? AND event_id = ? AND status = 'registered'");
        $stmt->execute([$_SESSION['student_id'], $event_id]);
        $is_registered = $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    } catch (PDOException $e) {
        // Handle error silently
    }
}

// Check if event is full
$is_full = $event['max_participants'] && $event['current_participants'] >= $event['max_participants'];

// Check if registration is still open
$event_datetime = $event['event_date'] . ' ' . $event['event_time'];
$registration_open = strtotime($event_datetime) > time() && $event['status'] == 'active';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['title']); ?> - SLIATE</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            background-color: #1e0836;
            color: white;
            line-height: 1.6;
        }
        
        header {
            background-color: #1e0836;
            padding: 20px 0;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .subtitle {
            font-size: 1rem;
            letter-spacing: 5px;
            margin-top: 5px;
        }
        
        nav {
            display: flex;
            justify-content: center;
            background-color: #1e0836;
            padding: 15px 0;
            position: relative;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 20px;
            font-weight: bold;
            font-size: 1rem;
            transition: color 0.3s;
        }
        
        nav a:hover {
            color: #ff9900;
        }
        
        nav a.active {
            color: #ff9900;
        }
        
        .login-btn {
            position: absolute;
            right: 30px;
            background: linear-gradient(90deg, #ff9900, #ff5500);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 153, 0, 0.4);
        }
        
        .main-content {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .back-link {
            margin-bottom: 30px;
        }
        
        .back-link a {
            color: #ff8c00;
            text-decoration: none;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s;
        }
        
        .back-link a:hover {
            color: #ff9900;
        }
        
        .event-header {
            background: linear-gradient(145deg, #2a0f4c 0%, #3d1a69 100%);
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        
        .event-image {
            height: 300px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .event-category-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 16px;
            border-radius: 50px;
            background: linear-gradient(90deg, #ff9900, #ff5500);
            color: white;
            font-size: 0.9rem;
            font-weight: bold;
        }
        
        .event-status-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 8px 16px;
            border-radius: 50px;
            color: white;
            font-size: 0.9rem;
            font-weight: bold;
        }
        
        .status-active {
            background: linear-gradient(90deg, #28a745, #20c997);
        }
        
        .status-cancelled {
            background: linear-gradient(90deg, #dc3545, #c82333);
        }
        
        .status-completed {
            background: linear-gradient(90deg, #6c757d, #5a6268);
        }
        
        .event-content {
            padding: 30px;
        }
        
        .event-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #ff8c00;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .event-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #a78bda;
        }
        
        .meta-item svg {
            color: #ff8c00;
        }
        
        .event-description {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #ff8c00;
        }
        
        .event-description h3 {
            color: #ff8c00;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .event-description p {
            color: #cccccc;
            line-height: 1.8;
        }
        
        .registration-section {
            background: linear-gradient(145deg, #2a0f4c 0%, #3d1a69 100%);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .registration-section h3 {
            color: #ff8c00;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        
        .participants-info {
            margin-bottom: 20px;
            color: #cccccc;
        }
        
        .register-btn, .registered-btn, .login-btn-large, .closed-btn {
            padding: 15px 40px;
            border-radius: 50px;
            border: none;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .register-btn {
            background: linear-gradient(90deg, #ff9900, #ff5500);
            color: white;
        }
        
        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 153, 0, 0.4);
        }
        
        .registered-btn {
            background: linear-gradient(90deg, #28a745, #20c997);
            color: white;
            cursor: default;
        }
        
        .login-btn-large {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: white;
        }
        
        .login-btn-large:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
        }
        
        .closed-btn {
            background: linear-gradient(90deg, #6c757d, #5a6268);
            color: white;
            cursor: default;
        }
        
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }
        
        .alert-warning {
            background-color: rgba(255, 193, 7, 0.2);
            border: 1px solid #ffc107;
            color: #ffc107;
        }
        
        @media (max-width: 768px) {
            .event-title {
                font-size: 2rem;
            }
            
            .event-meta {
                grid-template-columns: 1fr;
            }
            
            .event-content {
                padding: 20px;
            }
            
            .registration-section {
                padding: 20px;
            }
            
            nav {
                flex-wrap: wrap;
                justify-content: center;
                padding-bottom: 60px;
            }
            
            .login-btn {
                position: absolute;
                bottom: 15px;
                right: 50%;
                transform: translateX(50%);
            }
        }
    </style>
</head>
<body>
    <header>
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0 20px;">
            <img src="images/sliate.jpg" alt="SLIATE Logo" style="height: 50px; position: absolute; top: 10px; left: 10px;">
            <div style="flex: 1; text-align: center;">
                <div class="subtitle">SRI LANKA INSTITUTE OF ADVANCED TECHNOLOGICAL EDUCATION</div>
            </div>
        </div>
    </header>

    <nav>
        <a href="index.php">HOME</a>
        <a href="event.php" class="active">EVENTS</a>
        <a href="#">GALLERY</a>
        <a href="#">CONTACT</a>
        
        <?php if ($is_logged_in): ?>
            <a href="dashboard.php" class="login-btn">DASHBOARD</a>
        <?php else: ?>
            <a href="login.php" class="login-btn">LOGIN</a>
        <?php endif; ?>
    </nav>

    <div class="main-content">
        <div class="back-link">
            <a href="event.php">← Back to Events</a>
        </div>

        <div class="event-header">
            <div class="event-image">
                <?php if (!empty($event['image_url'])): ?>
                    <img src="<?php echo htmlspecialchars($event['image_url']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
                <?php else: ?>
                    <div style="background: linear-gradient(45deg, #2a0f4c, #3d1a69); height: 100%; display: flex; align-items: center; justify-content: center; color: #cccccc; font-size: 1.2rem;">
                        Event Image
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($event['category_name'])): ?>
                    <div class="event-category-badge"><?php echo htmlspecialchars($event['category_name']); ?></div>
                <?php endif; ?>
                
                <div class="event-status-badge status-<?php echo $event['status']; ?>">
                    <?php echo ucfirst($event['status']); ?>
                </div>
            </div>
            
            <div class="event-content">
                <h1 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h1>
                
                <div class="event-meta">
                    <div class="meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span><?php echo date('l, F d, Y', strtotime($event['event_date'])); ?></span>
                    </div>
                    
                    <div class="meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span><?php echo date('h:i A', strtotime($event['event_time'])); ?></span>
                    </div>
                    
                    <div class="meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span><?php echo htmlspecialchars($event['location']); ?></span>
                    </div>
                    
                    <?php if ($event['max_participants']): ?>
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span><?php echo $event['current_participants']; ?>/<?php echo $event['max_participants']; ?> participants</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="event-description">
            <h3>About This Event</h3>
            <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
        </div>

        <div class="registration-section">
            <h3>Event Registration</h3>
            
            <?php if ($event['max_participants']): ?>
                <div class="participants-info">
                    <strong><?php echo $event['current_participants']; ?></strong> out of <strong><?php echo $event['max_participants']; ?></strong> spots filled
                </div>
            <?php endif; ?>
            
            <?php if (!$registration_open): ?>
                <div class="alert alert-warning">
                    Registration is closed for this event.
                </div>
                <span class="closed-btn">Registration Closed</span>
            <?php elseif ($is_full): ?>
                <div class="alert alert-warning">
                    This event is full. No more registrations are being accepted.
                </div>
                <span class="closed-btn">Event Full</span>
            <?php elseif (!$is_logged_in): ?>
                <p style="margin-bottom: 20px; color: #cccccc;">Please login to register for this event.</p>
                <a href="login.php" class="login-btn-large">Login to Register</a>
            <?php elseif ($is_registered): ?>
                <p style="margin-bottom: 20px; color: #28a745;">✓ You are registered for this event!</p>
                <span class="registered-btn">Already Registered</span>
            <?php else: ?>
                <p style="margin-bottom: 20px; color: #cccccc;">Click the button below to register for this event.</p>
                <a href="register_event.php?id=<?php echo $event['event_id']; ?>" class="register-btn" 
                   onclick="return confirm('Are you sure you want to register for this event?')">Register Now</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

