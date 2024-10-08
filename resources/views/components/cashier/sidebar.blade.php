<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-blue-600 border-r border-gray-200 xl:translate-x-0"
    aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full bg-blue-600">
        <ul class="space-y-2">
            @can('isCashier')
                <li>
                    <a href="/cashier"
                        class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:text-gray-900 hover:bg-gray-100 group">
                        <ion-icon name="grid"
                            class="w-6 h-6 text-gray-50 transition duration-75 group-hover:text-gray-900"></ion-icon>
                        <span class="ml-3">Overview</span>
                    </a>
                </li>
                <li>
                    <button type="button"
                        class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                        aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                        <ion-icon name="bag-check"
                            class="w-6 h-6 text-gray-50 transition duration-75 group-hover:text-gray-900"></ion-icon>
                        <span
                            class="flex-1 ml-3 text-left whitespace-nowrap text-white group-hover:text-gray-900">Transaction</span>
                        <ion-icon name="chevron-down" class="w-6 h-6 text-gray-50 group-hover:text-gray-900"></ion-icon>
                    </button>
                    <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                        <li>
                            <a href="/cashier/sales"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-50 hover:text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Sales</a>
                        </li>
                        <li>
                            <a href="/cashier/sales/history"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-50 hover:text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">History</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:text-gray-900 hover:bg-gray-100 group">
                        <ion-icon name="swap-horizontal"
                            class="w-6 h-6 text-gray-50 transition duration-75 group-hover:text-gray-900"></ion-icon>
                        <span class="ml-3">Retur</span>
                    </a>
                </li>
                <li>
                    <a href="/cashier/inventory"
                        class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:text-gray-900 hover:bg-gray-100 group">
                        <ion-icon name="albums"
                            class="w-6 h-6 text-gray-50 transition duration-75 group-hover:text-gray-900"></ion-icon>
                        <span class="ml-3">Inventory</span>
                    </a>
                </li>
            @endcan

            @can('isAdmin')
                <li>
                    <a href="/admin"
                        class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:text-gray-900 hover:bg-gray-100 group">
                        <ion-icon name="grid"
                            class="w-6 h-6 text-gray-50 transition duration-75 group-hover:text-gray-900"></ion-icon>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/shop"
                        class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:text-gray-900 hover:bg-gray-100 group">
                        <ion-icon name="storefront"
                            class="w-6 h-6 text-gray-50 transition duration-75 group-hover:text-gray-900"></ion-icon>
                        <span class="ml-3">Shop</span>
                    </a>
                </li>
                <li>
                    <button type="button"
                        class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                        aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                        <ion-icon name="podium"
                            class="w-6 h-6 text-gray-50 transition duration-75 group-hover:text-gray-900"></ion-icon>
                        <span
                            class="flex-1 ml-3 text-left whitespace-nowrap text-white group-hover:text-gray-900">Product</span>
                        <ion-icon name="chevron-down" class="w-6 h-6 text-gray-50 group-hover:text-gray-900"></ion-icon>
                    </button>
                    <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                        <li>
                            <a href="/admin/product/in"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-50 hover:text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Add
                                Product</a>
                        </li>
                        <li>
                            <a href="/admin/product/in"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-50 hover:text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">In
                                Product</a>
                        </li>
                        <li>
                            <a href="/admin/product"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium text-gray-50 hover:text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100">Inventory</a>
                        </li>
                    </ul>
                </li>
            @endcan
        </ul>

        <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200">
            @can('cashier')
                <li>
                    <a href="/cashier/profile"
                        class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:text-gray-900 hover:bg-gray-100 group">
                        <ion-icon name="person"
                            class="w-6 h-6 text-gray-50 transition duration-75 group-hover:text-gray-900"></ion-icon>
                        <span class="ml-3">Cashier Profile</span>
                    </a>
                </li>
            @endcan
            <li>
                <form action="/authentication" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit"
                        class="flex items-center p-2 text-base font-medium text-gray-50 rounded-lg transition duration-75 hover:bg-gray-100 hover:text-gray-900 group w-full">
                        <ion-icon name="log-out"
                            class="w-6 h-6 text-gray-50 transition duration-75 group-hover:text-gray-900"></ion-icon>
                        <span class="ml-3">Log Out</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
