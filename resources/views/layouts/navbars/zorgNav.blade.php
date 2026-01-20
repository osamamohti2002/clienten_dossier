<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left: Logo -->
            <div class="flex items-center">
                <img class="h-10 w-auto mr-3 object-contain"
                     src="{{ asset('media/logo/ZorgSysteem_logo.png') }}"
                     alt="ZorgSysteem logo">
                <span class="text-xl font-bold text-gray-900">ZorgSysteem</span>
            </div>

            <!-- Middle: Navigation -->
            <div class="hidden md:flex items-center space-x-3">
                <a href="{{ route('zorg.dashboard') }}"
                   class="px-4 py-2 rounded-md text-sm font-medium
                          {{ request()->routeIs('zorg.dashboard')
                                ? 'bg-blue-600 text-white'
                                : 'border border-blue-600 text-blue-600 hover:bg-blue-50' }}">
                    Routes
                </a>

                <a href="{{ route('zorg.clients.index') }}"
                   class="px-4 py-2 rounded-md text-sm font-medium
                          {{ request()->routeIs('zorg.clients.*')
                                ? 'bg-blue-600 text-white'
                                : 'border border-blue-600 text-blue-600 hover:bg-blue-50' }}">
                    Cliënten
                </a>
            </div>

            <!-- Right: User + Logout -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center text-sm text-gray-700">
                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center mr-2">
                        <i class="fa fa-user text-blue-600"></i>
                    </div>
                    {{ auth()->user()->name }}
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        Uitloggen
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>