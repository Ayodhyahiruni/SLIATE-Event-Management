<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - SLIATE</title>
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
        }
        
        header {
            background-color: #1e0836;
            padding: 20px 0;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            letter-spacing: 1px;
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
            cursor: pointer;
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
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 153, 0, 0.4);
        }
        
        .main-content {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .dashboard-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .dashboard-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: bold;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }
        
        .dashboard-header .subtitle-text {
            font-size: 1.2rem;
            color: #a78bda;
        }
        
        .dashboard-tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
            gap: 20px;
        }
        
        .tab-btn {
            padding: 12px 25px;
            border-radius: 50px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
            font-weight: bold;
        }
        
        .tab-btn:hover, .tab-btn.active {
            background: linear-gradient(90deg, #ff9900, #ff5500);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .search-filter-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 40px;
            align-items: center;
        }
        
        .search-box {
            flex: 1;
            max-width: 500px;
            position: relative;
        }
        
        .search-box input {
            width: 100%;
            padding: 15px 20px;
            padding-left: 50px;
            border-radius: 50px;
            border: none;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
        }
        
        .search-box input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .search-box svg {
            position: absolute;
            left: 20px;
            top: 15px;
            color: rgba(255, 255, 255, 0.5);
        }
        
        .category-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
        
        .filter-btn {
            padding: 10px 20px;
            border-radius: 50px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .filter-btn:hover, .filter-btn.active {
            background: linear-gradient(90deg, #ff9900, #ff5500);
        }
        
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }
        
        .event-card {
            background: linear-gradient(145deg, #2a0f4c 0%, #3d1a69 100%);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s;
        }
        
        .event-card:hover {
            transform: translateY(-10px);
        }
        
        .event-img {
            height: 200px;
            width: 100%;
            background-color: #2a0f4c;
            position: relative;
            overflow: hidden;
        }
        
        .event-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .event-category {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 15px;
            border-radius: 50px;
            background: linear-gradient(90deg, #ff9900, #ff5500);
            color: white;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .event-details {
            padding: 20px;
        }
        
        .event-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
            font-weight: bold;
            color: white;
        }
        
        .event-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .event-info div {
            display: flex;
            align-items: center;
            color: #a78bda;
            font-size: 0.9rem;
        }
        
        .event-info svg {
            margin-right: 5px;
        }
        
        .event-location {
            color: #a78bda;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .event-location svg {
            margin-right: 5px;
        }
        
        .event-buttons {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        
        .view-btn, .register-btn, .remove-btn {
            padding: 10px 0;
            border-radius: 5px;
            flex: 1;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            text-decoration: none;
        }
        
        .view-btn {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .view-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .register-btn {
            background: linear-gradient(90deg, #ff9900, #ff5500);
            color: white;
        }
        
        .register-btn:hover {
            box-shadow: 0 5px 15px rgba(255, 153, 0, 0.4);
        }
        
        .remove-btn {
            background: linear-gradient(90deg, #ff4444, #cc0000);
            color: white;
        }
        
        .remove-btn:hover {
            box-shadow: 0 5px 15px rgba(255, 68, 68, 0.4);
        }
        
        .added-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 5px 15px;
            border-radius: 50px;
            background: linear-gradient(90deg, #00cc44, #00aa33);
            color: white;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #a78bda;
        }
        
        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        
        .empty-state p {
            font-size: 1rem;
            margin-bottom: 20px;
        }
        
        .empty-state button {
            background: linear-gradient(90deg, #ff9900, #ff5500);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .empty-state button:hover {
            box-shadow: 0 5px 15px rgba(255, 153, 0, 0.4);
        }
        
        @media (max-width: 768px) {
            .search-filter-container {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .search-box {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }
            
            .category-filters {
                width: 100%;
                justify-content: flex-start;
            }
            
            .events-grid {
                grid-template-columns: 1fr;
            }
            
            .dashboard-tabs {
                flex-direction: column;
                align-items: center;
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
        <a href="#" onclick="showTab('browse')" id="browse-tab" class="active">Browse Events</a>
        <a href="#" onclick="showTab('dashboard')" id="dashboard-tab">My Dashboard</a>
        <button class="login-btn">Profile</button>
    </nav>

    <div class="main-content">
        <div class="dashboard-header">
            <h1 id="page-title">Student Dashboard</h1>
            <div class="subtitle-text" id="page-subtitle">Manage your events and discover new opportunities</div>
        </div>

        <!-- Browse Events Tab -->
        <div id="browse-content" class="tab-content active">
            <div class="subtitle-text">CHECK OUT THE</div>
            <h1>EVENTS</h1>
            <div class="search-filter-container">
                <div class="search-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="search-input" placeholder="Search for events...">
                </div>
                <div class="category-filters">
                    <button class="filter-btn active" onclick="filterEvents('all', event)">All</button>
                    <button class="filter-btn" onclick="filterEvents('workshops', event)">Workshops</button>
                    <button class="filter-btn" onclick="filterEvents('cultural', event)">Cultural</button>
                    <button class="filter-btn" onclick="filterEvents('sports', event)">Sports</button>
                    <button class="filter-btn" onclick="filterEvents('tech talks', event)">Tech Talks</button>
                </div>
            </div>
            <div class="events-grid" id="browse-events-grid">
                <!-- Event 1 -->
                <div class="event-card" data-category="tech talks" data-title="advanced ai workshop">
                  <div class="event-img">
                    <img src="images/AI-Workshop.jpg" alt="AI Workshop">
                    <div class="event-category">Tech Talks</div>
                  </div>
                  <div class="event-details">
                    <h3 class="event-title">Advanced AI Workshop</h3>
                    <div class="event-info">
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                          <line x1="16" y1="2" x2="16" y2="6"></line>
                          <line x1="8" y1="2" x2="8" y2="6"></line>
                          <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        May 5, 2025
                      </div>
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <circle cx="12" cy="12" r="10"></circle>
                          <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        2:00 PM
                      </div>
                    </div>
                    <div class="event-location">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                      </svg>
                      Tech Building, Room 305
                    </div>
                    <div class="event-buttons">
                      <a href="AI.php" class="view-btn" style="text-align:center; display:inline-block; text-decoration:none;">View Details</a>          
                      <a class="register-btn" style="text-align:center; display:inline-block; text-decoration:none;">Add</a>
                    </div>
                  </div>
                </div>
                <!-- Event 2 -->
                <div class="event-card" data-category="cultural" data-title="annual cultural festival">
                  <div class="event-img">
                    <img src="images/Cultural.jpg" alt="Cultural Dance">
                    <div class="event-category">Cultural</div>
                  </div>
                  <div class="event-details">
                    <h3 class="event-title">Annual Cultural Festival</h3>
                    <div class="event-info">
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                          <line x1="16" y1="2" x2="16" y2="6"></line>
                          <line x1="8" y1="2" x2="8" y2="6"></line>
                          <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        May 12, 2025
                      </div>
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <circle cx="12" cy="12" r="10"></circle>
                          <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        6:00 PM
                      </div>
                    </div>
                    <div class="event-location">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                      </svg>
                      University Auditorium
                    </div>
                    <div class="event-buttons">
                      <a href="Cultural.php" class="view-btn" style="text-align:center; display:inline-block; text-decoration:none;">View Details</a> 
                        <a class="register-btn" style="text-align:center; display:inline-block; text-decoration:none;">Add</a>
                    </div>
                  </div>
                </div>
                <!-- Event 3 -->
                <div class="event-card" data-category="sports" data-title="inter-college volleyball">
                  <div class="event-img">
                    <img src="images/volleyball.jpg" alt="Basketball Tournament">
                    <div class="event-category">Sports</div>
                  </div>
                  <div class="event-details">
                    <h3 class="event-title">Inter-College Volleyball</h3>
                    <div class="event-info">
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                          <line x1="16" y1="2" x2="16" y2="6"></line>
                          <line x1="8" y1="2" x2="8" y2="6"></line>
                          <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        May 20, 2025
                      </div>
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <circle cx="12" cy="12" r="10"></circle>
                          <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        10:00 AM
                      </div>
                    </div>
                    <div class="event-location">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                      </svg>
                      University Sports Complex
                    </div>
                    <div class="event-buttons">
                      <a href="volley.php" class="view-btn" style="text-align:center; display:inline-block; text-decoration:none;">View Details</a> 
                      <a class="register-btn" style="text-align:center; display:inline-block; text-decoration:none;">Add</a>
                    </div>
                  </div>
                </div>
                <!-- Event 4 -->
                <div class="event-card" data-category="workshops" data-title="resume building workshop">
                  <div class="event-img">
                    <img src="images/resume.jpg" alt="Resume Workshop">
                    <div class="event-category">Workshops</div>
                  </div>
                  <div class="event-details">
                    <h3 class="event-title">Resume Building Workshop</h3>
                    <div class="event-info">
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                          <line x1="16" y1="2" x2="16" y2="6"></line>
                          <line x1="8" y1="2" x2="8" y2="6"></line>
                          <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        May 25, 2025
                      </div>
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <circle cx="12" cy="12" r="10"></circle>
                          <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        1:00 PM
                      </div>
                    </div>
                    <div class="event-location">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                      </svg>
                      Career Center, Room 102
                    </div>
                    <div class="event-buttons">
                      <a href="resume.php" class="view-btn" style="text-align:center; display:inline-block; text-decoration:none;">View Details</a> 
                      <a class="register-btn" style="text-align:center; display:inline-block; text-decoration:none;">Add</a>
                    </div>
                  </div>
                </div>
                <!-- Event 5 -->
                <div class="event-card" data-category="tech talks" data-title="programming hackathon">
                  <div class="event-img">
                    <img src="images/program.jpg" alt="Programming Contest">
                    <div class="event-category">Tech Talks</div>
                  </div>
                  <div class="event-details">
                    <h3 class="event-title">Programming Hackathon</h3>
                    <div class="event-info">
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                          <line x1="16" y1="2" x2="16" y2="6"></line>
                          <line x1="8" y1="2" x2="8" y2="6"></line>
                          <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        June 2, 2025
                      </div>
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <circle cx="12" cy="12" r="10"></circle>
                          <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        9:00 AM
                      </div>
                    </div>
                    <div class="event-location">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                      </svg>
                      Computer Science Building, Lab 4
                    </div>
                    <div class="event-buttons">
                      <a href="program.php" class="view-btn" style="text-align:center; display:inline-block; text-decoration:none;">View Details</a> 
                      <a class="register-btn" style="text-align:center; display:inline-block; text-decoration:none;">Add</a>
                    </div>
                  </div>
                </div>
                <!-- Event 6 -->
                <div class="event-card" data-category="cultural" data-title="music concert">
                  <div class="event-img">
                    <img src="images/concert.jpg" alt="Music Concert">
                    <div class="event-category">Cultural</div>
                  </div>
                  <div class="event-details">
                    <h3 class="event-title">Music Concert</h3>
                    <div class="event-info">
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                          <line x1="16" y1="2" x2="16" y2="6"></line>
                          <line x1="8" y1="2" x2="8" y2="6"></line>
                        </svg>
                        June 10, 2025
                      </div>
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        </svg>
                        7:00 PM
                      </div>
                    </div>
                    <div class="event-location">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                      </svg>
                      Outdoor Amphitheater
                    </div>
                    <div class="event-buttons">
                      <a href="music.php" class="view-btn" style="text-align:center; display:inline-block; text-decoration:none;">View Details</a> 
                       <a class="register-btn" style="text-align:center; display:inline-block; text-decoration:none;">Add</a>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        <!-- My Dashboard Tab -->
        <div id="dashboard-content" class="tab-content">
            <div id="my-events-grid" class="events-grid">
                <!-- Added events will appear here -->
            </div>
            <div id="empty-state" class="empty-state">
                <h3>No Events Added Yet</h3>
                <p>Start by browsing available events and adding them to your dashboard</p>
                <button onclick="showTab('browse')">Browse Events</button>
            </div>
        </div>
    </div>

    <script>
        // Sample events data
        const eventsData = [
            {
                id: 1,
                title: "Advanced AI Workshop",
                category: "Tech Talks",
                date: "May 5, 2025",
                time: "2:00 PM",
                location: "Tech Building, Room 305",
                image: "images/AI-wORKSHOP.jpg"
            },
            {
                id: 2,
                title: "Annual Cultural Festival", 
                category: "Cultural",
                date: "May 12, 2025",
                time: "6:00 PM",
                location: "University Auditorium",
                image: "images/cultural.jpg"
            },
            {
                id: 3,
                title: "Inter-College Volleyball",
                category: "Sports", 
                date: "May 20, 2025",
                time: "10:00 AM",
                location: "University Sports Complex",
                image: "images/volleyball.jpg"
            },
            {
                id: 4,
                title: "Resume Building Workshop",
                category: "Workshops",
                date: "May 25, 2025", 
                time: "1:00 PM",
                location: "Career Center, Room 102",
                image: "images/resume.jpg"
            },
            {
                id: 5,
                title: "Programming Hackathon",
                category: "Tech Talks",
                date: "June 2, 2025",
                time: "9:00 AM", 
                location: "Computer Science Building, Lab 4",
                image: "images/program.jpg"
            },
            {
                id: 6,
                title: "Music Concert",
                category: "Cultural",
                date: "June 10, 2025",
                time: "7:00 PM",
                location: "Outdoor Amphitheater",
                image: "images/concert.jpg"
            }
        ];

        // Store added events in memory
        let addedEvents = [];
        let currentFilter = 'all';

        // Initialize the page
        document.addEventListener("DOMContentLoaded", () => {
            renderBrowseEvents();
            updateDashboard();
            setupSearch();
        });

        // Tab switching functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Remove active class from all nav links
            document.querySelectorAll('nav a').forEach(link => {
                link.classList.remove('active');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').classList.add('active');
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Update header based on active tab
            if (tabName === 'browse') {
                document.getElementById('page-title').textContent = 'Browse Events';
                document.getElementById('page-subtitle').textContent = 'Discover and add events to your dashboard';
            } else {
                document.getElementById('page-title').textContent = 'My Dashboard';
                document.getElementById('page-subtitle').textContent = 'Your registered events and schedule';
                updateDashboard();
            }
        }

        // Render events in browse tab
        function renderBrowseEvents() {
            const grid = document.getElementById('browse-events-grid');
            const filteredEvents = currentFilter === 'all' 
                ? eventsData 
                : eventsData.filter(event => event.category.toLowerCase().includes(currentFilter));
            
            grid.innerHTML = filteredEvents.map(event => createEventCard(event, 'browse')).join('');
        }

        // Create event card HTML
        function createEventCard(event, context) {
            const isAdded = addedEvents.some(e => e.id === event.id);
            
            return `
                <div class="event-card" data-category="${event.category.toLowerCase()}" data-title="${event.title.toLowerCase()}">
                    <div class="event-img">
                        <img src="${event.image}" alt="${event.title}">
                        <div class="event-category">${event.category}</div>
                        ${isAdded && context === 'browse' ? '<div class="added-badge">Added</div>' : ''}
                    </div>
                    <div class="event-details">
                        <h3 class="event-title">${event.title}</h3>
                        <div class="event-info">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                ${event.date}
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                ${event.time}
                            </div>
                        </div>
                        <div class="event-location">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            ${event.location}
                        </div>
                        <div class="event-buttons">
                            <button class="view-btn">View Details</button>
                            ${context === 'browse' 
                                ? `<button class="register-btn" onclick="addEvent(${event.id})" ${isAdded ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : ''}>
                                    ${isAdded ? 'Added' : 'Add Event'}
                                   </button>`
                                : `<button class="remove-btn" onclick="removeEvent(${event.id})">Remove</button>`
                            }
                        </div>
                    </div>
                </div>
            `;
        }

        // Add event to dashboard
        function addEvent(eventId) {
            const event = eventsData.find(e => e.id === eventId);
            if (event && !addedEvents.some(e => e.id === eventId)) {
                addedEvents.push(event);
                renderBrowseEvents(); // Re-render to show "Added" state
                updateDashboard();
                
                // Show success feedback
                const button = event.target || document.querySelector(`button[onclick="addEvent(${eventId})"]`);
                if (button) {
                    button.textContent = 'Added!';
                    button.style.background = 'linear-gradient(90deg, #00cc44, #00aa33)';
                    setTimeout(() => {
                        renderBrowseEvents();
                    }, 1000);
                }
            }
        }

        // Remove event from dashboard
        function removeEvent(eventId) {
            addedEvents = addedEvents.filter(e => e.id !== eventId);
            updateDashboard();
            renderBrowseEvents(); // Re-render browse events to remove "Added" badge
        }

        // Update dashboard display
        function updateDashboard() {
            const grid = document.getElementById('my-events-grid');
            const emptyState = document.getElementById('empty-state');
            
            if (addedEvents.length === 0) {
                grid.style.display = 'none';
                emptyState.style.display = 'block';
            } else {
                grid.style.display = 'grid';
                emptyState.style.display = 'none';
                grid.innerHTML = addedEvents.map(event => createEventCard(event, 'dashboard')).join('');
            }
        }

        // Filter events by category
        function filterEvents(category) {
            currentFilter = category;
            
            // Update active filter button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            renderBrowseEvents();
        }

        // Setup search functionality
        function setupSearch() {
            const searchInput = document.getElementById('search-input');
            searchInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const eventCards = document.querySelectorAll('#browse-events-grid .event-card');
                
                eventCards.forEach(card => {
                    const title = card.getAttribute('data-title');
                    const category = card.getAttribute('data-category');
                    
                    if (title.includes(searchTerm) || category.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    </script>

</body>
</html>