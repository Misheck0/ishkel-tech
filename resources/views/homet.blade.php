@extends('layouts.homepage.app')
@section('title', 'ISHKEL TECH ENTERPRISES')
@section('description', 'ISHKEL TECH ENTERPRISES is a premier construction and installation company dedicated to building and wiring the nation with quality craftsmanship and innovative solutions.')
@section('keywords', 'ISHKEL TECH ENTERPRISES, construction, installation, generator service, diesel mechanic, electronics, wiring, Zambia')
@section('content')
    <!-- Hero Section -->
<!-- Hero Section -->
<div id="hero"
     class="bg-no-repeat bg-cover bg-center text-white min-h-screen flex items-center transition-all duration-700 ease-in-out"
     data-images='[
         "{{ asset('Archive/image2.JPG') }}",
         "{{ asset('Archive/image5.JPG') }}",
         "{{ asset('Archive/image2.JPG') }}", 
         "{{ asset('Archive/gen1.jpeg') }}",
          "{{ asset('Archive/person1.jpeg') }}",
           "{{ asset('Archive/person2.jpeg') }}"
     ]'
     data-headlines='[
         "We offer Electrical, Electronics and Diesel Mechanic Service 24/7",
         "Power Solutions & Generator Services for Every Sector",
         "Trusted for Heavy Equipment Repair and Spare Parts Supply",
         "Generator Services",
         "our team"
     ]'
     style="background-image: url('{{ asset('Archive/gen1.jpeg') }}');">
     
    <div class="container mx-auto px-6 text-center">
        <h1 id="hero-heading" class="text-4xl font-bold mb-6">
            We offer Electrical, Electronics and Diesel Mechanic Service 24/7
        </h1>
      
    
        
        <a href="#contact"
           class="bg-white text-green-700 font-bold py-3 px-6 rounded-full hover:bg-gray-100 transition duration-300">
            Get a Quote
        </a>
    </div>
</div>

 
    <!-- About Us Section -->
    <section id="about" class="py-16 bg-white relative overflow-hidden">
    

        <div class="container mx-auto px-6 relative">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">About ISHKEL TECH ENTERPRISES</h2>
            <div class="flex flex-col lg:ml-1/4">
                <div class="lg:w-3/4 mx-auto">
                    <p class="text-gray-600 mb-4">
                        
                    </p>
                    <p class="text-gray-600 mb-4">
                        
                    </p>
                    <div class="text-center mt-8">
                        <a href="{{ route('about') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition duration-300">
                            Learn More About Us
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Professional Services</h2>
                <div class="w-20 h-1 bg-green-600 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Comprehensive solutions for your power and machinery needs</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <div class="text-green-600 mb-4 text-4xl">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Generator Service & Repair</h4>
                    <p class="text-gray-600 text-sm">Professional troubleshooting and repair works for all generator types</p>
                </div>

                <!-- Service 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <div class="text-green-600 mb-4 text-4xl">
                        <i class="fas fa-generator"></i>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Generator Hiring</h4>
                    <p class="text-gray-600 text-sm">Rental services from 15kVA to 300kVA generators</p>
                </div>

                <!-- Service 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <div class="text-green-600 mb-4 text-4xl">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Generator Spare Parts</h4>
                    <p class="text-gray-600 text-sm">Supply of genuine generator spare parts</p>
                </div>

                <!-- Service 4 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <div class="text-green-600 mb-4 text-4xl">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Installation & Consultation</h4>
                    <p class="text-gray-600 text-sm">Professional installation services and technical consultation</p>
                </div>

                <!-- Service 5 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <div class="text-green-600 mb-4 text-4xl">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Generator Configurations</h4>
                    <p class="text-gray-600 text-sm">Complete generator setup and diagnosis</p>
                </div>

                <!-- Service 6 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <div class="text-green-600 mb-4 text-4xl">
                        <i class="fas fa-tractor"></i>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Earthmoving Machine Services</h4>
                    <p class="text-gray-600 text-sm">Configurations & diagnosis for all earthmoving equipment</p>
                </div>
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('services') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 transition duration-300">
                    View All Services
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Contact Us</h2>
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h3 class="text-xl font-semibold mb-4">Get in Touch</h3>
                    <p class="text-gray-600 mb-6">
                        Ready to start your project? Contact us today for a consultation or quote.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-indigo-600 mt-1 mr-4"></i>
                            <div>
                                <h4 class="font-medium">Location</h4>
                                <p class="text-gray-600">Lusaka Province</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-indigo-600 mt-1 mr-4"></i>
                            <div>
                                <h4 class="font-medium">Address</h4>
                                <p class="text-gray-600">164/40 kALUSHA Bwalya Road</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-phone-alt text-indigo-600 mt-1 mr-4"></i>
                            <div>
                                <h4 class="font-medium">Phone</h4>
                                <p class="text-gray-600">+260974642435</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-envelope text-indigo-600 mt-1 mr-4"></i>
                            <div>
                                <h4 class="font-medium">Email</h4>
                                <p class="text-gray-600">ishkel.tech@outlook.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2 md:pl-12">
                    <h3 class="text-xl font-semibold mb-4">Send Us a Message</h3>
                    <form id="whatsappForm">
                        <div class="mb-4">
                            <input type="text" id="name" placeholder="Your Name" required
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        </div>
                        <div class="mb-4">
                            <input type="email" id="email" placeholder="Your Email" required
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        </div>
                        <div class="mb-4">
                            <textarea id="message" rows="4" placeholder="Your Message" required
                                      class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600"></textarea>
                        </div>
                        <button type="submit"
                                class="bg-indigo-700 text-white font-bold py-3 px-6 rounded-full hover:bg-indigo-800 transition duration-300">
                            Send Message
                        </button>
                    </form>
                    <p class="mt-4 text-gray-600">Or reach us on WhatsApp:</p>
                    <a href="https://api.whatsapp.com/send?phone=260974642435&text=Hello%20ISHKEL%20TECH%20ENTERPRISES,%20I%20would%20like%20to%20inquire%20about%20your%20services." class="flex items-center mt-4 bg-green-500 text-white font-bold py-3 px-6 rounded-full hover:bg-green-600 transition duration-300">
                        <i class="fab fa-whatsapp mr-2"></i> WhatsApp Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('whatsappForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();

            const fullMessage = `Hello ISHKEL TECH ENTERPRISES,%0A
    Name: ${encodeURIComponent(name)}%0A
    Email: ${encodeURIComponent(email)}%0A
    Message: ${encodeURIComponent(message)}`;

            const phone = "260974642435";
            const url = `https://api.whatsapp.com/send?phone=${phone}&text=${fullMessage}`;

            window.open(url, '_blank');
        });
    </script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hero = document.getElementById('hero');
        const heading = document.getElementById('hero-heading');

        const images = JSON.parse(hero.dataset.images);
        const texts = JSON.parse(hero.dataset.headlines);

        let index = 0;

        setInterval(() => {
            index = (index + 1) % images.length;
            hero.style.backgroundImage = `url('${images[index]}')`;
            heading.textContent = texts[index];
        }, 3000); // every 5 seconds
    });
</script>

@endsection