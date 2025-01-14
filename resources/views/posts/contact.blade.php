@extends('layouts.app') <!-- Assuming 'app' is your layout -->

@section('title', 'Contact-Us')
@section('content')
    <section class="text-gray-600 body-font relative mt-4 mb-4">
        <!-- Map Container with lower z-index -->
        <div class="map-container absolute inset-0 z-0 w-full h-full px-5 overflow-hidden rounded-lg">
            <iframe title="map" src="https://maps.google.com/maps?width=800&amp;height=600&amp;hl=en&amp;q=%C4%B0zmir+(My%20Business%20Name)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=B&amp;output=embed" class="w-full h-full border-0 shimmer-img" style="border-radius: 20px;"></iframe>
        </div>
        
        <!-- Contact Form Container with higher z-index -->
        <div class="container px-5 py-5 mx-auto flex relative z-10 contact-form-container">
            <div class="lg:w-1/3 md:w-1/2 bg-white rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0 shadow-md">
                <form action="/contact" method="POST">
                    @csrf
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font shimmer-text">Contact Us</h2>
                    <p class="leading-relaxed mb-5 text-gray-600 shimmer-text">We are here to listen and help you.</p>
                    
                    <!-- Email Input -->
                    <div class="relative mb-4">
                        <label for="email" class="leading-7 text-sm text-gray-600 shimmer-text">Email</label>
                        <input type="email" id="email" name="email" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out shimmer-text">
                    </div>
                    
                    <!-- Message Input -->
                    <div class="relative mb-4">
                        <label for="message" class="leading-7 text-sm text-gray-600 shimmer-text">Message</label>
                        <textarea id="message" name="message" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out shimmer-text"></textarea>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg shimmer-text">Submit</button>
                    
                    <!-- Footer Text -->
                    <p class="text-xs text-gray-500 mt-3 shimmer-text">We are here to listen, so please don't hesitate to contact us with any questions or comments.</p>
                </form>
            </div>
        </div>
    </section>
@endsection

<style>
    .contact-form-container {
        display: flex;
        flex-direction: row;
    }
    .map-container {
        width: 50%;
    }
    .map-container iframe {
        width: 100%;
        height: 100%;
    }
    .md:w-1/2 {
        width: 50%;
    }
    @media (max-width: 768px) {
        .contact-form-container {
            flex-direction: column;
        }
        .map-container {
            width: 100%;
        }
        .md:w-1/2 {
            width: 100%;
        }
    }
</style>

