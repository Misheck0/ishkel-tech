@extends('layouts.homepage.app')
@section('title', 'About ISHKEL TECH ENTERPRISES')
@section('description', 'Learn more about ISHKEL TECH ENTERPRISES - our history, mission, and the team behind our professional services.')
@section('keywords', 'about ISHKEL TECH, company history, our team, mission statement')

@section('content')
     <!-- Main container with responsive layout -->
      <div class="flex flex-col lg:flex-row w-full">
        <!-- Left sidebar - Full width on mobile, left side on desktop -->
        <div class="w-full lg:w-1/2">
   <div id="hero"
     class="bg-no-repeat bg-cover bg-center text-white min-h-screen flex items-end transition-all duration-700 ease-in-out"
     style="background-image: url('/Archive/cat.jpeg');">
     
    <div class="container mx-auto px-6 text-center pb-12">
        <h1 id="hero-heading" class="text-4xl font-bold mb-4">
            We offer Electrical, Electronics and Diesel Mechanic Service 24/7
        </h1>
                   
                </div>
            </div>
        </div>

        <!-- Right content - Full width on mobile, right side on desktop -->
        <div class="w-full lg:w-1/2 bg-green-500 flex items-center">
            <div class="container mx-auto px-6 py-12 lg:py-0 text-center lg:text-left">
                <h1 class="text-4xl font-bold mb-6 about-heading">
                    <p>ABOUT </p>
                    ISHKEL TECH ENTERPRISES
                </h1>
                <p class="text-xl mb-8">
                    Building excellence through innovation and quality craftsmanship
                </p>
             
            </div>
        </div>
    </div>
    <!-- About Content with Sidebar Images -->
    <section class="py-16 bg-white relative overflow-hidden">
     

        <div class="container mx-auto px-6 relative">
            <div class="flex flex-col lg:ml-1/4">
                <div class="lg:w-3/4 mx-auto">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Our Story</h2>
                    <p class="text-gray-600 mb-6">
                        Founded in Zambia, ISHKEL TECH ENTERPRISES has grown from a small local operation to a trusted name in generator services and heavy equipment solutions. Our journey began with a simple mission: to provide reliable, professional services that our clients can depend on.
                    </p>
                    
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 mt-12">Our Mission</h2>
                    <p class="text-gray-600 mb-6">
                        To deliver exceptional technical services through innovation, quality craftsmanship, and unwavering commitment to customer satisfaction. We strive to be the preferred partner for all generator and heavy equipment needs in Zambia.
                    </p>
                    
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 mt-12">Our Team</h2>
                    <p class="text-gray-600 mb-6">
                        Our strength lies in our team of certified technicians and engineers who bring years of experience and specialized knowledge to every project. We invest in continuous training to ensure we stay at the forefront of industry developments.
                    </p>
                    
                    <div class="grid md:grid-cols-2 gap-8 mt-12">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold mb-4 text-green-600">Our Values</h3>
                            <ul class="space-y-3 text-gray-600">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span>Integrity in all our dealings</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span>Commitment to quality</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span>Customer-focused solutions</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span>Innovation and continuous improvement</span>
                                </li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-xl font-semibold mb-4 text-green-600">Certifications</h3>
                            <p class="text-gray-600 mb-4">
                                ISHKEL SERVICES BC_013843
                            </p>
                            <p class="text-gray-600">
                                Our team holds various certifications in generator maintenance, heavy equipment repair, and electrical systems.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Ready to work with us?</h2>
            <a href="#contact" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition duration-300">
                Contact Us Today
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </section>

   <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Image paths - update these to your actual paths
                const images = [
                    '/Archive/person1.jpeg',
                    '/Archive/gen1.jpeg',
                    '/Archive/person3.jpeg',
                    '/Archive/person4.jpeg',
                    '/Archive/cat.jpeg'
                ];
                
                // Headlines that will rotate with images
                const headlines = [
                     "Trusted for Heavy Equipment Repair and Spare Parts Supply",
                    "We offer Electrical, Electronics and Diesel Mechanic Service 24/7",
                
                   
                ];
                
                const heroElement = document.getElementById('hero');
                const headingElement = document.getElementById('hero-heading');
                let currentIndex = 0;
                
                // Function to rotate backgrounds and headlines
                function rotateContent() {
                    currentIndex = (currentIndex + 1) % images.length;
                    
                    // Apply fade-out effect
                    heroElement.style.opacity = '0';
                    
                    setTimeout(() => {
                        // Change background image and heading
                        heroElement.style.backgroundImage = `url('${images[currentIndex]}')`;
                        headingElement.textContent = headlines[currentIndex];
                        
                        // Apply fade-in effect
                        heroElement.style.opacity = '1';
                    }, 700); // Match this with your CSS transition duration
                }
                
                // Start rotation every 5 seconds
                setInterval(rotateContent, 5000);
            });
            </script>



@endsection