<?php
// Handle form submission
$message = '';
$messageType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    if (empty($_POST['name']) || empty($_POST['mobile'])) {
        $message = "Name and mobile number are required.";
        $messageType = "error";
    } else {
        // Sanitize inputs
        $name = htmlspecialchars(trim($_POST['name']));
        $mobile = htmlspecialchars(trim($_POST['mobile']));
        $email = !empty($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : 'Not provided';
        $unit_preference = isset($_POST['unit_preference']) ? htmlspecialchars(trim($_POST['unit_preference'])) : 'Not specified';
        
        // Validate email format if provided
        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $message = "Please enter a valid email address.";
            $messageType = "error";
        } else {
            // Email configuration
            $to = "arsalan.sayyad1994@gmail.com"; // Your email
            $subject = "New Enquiry - Nyati Equinox: $name";
            $email_message = "
Nyati Equinox - New Enquiry Received:

Name: $name
Mobile: $mobile
Email: $email
Unit Preference: $unit_preference

Enquiry Time: " . date('Y-m-d H:i:s') . "
";

            $headers = "From: Your Website <no-reply@yourwebsite.com>\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            // Try to send email
            if (mail($to, $subject, $email_message, $headers)) {
                $message = "Thank you! Your enquiry has been sent.";
                $messageType = "success";
            } else {
                $message = "Sorry, something went wrong. Please try again later.";
                $messageType = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyati Equinox - Codename 2.0</title>
    <meta name="description" content="Nyati Equinox Bavdhan Pune - Premium 2, 3 & 4 BHK Flats starting from ₹98 Lakhs onwards. Possession Dec 2027. Enquire now!">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            scroll-behavior: smooth;
        }
       
        .text-shadow-hero {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.6);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            padding-top: 50px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            position: relative;
            max-width: 90%;
            animation: slideUp 0.3s ease-out;
        }
        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .close-btn {
            color: #aaa;
            position: absolute;
            top: 15px;
            right: 25px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }
        .close-btn:hover,
        .close-btn:focus {
            color: #333;
            text-decoration: none;
            cursor: pointer;
        }
        .text-overlay {
            background-color: rgba(0, 0, 0, 0.6);
            transition: background-color 0.3s ease;
        }
        .text-overlay:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
        .project-image-box {
          position: relative;
          overflow: hidden;
        }
        .project-image {
          width: 100%;
          transition: transform 0.5s ease;
        }
        .project-image-box:hover .project-image {
          transform: scale(1.05);
        }
        @media (min-width: 1024px) {
            .lead-form-container {
                width: 400px;
                position: fixed;
                top: 50%;
                right: 20px;
                transform: translateY(-50%);
                z-index: 50;
            }
        }
        .alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: opacity 0.5s ease;
            z-index: 1000;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .tab {
          cursor: pointer;
          transition: background-color 0.3s ease;
        }
        .tab.active {
          background-color: #1a5276;
          color: white;
        }
        .tab-content {
          display: none;
        }
        .tab-content.active {
          display: block;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Header & Hero Section -->
    <header class="relative h-screen flex items-center justify-center text-white text-center overflow-hidden">
        <!-- Background Image/Video -->
        <!-- FIX: Replaced broken image URL with a placeholder URL -->
        <img src="gallery1.jpgr" alt="Nyati Equinox Banner" class="absolute inset-0 w-full h-full object-cover z-0">
        <div class="absolute inset-0 bg-black opacity-50 z-10"></div>
        
        <!-- Hero Content -->
        <div class="relative z-20 p-6 md:p-12 lg:p-20 bg-gray-900 bg-opacity-40 rounded-3xl backdrop-blur-sm mx-4">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 animate-fade-in text-shadow-hero">
                Nyati Equinox, Bavdhan, Pune
            </h1>
            <p class="text-xl md:text-2xl font-light mb-6 animate-fade-in-up">
                Premium 2, 3 & 4 BHK Flats
            </p>
            <p class="text-lg md:text-xl font-medium mb-8 animate-fade-in-up">
                Starting from <span class="text-green-400 font-bold">₹98 Lakhs*</span> onwards
            </p>
            <div class="space-x-4">
                <a href="#amenities" class="bg-white text-blue-800 font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out hover:bg-blue-800 hover:text-white hover:shadow-lg">
                    Explore Amenities
                </a>
                <a href="#contact" class="bg-green-500 text-white font-bold py-3 px-6 rounded-full transition duration-300 ease-in-out hover:bg-green-600 hover:shadow-lg">
                    Contact Us
                </a>
            </div>
        </div>
    </header>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $messageType; ?>">
            <p><?php echo htmlspecialchars($message); ?></p>
        </div>
    <?php endif; ?>

    <!-- Floating Lead Form (Desktop Only) -->
    <div class="hidden lg:block lead-form-container bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        <h3 class="text-xl font-bold mb-4 text-center text-blue-800">Get a Call Back</h3>
        <form id="enquiryForm" action="" method="POST" class="space-y-4">
            <input type="hidden" name="source" value="Website Lead Form">
            <div>
                <input type="text" name="name" placeholder="Your Name" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <input type="tel" name="mobile" placeholder="Mobile Number" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <input type="email" name="email" placeholder="Email (Optional)" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <select name="unit_preference" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="2 BHK">2 BHK</option>
                    <option value="3 BHK">3 BHK</option>
                    <option value="4 BHK">4 BHK</option>
                </select>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="consent" name="consent" required class="form-checkbox h-4 w-4 text-blue-600 rounded">
                <label for="consent" class="ml-2 text-sm text-gray-600">
                    I agree to the <a href="#" class="text-blue-500 hover:underline">terms and conditions</a>.
                </label>
            </div>
            <button type="submit" class="w-full bg-blue-700 text-white font-bold py-3 rounded-lg hover:bg-blue-800 transition duration-300 ease-in-out">
                Submit Enquiry
            </button>
        </form>
    </div>

    <!-- Main Content Sections -->
    <main>
        <!-- About Section -->
        <section id="about" class="py-16 md:py-24">
            <div class="container mx-auto px-4 md:px-8 max-w-7xl">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-blue-800 mb-4">About the Project</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Nyati Equinox is a landmark residential project in the heart of Bavdhan, Pune, offering a perfect blend of luxury and convenience.
                    </p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center text-center">
                        <i class="fas fa-building text-4xl text-blue-600 mb-4"></i>
                        <h4 class="text-xl font-semibold text-gray-800 mb-2">Prime Location</h4>
                        <p class="text-sm text-gray-500">Nestled in Bavdhan, offering excellent connectivity to key areas of Pune.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center text-center">
                        <i class="fas fa-home text-4xl text-blue-600 mb-4"></i>
                        <h4 class="text-xl font-semibold text-gray-800 mb-2">Spacious Homes</h4>
                        <p class="text-sm text-gray-500">Thoughtfully designed 2, 3 & 4 BHK apartments with modern layouts.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col items-center text-center">
                        <i class="fas fa-calendar-alt text-4xl text-blue-600 mb-4"></i>
                        <h4 class="text-xl font-semibold text-gray-800 mb-2">Timely Possession</h4>
                        <p class="text-sm text-gray-500">Project possession expected by December 2027.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Project Images Section -->
        <section id="images" class="py-16 md:py-24 bg-gray-50">
            <div class="container mx-auto px-4 md:px-8 max-w-7xl">
                <h2 class="text-3xl md:text-4xl font-bold text-center text-blue-800 mb-12">Project Glimpses</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- FIX: Replaced broken image URLs with placeholders -->
                    <div class="project-image-box rounded-xl shadow-lg">
                        <img src="https://placehold.co/600x400/808080/fff?text=Lobby+View" alt="Project Image 1" class="project-image rounded-xl">
                        <div class="text-overlay absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity rounded-xl">
                            <p class="text-white text-lg font-semibold">Lobby View</p>
                        </div>
                    </div>
                    <div class="project-image-box rounded-xl shadow-lg">
                        <img src="https://placehold.co/600x400/808080/fff?text=Swimming+Pool" alt="Project Image 2" class="project-image rounded-xl">
                        <div class="text-overlay absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity rounded-xl">
                            <p class="text-white text-lg font-semibold">Swimming Pool</p>
                        </div>
                    </div>
                    <div class="project-image-box rounded-xl shadow-lg">
                        <img src="https://placehold.co/600x400/808080/fff?text=Gym" alt="Project Image 3" class="project-image rounded-xl">
                        <div class="text-overlay absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity rounded-xl">
                            <p class="text-white text-lg font-semibold">Gymnasium</p>
                        </div>
                    </div>
                    <div class="project-image-box rounded-xl shadow-lg">
                        <img src="https://placehold.co/600x400/808080/fff?text=Clubhouse" alt="Project Image 4" class="project-image rounded-xl">
                        <div class="text-overlay absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity rounded-xl">
                            <p class="text-white text-lg font-semibold">Clubhouse</p>
                        </div>
                    </div>
                    <div class="project-image-box rounded-xl shadow-lg">
                        <img src="https://placehold.co/600x400/808080/fff?text=Kids+Area" alt="Project Image 5" class="project-image rounded-xl">
                        <div class="text-overlay absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity rounded-xl">
                            <p class="text-white text-lg font-semibold">Kids' Play Area</p>
                        </div>
                    </div>
                    <div class="project-image-box rounded-xl shadow-lg">
                        <img src="https://placehold.co/600x400/808080/fff?text=Garden" alt="Project Image 6" class="project-image rounded-xl">
                        <div class="text-overlay absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity rounded-xl">
                            <p class="text-white text-lg font-semibold">Lush Gardens</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Configuration & Pricing -->
        <section id="configurations" class="py-16 md:py-24">
          <div class="container mx-auto px-4 md:px-8 max-w-7xl">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-blue-800 mb-12">
              Unit Configurations
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- 2 BHK Card -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-bed text-3xl text-blue-600 mr-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800">2 BHK Homes</h3>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Spacious and well-designed 2BHK apartments perfect for nuclear families.
                    </p>
                    <ul class="text-gray-700 space-y-2 mb-6">
                        <li class="flex items-center">
                            <i class="fas fa-expand mr-2 text-blue-500"></i>
                            Carpet Area: <span class="font-semibold ml-1">750 - 850 Sq.ft</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-rupee-sign mr-2 text-blue-500"></i>
                            Starting From: <span class="font-semibold ml-1 text-green-600">₹98 Lacs*</span>
                        </li>
                    </ul>
                    <button class="bg-blue-700 text-white font-bold py-3 px-6 rounded-full w-full transition duration-300 ease-in-out hover:bg-blue-800 get-pricing-btn" data-unit-type="2 BHK">
                        <i class="fas fa-file-download mr-2"></i> Download Pricing
                    </button>
                </div>
                <!-- 3 BHK Card -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-bed text-3xl text-blue-600 mr-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800">3 BHK Homes</h3>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Luxurious 3BHK residences offering comfort and style for a modern lifestyle.
                    </p>
                    <ul class="text-gray-700 space-y-2 mb-6">
                        <li class="flex items-center">
                            <i class="fas fa-expand mr-2 text-blue-500"></i>
                            Carpet Area: <span class="font-semibold ml-1">1100 - 1250 Sq.ft</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-rupee-sign mr-2 text-blue-500"></i>
                            Starting From: <span class="font-semibold ml-1 text-green-600">₹1.5 Crores*</span>
                        </li>
                    </ul>
                    <button class="bg-blue-700 text-white font-bold py-3 px-6 rounded-full w-full transition duration-300 ease-in-out hover:bg-blue-800 get-pricing-btn" data-unit-type="3 BHK">
                        <i class="fas fa-file-download mr-2"></i> Download Pricing
                    </button>
                </div>
                <!-- 4 BHK Card -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-bed text-3xl text-blue-600 mr-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800">4 BHK Homes</h3>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Expansive 4BHK homes designed for those who desire ultimate luxury and space.
                    </p>
                    <ul class="text-gray-700 space-y-2 mb-6">
                        <li class="flex items-center">
                            <i class="fas fa-expand mr-2 text-blue-500"></i>
                            Carpet Area: <span class="font-semibold ml-1">1500 - 1700 Sq.ft</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-rupee-sign mr-2 text-blue-500"></i>
                            Starting From: <span class="font-semibold ml-1 text-green-600">₹2.1 Crores*</span>
                        </li>
                    </ul>
                    <button class="bg-blue-700 text-white font-bold py-3 px-6 rounded-full w-full transition duration-300 ease-in-out hover:bg-blue-800 get-pricing-btn" data-unit-type="4 BHK">
                        <i class="fas fa-file-download mr-2"></i> Download Pricing
                    </button>
                </div>
            </div>
          </div>
        </section>

        <!-- Location & Connectivity Section -->
        <section id="location" class="py-16 md:py-24 bg-gray-50">
            <div class="container mx-auto px-4 md:px-8 max-w-7xl">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-blue-800 mb-4">Strategic Location</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Nyati Equinox is located in the well-connected and rapidly developing Bavdhan, Pune.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="map-container rounded-xl shadow-lg overflow-hidden h-96">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15129.54013404172!2d73.7656209!3d18.575677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2bf931d68305f%3A0x647b0a7b54a26e83!2sBavdhan%2C%20Pune%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1678289456201!5m2!1sen!2sin" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <i class="fas fa-road text-2xl text-blue-600 mr-4 mt-1"></i>
                            <div>
                                <h4 class="text-xl font-semibold text-gray-800">Excellent Connectivity</h4>
                                <p class="text-gray-600">Seamless access to Mumbai-Pune Expressway, Hinjewadi IT Park, and major city hubs.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-university text-2xl text-blue-600 mr-4 mt-1"></i>
                            <div>
                                <h4 class="text-xl font-semibold text-gray-800">Proximity to Institutions</h4>
                                <p class="text-gray-600">Close to reputed schools, colleges, and hospitals.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-shopping-bag text-2xl text-blue-600 mr-4 mt-1"></i>
                            <div>
                                <h4 class="text-xl font-semibold text-gray-800">Shopping & Entertainment</h4>
                                <p class="text-gray-600">Enjoy easy access to shopping malls, restaurants, and multiplexes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Amenities Section -->
        <section id="amenities" class="py-16 md:py-24">
            <div class="container mx-auto px-4 md:px-8 max-w-7xl">
                <h2 class="text-3xl md:text-4xl font-bold text-center text-blue-800 mb-12">World-Class Amenities</h2>
                <div class="flex justify-center mb-8 space-x-2 md:space-x-4 flex-wrap">
                    <button class="tab px-4 py-2 md:px-6 md:py-3 rounded-full text-sm md:text-base font-semibold transition-all duration-300 active" data-tab="amenities-tab-1">
                        Lifestyle
                    </button>
                    <button class="tab px-4 py-2 md:px-6 md:py-3 rounded-full text-sm md:text-base font-semibold transition-all duration-300" data-tab="amenities-tab-2">
                        Wellness
                    </button>
                    <button class="tab px-4 py-2 md:px-6 md:py-3 rounded-full text-sm md:text-base font-semibold transition-all duration-300" data-tab="amenities-tab-3">
                        Recreation
                    </button>
                    <button class="tab px-4 py-2 md:px-6 md:py-3 rounded-full text-sm md:text-base font-semibold transition-all duration-300" data-tab="amenities-tab-4">
                        Security
                    </button>
                </div>
                
                <div id="amenities-tab-1" class="tab-content active grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-swimming-pool text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Swimming Pool</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-utensils text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Cafeteria</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-handshake text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Community Hall</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-car text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Ample Parking</p>
                    </div>
                </div>
                <div id="amenities-tab-2" class="tab-content grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-dumbbell text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Gymnasium</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-yoga text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Yoga Deck</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-tree text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Meditation Area</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-running text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Jogging Track</p>
                    </div>
                </div>
                <div id="amenities-tab-3" class="tab-content grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-futbol text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Sports Courts</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-biking text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Cycling Track</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-child text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Kids' Play Area</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-chess text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Indoor Games</p>
                    </div>
                </div>
                <div id="amenities-tab-4" class="tab-content grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-camera text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">CCTV Surveillance</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-user-shield text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">24/7 Security</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-fire-extinguisher text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Fire Safety</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md text-center flex flex-col items-center">
                        <i class="fas fa-power-off text-4xl text-blue-600 mb-3"></i>
                        <p class="text-lg font-semibold">Power Backup</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-16 md:py-24 bg-blue-800 text-white">
            <div class="container mx-auto px-4 md:px-8 max-w-7xl text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Get in Touch</h2>
                <p class="text-lg mb-8 max-w-2xl mx-auto">
                    Fill out the form below to receive a detailed brochure and pricing. Our team will contact you shortly.
                </p>
                <form id="contactForm" action="" method="POST" class="max-w-xl mx-auto space-y-4">
                    <input type="hidden" name="source" value="Website Contact Form">
                    <div>
                        <input type="text" name="name" placeholder="Your Name" required class="w-full p-3 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <input type="tel" name="mobile" placeholder="Mobile Number" required class="w-full p-3 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Email (Optional)" class="w-full p-3 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <select name="unit_preference" class="w-full p-3 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="2 BHK">2 BHK</option>
                            <option value="3 BHK">3 BHK</option>
                            <option value="4 BHK">4 BHK</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-green-500 text-white font-bold py-3 rounded-lg hover:bg-green-600 transition duration-300 ease-in-out">
                        Submit Enquiry
                    </button>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-4 md:px-8 text-center text-sm text-gray-400">
            <p>&copy; 2024 Nyati Equinox. All Rights Reserved.</p>
            <p class="mt-2">Disclaimer: All images and information are for representation purposes only. The company reserves the right to change any information without prior notice.</p>
        </div>
    </footer>

    <!-- Pricing Modal -->
    <div id="pricingModal" class="modal">
        <div class="modal-content bg-white max-w-md mx-auto p-8 rounded-xl shadow-2xl">
            <span class="close-btn">&times;</span>
            <h3 class="text-2xl font-bold mb-4 text-center text-blue-800">Download Pricing</h3>
            <p class="text-center text-gray-600 mb-6">Enter your details to get the pricing details for your chosen unit.</p>
            <form id="modalForm" action="" method="POST" class="space-y-4">
                <input type="hidden" name="source" value="Website Modal Form">
                <input type="hidden" id="unitPreferenceModal" name="unit_preference">
                <div>
                    <input type="text" name="name" placeholder="Your Name" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <input type="tel" name="mobile" placeholder="Mobile Number" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-blue-700 text-white font-bold py-3 rounded-lg hover:bg-blue-800 transition duration-300 ease-in-out">
                    <i class="fas fa-file-download mr-2"></i> Download Now
                </button>
            </form>
            <div id="modalThankYou" style="display: none;" class="text-center mt-6">
                <p class="text-green-600 font-semibold text-lg">Thank you! Your pricing PDF has been downloaded.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle the modal
            const modal = document.getElementById('pricingModal');
            const closeBtn = document.querySelector('.close-btn');
            const openModalBtns = document.querySelectorAll('.get-pricing-btn');
            const modalForm = document.getElementById('modalForm');
            const modalThankYou = document.getElementById('modalThankYou');
            const unitPreferenceModal = document.getElementById('unitPreferenceModal');

            function openModal(unitType) {
                unitPreferenceModal.value = unitType;
                modal.style.display = 'block';
                modalForm.style.display = 'block';
                modalThankYou.style.display = 'none';
            }

            function closeModal() {
                modal.style.display = 'none';
            }

            openModalBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const unitType = btn.dataset.unitType;
                    openModal(unitType);
                });
            });

            closeBtn.addEventListener('click', closeModal);

            window.onclick = function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            };
            
            // Handle smooth scrolling for all anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Clear messages after form submission success
            <?php if ($messageType === 'success'): ?>
                setTimeout(() => {
                    const alerts = document.querySelectorAll('.alert');
                    alerts.forEach(alert => {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 300);
                    });
                }, 5000);
            <?php endif; ?>
        });
        const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        tabContents.forEach(c => c.classList.remove('active'));
        document.getElementById(tab.dataset.tab).classList.add('active');
      });
    });
    </script>
</body>
</html>
