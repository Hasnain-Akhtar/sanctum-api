<section class="text-gray-600 body-font bg-gradient-to-r from-gray-800 via-gray-900 to-black border-white border-2 rounded-lg shadow-xl mt-12">
    <div class="container py-16 mx-auto">
      <h2 class="text-3xl font-semibold text-white text-center uppercase tracking-wider">Spotlight Post</h2>
      <div class="lg:w-4/6 mx-auto">
        <!-- Auto-Moving Image Carousel -->
        <div class="relative overflow-hidden rounded-lg mb-6 mt-5">
          <div id="carousel" class="flex w-max animate-scroll space-x-6 cursor-grab"
            onmouseover="this.classList.add('paused')" onmouseout="this.classList.remove('paused')">
            <!-- Spotlight Items -->
            ${posts.map(post => `
            <div class="flex-shrink-0 w-96 group">
              <div class="transform group-hover:scale-105 transition duration-500 ease-in-out">
                <img alt="Post Image" class="object-cover object-center h-72 w-full rounded-lg shadow-lg border-2 border-white group-hover:scale-110" src="/uploads/${post.image}"
                  onmouseover="this.classList.add('zoom-in')" onmouseout="this.classList.remove('zoom-in')">
              </div>
              <div class="min-w-0 flex-auto">
                <p class="text-sm font-semibold text-gray-900">${post.title}</p>
                <p class="mt-1 truncate text-xs text-gray-500">${post.description}</p>
                <div class="flex flex-wrap mt-3">
                  <button class="text-indigo-500 inline-flex items-center mr-3 hover:text-indigo-600" onclick="viewPost('${post.id}')">Learn More
                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M5 12h14"></path>
                      <path d="M12 5l7 7-7 7"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </div>`).join('')}
          </div>
        </div>
      </div>
    </div>
  </section>