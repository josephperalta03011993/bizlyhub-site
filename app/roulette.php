<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main.css"> 
    <title>Filipino Food Roulette 🍽️</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
        }
        
        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 600px;
            width: 100%;
            margin: 2% 28%;
        }
        
        h1 {
            color: white;
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2em;
            margin-bottom: 30px;
            font-weight: 300;
        }
        
        .roulette-container {
            position: relative;
            width: 350px;
            height: 350px;
            margin: 20px auto;
        }
        
        .wheel {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 8px solid #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            transition: transform 4s cubic-bezier(0.23, 1, 0.32, 1);
        }
        
        .wheel-section {
            position: absolute;
            width: 100%;
            height: 100%;
            transform-origin: center;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            font-weight: 600;
            font-size: 0.8em; /* Adjust font size for better fit */
            color: white;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .wheel-section::before {
            content: none; /* Remove clip-path pseudo-element */
        }

        .wheel-section span {
            position: relative;
            transform: rotate(-45deg) translateY(20px); /* Adjust text positioning */
            max-width: 80px; /* Reduce max-width for smaller sections */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .pointer {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-top: 25px solid #ff6b6b;
            z-index: 10;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }
        
        .spin-button {
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 1.2em;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }
        
        .spin-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
        }
        
        .spin-button:active {
            transform: translateY(0);
        }
        
        .spin-button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .result {
            margin-top: 20px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }
        
        .result.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .result h3 {
            color: white;
            font-size: 1.8em;
            margin-bottom: 10px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        .result p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1em;
            line-height: 1.5;
        }
        
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background: #ff6b6b;
            top: -10px;
            border-radius: 50%;
            animation: confetti-fall 3s linear infinite;
        }
        
        @keyframes confetti-fall {
            0% { transform: translateY(-100vh) rotate(0deg); }
            100% { transform: translateY(100vh) rotate(360deg); }
        }
        
        .stats {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .stat-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 15px;
            border-radius: 10px;
            color: white;
            font-size: 0.9em;
        }
        
        .reset-button {
            background: linear-gradient(45deg, #4ecdc4, #44a08d);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            border-radius: 25px;
            cursor: pointer;
            margin-top: 10px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }
        
        .reset-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(68, 160, 141, 0.4);
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 20px;
                margin: 0;
                border-radius: 0;
            }
            
            h1 {
                font-size: 2em;
            }
            
            .roulette-container {
                width: 280px;
                height: 280px;
            }
            
            .wheel-section {
                font-size: 0.5em;
            }
            
            .wheel-section span {
                max-width: 60px;
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    
    <!-- Navigation -->
    <nav class="navbar" aria-label="Main navigation">
        <div class="navbar-container">
            <a href="#home" class="logo animate-in" aria-label="BizlyHub Home">BizlyHub</a>
            <button class="menu-toggle" aria-label="Toggle menu" aria-expanded="false">☰</button>
            <div class="nav-links" role="menu">
                <a href="../index.php">Home</a>
                <a href="../index.php#features">Services</a>
                <a href="../index.php#about">About</a>
                <a href="../index.php#portfolio">Portfolio</a>
                <a href="../blogs">Blogs</a>
                <a href="../index.php#pricing">Pricing</a>
                <a href="../index.php#contact">Contact</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>🍽️ Filipino Food Roulette</h1>
        <p class="subtitle">Spin the wheel to discover your next delicious meal!</p>
        
        <div class="roulette-container">
            <div class="pointer"></div>
            <div class="wheel" id="wheel">
                <!-- Wheel sections will be generated by JavaScript -->
            </div>
        </div>
        
        <button class="spin-button" id="spinButton">🎲 SPIN THE WHEEL!</button>
        
        <div class="result" id="result">
            <h3 id="resultFood"></h3>
            <p id="resultDescription"></p>
        </div>
        
        <div class="stats">
            <div class="stat-item">
                <strong>Spins:</strong> <span id="spinCount">0</span>
            </div>
            <div class="stat-item">
                <strong>Last Pick:</strong> <span id="lastPick">-</span>
            </div>
        </div>
        
        <button class="reset-button" id="resetButton">🔄 Reset Stats</button>
    </div>

    <!-- Footer -->
    <?php include('../layouts/footer.php'); ?>

    <script>
        const foods = [
            { name: "Adobo", description: "The classic Filipino dish with tender meat braised in soy sauce, vinegar, and garlic. A true comfort food!" },
            { name: "Sinigang", description: "A sour and savory soup that's perfect for any weather. Usually with pork, shrimp, or fish!" },
            { name: "Lechon", description: "The king of Filipino celebrations! Crispy-skinned roasted pig that's absolutely divine." },
            { name: "Pancit", description: "Long noodles for long life! This stir-fried noodle dish comes in many delicious varieties." },
            { name: "Lumpia", description: "Filipino spring rolls that are crispy, fresh, and always a crowd favorite!" },
            { name: "Sisig", description: "Sizzling pork dish that's crispy, tangy, and absolutely addictive. Perfect with rice!" },
            { name: "Kare-Kare", description: "Rich peanut stew with oxtail and vegetables. Don't forget the bagoong!" },
            { name: "Tinola", description: "Comforting ginger soup with chicken, green papaya, and chili leaves. Soul food at its finest!" },
            { name: "Bicol Express", description: "Spicy and creamy pork dish cooked in coconut milk and chilies. Not for the faint of heart!" },
            { name: "Longsilog", description: "The ultimate Filipino breakfast: longganisa, sinangag, and itlog. Perfect any time of day!" },
            { name: "Bulalo", description: "Hearty beef bone marrow soup that's perfect for sharing. Comfort in a bowl!" },
            { name: "Chicken Inasal", description: "Grilled chicken marinated in lemongrass and annatto. Smoky, juicy, and flavorful!" },
            { name: "Laing", description: "Taro leaves stewed in creamy coconut milk with chilies and sometimes dried fish. Rich and earthy!" },
            { name: "Dinuguan", description: "Savory pork blood stew simmered with vinegar and spices. Best paired with puto!" },
            { name: "Pinakbet", description: "Colorful vegetable stew with squash, bitter melon, okra, and bagoong. A healthy classic!" },
            { name: "Menudo", description: "Tomato-based pork stew with potatoes, carrots, and bell peppers. Comforting and familiar!" },
            { name: "Paksiw na Pata", description: "Braised pork hock simmered in vinegar and soy sauce with banana blossoms. Tender and flavorful!" },
            { name: "Pochero", description: "Spanish-influenced stew with beef or pork, saba bananas, chickpeas, and tomato sauce." },
            { name: "Caldereta", description: "Rich beef stew simmered with tomato sauce, liver spread, and vegetables. A party favorite!" },
            { name: "Tortang Talong", description: "Eggplant omelet that's smoky, fluffy, and delicious with ketchup or vinegar dip!" },
            { name: "Ginisang Munggo", description: "Nutritious mung beans sautéed with garlic, onions, and tomatoes, often with pork or tinapa. Great with rice!" },
            { name: "Tapa", description: "Cured beef slices that are salty, savory, and perfect for tapsilog!" },
            { name: "Piniritong Manok", description: "Classic Filipino-style fried chicken that's crispy on the outside, juicy inside. Always a hit!" },
            { name: "Ginataang Sitaw at Kalabasa", description: "String beans and squash simmered in rich coconut milk with shrimp or pork. Creamy and comforting!" },
            { name: "Ginisang Togue", description: "Sautéed mung bean sprouts with carrots, tofu, and sometimes pork or shrimp. Light and healthy!" },
            { name: "Tokwa", description: "Crispy fried tofu cubes often served with vinegar dipping sauce or added to stir-fries. Simple and delicious!" },
            { name: "Daing na Bangus", description: "Milkfish marinated in vinegar, garlic, and pepper, then fried until golden and crispy. A breakfast favorite with garlic rice!" }
        ];
        
        const colors = [
            '#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#ffeaa7', 
            '#dda0dd', '#98d8c8', '#f7dc6f', '#bb8fce', '#85c1e9',
            '#f8c471', '#82e0aa', '#ff9ff3', '#54a0ff', '#5f27cd',
            '#00d2d3', '#ff9f43', '#feca57', '#ff6348', '#ff3838',
            '#7bed9f', '#70a1ff', '#5352ed', '#2ed573', '#1e90ff',
            '#ff4757', '#ff6b6b'
        ];
        
        let currentRotation = 0;
        let spinCount = 0;
        let lastPick = '-';
        let isSpinning = false;
        
        // Initialize the wheel
        function initWheel() {
            const wheel = document.getElementById('wheel');
            wheel.innerHTML = ''; // Clear existing content

            const sectionAngle = 360 / foods.length;

            foods.forEach((food, index) => {
                const section = document.createElement('div');
                section.className = 'wheel-section';
                // Set rotation for each section
                section.style.transform = `rotate(${index * sectionAngle}deg)`;
                section.style.background = `conic-gradient(from ${index * sectionAngle}deg, ${colors[index]} ${sectionAngle}deg, transparent ${sectionAngle}deg)`;
                section.style.zIndex = foods.length - index;

                const span = document.createElement('span');
                span.textContent = food.name; // Use actual food name
                section.appendChild(span);

                wheel.appendChild(section);
            });
        }
        
        // Spin the wheel
        function spin() {
            if (isSpinning) return;
            
            isSpinning = true;
            const spinButton = document.getElementById('spinButton');
            spinButton.disabled = true;
            spinButton.textContent = '🌪️ SPINNING...';
            
            const wheel = document.getElementById('wheel');
            const result = document.getElementById('result');
            
            // Hide previous result
            result.classList.remove('show');
            
            // Calculate random spin
            const minSpins = 5;
            const maxSpins = 10;
            const randomSpins = Math.random() * (maxSpins - minSpins) + minSpins;
            const finalRotation = randomSpins * 360;
            
            currentRotation += finalRotation;
            wheel.style.transform = `rotate(${currentRotation}deg)`;
            
            // Calculate which food was selected
            setTimeout(() => {
                const normalizedRotation = currentRotation % 360;
                const sectionAngle = 360 / foods.length;
                const selectedIndex = Math.floor((360 - normalizedRotation) / sectionAngle) % foods.length;
                const selectedFood = foods[selectedIndex];
                
                // Update stats
                spinCount++;
                lastPick = selectedFood.name;
                updateStats();
                
                // Show result
                document.getElementById('resultFood').textContent = selectedFood.name;
                document.getElementById('resultDescription').textContent = selectedFood.description;
                result.classList.add('show');
                
                // Add confetti effect
                createConfetti();
                
                // Re-enable button
                spinButton.disabled = false;
                spinButton.textContent = '🎲 SPIN AGAIN!';
                isSpinning = false;
                
            }, 4000);
        }
        
        // Create confetti effect
        function createConfetti() {
            const confettiColors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#ffeaa7', '#dda0dd'];
            
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.backgroundColor = confettiColors[Math.floor(Math.random() * confettiColors.length)];
                    confetti.style.animationDelay = Math.random() * 3 + 's';
                    confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
                    document.body.appendChild(confetti);
                    
                    setTimeout(() => {
                        confetti.remove();
                    }, 5000);
                }, i * 50);
            }
        }
        
        // Update statistics
        function updateStats() {
            document.getElementById('spinCount').textContent = spinCount;
            document.getElementById('lastPick').textContent = lastPick;
        }
        
        // Reset statistics
        function resetStats() {
            spinCount = 0;
            lastPick = '-';
            updateStats();
            document.getElementById('result').classList.remove('show');
        }
        
        // Event listeners
        document.getElementById('spinButton').addEventListener('click', spin);
        document.getElementById('resetButton').addEventListener('click', resetStats);
        
        // Initialize the game
        initWheel();
        updateStats();

        // Navbar Shrink on Scroll
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.padding = '10px 0';
            } else {
                navbar.style.padding = '20px 0';
            }
        });

        // Responsive Menu Toggle
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');
        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            menuToggle.textContent = navLinks.classList.contains('active') ? '✕' : '☰';
        });

    </script>
</body>
</html>