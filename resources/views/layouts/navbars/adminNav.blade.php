    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left: Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="logo-img" src="../media/logo/ZorgSysteem_logo.png" alt="ZorgSysteem logo">
                        <span class="text-xl font-bold text-gray-900">ZorgSysteem</span>
                    </div>
                </div>
                
                <!-- Right: Profile & Logout -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('profile.view') }}" class="flex items-center text-sm rounded-full">
                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fa fa-user text-blue-600"></i>
                        </div>
                        <span class="ml-2 hidden md:block">
                            {{ auth()->user()->name ?? 'Planner' }}
                        </span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                            <i class="fa fa-sign-out mr-2"></i>Uitloggen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>