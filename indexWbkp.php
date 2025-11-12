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
    <script src="https://cdn.tailwindcss.com"></script>
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
                        <img src="gallery1.jpg" alt="Nyati Equinox banner"  class="absolute inset-0 w-full h-full object-cover" onerror="this.src='https://placehold.co/1920x1080?text=Gallery+Image+1';">
                        <div class="gallery-overlay">
                            <h1>Nyati Equinox - Bavdhan, Pune</h1>
                            <p>Premium 2, 3 & 4 BHK Homes Starting ₹98 Lakhs* Onwards</p>
                           
                        </div>
                     </div>
                    <div class="w-full flex-shrink-0 relative">
                        <img src="gallery2.jpg" alt="Nyati Equinox"  class="absolute inset-0 w-full h-full object-cover" onerror="this.src='https://placehold.co/1920x1080?text=Gallery+Image+2';">
                        <div class="gallery-overlay">
                            <h1>Modern Architecture</h1>
                            <p>Contemporary design with premium amenities</p>
                            
                        </div>
                    </div>
                   <div class="w-full flex-shrink-0 relative">
                        <img src="gallery3.jpg" alt="Nyati Equinox"  class="absolute inset-0 w-full h-full object-cover" onerror="this.src='https://placehold.co/1920x1080?text=Gallery+Image+3';">
                        <div class="gallery-overlay">
                            <h1>Luxury Interiors</h1>
                            <p>Elegant finishes and spacious layouts</p>
                           
                        </div>
                    </div>
                    <div class="w-full flex-shrink-0 relative">
                        <img src="gallery4.jpg" alt="Nyati Equinox"  class="absolute inset-0 w-full h-full object-cover" onerror="this.src='https://placehold.co/1920x1080?text=Gallery+Image+4';">
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
                <div id="hero-dots-container" class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <!-- Dots will be generated by JS -->
                </div>
            </section>
            
            <!-- About Us Section -->
            <section id="about-us" class="bg-white p-6 rounded-lg shadow-lg mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">About Nyati Group</h2>
                <div class="flex flex-col md:flex-row items-center md:space-x-8">
                    <img src="about.jpg" alt="Nyati Group Logo" class="w-full md:w-1/3 mb-4 md:mb-0 rounded-lg shadow-md">
                    <p class="text-gray-700 text-lg">
                        Nyati Equinox presents a vision of integrated urban living, which combines the splendour of Bavdhan's nature, Balewadi's futuristic living & vibrance of the Pune city. Located near the upcoming Chandani Chowk metro station, Nyati Equinox is at the centre of both Kothrud & Balewadi, thereby offering superb connectivity to the rest of Pune & a satisfactory work-life balance! That's why Nyati Equinox is a future-ready project for a perfect lifestyle upgrade!
                    </p>
                </div>
            </section>

            <!-- Pricing Section -->
            <section id="pricing" class="py-12 px-4 md:px-8 bg-gray-50 rounded-lg shadow-lg mb-8">
                <div class="container mx-auto">
                    <h2 class="text-3xl font-bold text-gray-900 text-center mb-6">Pricing & Configurations</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-emerald-500 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">2 BHK</h3>
                            <p class="text-sm text-gray-600 mb-4">838 Sq.ft</p>
                            <p class="text-2xl font-extrabold text-emerald-600 mb-6">₹98 Lakhs* Onwards</p>
                            <button class="open-modal-btn bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2 px-6 rounded-full shadow-md transition duration-300" data-modal-type="Get-Details" data-unit="2 BHK">
                                Get Details
                            </button>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-emerald-500 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">3 BHK</h3>
                            <p class="text-sm text-gray-600 mb-4">1230 Sq.ft</p>
                            <p class="text-2xl font-extrabold text-emerald-600 mb-6">₹1.48 Cr* Onwards</p>
                            <button class="open-modal-btn bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2 px-6 rounded-full shadow-md transition duration-300" data-modal-type="Get-Details" data-unit="3 BHK">
                                Get Details
                            </button>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-emerald-500 text-center">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">4 BHK</h3>
                            <p class="text-sm text-gray-600 mb-4">2056 Sq.ft</p>
                            <p class="text-2xl font-extrabold text-emerald-600 mb-6">₹2.55 Cr* Onwards</p>
                            <button class="open-modal-btn bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2 px-6 rounded-full shadow-md transition duration-300" data-modal-type="Get-Details" data-unit="4 BHK">
                                Get Details
                            </button>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- View Plans Section -->
            <section id="plans" class="bg-white p-6 rounded-lg shadow-lg mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">Project Plans</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <button class="open-modal-btn w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-4 px-6 rounded-lg shadow-md transition duration-300" data-modal-type="master-plan">
                        <i class="fas fa-map-marked-alt mr-2"></i> View Master Plan
                    </button>
                    <button class="open-modal-btn w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-4 px-6 rounded-lg shadow-md transition duration-300" data-modal-type="unit-plan">
                        <i class="fas fa-home mr-2"></i> Request Unit Plan
                    </button>
                </div>
            </section>

            <!-- Amenities Section -->
            <section id="amenities" class="py-12 px-4 md:px-8 bg-white rounded-lg shadow-lg mb-8">
                <div class="container mx-auto">
                    <h2 class="text-3xl font-bold text-gray-900 text-center mb-6">World-Class Amenities</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-lg shadow-sm overflow-hidden">
                            <img src="swimmingPool.jpg" alt="Swimming Pool" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-gray-900">Swimming Pool</h3>
                                <p class="text-sm text-gray-600">Rejuvenate and relax in our pristine swimming pool.</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg shadow-sm overflow-hidden">
                            <img src="MultipurposeHall.jpg" alt="Clubhouse" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-gray-900">Spacious Clubhouse</h3>
                                <p class="text-sm text-gray-600">A perfect venue for community events and gatherings.</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg shadow-sm overflow-hidden">
                            <img src="JoggingTrack.jpg" alt="Gymnasium" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-gray-900">Fully Equipped Gymnasium</h3>
                                <p class="text-sm text-gray-600">Stay fit and healthy with state-of-the-art gym equipment.</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg shadow-sm overflow-hidden">
                            <img src="landscapeGarden.jpg" alt="Landscaped Gardens" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-gray-900">Landscaped Gardens</h3>
                                <p class="text-sm text-gray-600">Enjoy the serenity of nature in beautifully designed gardens.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Gallery Section -->
            <section id="gallery" class="py-12 px-4 md:px-8 bg-gray-50 rounded-lg shadow-lg mb-8">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-6">Project Gallery</h2>
                <div class="relative w-full max-w-3xl mx-auto overflow-hidden rounded-lg shadow-xl">
                    <div id="gallery-carousel" class="flex transition-transform duration-500 ease-in-out">
                        <img src="Livingroom.jpg" alt="Gallery Image 1" class="w-full h-auto object-cover flex-shrink-0">
                        <img src="childrenroom.jpg" alt="Gallery Image 2" class="w-full h-auto object-cover flex-shrink-0">
                        <img src="Kitchen.jpg" alt="Gallery Image 3" class="w-full h-auto object-cover flex-shrink-0">
                    </div>
                    <button id="prev-btn" class="absolute top-1/2 left-4 transform -translate-y-1/2 text-white bg-black/50 p-3 rounded-full hover:bg-black/70 transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button id="next-btn" class="absolute top-1/2 right-4 transform -translate-y-1/2 text-white bg-black/50 p-3 rounded-full hover:bg-black/70 transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </section>

            <!-- Location Advantage Section -->
             <!-- Start of new 'Location Advantage' section -->
            <section id="location" class="bg-white p-6 rounded-2xl shadow-lg mx-4">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Location Advantage</h2>
              <div class="tabs">
    <div class="tab active" data-tab="it">IT HUBS</div>
    <div class="tab" data-tab="edu">EDUCATIONAL</div>
    <div class="tab" data-tab="health">HEALTHCARE</div>
    <div class="tab" data-tab="malls">MALLS/ SHOPPING</div>
  </div>

  <!-- IT HUBS -->
  <div class="tab-content active" id="it">
    <div class="place"><i class="fas fa-map-marker-alt"></i> Sharda Center - 8 KM</div>
    <div class="place"><i class="fas fa-map-marker-alt"></i> Nanospace IT Park - 9 KM</div>
    <div class="place"><i class="fas fa-map-marker-alt"></i> ICC Trade Towers - 10 KM</div>
    <div class="place"><i class="fas fa-map-marker-alt"></i> Hinjewadi IT Park - 18.5 KM</div>
  </div>

  <!-- EDUCATIONAL -->
  <div class="tab-content" id="edu">
    <div class="place"><i class="fas fa-map-marker-alt"></i> JSPM College Of Engineering, Bavdhan - 1 KM</div>
    <div class="place"><i class="fas fa-map-marker-alt"></i> Oxford International Public School - 1 KM</div>
    <div class="place"><i class="fas fa-map-marker-alt"></i> Ryan International School - 3 KM</div>
    <div class="place"><i class="fas fa-map-marker-alt"></i> Little Millenium - 3 KM</div>
    <div class="place"><i class="fas fa-map-marker-alt"></i> MIT-WPU - 6 KM</div>
  </div>

  <!-- HEALTHCARE -->
  <div class="tab-content" id="health">
    <div class="place"><i class="fas fa-map-marker-alt"></i> Bavdhan Medicare Centre - 3 KM</div>
    <div class="place"><i class="fas fa-map-marker-alt"></i> Opel Hospital - 4 KM</div>
    <div class="place"><i class="fas fa-map-marker-alt"></i> Sahyadri Hospital, Kothrud - 5 KM</div>
    <div class="place"><i class="fas fa-map-marker-alt"></i> Chellaram Hospital - 4 KM</div>
    <div class="place"><i class="fas fa-map-marker-alt"></i> City Hospital - 4 KM</div>
  </div>

  <!-- MALLS -->
  <div class="tab-content" id="malls">
    <div class="place"><i class="fas fa-map-marker-alt"></i> D-Mart, Karve Nagar - 8 KM</div>
    <div class="place"><i class="fas fa-map-marker-alt"></i> MSM Mall, Karve Road - 8.5 KM</div>
    <div class="place"><i class="fas fa-map-marker-alt"></i> The Pavillion, SB Road - 10 KM</div>
  </div>

            </section>
            <!-- End of new 'Location Advantage' section -->

            <!-- Location & Map Section -->
            <section class="py-12 px-4 md:px-8 bg-gray-50 rounded-lg shadow-lg mb-8">
                <div class="container mx-auto">
                    <h2 class="text-3xl font-bold text-gray-900 text-center mb-6">Location</h2>
                    <p class="text-gray-700 text-lg mb-4 text-center">
                        Located near Chandani Chowk Metro, Bavdhan, Pune.
                    </p>
                    <div class="w-full h-80 md:h-96 rounded-lg shadow-lg overflow-hidden">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3783.189565509935!2d73.76569721489063!3d18.52044328741165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2bf9e02c6d48f%3A0x6a2c9c7f68c3a9d5!2sBavdhan%2C%20Pune%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1628173432130!5m2!1sen!2sin"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </section>
        </div>

        <!-- Right Side - Sticky Lead Form & Widgets -->
        <div id="enquire" class="lg:w-[55%] p-0 lg:p-0 shadow-2xl z-20 lead-form-container">
            <div class="bg-white rounded-xl shadow-lg p-6 lg:p-8">
                <!-- Display success/error messages -->
                <?php if ($message): ?>
                    <div class="alert <?php echo $messageType === 'success' ? 'alert-success' : 'alert-error'; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                
                <div class="space-y-4 mb-8 text-center">
                    <a href="#" class="w-full bg-emerald-500 text-white font-semibold py-2 px-4 rounded-full flex items-center justify-center space-x-2 shadow-md">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Organize Site Visit</span>
                    </a>
                    <a href="#" class="w-full bg-white text-gray-800 border-2 border-emerald-500 font-semibold py-2 px-4 rounded-full flex items-center justify-center space-x-2 shadow-md">
                        <i class="fas fa-phone-alt"></i>
                        <span>Request Call Back</span>
                    </a>
                    <a href="https://wa.me/917387088452" target="_blank" class="w-full bg-green-500 text-white font-semibold py-2 px-4 rounded-full flex items-center justify-center space-x-2 shadow-md">
                        <i class="fab fa-whatsapp"></i>
                        <span>+91 7387088452</span>
                    </a>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4 text-center">ENQUIRE NOW</h3>
                <form id="lead-form" class="space-y-4" method="POST" action="">
                    <input type="hidden" id="unit-preference" name="unit_preference" value="<?php echo isset($_POST['unit_preference']) ? htmlspecialchars($_POST['unit_preference']) : ''; ?>">
                    <div>
                        <input type="text" id="name" name="name" placeholder="Name" required 
                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <input type="tel" id="mobile" name="mobile" placeholder="+91 Mobile Number" required pattern="[0-9]{10}" 
                               value="<?php echo isset($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : ''; ?>"
                               title="Please enter a 10-digit mobile number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <input type="email" id="email" name="email" placeholder="Email Address (Optional)" 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div class="flex items-start text-xs text-gray-500 mt-2">
                        <input type="checkbox" id="consent" name="consent" required class="mt-1 form-checkbox h-4 w-4 text-emerald-600 rounded">
                        <label for="consent" class="ml-2 leading-tight">
                            I Consent to the Processing of Provided Data According To <a href="#" class="text-emerald-500 underline">Privacy Policy</a>, <a href="#" class="text-emerald-500 underline">Terms & Conditions</a>. I Authorize Propertypistol Realty Private Limited and its representatives to Call, SMS, Email or Whatsapp Me About its Products and Offers. This Consent Overrides Any Registration for DNC/DNCR.
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 rounded-lg shadow-md transition duration-300">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </main>

    <!-- Modal Structure -->
    <div id="mainModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <div id="modal-content-area" class="text-center">
                <!-- Content will be injected here by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8 px-4 md:px-8">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            <div class="text-center md:text-left">
                  <p class="text-sm font-semibold mb-2"><a href="about.html" class="text-light me-2">About</a> | <a href="contact.html" class="text-light mx-2">Contact</a> | <a href="privacy-policy.html" class="text-light mx-2">Privacy</a> | <a href="terms-of-use.html" class="text-light ms-2">Terms</a></p>
      
                <a href="https://wa.me/917387088452" target="_blank" class="flex items-center justify-center md:justify-start text-sm hover:text-white transition duration-200">
                    <i class="fab fa-whatsapp mr-2"></i>
                    WhatsApp
                </a>
            </div>
            <div class="text-sm text-center">
                <p>RERA ID: P52100047984</p>
                <p class="mt-2 text-xs">
                    *The images used are for representation purposes only. The final product may vary.
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
          const form = document.getElementById('lead-form');
            const unitButtons = document.querySelectorAll('.get-costing-btn');
            const unitPreferenceInput = document.getElementById('unit-preference');
            const modal = document.getElementById('mainModal');
            const modalContentArea = document.getElementById('modal-content-area');
            const closeBtn = document.querySelector('.close-btn');
            const openModalBtns = document.querySelectorAll('.open-modal-btn');
            const tabButtons = document.querySelectorAll('.tab-btn');
            const galleryCarousel = document.getElementById('gallery-carousel');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');

            let currentIndex = 0;
            const totalImages = 3; // Updated to match actual number of images

            function updateCarousel() {
                const offset = -currentIndex * 100;
                galleryCarousel.style.transform = `translateX(${offset}%)`;
            }

            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                updateCarousel();
            });

            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % totalImages;
                updateCarousel();
            });
            
            // Hero carousel logic
            const heroCarousel = document.getElementById('hero-carousel');
            const heroPrevBtn = document.getElementById('hero-prev-btn');
            const heroNextBtn = document.getElementById('hero-next-btn');
            const heroDotsContainer = document.getElementById('hero-dots-container');
            let heroIndex = 0;
            const totalHeroImages = 4;
            let autoSlideInterval;

            // Generate navigation dots
            for (let i = 0; i < totalHeroImages; i++) {
                const dot = document.createElement('div');
                dot.classList.add('w-3', 'h-3', 'rounded-full', 'bg-white/50', 'cursor-pointer', 'transition-colors');
                dot.dataset.index = i;
                heroDotsContainer.appendChild(dot);
            }

            function updateHeroCarousel() {
                const offset = -heroIndex * 100;
                heroCarousel.style.transform = `translateX(${offset}%)`;
                
                // Update dots
                document.querySelectorAll('#hero-dots-container div').forEach((dot, index) => {
                    if (index === heroIndex) {
                        dot.classList.add('bg-white');
                        dot.classList.remove('bg-white/50');
                    } else {
                        dot.classList.remove('bg-white');
                        dot.classList.add('bg-white/50');
                    }
                });
            }

            function startAutoSlide() {
                autoSlideInterval = setInterval(() => {
                    heroIndex = (heroIndex + 1) % totalHeroImages;
                    updateHeroCarousel();
                }, 8000); // Change image every 5 seconds
            }

            function stopAutoSlide() {
                clearInterval(autoSlideInterval);
            }

            heroPrevBtn.addEventListener('click', () => {
                stopAutoSlide();
                heroIndex = (heroIndex - 1 + totalHeroImages) % totalHeroImages;
                updateHeroCarousel();
                startAutoSlide();
            });

            heroNextBtn.addEventListener('click', () => {
                stopAutoSlide();
                heroIndex = (heroIndex + 1) % totalHeroImages;
                updateHeroCarousel();
                startAutoSlide();
            });
            
            heroDotsContainer.addEventListener('click', (e) => {
                if (e.target.dataset.index) {
                    stopAutoSlide();
                    heroIndex = parseInt(e.target.dataset.index);
                    updateHeroCarousel();
                    startAutoSlide();
                }
            });

            // Initial call to set up the carousel and start auto-sliding
            updateHeroCarousel();
            startAutoSlide();
            
            // Initial active tab state for Location Advantage
            const initialTab = document.querySelector('.tab-btn[data-tab="education"]');
            if (initialTab) {
                initialTab.classList.add('border-emerald-500', 'text-emerald-500');
                document.getElementById('education-tab').classList.add('active');
            }

            tabButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-emerald-500', 'text-emerald-500');
                    });
                    button.classList.add('border-emerald-500', 'text-emerald-500');
                    
                    const tabName = button.dataset.tab;
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.remove('active');
                    });
                    document.getElementById(`${tabName}-tab`).classList.add('active');
                });
            });

            function openModal(type, unit = '') {
                modal.style.display = 'block';
                modalContentArea.innerHTML = '';

                switch(type) {
                    case 'costing':
                        modalContentArea.innerHTML = `
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Costing Details for ${unit}</h3>
                            <p class="text-gray-700 mb-6">Thank you for your interest! Our team will provide you with a detailed breakdown of the costing for the ${unit} unit shortly.</p>
                            <button class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 w-full" onclick="closeModal(); scrollToForm('${unit}')">Get Pricing Details</button>
                        `;
                        break;
                    case 'master-plan':
                        modalContentArea.innerHTML = `
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">View Master Plan</h3>
                            <p class="text-gray-700 mb-6">Here is the master plan for Nyati Equinox. It highlights the overall layout of the project, including towers, amenities, and green spaces.</p>
                            <img src="1484-Nyati-Equinox_Cam_010_MasterPlan.jpg" alt="Master Plan" class="w-full rounded-lg shadow-md mb-4">
                            <button class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 w-full" onclick="closeModal(); scrollToForm('')">Request Unit Plan</button>
                        `;
                        break;
                    case 'unit-plan':
                        modalContentArea.innerHTML = `
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Request Unit Plan</h3>
                            <p class="text-gray-700 mb-6">Please fill out your details to receive the unit plan for your desired configuration.</p>
                            <form class="space-y-4" method="POST" action="">
                                <input type="text" name="name" placeholder="Name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                <input type="tel" name="mobile" placeholder="+91 Mobile Number" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                <input type="email" name="email" placeholder="Email Address" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                <select name="unit_preference" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                    <option value="">Select Unit</option>
                                    <option value="2 BHK">2 BHK</option>
                                    <option value="3 BHK">3 BHK</option>
                                    <option value="4 BHK">4 BHK</option>
                                </select>
                                <div class="flex items-start text-xs text-gray-500 mt-2">
                                    <input type="checkbox" name="consent" required class="mt-1 form-checkbox h-4 w-4 text-emerald-600 rounded">
                                    <label class="ml-2 leading-tight">I consent to be contacted for this enquiry.</label>
                                </div>
                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 rounded-lg shadow-md transition duration-300">Submit</button>
                            </form>
                        `;
                        break;
					case 'Get-Details':
                        modalContentArea.innerHTML = `
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Request Details</h3>
                            <p class="text-gray-700 mb-6">Please fill out your details to receive the Pricing & Configurations.</p>
                            <form class="space-y-4" method="POST" action="">
                                <input type="text" name="name" placeholder="Name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                <input type="tel" name="mobile" placeholder="+91 Mobile Number" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                <input type="email" name="email" placeholder="Email Address" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                              
                                <div class="flex items-start text-xs text-gray-500 mt-2">
                                    <input type="checkbox" name="consent" required class="mt-1 form-checkbox h-4 w-4 text-emerald-600 rounded">
                                    <label class="ml-2 leading-tight">I consent to be contacted for this enquiry.</label>
                                </div>
                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 rounded-lg shadow-md transition duration-300">Submit</button>
                            </form>
                        `;
                        break;
                        case 'Visit-Form':
                        modalContentArea.innerHTML = `
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">ORGNIZE SITE VIST</h3>
                            <p class="text-gray-700 mb-6">Please fill out your details for Site Visit.</p>
                            <form class="space-y-4" method="POST" action="">
                                <input type="text" name="name" placeholder="Name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                <input type="tel" name="mobile" placeholder="+91 Mobile Number" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                <input type="email" name="email" placeholder="Email Address" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                              
                                <div class="flex items-start text-xs text-gray-500 mt-2">
                                    <input type="checkbox" name="consent" required class="mt-1 form-checkbox h-4 w-4 text-emerald-600 rounded">
                                    <label class="ml-2 leading-tight">I consent to be contacted for this enquiry.</label>
                                </div>
                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 rounded-lg shadow-md transition duration-300">Submit</button>
                            </form>
                        `;
                        break;
                }
            }

            function closeModal() {
                modal.style.display = 'none';
            }
            
            function scrollToForm(unit) {
                if (unit) {
                    unitPreferenceInput.value = unit;
                }
                document.getElementById('enquire').scrollIntoView({
                    behavior: 'smooth'
                });
            }

            // Make functions globally accessible
            window.closeModal = closeModal;
            window.scrollToForm = scrollToForm;

            openModalBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const type = btn.dataset.modalType;
                    const unit = btn.dataset.unit || '';
                    openModal(type, unit);
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