<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Manage Categories') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            max-width: 1200px !important;
            width: 95%;
            margin: 20px auto;
        }

        table {
            width: 100% !important;
        }

        th,
        td {
            padding: 12px !important;
            vertical-align: middle;
        }
    </style>
</head>

<body>

    @include('navbar')

    <h1>🏷️ {{ __('Manage Categories') }}</h1>

    @if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
        {{ __(session('success')) }}
    </div>
    @endif

    <div style="background: rgba(0,0,0,0.02); padding: 20px; border-radius: 6px; border: 1px solid #ddd; margin-bottom: 30px;">
        <h3>➕ {{ __('New Category') }}</h3>
        <form action="/categories" method="POST" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
            @csrf
            <div style="flex: 2; min-width: 200px;">
                <label for="name">{{ __('Category Name:') }}</label>
                <input type="text" id="name" name="name" required style="margin:0;">
            </div>
            <div style="flex: 1; min-width: 100px;">
                <label for="color">{{ __('Color:') }}</label>
                <input type="color" id="color" name="color" value="#007bff" style="padding:0; width:100%; height:38px; border:none; cursor:pointer; margin:0;">
            </div>
            <div style="padding-top: 20px;">
                <button type="submit" style="margin:0;">{{ __('Save') }}</button>
            </div>
        </form>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: rgba(0,0,0,0.02);">
                <th style="text-align: left; padding: 12px; width: 80px;">{{ __('Color:') }}</th>
                <th style="text-align: left; padding: 12px;">{{ __('Category Name:') }}</th>
                <th style="text-align: right; padding: 12px; width: 120px; white-space: nowrap;">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 12px; vertical-align: middle;">
                    <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background-color: {{ $category->color }}; border: 1px solid #ccc;"></span>
                </td>
                <td style="padding: 12px; vertical-align: middle;">
                    <strong>{{ $category->name }}</strong>
                </td>
                <td style="padding: 12px; text-align: right; vertical-align: middle;">
                    <div style="display: inline-flex; gap: 8px; justify-content: flex-end;">
                        <a href="/categories/{{ $category->id }}/edit" style="background-color: #f0ad4e; color: white; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 4px; padding: 0;" title="{{ __('Edit Bill') }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="/categories/{{ $category->id }}" method="POST" style="margin: 0; display: inline;" onsubmit="return confirm('{{ __('If you delete this category, its bills will be left without a category. Are you sure?') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: #ff4d4d; color: white; width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center; border: none; border-radius: 4px; cursor: pointer; padding: 0; margin: 0;" title="{{ __('Delete') }}">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center; padding: 20px;">{{ __('You haven\'t created any custom categories yet.') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>