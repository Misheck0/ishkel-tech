@extends('layouts.homepage.app')
@section('title', 'Our Services')
@section('description', 'Explore our range of services including generator repair, hiring, and more.')
@section('keywords', 'generator repair, generator hiring, generator spare parts, installation, consultation')


@section('content')
<div class="bg-white py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-green-700 uppercase tracking-wide">ISHKEL TECH ENTERPRISE</h2>
        <p class="mt-2 text-gray-600 text-lg">Lusaka | Zambia</p>

        <h3 class="mt-10 text-2xl font-semibold text-gray-800 uppercase border-b-2 border-green-600 pb-2 inline-block">Our Services</h3>
    </div>

    <div class="mt-12 max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Service 1 -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
            <div class="text-green-600 mb-4 text-4xl">
                <i class="fas fa-bolt"></i>
            </div>
            <h4 class="text-lg font-semibold mb-2">Generator Service & Repair</h4>
            <p class="text-gray-600 text-sm">Professional troubleshooting and repair works for all generator types</p>
        </div>

        <!-- Service 2 -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
            <div class="text-green-600 mb-4 text-4xl">
                <i class="fas fa-generator"></i>
            </div>
            <h4 class="text-lg font-semibold mb-2">Generator Hiring</h4>
            <p class="text-gray-600 text-sm">Rental services from 15kVA to 300kVA generators</p>
        </div>

        <!-- Service 3 -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
            <div class="text-green-600 mb-4 text-4xl">
                <i class="fas fa-cogs"></i>
            </div>
            <h4 class="text-lg font-semibold mb-2">Generator Spare Parts</h4>
            <p class="text-gray-600 text-sm">Supply of genuine generator spare parts</p>
        </div>

        <!-- Service 4 -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
            <div class="text-green-600 mb-4 text-4xl">
                <i class="fas fa-tools"></i>
            </div>
            <h4 class="text-lg font-semibold mb-2">Installation & Consultation</h4>
            <p class="text-gray-600 text-sm">Professional installation services and technical consultation</p>
        </div>

        <!-- Service 5 -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
            <div class="text-green-600 mb-4 text-4xl">
                <i class="fas fa-microchip"></i>
            </div>
            <h4 class="text-lg font-semibold mb-2">Generator Configurations</h4>
            <p class="text-gray-600 text-sm">Complete generator setup and diagnosis</p>
        </div>

        <!-- Service 6 -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
            <div class="text-green-600 mb-4 text-4xl">
                <i class="fas fa-tractor"></i>
            </div>
            <h4 class="text-lg font-semibold mb-2">Earthmoving Machine Services</h4>
            <p class="text-gray-600 text-sm">Configurations & diagnosis for all earthmoving equipment</p>
        </div>

        <!-- Service 7 -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
            <div class="text-green-600 mb-4 text-4xl">
                <i class="fas fa-server"></i>
            </div>
            <h4 class="text-lg font-semibold mb-2">DSE Configurations</h4>
            <p class="text-gray-600 text-sm">Deep Sea Electronic configurations and supply</p>
        </div>

        <!-- Service 8 -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
            <div class="text-green-600 mb-4 text-4xl">
                <i class="fas fa-hard-hat"></i>
            </div>
            <h4 class="text-lg font-semibold mb-2">Heavy Equipment Repairs</h4>
            <p class="text-gray-600 text-sm">Professional repair services for heavy machinery</p>
        </div>

        <!-- Service 9 -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
            <div class="text-green-600 mb-4 text-4xl">
                <i class="fas fa-car-battery"></i>
            </div>
            <h4 class="text-lg font-semibold mb-2">Auto Electrical Services</h4>
            <p class="text-gray-600 text-sm">Specialized electrical services for heavy equipment</p>
        </div>

        <!-- Service 10 -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
            <div class="text-green-600 mb-4 text-4xl">
                <i class="fas fa-truck-pickup"></i>
            </div>
            <h4 class="text-lg font-semibold mb-2">Machine Hire</h4>
            <p class="text-gray-600 text-sm">Equipment rental services for various needs</p>
        </div>

        <!-- Service 11 -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
            <div class="text-green-600 mb-4 text-4xl">
                <i class="fas fa-box-open"></i>
            </div>
            <h4 class="text-lg font-semibold mb-2">Heavy Equipment Spares</h4>
            <p class="text-gray-600 text-sm">Supply of genuine parts for heavy machinery</p>
        </div>

        <!-- Service 12 -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
            <div class="text-green-600 mb-4 text-4xl">
                <i class="fas fa-engine"></i>
            </div>
            <h4 class="text-lg font-semibold mb-2">Engine Rebuilds</h4>
            <p class="text-gray-600 text-sm">Complete engine and transmission rebuild services</p>
        </div>


    </div>
</div>

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    /* Custom generator icon */
    .fa-generator:before {
        content: "⚙️";
        font-style: normal;
    }
    .fa-engine:before {
        content: "🔧";
        font-style: normal;
    }
</style>
@endpush
@endsection