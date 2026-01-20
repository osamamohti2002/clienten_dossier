@extends('layouts.app')

@section('content')
<div class="px-4 py-6 sm:px-0 max-w-3xl mx-auto">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Rapportage bewerken</h1>
        <p class="text-gray-600 mt-1">Wijzig je rapportage en sla op</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200 text-red-800">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('zorg.reports.update', $report->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rapportage *</label>
                <textarea name="report"
                          rows="6"
                          class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                          required>{{ old('report', $report->report) }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('zorg.reports.index', $report->client_id) }}"
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Annuleren
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Opslaan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection