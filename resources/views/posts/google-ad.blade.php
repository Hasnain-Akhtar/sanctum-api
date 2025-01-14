<section class="text-gray-600 body-font bg-gradient-to-r from-gray-800 via-gray-900 to-black border-white border-2 rounded-lg shadow-xl">
  <div class="container py-16 mx-auto">
    <h2 class="text-3xl font-semibold text-white text-center uppercase tracking-wider mb-6">Google Ads</h2>
    <div class="lg:w-4/6 mx-auto overflow-hidden" style="max-height: 500px;">
      <ul id="googleAdsList" class="list-decimal list-inside space-y-6" style="animation: scrollList 40s linear infinite;">
        ${posts.map(post => `
          <li id="ad-${post.id}" class="flex items-start space-x-4 p-4 bg-white rounded-lg shadow-md">
            <div class="w-24 h-24 flex-shrink-0">
              <img alt="Post Image" class="object-cover object-center w-full h-full rounded-lg border-2 border-white" src="https://picsum.photos/id/${Math.floor(Math.random() * 1000)}/200/300">
            </div>
            <div class="flex-grow">
              <h3 class="text-lg font-semibold text-gray-900">${post.title}</h3>
              <p class="text-sm leading-relaxed text-gray-600">${post.description.slice(0, 50)}...</p>
              <div class="mt-3">
                <button class="text-indigo-500 inline-flex items-center hover:text-indigo-600" onclick="viewPost('${post.id}')">Learn More
                  <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                    <path d="M12 5l7 7-7 7"></path>
                  </svg>
                </button>
              </div>
            </div>
          </li>
        `).join('')}
      </ul>
    </div>
  </div>
</section>

<style>
  @keyframes scrollList {
    0% {
      transform: translateY(0);
    }
    100% {
      transform: translateY(calc(-100%));
    }
  }

  #googleAdsList {
    display: flex;
    flex-direction: column;
    gap: 1.5rem; /* Matches space-y-6 */
  }

  #googleAdsList > li {
    transition: transform 0.3s ease-in-out;
  }
</style>

