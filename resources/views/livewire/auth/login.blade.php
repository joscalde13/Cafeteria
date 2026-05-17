<x-layouts::auth.minimal :title="__('Log in')">
    <div class="flex min-h-screen">
        <!-- Left Banner: Cafe Image -->
        <div
            class="relative hidden w-1/2 lg:flex flex-col justify-end bg-stone-900 border-r border-stone-200 shadow-xl overflow-hidden">
            <!-- Professional Cafe Aesthetic Image -->
            <img class="absolute inset-0 h-full w-full object-cover opacity-50 mix-blend-overlay"
                src="https://images.unsplash.com/photo-1497935586351-b67a49e012bf?q=80&w=2000&auto=format&fit=crop"
                alt="Imagen de Cafe" />

            <div class="relative z-10 p-12 text-white bg-gradient-to-t from-stone-900/95 to-transparent pt-32">

                <h1 class="text-5xl font-light tracking-tight mb-4 text-stone-50 drop-shadow-sm">Cafeteria</h1>
                <p class="text-lg font-light text-stone-300 max-w-md drop-shadow">
                    El aroma del éxito en cada inicio de sesión. Ingrese sus credenciales para acceder al sistema.
                </p>
            </div>
        </div>

        <!-- Right Form Panel -->
        <div
            class="flex flex-1 flex-col justify-center px-6 py-12 sm:px-12 lg:px-24 bg-stone-50 relative selection:bg-stone-300 selection:text-stone-900">
            <!-- Decorative circle -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 h-64 w-64 rounded-full bg-stone-200/50 blur-3xl"></div>

            <div
                class="mx-auto w-full max-w-md relative z-10 p-8 sm:p-10 rounded-[2rem] bg-white lg:bg-transparent lg:p-0 shadow-2xl shadow-stone-200/40 lg:shadow-none border border-stone-100 lg:border-none">

                <div class="flex justify-center mb-8 lg:hidden">
                    <span class="inline-flex items-center justify-center p-3.5 bg-stone-900 rounded-2xl shadow-md">
                        <x-app-logo-icon class="h-10 w-10 text-white" />
                    </span>
                </div>

                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-3xl font-bold text-stone-900 tracking-tight">Bienvenido</h2>
                    <p class="mt-3 text-sm text-stone-500 font-medium">Por favor ingresa tus detalles para acceder al
                        panel.</p>
                </div>

                <x-auth-session-status
                    class="mb-6 text-sm font-medium text-emerald-600 bg-emerald-50 px-4 py-3 rounded-xl border border-emerald-100"
                    :status="session('status')" />

                <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-1">
                        <label for="email"
                            class="block text-[11px] font-bold text-stone-500 uppercase tracking-widest px-1 mb-2">Correo
                            Electrónico</label>
                        <div class="relative group">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                autocomplete="email" placeholder="nombre@ejemplo.com"
                                class="block w-full rounded-2xl border-0 py-3.5 px-4 text-stone-900 shadow-sm ring-1 ring-inset ring-stone-200 placeholder:text-stone-300 focus:ring-2 focus:ring-inset focus:ring-stone-900 sm:text-sm transition-all bg-white hover:ring-stone-300" />
                        </div>
                        @error('email')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center justify-between px-1 mb-2">
                            <label for="password"
                                class="block text-[11px] font-bold text-stone-500 uppercase tracking-widest">Contraseña</label>
                        </div>
                        <div class="relative group">
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password" placeholder="••••••••"
                                class="block w-full rounded-2xl border-0 py-3.5 px-4 text-stone-900 shadow-sm ring-1 ring-inset ring-stone-200 placeholder:text-stone-300 focus:ring-2 focus:ring-inset focus:ring-stone-900 sm:text-sm transition-all bg-white hover:ring-stone-300" />
                        </div>
                        @error('password')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">


                        </div>

                    </div>

                    <div class="pt-4">
                        <button type="submit" data-test="login-button"
                            class="group relative flex w-full items-center justify-center gap-3 rounded-2xl bg-stone-900 px-4 py-4 text-sm font-bold text-white shadow-lg shadow-stone-900/20 hover:bg-stone-800 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-stone-900 focus:ring-offset-2 transition-all active:scale-[0.98] duration-200">
                            Iniciar sesión
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                @if (Route::has('register'))
                    <div class="mt-8 text-center text-sm font-medium text-stone-500">
                        ¿Trabajas aquí pero no tienes cuenta?
                        <a href="mailto:admin@cafeteria.com"
                            class="font-bold text-stone-900 hover:underline underline-offset-4 decoration-2 decoration-stone-300 transition-all">
                            Contactar Admin
                        </a>
                    </div>
                @endif
            </div>


        </div>
    </div>
</x-layouts::auth.minimal>