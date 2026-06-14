<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Edit Bill') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    @include('navbar')
    <h1>{{ __('Edit:') }} {{ $bill->title }} ✏️</h1>
    <p><a href="/bills">← {{ __('Back to List') }}</a></p>

    {{-- Η φόρμα στέλνει τα δεδομένα στο /bills/id --}}
    <form action="/bills/{{ $bill->id }}" method="POST">
        @csrf
        @method('PUT') {{-- Η Laravel χρειάζεται το PUT για ανανεώσεις δεδομένων --}}

        <label for="title">{{ __('Bill Name') }}:</label>
        <input type="text" id="title" name="title" value="{{ $bill->title }}" required>

        <label for="amount">{{ __('Amount (€)') }}:</label>
        <input type="number" id="amount" name="amount" step="0.01" value="{{ $bill->amount }}">

        <label for="paid_at">{{ __('Payment Date') }}:</label>
        <input type="date" id="paid_at" name="paid_at"
            value="{{ $bill->paid_at ? $bill->paid_at->format('Y-m-d') : '' }}">

        <label for="expires_at">{{ __('Due Date') }}:</label>
        <input type="date" id="expires_at" name="expires_at"
            value="{{ $bill->expires_at ? $bill->expires_at->format('Y-m-d') : '' }}">

        <label for="notes">{{ __('Notes') }}:</label>
        <textarea id="notes" name="notes" rows="4">{{ $bill->notes }}</textarea>

        <label for="frequency">{{ __('Bill Frequency:') }}</label>
        <select id="frequency" name="frequency">
            <option value="none" {{ $bill->frequency == 'none' ? 'selected' : '' }}>{{ __('No, it is one-time') }}</option>
            <option value="monthly" {{ $bill->frequency == 'monthly' ? 'selected' : '' }}>{{ __('Every Month') }}</option>
            <option value="yearly" {{ $bill->frequency == 'yearly' ? 'selected' : '' }}>{{ __('Every Year') }}</option>
        </select>

        <label for="category_id">{{ __('Category') }}:</label>
        <select id="category_id" name="category_id">
            <option value="">-- {{ __('No Category') }} --</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $bill->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>

        <button type="submit">{{ __('Save Changes') }}</button>
    </form>

</body>

</html>