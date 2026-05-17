<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky collapsible="mobile"
        class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            {{-- ============================================ --}}
            {{-- Sección visible para TODOS (admin + employee) --}}
            {{-- ============================================ --}}
            <flux:sidebar.group :heading="__('Principal')" class="grid">
                <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>
                    {{ __('Dashboard') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group :heading="__('Ventas')" class="grid">
                <flux:sidebar.item icon="shopping-cart" :href="route('ventas.index')"
                    :current="request()->routeIs('ventas.*')">
                    {{ __('Ventas') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group :heading="__('Inventario')" class="grid">
                <flux:sidebar.item icon="archive-box" :href="route('inventario.index')"
                    :current="request()->routeIs('inventario.*')">
                    {{ __('Inventario') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            {{-- ============================================ --}}
            {{-- Sección visible SOLO para ADMIN --}}
            {{-- ============================================ --}}
            @if(auth()->user()->isAdmin())
                <flux:sidebar.group :heading="__('Catálogo')" class="grid">
                    <flux:sidebar.item icon="tag" :href="route('categorias.index')"
                        :current="request()->routeIs('categorias.*')">
                        {{ __('Categorías') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="cube" :href="route('productos.index')"
                        :current="request()->routeIs('productos.*')">
                        {{ __('Productos') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Compras')" class="grid">
                    <flux:sidebar.item icon="truck" :href="route('compras.index')"
                        :current="request()->routeIs('compras.*')">
                        {{ __('Compras') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="users" :href="route('proveedores.index')"
                        :current="request()->routeIs('proveedores.*')">
                        {{ __('Proveedores') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Configuración')" class="grid">

                    <flux:sidebar.item icon="receipt-percent" :href="route('impuestos-mensuales.index')"
                        :current="request()->routeIs('impuestos-mensuales.*')">
                        {{ __('Impuesto del Mes') }}
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="user-group" :href="route('usuarios.index')"
                        :current="request()->routeIs('usuarios.*')">
                        {{ __('Usuarios') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            @endif
        </flux:sidebar.nav>

        <flux:spacer />


        <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer" data-test="logout-button">
                        {{ __('Log out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @persist('toast')
    <flux:toast.group>
        <flux:toast />
    </flux:toast.group>
    @endpersist

    @fluxScripts
</body>

</html>