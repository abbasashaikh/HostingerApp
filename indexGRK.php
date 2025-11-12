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

            $headers = "From: Nyati Equinox <contact@abstechsolution.co.in>\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            // Try to send email
            try {
                $mailSent = mail($to, $subject, $email_message, $headers);
                
                if ($mailSent) {
                    $message = "Thank you for your enquiry! We will contact you soon.";
                    $messageType = "success";
                    // Clear form data after successful submission
                    $_POST = array();
                } else {
                    $message = "Sorry, there was an error sending your enquiry. Please try again.";
                    $messageType = "error";
                }
            } catch (Exception $e) {
                $message = "Sorry, there was an error processing your request. Please try again.";
                $messageType = "error";
            }
        }
    }
}

// Handle URL parameters for messages
if (isset($_GET['message'])) {
    switch ($_GET['message']) {
        case 'success':
            $message = "Thank you for your enquiry! We will contact you soon.";
            $messageType = "success";
            break;
        case 'error':
            $message = "Sorry, there was an error processing your request. Please try again.";
            $messageType = "error";
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyati Equinox: Luxury 2, 3 & 4 BHK Flats in Bavdhan, Pune</title>
    <meta name="description" content="Nyati Equinox Bavdhan Pune - Premium 2, 3 & 4 BHK Flats starting from ₹98 Lakhs onwards. Possession Dec 2027. Enquire now!">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.10/dist/tailwind.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="image/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="image/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="image/favicon-16x16.png">
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
        
        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
           /* padding: 2rem; */
            text-align: center;
        }
        
        .gallery-overlay h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .gallery-overlay p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        
        .gallery-overlay .btn {
            background: #10b981;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
            display: inline-block;
        }
        
        .gallery-overlay .btn:hover {
            background: #059669;
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
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 2rem;
            border-radius: 1rem;
            width: 90%;
            max-width: 600px;
            position: relative;
            animation: fadeIn 0.3s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close-btn:hover,
        .close-btn:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        .tab-content.active {
            display: block;
        }
        .tab-content {
            display: none;
        }
        /* Utility for sticky form on desktop */
        @media (min-width: 1020px) {
            .lead-form-container {
                position: sticky;
                top: 2rem;
                align-self: flex-start;
            }
        }
        
        /* Responsive two-column layout */
        .main-container {
            display: flex;
            flex-direction: column;
           /* padding: 1rem;*/
        }
        @media (min-width: 1024px) {
            .main-container {
                flex-direction: row;
                justify-content: space-between;
               /* gap: 2rem;
                padding: 2rem;*/
            }
        }
        
        /* Alert styles */
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            border: 1px solid;
        }
        .alert-success {
            background-color: #d1fae5;
            border-color: #10b981;
            color: #065f46;
        }
        .alert-error {
            background-color: #fee2e2;
            border-color: #ef4444;
            color: #991b1b;
        }
         .tabs {
      display: flex;
      border-bottom: 2px solid #ddd;
    }
    .tab {
      padding: 12px 20px;
      background: #f4f4f4;
      cursor: pointer;
      font-weight: bold;
      border-radius: 6px 6px 0 0;
      margin-right: 5px;
      color: #333;
      transition: background 0.3s;
    }
    .tab:hover {
      background: #eaeaea;
    }
    .tab.active {
      background: #28a745;
      color: #fff;
    }
    .tab-content {
      display: none;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 0 0 8px 8px;
      margin-top: -1px;
    }
    .tab-content.active {
      display: block;
    }
    .place {
      margin-bottom: 10px;
      color: #333;
    }
    .place i {
      margin-right: 6px;
      color: #28a745;
    }
    </style>
</head>
<body class="text-gray-800">

    <!-- Top Navigation Bar for Desktop -->
    <nav class="bg-white p-4 shadow-sm hidden lg:block">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-8">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-gray-900">NYATI</span>
                    <span class="text-xl font-thin text-gray-900 ml-1">Equinox</span>
                </div>
                <ul class="flex space-x-6 text-sm font-medium text-gray-600">
                    <li><a href="#home" class="hover:text-emerald-500 transition-colors">Home</a></li>
                    <li><a href="#about-us" class="hover:text-emerald-500 transition-colors">About Us</a></li>
                    <li><a href="#pricing" class="hover:text-emerald-500 transition-colors">Price</a></li>
                    <li><a href="#amenities" class="hover:text-emerald-500 transition-colors">Amenities</a></li>
                    <li><a href="#gallery" class="hover:text-emerald-500 transition-colors">Gallery</a></li>
                    <li><a href="#location" class="hover:text-emerald-500 transition-colors">Location</a></li>
                   <!-- <li><a href="#" class="hover:text-emerald-500 transition-colors">Brochure</a></li>-->
                </ul>
            </div>
          
            
            <div class="flex items-center space-x-4 text-sm font-medium text-gray-600">
                <a href="#" class="flex items-center hover:text-emerald-500 transition-colors">
                    <img src="DSPLogo.jpg" alt="Dream Shelter Properties Logo" class="mr-1 rounded-full w-8 h-8 object-contain" onerror="this.src='https://placehold.co/32x32?text=Logo';">
                   <!-- <img src="DSPLogo.jpg" class="mr-1 rounded-full">-->
                    BY Dream Shelter Properties
                </a>
                <!--<a href="#" data-modal-type="Visit-Form" class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full hover:bg-gray-300 transition-colors">Organize Site Visit</a>-->
                <a href="tel:+917387088452" class="flex items-center text-emerald-600 font-bold hover:text-emerald-700">
                    <i class="fas fa-phone mr-1"></i> +91 7387088452
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Main Two-Column Layout -->
    <main class="flex flex-col lg:flex-row min-h-screen">
        <!-- Left Side - Content Sections -->
        <div class="lg:flex-grow p-0 md:p-0">
            <!-- Hero Carousel Section -->
            <section id="home" class="relative w-full rounded-lg overflow-hidden min-h-[500px] mb-8 lg:min-h-0 lg:h-[90vh] shadow-lg">
                <!-- "New Launch" floating badge on the left -->
                <div class="absolute top-1/2 left-0 transform -translate-y-1/2 -rotate-90 origin-top-left bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg rounded-br-lg z-20">
                    NEW LAUNCH
                </div>
                <div id="hero-carousel" class="flex transition-transform duration-700 ease-in-out h-full w-full">
                    <div class="w-full flex-shrink-0 relative">
                        <img src="gallery1.jpg" alt="Nyati Equinox banner" class="absolute inset-0 w-full h-full object-cover" loading="eager" onerror="this.src='https://placehold.co/1920x1080?text=Gallery+Image';">
                        <div class="gallery-overlay">
                            <h1>Nyati Equinox - Bavdhan, Pune</h1>
                            <p>Premium 2, 3 & 4 BHK Homes Starting ₹98 Lakhs* Onwards</p>
                           
                        </div>
                    </div>
                    <div class="w-full flex-shrink-0 relative">
                        <img src="gallery2.jpg" alt="Nyati Equinox" class="absolute inset-0 w-full h-full object-cover" loading="eager" onerror="this.src='https://placehold.co/1920x1080?text=Gallery+Image';">
                        <div class="gallery-overlay">
                            <h1>Modern Architecture</h1>
                            <p>Contemporary design with premium amenities</p>
                            
                        </div>
                    </div>
                    <div class="w-full flex-shrink-0 relative">
                        <img src="gallery3.jpg" alt="Nyati Equinox" class="absolute inset-0 w-full h-full object-cover" loading="eager" onerror="this.src='https://placehold.co/1920x1080?text=Gallery+Image';">
                        <div class="gallery-overlay">
                            <h1>Luxury Interiors</h1>
                            <p>Elegant finishes and spacious layouts</p>
                           
                        </div>
                    </div>
                    <div class="w-full flex-shrink-0 relative">
                        <img src="gallery4.jpg" alt="Nyati Equinox" class="absolute inset-0 w-full h-full object-cover" loading="eager" onerror="this.src='https://placehold.co/1920x1080?text=Gallery+Image';">
                        <div class="gallery-overlay">
                            <h1>Luxury Interiors</h1>
                            <p>Elegant finishes and spacious layouts</p>
                          
                        </div>
                    </div>
                </div>
                <div class="absolute inset-0 bg-black opacity-40"></div>
               
                <button id="hero-prev-btn" class="absolute top-1/2 left-4 transform -translate-y-1/2 text-white text-xl bg-black/50 p-4 rounded-full hover:bg-black/70 transition-colors duration-300">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="hero-next-btn" class="absolute top-1/2 right-4 transform -translate-y-1/2 text-white text-xl bg-black/50 p-4 rounded-full hover:bg-black/70 transition-colors duration-300">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <div id="hero-dots-container" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2"></div>
            </section>
            <!-- Other sections would continue here (truncated in query, but unchanged) -->
        </div>
        <!-- Right Side - Lead Form (unchanged) -->
        <!-- ... (rest of the code remains the same) -->
    </main>
    <!-- ... (JavaScript and closing tags remain the same) -->
</body>
</html>