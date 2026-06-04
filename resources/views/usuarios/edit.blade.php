<x-layouts::app :title="__('Editar Usuario')">
    <!-- ENCABEZADO DE PAGINA -->
    <div class="mb-6">
        <flux:heading size="xl">{{ __('Editar Usuario') }}</flux:heading>
    </div>
    <!-- CONTENEDOR PRINCIPAL -->
    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <!-- FORMULARIO DE EDICION -->
            <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                @csrf @method('PUT')

                <!-- CAMPOS PRINCIPALES -->
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nombre
                            *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $usuario->name) }}" required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        @error('name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Email
                            *</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}" required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                        @error('email') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="role"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Rol *</label>
                        <select name="role" id="role" required
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            <option value="employee" {{ old('role', $usuario->role) == 'employee' ? 'selected' : '' }}>
                                Empleado</option>
                            <option value="admin" {{ old('role', $usuario->role) == 'admin' ? 'selected' : '' }}>
                                Administrador</option>
                        </select>
                    </div>
                    <div>
                        <label for="password"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Nueva
                            Contraseña</label>
                        <input type="password" name="password" id="password"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"
                            placeholder="Dejar vacío para no cambiar">
                        @error('password') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation"
                            class="mb-1 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Confirmar
                            Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-blue-500 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>
                </div>
                <!-- ACCIONES DEL FORMULARIO -->
                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                        class="rounded-lg bg-zinc-800 px-5 py-2 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-white dark:text-zinc-800 dark:hover:bg-zinc-200 transition">Actualizar</button>
                    <a href="{{ route('usuarios.index') }}"
                        class="rounded-lg px-5 py-2 text-sm font-medium text-neutral-600 hover:bg-neutral-100 dark:text-neutral-400 dark:hover:bg-neutral-800 transition">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>