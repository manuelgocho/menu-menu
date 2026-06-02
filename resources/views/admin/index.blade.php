@extends('layouts.app')

@section('content')
    <section class="rounded-3xl border border-blue-600/30 bg-white/5 p-8 shadow-2xl shadow-blue-900/10">
        <div class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.3em] text-blue-400">Panel administrativo</p>
                <h1 class="mt-3 text-4xl font-black uppercase tracking-tight text-white">Editar productos del menú</h1>
                <p class="mt-4 max-w-2xl text-sm leading-relaxed text-gray-300">Modifica nombres, descripciones, precios y categorías. Los productos se guardan en la base de datos SQLite del proyecto.</p>
            </div>
            <a href="{{ route('menu') }}" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-sm font-black uppercase tracking-widest text-white transition hover:bg-blue-700">Ver menú público</a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-3xl border border-green-500/20 bg-green-500/10 p-4 text-sm text-green-100">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-3xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-100">
                <p class="font-black uppercase tracking-widest text-red-200">Hay errores al guardar:</p>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-6">
            @forelse($products as $product)
                <form action="{{ route('admin.products.update', $product) }}" method="POST" class="rounded-3xl border border-blue-600/30 bg-black/70 p-6 shadow-lg shadow-blue-900/10">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-4 lg:grid-cols-[1.2fr_0.8fr]">
                        <div class="space-y-4">
                            <label class="block">
                                <span class="text-xs font-black uppercase tracking-widest text-gray-400">Nombre del producto</span>
                                <input name="name" value="{{ old('name', $product->name) }}" class="mt-2 w-full rounded-3xl border border-blue-600/30 bg-black/80 px-4 py-3 text-white focus:border-blue-400 focus:outline-none" required>
                            </label>
                            <label class="block">
                                <span class="text-xs font-black uppercase tracking-widest text-gray-400">Descripción</span>
                                <textarea name="description" rows="3" class="mt-2 w-full rounded-3xl border border-blue-600/30 bg-black/80 px-4 py-3 text-white focus:border-blue-400 focus:outline-none">{{ old('description', $product->description) }}</textarea>
                            </label>
                        </div>

                        <div class="grid gap-4">
                            <label class="block">
                                <span class="text-xs font-black uppercase tracking-widest text-gray-400">Precio USD</span>
                                <input name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" class="mt-2 w-full rounded-3xl border border-blue-600/30 bg-black/80 px-4 py-3 text-white focus:border-blue-400 focus:outline-none" required>
                            </label>
                            <label class="block">
                                <span class="text-xs font-black uppercase tracking-widest text-gray-400">Categoría</span>
                                <input name="category" value="{{ old('category', $product->category) }}" class="mt-2 w-full rounded-3xl border border-blue-600/30 bg-black/80 px-4 py-3 text-white focus:border-blue-400 focus:outline-none" required>
                            </label>
                            <label class="block">
                                <span class="text-xs font-black uppercase tracking-widest text-gray-400">Etiqueta</span>
                                <input name="tag" value="{{ old('tag', $product->tag) }}" class="mt-2 w-full rounded-3xl border border-blue-600/30 bg-black/80 px-4 py-3 text-white focus:border-blue-400 focus:outline-none">
                            </label>
                            <label class="block">
                                <span class="text-xs font-black uppercase tracking-widest text-gray-400">Badge</span>
                                <input name="badge" value="{{ old('badge', $product->badge) }}" class="mt-2 w-full rounded-3xl border border-blue-600/30 bg-black/80 px-4 py-3 text-white focus:border-blue-400 focus:outline-none">
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-sm font-black uppercase tracking-widest text-white transition hover:bg-blue-700">Actualizar</button>
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                            <span class="text-xs uppercase tracking-widest text-gray-400">ID {{ $product->id }}</span>
                            <button type="submit" form="delete-product-{{ $product->id }}" class="rounded-full border border-red-500/30 bg-red-500/10 px-5 py-3 text-sm font-black uppercase tracking-widest text-red-200 transition hover:bg-red-500/20">Eliminar</button>
                        </div>
                    </div>
                </form>
                <form id="delete-product-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @empty
                <div class="rounded-3xl border border-blue-600/30 bg-black/60 p-8 text-gray-300">
                    No hay productos registrados. Agrega uno nuevo abajo.
                </div>
            @endforelse
        </div>

        <div class="mt-10 rounded-3xl border border-blue-600/30 bg-black/70 p-6 shadow-lg shadow-blue-900/10">
            <h2 class="text-2xl font-black uppercase tracking-tight text-white">Agregar nuevo producto</h2>
            <form action="{{ route('admin.products.store') }}" method="POST" class="mt-6 grid gap-4 lg:grid-cols-[1.2fr_0.8fr]">
                @csrf
                <div class="space-y-4">
                    <label class="block">
                        <span class="text-xs font-black uppercase tracking-widest text-gray-400">Nombre</span>
                        <input name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-3xl border border-blue-600/30 bg-black/80 px-4 py-3 text-white focus:border-blue-400 focus:outline-none" required>
                    </label>
                    <label class="block">
                        <span class="text-xs font-black uppercase tracking-widest text-gray-400">Descripción</span>
                        <textarea name="description" rows="3" class="mt-2 w-full rounded-3xl border border-blue-600/30 bg-black/80 px-4 py-3 text-white focus:border-blue-400 focus:outline-none">{{ old('description') }}</textarea>
                    </label>
                </div>

                <div class="space-y-4">
                    <label class="block">
                        <span class="text-xs font-black uppercase tracking-widest text-gray-400">Precio USD</span>
                        <input name="price" type="number" step="0.01" value="{{ old('price') }}" class="mt-2 w-full rounded-3xl border border-blue-600/30 bg-black/80 px-4 py-3 text-white focus:border-blue-400 focus:outline-none" required>
                    </label>
                    <label class="block">
                        <span class="text-xs font-black uppercase tracking-widest text-gray-400">Categoría</span>
                        <input name="category" value="{{ old('category') }}" class="mt-2 w-full rounded-3xl border border-blue-600/30 bg-black/80 px-4 py-3 text-white focus:border-blue-400 focus:outline-none" required>
                    </label>
                    <label class="block">
                        <span class="text-xs font-black uppercase tracking-widest text-gray-400">Etiqueta</span>
                        <input name="tag" value="{{ old('tag') }}" class="mt-2 w-full rounded-3xl border border-blue-600/30 bg-black/80 px-4 py-3 text-white focus:border-blue-400 focus:outline-none">
                    </label>
                    <label class="block">
                        <span class="text-xs font-black uppercase tracking-widest text-gray-400">Badge</span>
                        <input name="badge" value="{{ old('badge') }}" class="mt-2 w-full rounded-3xl border border-blue-600/30 bg-black/80 px-4 py-3 text-white focus:border-blue-400 focus:outline-none">
                    </label>
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-green-500 px-6 py-3 text-sm font-black uppercase tracking-widest text-black transition hover:bg-green-400">Agregar producto</button>
                </div>
            </form>
        </div>
    </section>
@endsection
