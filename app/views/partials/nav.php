 <!-- Navigation -->
            <nav class="border-b border-emerald-300 border-opacity-25 bg-emerald-600"
                x-data="{ mobileMenuOpen: false, userMenuOpen: false }">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex items-center px-2 lg:px-0">
                            <div class="hidden sm:block">
                                <div class="flex space-x-4">
                                    <!-- Current: "bg-emerald-700 text-white", Default: "text-white hover:bg-emerald-500 hover:bg-opacity-75" -->
                                    <a href="/customer/dashboard_page"
                                        class="text-white hover:bg-emerald-500 hover:bg-opacity-75 rounded-md py-2 px-3 text-sm font-medium"
                                        aria-current="page">Dashboard</a>
                                    <a href="/customer/deposit_page"
                                        class="bg-emerald-700 text-white rounded-md py-2 px-3 text-sm font-medium">Deposit</a>
                                    <a href="/customer/withdraw_page"
                                        class="text-white hover:bg-emerald-500 hover:bg-opacity-75 rounded-md py-2 px-3 text-sm font-medium">Withdraw</a>
                                    <a href="/customer/transfer_page"
                                        class="text-white hover:bg-emerald-500 hover:bg-opacity-75 rounded-md py-2 px-3 text-sm font-medium">Transfer</a>
                                </div>
                            </div>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex gap-2 sm:items-center">
                            <!-- Profile dropdown -->
                            <div class="relative ml-3" x-data="{ open: false }">
                                <div>
                                    <button @click="open = !open" type="button"
                                        class="flex rounded-full bg-white text-sm focus:outline-none"
                                        id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        <!-- <img
                        class="h-10 w-10 rounded-full"
                        src="https://avatars.githubusercontent.com/u/831997"
                        alt="Ahmed Shamim Hasan Shaon" /> -->
                                        <span
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100">
                                            <span class="font-medium leading-none text-emerald-700">AS</span>
                                        </span>
                                    </button>
                                </div>

                                <!-- Dropdown menu -->
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                    tabindex="-1">
                                    <a href="/signout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                                </div>
                            </div>
                        </div>
                        <div class="-mr-2 flex items-center sm:hidden">
                            <!-- Mobile menu button -->
                            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                                class="inline-flex items-center justify-center rounded-md p-2 text-emerald-100 hover:bg-emerald-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-emerald-500"
                                aria-controls="mobile-menu" aria-expanded="false">
                                <span class="sr-only">Open main menu</span>
                                <!-- Icon when menu is closed -->
                                <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>

                                <!-- Icon when menu is open -->
                                <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu, show/hide based on menu state. -->
                <div x-show="mobileMenuOpen" class="sm:hidden" id="mobile-menu">
                    <div class="space-y-1 pt-2 pb-3">
                        <a href="index.php?action=customer_dashboard"
                            class="text-white hover:bg-emerald-500 hover:bg-opacity-75 block rounded-md py-2 px-3 text-base font-medium"
                            aria-current="page">Dashboard</a>

                        <a href="index.php?action=deposit_form"
                            class="bg-emerald-700 text-white block rounded-md py-2 px-3 text-base font-medium">Deposit</a>

                        <a href="index.php?action=withdraw_form"
                            class="text-white hover:bg-emerald-500 hover:bg-opacity-75 block rounded-md py-2 px-3 text-base font-medium">Withdraw</a>

                        <a href="index.php?action=transfer_form"
                            class="text-white hover:bg-emerald-500 hover:bg-opacity-75 block rounded-md py-2 px-3 text-base font-medium">Transfer</a>
                    </div>
                    <div class="border-t border-emerald-700 pb-3 pt-4">
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <!-- <img
                    class="h-10 w-10 rounded-full"
                    src="https://avatars.githubusercontent.com/u/831997"
                    alt="" /> -->
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100">
                                    <span class="font-medium leading-none text-emerald-700">AS</span>
                                </span>
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-white">
                                    Ahmed Shamim
                                </div>
                                <div class="text-sm font-medium text-emerald-300">
                                    ahmed@shamim.com
                                </div>
                            </div>
                            <button type="button"
                                class="ml-auto flex-shrink-0 rounded-full bg-emerald-600 p-1 text-emerald-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-emerald-600">
                                <span class="sr-only">View notifications</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-3 space-y-1 px-2">
                            <a href="index.php?action=logout"
                                class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-emerald-500 hover:bg-opacity-75">Sign
                                out</a>
                        </div>
                    </div>
                </div>
            </nav>