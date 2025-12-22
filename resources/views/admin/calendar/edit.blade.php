@extends('layouts.admin')

@section('title', 'Edit Event')
@section('page-title', 'Edit Event')

@section('content')
    <div class="max-w-2xl">
        <form action="{{ route('admin.calendar.update', $event) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="glass-card rounded-2xl p-6 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Judul Event</label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tanggal
                            Mulai</label>
                        <input type="datetime-local" name="event_date"
                            value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tanggal
                            Selesai</label>
                        <input type="datetime-local" name="end_date"
                            value="{{ old('end_date', $event->end_date?->format('Y-m-d\TH:i')) }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Kategori</label>
                        <select name="category"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <option value="">Pilih Kategori</option>
                            <option value="Akademik" {{ $event->category == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="Ekstrakurikuler" {{ $event->category == 'Ekstrakurikuler' ? 'selected' : '' }}>
                                Ekstrakurikuler</option>
                            <option value="Libur" {{ $event->category == 'Libur' ? 'selected' : '' }}>Libur</option>
                            <option value="Ujian" {{ $event->category == 'Ujian' ? 'selected' : '' }}>Ujian</option>
                            <option value="Kegiatan" {{ $event->category == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Warna</label>
                        <input type="color" name="color" value="{{ old('color', $event->color) }}"
                            class="w-full h-12 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', $event->location) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">{{ old('description', $event->description) }}</textarea>
                </div>

                <label class="flex items-center">
                    <input type="checkbox" name="is_all_day" value="1" {{ $event->is_all_day ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-slate-300 text-cyan-500 focus:ring-cyan-500">
                    <span class="ml-2 text-sm text-slate-700 dark:text-slate-300">Event sepanjang hari</span>
                </label>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.calendar.index') }}"
                    class="px-6 py-3 text-slate-700 dark:text-slate-300 font-medium rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">Batal</a>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-teal-500 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-cyan-500/30 transition-all duration-300">Update
                    Event</button>
            </div>
        </form>
    </div>
@endsection