            <header class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
                <div class="px-4 py-4">
                    <div class="flex items-center justify-between">

                        <button id="toggleSidebar"
                            class="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-600 border border-gray-200">
                            <i id="toggleIcon" data-feather="menu" class="w-5 h-5"></i>
                        </button>

                        {{-- Admin --}}
                        <div class="relative">
                            <button id="adminButton"
                                class="flex items-center gap-3 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-100">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <i data-feather="user" class="w-4 h-4 text-white"></i>
                                </div>
                                <span class="text-gray-700 font-semibold text-sm hidden sm:block">{{ Auth::user()->name }}</span>
                                <i data-feather="chevron-down" class="w-4 h-4 text-gray-400"></i>
                            </button>

                            <div id="adminDropdown"
                                class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 z-50">

                                <div class="p-3 border-b">
                                    <p class="text-xs text-gray-500">Masuk sebagai</p>
                                    <p class="font-semibold text-gray-900 text-sm">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ Auth::user()->email }}</p>
                                </div>

                                <a href="{{ route('profile') }}"
                                    class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 text-gray-700 text-sm transition-colors">
                                    <i data-feather="user" class="w-4 h-4"></i>
                                    <span>Profil Saya</span>
                                </a>

                                <form method="POST" action="{{ route('logout') }}" class="p-2 border-t">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-50 text-red-600 transition-colors">
                                        <i data-feather="log-out" class="w-4 h-4"></i> Logout
                                    </button>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </header>
