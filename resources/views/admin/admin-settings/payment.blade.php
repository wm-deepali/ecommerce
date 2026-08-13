<form method="POST"
      action="{{ route('admin.payment-settings.store') }}">
    @csrf
    
    <div class="settings-content" style="max-width:720px">

    <!-- Razorpay header card -->
    <div class="razorpay-header">
        <div class="razorpay-logo">
            <i class="fa-solid fa-bolt"></i>
        </div>
        <div>
            <div class="razorpay-name">Razorpay</div>
            <div class="razorpay-desc">India's leading payment gateway — UPI, Cards, Net Banking, Wallets &amp; EMI
            </div>
        </div>
        <div style="margin-left:auto">
            <span class="mode-pill mode-test" id="modePill">Test Mode</span>
        </div>
    </div>


<!-- Mode toggle -->
   <div class="info-banner amber" id="modeBanner">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <div id="modeBannerText">You are currently in <strong>Test Mode</strong>. Payments will not be captured. Switch to Live Mode only
            when you are ready to accept real payments.</div>
    </div>
    
    <div class="settings-section">
        <div class="settings-section-title"><i class="fa-solid fa-toggle-on"></i> Mode</div>
        <div class="toggle-row" style="padding:14px 0">
            <div>
                <div class="toggle-info-label">Live Mode</div>
                <div class="toggle-info-sub">Toggle ON to accept real payments from customers.</div>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" id="liveToggle" name="live_mode" value="1" {{ old('live_mode', $payment->live_mode ?? 0) ? 'checked' : '' }} onchange="toggleMode(this)">
                <span class="toggle-track"></span>
            </label>
        </div>
    </div>

    <hr class="section-divider">

    <!-- Test Keys -->
    <div class="settings-section" id="rp-test">
        <div class="settings-section-title"><i class="fa-solid fa-flask"></i> Test API Keys</div>
        <p class="settings-section-desc">Use these keys in development. No real money is processed.</p>

        <div class="api-key-card">
            <div class="api-key-card-title">Test Key ID</div>
            <div class="input-wrap">
                <span class="input-prefix"><i class="fa fa-key"></i></span>
                <input type="text" name="test_key_id" class="field-input monospace"
                    value="{{ old('test_key_id', $payment->test_key_id ?? '') }}" placeholder="rzp_test_XXXXXXXXXXXX">
            </div>
        </div>
        <div class="api-key-card">
            <div class="api-key-card-title">Test Key Secret</div>
            <div class="input-wrap">
                <span class="input-prefix"><i class="fa fa-lock"></i></span>
                <input type="password" name="test_key_secret" class="field-input monospace" id="testSecret"
                    value="{{ old('test_key_secret', $payment->test_key_secret ?? '') }}"
                    placeholder="••••••••••••••••••••">
                <button type="button" onclick="togglePass('testSecret', this)"
                    style="border:1px solid var(--border);border-left:none;border-radius:0 var(--radius-sm) var(--radius-sm) 0;background:var(--bg);padding:0 12px;cursor:pointer;color:var(--text-hint);flex-shrink:0"><i
                        class="fa fa-eye"></i></button>
            </div>
        </div>
    </div>

    <hr class="section-divider">

    <!-- Live Keys -->
    <div class="settings-section" id="rp-live">
        <div class="settings-section-title"><i class="fa-solid fa-circle-check"></i> Live API Keys</div>
        <p class="settings-section-desc">Enter your production keys from the Razorpay Dashboard. Keep these secret.</p>

        <div class="api-key-card">
            <div class="api-key-card-title">Live Key ID</div>
            <div class="input-wrap">
                <span class="input-prefix"><i class="fa fa-key"></i></span>
                <input type="text" name="live_key_id" class="field-input monospace"
                    value="{{ old('live_key_id', $payment->live_key_id ?? '') }}" placeholder="rzp_live_XXXXXXXXXXXX">
            </div>
        </div>
        <div class="api-key-card">
            <div class="api-key-card-title">Live Key Secret</div>
            <div class="input-wrap">
                <span class="input-prefix"><i class="fa fa-lock"></i></span>
                <input type="password" name="live_key_secret" class="field-input monospace" id="liveSecret"
                    value="{{ old('live_key_secret', $payment->live_key_secret ?? '') }}"
                    placeholder="••••••••••••••••••••">
                <button type="button" onclick="togglePass('liveSecret', this)"
                    style="border:1px solid var(--border);border-left:none;border-radius:0 var(--radius-sm) var(--radius-sm) 0;background:var(--bg);padding:0 12px;cursor:pointer;color:var(--text-hint);flex-shrink:0"><i
                        class="fa fa-eye"></i></button>
            </div>
        </div>
    </div>

    <!-- <hr class="section-divider"> -->

    <!-- Payment Methods -->
    <!-- <div class="settings-section">
                            <div class="settings-section-title"><i class="fa-solid fa-wallet"></i> Accepted Payment Methods</div>
                            <p class="settings-section-desc">Choose which methods appear on the checkout page.</p>

                            <div class="toggle-row">
                                <div><div class="toggle-info-label">UPI (PhonePe, GPay, Paytm)</div><div class="toggle-info-sub">Fastest payment method in India.</div></div>
                                <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-track"></span></label>
                            </div>
                            <div class="toggle-row">
                                <div><div class="toggle-info-label">Credit / Debit Cards</div><div class="toggle-info-sub">Visa, Mastercard, RuPay.</div></div>
                                <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-track"></span></label>
                            </div>
                            <div class="toggle-row">
                                <div><div class="toggle-info-label">Net Banking</div><div class="toggle-info-sub">All major Indian banks.</div></div>
                                <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-track"></span></label>
                            </div>
                            <div class="toggle-row">
                                <div><div class="toggle-info-label">EMI</div><div class="toggle-info-sub">No-cost EMI on eligible cards.</div></div>
                                <label class="toggle-switch"><input type="checkbox"><span class="toggle-track"></span></label>
                            </div>
                            <div class="toggle-row">
                                <div><div class="toggle-info-label">Wallets (Paytm, Mobikwik)</div><div class="toggle-info-sub">Digital wallet payments.</div></div>
                                <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-track"></span></label>
                            </div>
                            <div class="toggle-row">
                                <div><div class="toggle-info-label">Cash on Delivery (COD)</div><div class="toggle-info-sub">Handled separately outside Razorpay.</div></div>
                                <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-track"></span></label>
                            </div>
                        </div> -->

</div>

<div class="action-bar">
    <button class="btn-secondary-dash">Discard Changes</button>
    <button class="btn-primary-dash" type="submit">
        <i class="fa fa-save"></i> Save Payment Settings
    </button>
</div>

</form>