
            
            {{-- <ul class="navbar-item flex-row nav-dropdowns">
                <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
                     --}}<!-- Settings Dropdown -->
                    <nav x-data="{ open: false }" class="bg-gray border-b border-gray-200 col-12">
                        <!-- Primary Navigation Menu -->
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="flex justify-between h-16"> 
                                <div class="flex">
                                     <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></a> 
                                    <div class="nav-logo align-self-center">
                                        <a class="navbar-brand" href="/dash"><img style="width: 80px" alt="logo" src="{{ asset('images/favicon-96x96.png') }}"></a>
                                    </div>
                                    <ul class="navbar-item flex-row mr-auto">
                                        <li class="nav-item align-self-center search-animated">
                                            
                                        </li>
                                    </ul>

                                </div>
                                <!-- Settings Dropdown -->
                                <div class="hidden sm:flex sm:items-center sm:ml-10 order-lg-0 order-1">
                                    <x-jet-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                                </button>
                                            @else
                                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                                    <div>{{ Auth::user()->name }}</div>
                    
                                                    <div class="ml-1">
                                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            @endif
                                        </x-slot>
                    
                                        <x-slot name="content">
                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Gerenciar conta') }}
                                            </div>
                    
                                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                                {{ __('Perfil') }}
                                            </x-jet-dropdown-link>
                    
                                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                                    {{ __('API Tokens') }}
                                                </x-jet-dropdown-link>
                                            @endif
                    
                                            <div class="border-t border-gray-100"></div>
                    
                                            <!-- Team Management -->
                                            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    {{ __('Manage Team') }}
                                                </div>
                    
                                                <!-- Team Settings -->
                                                <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                                    {{ __('Team Settings') }}
                                                </x-jet-dropdown-link>
                    
                                                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                                    <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                                        {{ __('Create New Team') }}
                                                    </x-jet-dropdown-link>
                                                @endcan
                    
                                                <div class="border-t border-gray-100"></div>
                    
                                                <!-- Team Switcher -->
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    {{ __('Switch Teams') }}
                                                </div>
                    
                                                @foreach (Auth::user()->allTeams() as $team)
                                                    <x-jet-switchable-team :team="$team" />
                                                @endforeach
                    
                                                <div class="border-t border-gray-100"></div>
                                            @endif
                    
                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                    
                                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                                                    onclick="event.preventDefault();
                                                                                this.closest('form').submit();">
                                                    {{ __('Logout') }}
                                                </x-jet-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-jet-dropdown>
                                </div>
                            </div>
                            <!-- Hamburger -->
           {{-- <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div> --}}
                        </div>
                    </nav>

{{-- 
                </li> 
            </ul> --}}
