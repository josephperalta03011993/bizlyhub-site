<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A web application for helping students find there perfect career">
    <meta name="author" content="Joseph D. Peralta">
    <link rel="icon" type="image/png" href="../favicon.ico">
    <title>Career Path Discovery Hub - Find Your Perfect Career</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .hero {
            text-align: center;
            color: white;
            padding: 60px 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-bottom: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #fff, #f0f8ff);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { text-shadow: 0 0 20px rgba(255, 255, 255, 0.5); }
            to { text-shadow: 0 0 30px rgba(255, 255, 255, 0.8); }
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .cta-button {
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.6);
        }

        .section {
            background: white;
            margin: 30px 0;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .section:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 2.2rem;
            background: linear-gradient(45deg, #667eea, #764ba2);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .assessment-tool {
            background: linear-gradient(135deg, #74b9ff, #0984e3);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin: 20px 0;
        }

        .quiz-container {
            display: none;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
        }

        .quiz-container.active {
            display: block;
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .question {
            margin: 20px 0;
        }

        .question h4 {
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 10px;
        }

        .option {
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .option:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.02);
        }

        .option.selected {
            border-color: #ff6b6b;
            background: rgba(255, 107, 107, 0.3);
        }

        .career-paths {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .career-card {
            background: linear-gradient(135deg, #a8edea, #fed6e3);
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .career-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }

        .career-card:hover::before {
            animation: shimmer 1.5s ease-in-out;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); opacity: 0; }
        }

        .career-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .career-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .career-card h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 1.4rem;
        }

        .resources {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .resource-item {
            background: linear-gradient(135deg, #ffecd2, #fcb69f);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 3px solid transparent;
        }

        .resource-item:hover {
            transform: scale(1.05);
            border-color: #ff6b6b;
            box-shadow: 0 10px 25px rgba(255, 107, 107, 0.3);
        }

        .step-process {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 30px 0;
        }

        .step {
            flex: 1;
            min-width: 250px;
            margin: 10px;
            padding: 30px 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px;
            text-align: center;
            position: relative;
            transition: all 0.3s ease;
        }

        .step:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }

        .step-number {
            background: rgba(255, 255, 255, 0.2);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .progress-bar {
            width: 100%;
            height: 10px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            margin: 20px 0;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            width: 0%;
            transition: width 1s ease;
            border-radius: 5px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 2rem;
            cursor: pointer;
            color: #666;
        }

        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .section {
                padding: 20px;
            }
            
            .step-process {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating-shape" style="width: 100px; height: 100px; top: 10%; left: 10%; animation-delay: 0s;"></div>
        <div class="floating-shape" style="width: 150px; height: 150px; top: 20%; right: 15%; animation-delay: 2s;"></div>
        <div class="floating-shape" style="width: 80px; height: 80px; bottom: 20%; left: 20%; animation-delay: 4s;"></div>
        <div class="floating-shape" style="width: 120px; height: 120px; bottom: 10%; right: 10%; animation-delay: 1s;"></div>
    </div>

    <div class="container">
        <div class="hero">
            <h1>🚀 Career Path Discovery Hub</h1>
            <p>Feeling lost about your career? You're not alone. Let's discover your perfect path together!</p>
            <button class="cta-button" onclick="startJourney()">Start Your Journey</button>
        </div>

        <div class="section">
            <h2>🧭 Take Our Career Assessment</h2>
            <div class="assessment-tool">
                <h3>Discover Your Career Personality</h3>
                <p>Answer a few questions to uncover careers that match your interests, skills, and values.</p>
                <br><button class="cta-button" onclick="startAssessment()">Take Assessment</button>
                
                <div id="quizContainer" class="quiz-container">
                    <div class="progress-bar">
                        <div id="progressFill" class="progress-fill"></div>
                    </div>
                    <div id="currentQuestion"></div>
                    <button class="cta-button" onclick="nextQuestion()" id="nextBtn" style="display: none;">Next Question</button>
                    <button class="cta-button" onclick="showResults()" id="resultsBtn" style="display: none;">See My Results</button>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>💼 Popular Career Paths</h2>
            <div class="career-paths">
                <div class="career-card" onclick="showCareerDetails('technology')">
                    <div class="career-icon">💻</div>
                    <h3>Technology</h3>
                    <p>Software development, data science, cybersecurity, and more</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('healthcare')">
                    <div class="career-icon">🏥</div>
                    <h3>Healthcare</h3>
                    <p>Nursing, medicine, therapy, medical research</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('business')">
                    <div class="career-icon">📊</div>
                    <h3>Business</h3>
                    <p>Marketing, finance, consulting, entrepreneurship</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('creative')">
                    <div class="career-icon">🎨</div>
                    <h3>Creative Arts</h3>
                    <p>Design, writing, photography, digital media</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('education')">
                    <div class="career-icon">📚</div>
                    <h3>Education</h3>
                    <p>Teaching, training, educational leadership</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('trades')">
                    <div class="career-icon">🔧</div>
                    <h3>Skilled Trades</h3>
                    <p>Electrician, plumber, carpenter, mechanic</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('engineering')">
                    <div class="career-icon">⚙️</div>
                    <h3>Engineering</h3>
                    <p>Civil, mechanical, electrical, chemical engineering</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('science')">
                    <div class="career-icon">🔬</div>
                    <h3>Science & Research</h3>
                    <p>Biology, chemistry, physics, environmental science</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('law')">
                    <div class="career-icon">⚖️</div>
                    <h3>Law & Legal</h3>
                    <p>Attorney, paralegal, legal consultant, judge</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('media')">
                    <div class="career-icon">📺</div>
                    <h3>Media & Communications</h3>
                    <p>Journalism, broadcasting, public relations, social media</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('hospitality')">
                    <div class="career-icon">🏨</div>
                    <h3>Hospitality & Tourism</h3>
                    <p>Hotel management, event planning, travel, restaurants</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('nonprofit')">
                    <div class="career-icon">🤲</div>
                    <h3>Non-Profit & Social Services</h3>
                    <p>Social work, community outreach, advocacy, fundraising</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('transportation')">
                    <div class="career-icon">🚛</div>
                    <h3>Transportation & Logistics</h3>
                    <p>Supply chain, trucking, aviation, shipping</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('agriculture')">
                    <div class="career-icon">🌾</div>
                    <h3>Agriculture & Environment</h3>
                    <p>Farming, forestry, environmental conservation, sustainability</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('sports')">
                    <div class="career-icon">⚽</div>
                    <h3>Sports & Fitness</h3>
                    <p>Personal training, sports management, recreation, coaching</p>
                </div>
                <div class="career-card" onclick="showCareerDetails('government')">
                    <div class="career-icon">🏛️</div>
                    <h3>Government & Public Service</h3>
                    <p>Civil service, military, policy analysis, administration</p>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>📋 Your 5-Step Career Discovery Process</h2>
            <div class="step-process">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Self-Assessment</h3>
                    <p>Identify your interests, skills, values, and personality traits</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Explore Options</h3>
                    <p>Research careers that align with your assessment results</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Get Experience</h3>
                    <p>Volunteer, intern, or shadow professionals in your fields of interest</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Develop Skills</h3>
                    <p>Take courses, earn certifications, or pursue relevant education</p>
                </div>
                <div class="step">
                    <div class="step-number">5</div>
                    <h3>Take Action</h3>
                    <p>Apply for positions, network, and launch your career</p>
                </div>
            </div>
        </div>

        <div class="section">
        <h2>Career Development Resources</h2>
        <div class="resources">
            <div class="resource-item">
                <h3>Resume Tips</h3>
                <p>Highlight skills with action verbs (e.g., "Developed a website that increased traffic by 30%"). Keep it to one page and tailor it to each job.</p>
            </div>
            <div class="resource-item">
                <h3>Interview Strategies</h3>
                <p>Practice STAR method (Situation, Task, Action, Result) to answer questions. Research the company and prepare 2-3 questions to ask.</p>
            </div>
            <div class="resource-item">
                <h3>Networking Tips</h3>
                <p>Connect on LinkedIn with a personalized message (e.g., "I admired your project on X"). Attend industry events or virtual webinars.</p>
            </div>
            <div class="resource-item">
                <h3>Salary Insights</h3>
                <p>Check salary ranges on sites like Glassdoor or Payscale. For tech roles, expect $60K-$120K for entry-level; adjust for your region.</p>
            </div>
            <div class="resource-item">
                <h3>Learning Platforms</h3>
                <p>Explore free courses on Coursera (e.g., "Digital Marketing") or YouTube (e.g., "CrashCourse"). Focus on skills like coding or data analysis.</p>
            </div>
            <div class="resource-item">
                <h3>Career Planning</h3>
                <p>Set a 6-month goal (e.g., learn Python). Create a weekly schedule and track progress with a journal or app like Trello.</p>
            </div>
        </div>
    </div>

    <!-- Modal for career details -->
    <div id="careerModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <div id="modalContent"></div>
        </div>
    </div>

    <script>
        let currentQuestionIndex = 0;
        let answers = [];
        
        const questions = [
            {
                question: "What type of work environment energizes you most?",
                options: [
                    { text: "Collaborative team settings", category: "social" },
                    { text: "Independent, quiet spaces", category: "analytical" },
                    { text: "Dynamic, fast-paced environments", category: "entrepreneurial" },
                    { text: "Creative, flexible workspaces", category: "creative" }
                ]
            },
            {
                question: "Which activities do you find most fulfilling?",
                options: [
                    { text: "Solving complex problems", category: "analytical" },
                    { text: "Helping and teaching others", category: "social" },
                    { text: "Creating and designing", category: "creative" },
                    { text: "Leading projects and teams", category: "entrepreneurial" }
                ]
            },
            {
                question: "What motivates you most in work?",
                options: [
                    { text: "Making a positive impact on society", category: "social" },
                    { text: "Intellectual challenges and learning", category: "analytical" },
                    { text: "Creative expression and innovation", category: "creative" },
                    { text: "Building something valuable and profitable", category: "entrepreneurial" }
                ]
            },
            {
                question: "Which skills come most naturally to you?",
                options: [
                    { text: "Communication and interpersonal skills", category: "social" },
                    { text: "Logical thinking and data analysis", category: "analytical" },
                    { text: "Artistic and design abilities", category: "creative" },
                    { text: "Leadership and strategic planning", category: "entrepreneurial" }
                ]
            }
        ];

        const careerData = {
            technology: {
                title: "Technology Careers",
                icon: "💻",
                description: "The tech industry offers diverse opportunities for problem-solvers and innovators.",
                roles: [
                    "Software Developer - Design and build applications",
                    "Data Scientist - Analyze data to drive business decisions",
                    "Cybersecurity Specialist - Protect digital assets",
                    "UX/UI Designer - Create user-friendly interfaces",
                    "DevOps Engineer - Streamline development processes"
                ],
                skills: ["Programming", "Problem-solving", "Technical communication", "Continuous learning"],
                education: "Bachelor's degree in Computer Science or related field, coding bootcamps, self-taught with portfolio",
                growth: "Expected to grow 13% from 2020-2030, much faster than average"
            },
            healthcare: {
                title: "Healthcare Careers",
                icon: "🏥",
                description: "Healthcare professionals make a direct impact on people's lives and well-being.",
                roles: [
                    "Registered Nurse - Provide patient care and education",
                    "Physical Therapist - Help patients recover mobility",
                    "Medical Technologist - Perform diagnostic tests",
                    "Healthcare Administrator - Manage healthcare facilities",
                    "Mental Health Counselor - Provide therapy and support"
                ],
                skills: ["Empathy", "Attention to detail", "Communication", "Physical stamina"],
                education: "Varies from certificates to doctoral degrees depending on role",
                growth: "Healthcare is one of the fastest-growing sectors"
            },
            business: {
                title: "Business Careers",
                icon: "📊",
                description: "Business roles drive organizational success through strategy, operations, and relationships.",
                roles: [
                    "Marketing Manager - Develop brand strategies",
                    "Financial Analyst - Analyze investment opportunities",
                    "Project Manager - Lead cross-functional teams",
                    "Sales Representative - Build client relationships",
                    "Business Analyst - Improve business processes"
                ],
                skills: ["Communication", "Strategic thinking", "Leadership", "Analytical skills"],
                education: "Bachelor's degree in business, MBA for senior roles",
                growth: "Steady growth across most business functions"
            },
            creative: {
                title: "Creative Arts Careers",
                icon: "🎨",
                description: "Creative careers allow you to express yourself while solving visual and communication challenges.",
                roles: [
                    "Graphic Designer - Create visual communications",
                    "Content Writer - Develop engaging written content",
                    "Photographer - Capture compelling images",
                    "Video Editor - Create engaging visual stories",
                    "Art Director - Lead creative projects"
                ],
                skills: ["Creativity", "Visual thinking", "Software proficiency", "Client communication"],
                education: "Bachelor's in relevant field, strong portfolio essential",
                growth: "Growing demand for digital content creators"
            },
            education: {
                title: "Education Careers",
                icon: "📚",
                description: "Education professionals shape future generations and facilitate lifelong learning.",
                roles: [
                    "Teacher - Educate students in specific subjects",
                    "Instructional Designer - Create learning materials",
                    "School Counselor - Support student development",
                    "Training Specialist - Develop workplace training",
                    "Education Administrator - Lead educational institutions"
                ],
                skills: ["Communication", "Patience", "Organization", "Adaptability"],
                education: "Bachelor's degree, teaching certification, often master's required",
                growth: "Steady demand, especially in specialized areas"
            },
            trades: {
                title: "Skilled Trades Careers",
                icon: "🔧",
                description: "Skilled trades offer stable, well-paying careers with hands-on work and clear career paths.",
                roles: [
                    "Electrician - Install and maintain electrical systems",
                    "Plumber - Install and repair water systems",
                    "Carpenter - Build and repair structures",
                    "HVAC Technician - Maintain heating and cooling systems",
                    "Automotive Technician - Repair and maintain vehicles"
                ],
                skills: ["Manual dexterity", "Problem-solving", "Physical fitness", "Attention to detail"],
                education: "Apprenticeships, trade schools, on-the-job training",
                growth: "Strong demand, difficult to outsource, good job security"
            },
            engineering: {
                title: "Engineering Careers",
                icon: "⚙️",
                description: "Engineers design, build, and maintain the infrastructure and systems that power our world.",
                roles: [
                    "Civil Engineer - Design infrastructure and buildings",
                    "Mechanical Engineer - Develop machines and mechanical systems",
                    "Electrical Engineer - Work with electrical systems and components",
                    "Chemical Engineer - Design processes for manufacturing",
                    "Environmental Engineer - Solve environmental problems"
                ],
                skills: ["Mathematical ability", "Problem-solving", "Technical drawing", "Project management"],
                education: "Bachelor's degree in engineering, PE license for some roles",
                growth: "Steady growth, especially in renewable energy and infrastructure"
            },
            science: {
                title: "Science & Research Careers",
                icon: "🔬",
                description: "Scientists advance human knowledge through research, experimentation, and discovery.",
                roles: [
                    "Research Scientist - Conduct experiments and studies",
                    "Laboratory Technician - Support scientific research",
                    "Environmental Scientist - Study environmental problems",
                    "Biotechnologist - Apply biology to develop products",
                    "Quality Control Analyst - Ensure product standards"
                ],
                skills: ["Analytical thinking", "Attention to detail", "Research methods", "Scientific writing"],
                education: "Bachelor's degree minimum, advanced degrees for research roles",
                growth: "Growing demand in biotechnology and environmental sciences"
            },
            law: {
                title: "Law & Legal Careers",
                icon: "⚖️",
                description: "Legal professionals uphold justice and provide essential services in our legal system.",
                roles: [
                    "Attorney - Represent clients in legal matters",
                    "Paralegal - Assist lawyers with case preparation",
                    "Legal Secretary - Provide administrative support",
                    "Court Reporter - Record legal proceedings",
                    "Legal Consultant - Provide specialized legal advice"
                ],
                skills: ["Critical thinking", "Research skills", "Communication", "Ethics"],
                education: "Law degree (JD) for attorneys, certificates for paralegals",
                growth: "Steady demand, especially in corporate and healthcare law"
            },
            media: {
                title: "Media & Communications Careers",
                icon: "📺",
                description: "Media professionals inform, entertain, and connect people through various communication channels.",
                roles: [
                    "Journalist - Research and report news stories",
                    "Public Relations Specialist - Manage public image",
                    "Social Media Manager - Develop online presence",
                    "Broadcast Technician - Operate broadcasting equipment",
                    "Content Creator - Produce digital media content"
                ],
                skills: ["Communication", "Writing", "Digital literacy", "Creativity"],
                education: "Bachelor's degree in communications, journalism, or related field",
                growth: "Evolving rapidly with digital media expansion"
            },
            hospitality: {
                title: "Hospitality & Tourism Careers",
                icon: "🏨",
                description: "Hospitality professionals create memorable experiences for travelers and guests.",
                roles: [
                    "Hotel Manager - Oversee hotel operations",
                    "Event Planner - Organize and coordinate events",
                    "Travel Agent - Help clients plan trips",
                    "Restaurant Manager - Manage dining establishments",
                    "Tour Guide - Lead and educate tourists"
                ],
                skills: ["Customer service", "Organization", "Cultural awareness", "Communication"],
                education: "Associate or bachelor's degree in hospitality management",
                growth: "Recovery expected post-pandemic, strong long-term growth"
            },
            nonprofit: {
                title: "Non-Profit & Social Services Careers",
                icon: "🤲",
                description: "Social service professionals work to improve communities and help those in need.",
                roles: [
                    "Social Worker - Provide support and advocacy",
                    "Program Coordinator - Manage community programs",
                    "Grant Writer - Secure funding for organizations",
                    "Community Organizer - Mobilize communities for change",
                    "Fundraising Specialist - Raise money for causes"
                ],
                skills: ["Empathy", "Communication", "Grant writing", "Program management"],
                education: "Bachelor's or master's degree in social work or related field",
                growth: "Steady demand driven by social needs and aging population"
            },
            transportation: {
                title: "Transportation & Logistics Careers",
                icon: "🚛",
                description: "Transportation professionals keep goods and people moving efficiently across the globe.",
                roles: [
                    "Logistics Coordinator - Manage supply chain operations",
                    "Truck Driver - Transport goods across distances",
                    "Air Traffic Controller - Direct aircraft movements",
                    "Supply Chain Analyst - Optimize distribution processes",
                    "Warehouse Manager - Oversee storage and distribution"
                ],
                skills: ["Organization", "Attention to detail", "Problem-solving", "Communication"],
                education: "Varies from high school diploma to bachelor's degree",
                growth: "Strong growth driven by e-commerce and global trade"
            },
            agriculture: {
                title: "Agriculture & Environment Careers",
                icon: "🌾",
                description: "Agricultural professionals feed the world while protecting our natural environment.",
                roles: [
                    "Agricultural Scientist - Research crop improvement",
                    "Farm Manager - Oversee agricultural operations",
                    "Environmental Consultant - Advise on environmental issues",
                    "Forestry Technician - Manage forest resources",
                    "Sustainability Specialist - Develop eco-friendly practices"
                ],
                skills: ["Scientific knowledge", "Problem-solving", "Physical fitness", "Environmental awareness"],
                education: "Associate or bachelor's degree in agriculture or environmental science",
                growth: "Growing focus on sustainable practices and food security"
            },
            sports: {
                title: "Sports & Fitness Careers",
                icon: "⚽",
                description: "Sports and fitness professionals promote health, wellness, and athletic achievement.",
                roles: [
                    "Personal Trainer - Help clients achieve fitness goals",
                    "Sports Coach - Train and develop athletes",
                    "Athletic Director - Manage sports programs",
                    "Sports Therapist - Treat sports-related injuries",
                    "Recreation Coordinator - Plan fitness and sports activities"
                ],
                skills: ["Physical fitness", "Motivation", "Communication", "Sports knowledge"],
                education: "Certifications and bachelor's degree in exercise science or related field",
                growth: "Growing emphasis on health and wellness drives demand"
            },
            government: {
                title: "Government & Public Service Careers",
                icon: "🏛️",
                description: "Public service professionals work to serve citizens and maintain effective government operations.",
                roles: [
                    "Civil Servant - Provide government services",
                    "Policy Analyst - Research and develop policies",
                    "Military Officer - Lead and serve in armed forces",
                    "City Planner - Design community development",
                    "Public Administrator - Manage government programs"
                ],
                skills: ["Public service orientation", "Communication", "Leadership", "Analytical thinking"],
                education: "Varies from high school diploma to advanced degrees",
                growth: "Stable employment with benefits, steady demand"
            }
        };

        function startJourney() {
            document.querySelector('.hero').scrollIntoView({ behavior: 'smooth' });
            setTimeout(() => {
                document.querySelector('.assessment-tool').style.background = 'linear-gradient(135deg, #ff6b6b, #ee5a52)';
                setTimeout(() => {
                    document.querySelector('.assessment-tool').style.background = 'linear-gradient(135deg, #74b9ff, #0984e3)';
                }, 1000);
            }, 500);
        }

        function startAssessment() {
            const container = document.getElementById('quizContainer');
            container.classList.add('active');
            currentQuestionIndex = 0;
            answers = [];
            showQuestion();
        }

        function showQuestion() {
            if (currentQuestionIndex < questions.length) {
                const question = questions[currentQuestionIndex];
                const questionHTML = `
                    <div class="question">
                        <h4>Question ${currentQuestionIndex + 1} of ${questions.length}</h4>
                        <h3>${question.question}</h3>
                        <div class="options">
                            ${question.options.map((option, index) => `
                                <div class="option" onclick="selectOption(${index})">
                                    ${option.text}
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
                document.getElementById('currentQuestion').innerHTML = questionHTML;
                updateProgress();
            }
        }

        function selectOption(optionIndex) {
            const options = document.querySelectorAll('.option');
            options.forEach(opt => opt.classList.remove('selected'));
            options[optionIndex].classList.add('selected');
            
            answers[currentQuestionIndex] = questions[currentQuestionIndex].options[optionIndex];
            
            document.getElementById('nextBtn').style.display = 'inline-block';
            if (currentQuestionIndex === questions.length - 1) {
                document.getElementById('nextBtn').style.display = 'none';
                document.getElementById('resultsBtn').style.display = 'inline-block';
            }
        }

        function nextQuestion() {
            currentQuestionIndex++;
            showQuestion();
            document.getElementById('nextBtn').style.display = 'none';
        }

        function updateProgress() {
            const progress = ((currentQuestionIndex + 1) / questions.length) * 100;
            document.getElementById('progressFill').style.width = progress + '%';
        }

        function showResults() {
            const categories = {};
            answers.forEach(answer => {
                categories[answer.category] = (categories[answer.category] || 0) + 1;
            });

            const topCategory = Object.keys(categories).reduce((a, b) => 
                categories[a] > categories[b] ? a : b
            );

            const recommendations = {
                analytical: ["Technology", "Healthcare Research", "Finance", "Engineering"],
                social: ["Healthcare", "Education", "Social Work", "Human Resources"],
                creative: ["Creative Arts", "Marketing", "Architecture", "Entertainment"],
                entrepreneurial: ["Business", "Sales", "Consulting", "Startup Ventures"]
            };

            const resultHTML = `
                <div class="question">
                    <h3>🎉 Your Career Assessment Results</h3>
                    <p><strong>Your Primary Career Personality:</strong> ${topCategory.charAt(0).toUpperCase() + topCategory.slice(1)}</p>
                    <p><strong>Recommended Career Areas:</strong></p>
                    <ul>
                        ${recommendations[topCategory].map(rec => `<li>${rec}</li>`).join('')}
                    </ul>
                    <p>Explore the career cards below to learn more about these fields!</p>
                </div>
            `;
            document.getElementById('currentQuestion').innerHTML = resultHTML;
            document.getElementById('resultsBtn').style.display = 'none';
        }

        function showCareerDetails(career) {
            const data = careerData[career];
            const modalContent = `
                <div style="text-align: center;">
                    <div style="font-size: 4rem; margin-bottom: 20px;">${data.icon}</div>
                    <h2>${data.title}</h2>
                    <p style="font-size: 1.2rem; margin: 20px 0;">${data.description}</p>
                    
                    <div style="text-align: left; margin: 30px 0;">
                        <h3>🎯 Common Roles:</h3>
                        <ul>
                            ${data.roles.map(role => `<li>${role}</li>`).join('')}
                        </ul>
                        
                        <h3>💪 Key Skills:</h3>
                        <ul>
                            ${data.skills.map(skill => `<li>${skill}</li>`).join('')}
                        </ul>
                        
                        <h3>🎓 Education Requirements:</h3>
                        <p>${data.education}</p>
                        
                        <h3>📈 Job Market Outlook:</h3>
                        <p>${data.growth}</p>
                    </div>
                    
                    <button class="cta-button" onclick="closeModal()">Explore More Careers</button>
                </div>
            `;
            document.getElementById('modalContent').innerHTML = modalContent;
            document.getElementById('careerModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('careerModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('careerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Add some interactive animations on scroll
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }
            });
        });

        // Initialize sections with fade-in effect
        document.addEventListener('DOMContentLoaded', () => {
            const sections = document.querySelectorAll('.section');
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(50px)';
                setTimeout(() => {
                    section.style.transition = 'all 0.8s ease';
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });

        // Add hover effects to career cards
        document.addEventListener('DOMContentLoaded', () => {
            const careerCards = document.querySelectorAll('.career-card');
            careerCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-10px) scale(1.05)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0) scale(1)';
                });
            });
        });

        // Smooth scrolling for internal links
        function scrollToSection(sectionId) {
            document.getElementById(sectionId).scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }

        // Add dynamic particles effect
        function createParticle() {
            const particle = document.createElement('div');
            particle.style.position = 'fixed';
            particle.style.width = '4px';
            particle.style.height = '4px';
            particle.style.background = 'rgba(255, 255, 255, 0.6)';
            particle.style.borderRadius = '50%';
            particle.style.pointerEvents = 'none';
            particle.style.zIndex = '-1';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = '100%';
            
            document.body.appendChild(particle);
            
            const animation = particle.animate([
                { transform: 'translateY(0) rotate(0deg)', opacity: 1 },
                { transform: `translateY(-${window.innerHeight + 100}px) rotate(360deg)`, opacity: 0 }
            ], {
                duration: Math.random() * 3000 + 2000,
                easing: 'linear'
            });
            
            animation.addEventListener('finish', () => {
                particle.remove();
            });
        }

        // Create floating particles periodically
        setInterval(createParticle, 700);

        // Add interactive tips system
        const tips = [
            "💡 Tip: Most successful careers combine passion with practical skills!",
            "🎯 Tip: Networking is just as important as qualifications in many fields.",
            "📚 Tip: Continuous learning is key in today's rapidly changing job market.",
            "🤝 Tip: Consider informational interviews to learn about different careers.",
            "🌟 Tip: Your first job doesn't have to be your dream job - it's a stepping stone!"
        ];

        function showRandomTip() {
            const tipElement = document.createElement('div');
            tipElement.innerHTML = tips[Math.floor(Math.random() * tips.length)];
            tipElement.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: linear-gradient(45deg, #ff6b6b, #ee5a52);
                color: white;
                padding: 15px 20px;
                border-radius: 10px;
                box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
                z-index: 1000;
                font-size: 0.9rem;
                max-width: 300px;
                animation: slideIn 0.5s ease;
            `;
            
            document.body.appendChild(tipElement);
            
            setTimeout(() => {
                tipElement.style.animation = 'slideOut 0.5s ease forwards';
                setTimeout(() => tipElement.remove(), 500);
            }, 4000);
        }

        // Show tip every 30 seconds
        setTimeout(() => {
            showRandomTip();
            setInterval(showRandomTip, 30000);
        }, 10000);

        // Add CSS animations for tips
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>