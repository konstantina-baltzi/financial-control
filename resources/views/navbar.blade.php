<nav style="display: flex; justify-content: space-between; align-items: center; background-color: #f8f9fa; padding: 10px 20px; border-radius: 6px; margin-bottom: 30px; border: 1px solid #e2e8f0;">
    <div style="display: flex; gap: 20px; align-items: center;">
        <span style="font-weight: bold; color: #333;">📊 Financial Control</span>
        <a href="/bills" style="text-decoration: none; color: #0076d6; font-weight: 500;">📅 {{ __('Bills') }}</a>
        <a href="/categories" style="text-decoration: none; color: #0076d6; font-weight: 500;">🏷️ {{ __('Manage Categories') }}</a>
    </div>

    <div style="display: flex; align-items: center; gap: 18px;">
        <span style="font-size: 14px; color: #555;">👤 {{ auth()->user()->name }}</span>

        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" style="background-color: #e2e8f0; color: #333; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 13px;">{{ __('Logout') }}</button>
        </form>

        <div style="display: flex; gap: 15px; align-items: center; border-left: 1px solid #e2e8f0; padding-left: 15px; font-size: 14px; font-weight: bold;">
            <a href="/lang/en" title="English" style="text-decoration: none; color: {{ app()->getLocale() == 'en' ? '#0076d6' : '#94a3b8' }}; display: flex; align-items: center; gap: 4px;">
                EN
                @if(app()->getLocale() == 'en')
                @endif
            </a>

            <span style="color: #cbd5e1;">|</span>

            <a href="/lang/el" title="Ελληνικά" style="text-decoration: none; color: {{ app()->getLocale() == 'el' ? '#0076d6' : '#94a3b8' }}; display: flex; align-items: center; gap: 4px;">
                EL
                @if(app()->getLocale() == 'el')
                @endif
            </a>
        </div>
    </div>
</nav>