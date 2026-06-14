<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Add New Bill') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    @include('navbar')
    <h1>{{ __('New Bill') }} 📝</h1>
    <p><a href="/bills">← {{ __('Back to List') }}</a></p>

    {{-- Η φόρμα στέλνει τα δεδομένα με μέθοδο POST στο route /bills --}}
    <form action="/bills" method="POST">
        {{-- ΠΟΛΥ ΣΗΜΑΝΤΙΚΟ: Το @csrf είναι απαραίτητο στη Laravel για λόγους ασφαλείας --}}
        @csrf

        <label for="title">{{ __('Bill Name / Account (e.g. Electricity, Car Service):') }}</label>
        <input type="text" id="title" name="title" required>

        <label for="amount">{{ __('Amount (€)') }}:</label>
        <input type="number" id="amount" name="amount" step="0.01">

        <label for="paid_at">{{ __('Payment Date (Optional):') }}</label>
        <input type="date" id="paid_at" name="paid_at">

        <label for="expires_at">{{ __('Due Date / Next Payment:') }}</label>
        <input type="date" id="expires_at" name="expires_at">

        <label for="notes">{{ __('Notes') }}:</label>
        <textarea id="notes" name="notes" rows="4"></textarea>

        <label for="frequency">{{ __('Bill Frequency:') }}</label>
        <select id="frequency" name="frequency">
            <option value="none">{{ __('No, it is one-time') }}</option>
            <option value="monthly">{{ __('Every Month') }}</option>
            <option value="yearly">{{ __('Every Year') }}</option>
        </select>

        <label for="category_id">{{ __('Category') }}:</label>
        <select id="category_id" name="category_id">
            <option value="">-- {{ __('No Category') }} --</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <button type="submit">{{ __('Save Bill') }}</button>
    </form>

</body>

</html>