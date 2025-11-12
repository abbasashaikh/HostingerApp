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
                    $_POST = array(); // Clear form data
                } else {
                    $message = "Sorry, there was an issue sending your enquiry. Please try again later.";
                    $messageType = "error";
                }
            } catch (Exception $e) {
                $message = "Error: " . $e->getMessage();
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
  <title>Nyati Equinox</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- Carousel Section -->
<div class="relative w-full h-64 sm:h-80 md:h-[500px] overflow-hidden">

  <!-- Slides -->
  <div class="carousel-slide">
    <img src="images/gallery1.jpg" alt="Nyati Equinox banner" class="w-full h-full object-cover"
         onerror="this.src='https://placehold.co/600x400?text=Image+1';">
  </div>
  <div class="carousel-slide hidden">
    <img src="images/gallery2.jpg" alt="Nyati Equinox" class="w-full h-full object-cover"
         onerror="this.src='https://placehold.co/600x400?text=Image+2';">
  </div>
  <div class="carousel-slide hidden">
    <img src="images/gallery3.jpg" alt="Nyati Equinox" class="w-full h-full object-cover"
         onerror="this.src='https://placehold.co/600x400?text=Image+3';">
  </div>
  <div class="carousel-slide hidden">
    <img src="images/gallery4.jpg" alt="Nyati Equinox" class="w-full h-full object-cover"
         onerror="this.src='https://placehold.co/600x400?text=Image+4';">
  </div>

  <!-- Prev Button -->
  <button id="prevBtn"
          class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-black bg-opacity-40 hover:bg-opacity-70 text-white p-2 sm:p-3 rounded-full text-sm sm:text-lg">
    &#10094;
  </button>

  <!-- Next Button -->
  <button id="nextBtn"
          class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-black bg-opacity-40 hover:bg-opacity-70 text-white p-2 sm:p-3 rounded-full text-sm sm:text-lg">
    &#10095;
  </button>

  <!-- Dots -->
  <div class="absolute bottom-3 w-full flex justify-center space-x-2">
    <span class="dot w-2 h-2 sm:w-3 sm:h-3 bg-white rounded-full opacity-50 cursor-pointer"></span>
    <span class="dot w-2 h-2 sm:w-3 sm:h-3 bg-white rounded-full opacity-50 cursor-pointer"></span>
    <span class="dot w-2 h-2 sm:w-3 sm:h-3 bg-white rounded-full opacity-50 cursor-pointer"></span>
    <span class="dot w-2 h-2 sm:w-3 sm:h-3 bg-white rounded-full opacity-50 cursor-pointer"></span>
  </div>
</div>

<!-- About Section -->
<section class="max-w-5xl mx-auto px-4 py-8">
  <h2 class="text-2xl font-bold mb-4">About Nyati Group</h2>
  <img src="about.jpg" alt="Nyati Group Logo" class="w-full md:w-1/3 mb-4 rounded-lg shadow-md"
       onerror="this.src='https://placehold.co/400x200?text=About+Image';">
  <p>
    Nyati Equinox presents a vision of integrated urban living, combining the splendour of Bavdhan’s nature with Balewadi’s futuristic vibrance...
  </p>
</section>

<!-- Contact Form -->
<section class="max-w-xl mx-auto px-4 py-8 bg-white shadow-lg rounded-lg">
  <h2 class="text-xl font-semibold mb-4">Enquiry Form</h2>

  <?php if (!empty($message)): ?>
    <div class="mb-4 p-3 rounded <?= $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
      <?= $message ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="" class="space-y-4">
    <input type="text" name="name" placeholder="Your Name" required class="w-full border p-2 rounded">
    <input type="text" name="mobile" placeholder="Mobile Number" required class="w-full border p-2 rounded">
    <input type="email" name="email" placeholder="Email (optional)" class="w-full border p-2 rounded">
    <select name="unit_preference" class="w-full border p-2 rounded">
      <option value="">Select Unit Preference</option>
      <option value="2BHK">2 BHK</option>
      <option value="3BHK">3 BHK</option>
    </select>
    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
      Submit Enquiry
    </button>
  </form>
</section>

<!-- Slider Script -->
<script>
let slideIndex = 0;
const slides = document.querySelectorAll(".carousel-slide");
const dots = document.querySelectorAll(".dot");

function showSlide(index) {
  slides.forEach((slide, i) => {
    slide.classList.add("hidden");
    dots[i].classList.remove("opacity-100");
    dots[i].classList.add("opacity-50");
  });
  slides[index].classList.remove("hidden");
  dots[index].classList.remove("opacity-50");
  dots[index].classList.add("opacity-100");
}

document.getElementById("prevBtn").addEventListener("click", () => {
  slideIndex = (slideIndex - 1 + slides.length) % slides.length;
  showSlide(slideIndex);
});

document.getElementById("nextBtn").addEventListener("click", () => {
  slideIndex = (slideIndex + 1) % slides.length;
  showSlide(slideIndex);
});

dots.forEach((dot, i) => {
  dot.addEventListener("click", () => {
    slideIndex = i;
    showSlide(slideIndex);
  });
});

// Auto-slide every 5s
setInterval(() => {
  slideIndex = (slideIndex + 1) % slides.length;
  showSlide(slideIndex);
}, 5000);

// Initialize
showSlide(slideIndex);
</script>

</body>
</html>
