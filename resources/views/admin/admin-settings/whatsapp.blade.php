@php
    $whatsapp = null;
@endphp
<form action="{{ route('admin.admin-setting.whatsapp') }}" method="POST">
    @csrf

    <div class="settings-layout">

        <!-- Section nav -->
        <div class="settings-sidenav">
            <span class="settings-sidenav-label">Sections</span>
            <a href="#wa-provider" class="active"><i class="fa-solid fa-plug"></i> Provider</a>
            <a href="#wa-credentials"><i class="fa-solid fa-key"></i> API Credentials</a>
            <a href="#wa-webhook"><i class="fa-solid fa-link"></i> Webhook</a>
            <a href="#wa-settings"><i class="fa-solid fa-sliders"></i> Send Settings</a>
        </div>

        <!-- Content -->
        <div class="settings-content">

            <!-- ── Provider ── -->
            <div class="settings-section" id="wa-provider">
                <div class="settings-section-title">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp Provider
                </div>
                <p class="settings-section-desc">
                    Select your WhatsApp Business API provider. Each provider has different credential requirements below.
                </p>

                <div class="form-grid">
                    <div class="field-group col-full">
                        <label class="field-label">Provider <span class="req">*</span></label>
                        <select name="provider" id="waProvider" class="field-select" onchange="toggleProvider(this.value)">
                            <option value="">— Select Provider —</option>
                            <option value="meta"    {{ old('provider', $whatsapp?->provider) == 'meta'    ? 'selected' : '' }}>Meta (Official Cloud API)</option>
                            <option value="twilio"  {{ old('provider', $whatsapp?->provider) == 'twilio'  ? 'selected' : '' }}>Twilio</option>
                            <option value="wati"    {{ old('provider', $whatsapp?->provider) == 'wati'    ? 'selected' : '' }}>WATI</option>
                            <option value="interakt"{{ old('provider', $whatsapp?->provider) == 'interakt'? 'selected' : '' }}>Interakt</option>
                            <option value="aisensy" {{ old('provider', $whatsapp?->provider) == 'aisensy' ? 'selected' : '' }}>AiSensy</option>
                            <option value="360dialog"{{ old('provider', $whatsapp?->provider) == '360dialog'? 'selected' : '' }}>360dialog</option>
                        </select>
                        <span class="field-hint">Your WhatsApp Business API service provider.</span>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Business Phone Number</label>
                        <input type="text" name="business_phone" class="field-input"
                            value="{{ old('business_phone', $whatsapp?->business_phone) }}"
                            placeholder="+91 98765 43210">
                        <span class="field-hint">The WhatsApp number registered with your provider.</span>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Display Name</label>
                        <input type="text" name="display_name" class="field-input"
                            value="{{ old('display_name', $whatsapp?->display_name) }}"
                            placeholder="Your Store Name">
                        <span class="field-hint">Name shown to customers in WhatsApp.</span>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <!-- ── API Credentials ── -->
            <div class="settings-section" id="wa-credentials">
                <div class="settings-section-title">
                    <i class="fa-solid fa-key"></i> API Credentials
                </div>
                <p class="settings-section-desc">
                    Enter the API keys and tokens provided by your WhatsApp Business API provider.
                </p>

                <!-- Meta Cloud API fields -->
                <div id="creds-meta" class="provider-fields" style="display:none">
                    <div class="info-banner blue" style="margin-bottom:20px">
                        <i class="fa-solid fa-circle-info"></i>
                        <div>
                            <strong>Meta Cloud API</strong> — Get your credentials from
                            <a href="https://developers.facebook.com/apps" target="_blank" style="color:#0069d9;font-weight:600">Meta Developer Console</a>.
                            You will need a verified Business Account and a WhatsApp Business App.
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="field-group col-full">
                            <label class="field-label">App ID <span class="req">*</span></label>
                            <input type="text" name="meta_app_id" class="field-input field-input monospace"
                                value="{{ old('meta_app_id', $whatsapp?->meta_app_id) }}"
                                placeholder="123456789012345">
                        </div>
                        <div class="field-group col-full">
                            <label class="field-label">App Secret <span class="req">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="metaSecret" name="meta_app_secret" class="field-input monospace"
                                    value="{{ old('meta_app_secret', $whatsapp?->meta_app_secret) }}"
                                    placeholder="••••••••••••••••••••••••••••••••">
                                <button type="button" onclick="togglePass('metaSecret', this)"
                                    style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="field-group col-full">
                            <label class="field-label">Permanent Access Token <span class="req">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="metaToken" name="meta_access_token" class="field-input monospace"
                                    value="{{ old('meta_access_token', $whatsapp?->meta_access_token) }}"
                                    placeholder="EAAxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
                                <button type="button" onclick="togglePass('metaToken', this)"
                                    style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            <span class="field-hint">Generate a System User token for long-lived access.</span>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Phone Number ID <span class="req">*</span></label>
                            <input type="text" name="meta_phone_number_id" class="field-input monospace"
                                value="{{ old('meta_phone_number_id', $whatsapp?->meta_phone_number_id) }}"
                                placeholder="109xxxxxxxxxx">
                        </div>
                        <div class="field-group">
                            <label class="field-label">WABA ID (Business Account ID)</label>
                            <input type="text" name="meta_waba_id" class="field-input monospace"
                                value="{{ old('meta_waba_id', $whatsapp?->meta_waba_id) }}"
                                placeholder="102xxxxxxxxxx">
                        </div>
                        <div class="field-group">
                            <label class="field-label">API Version</label>
                            <select name="meta_api_version" class="field-select">
                                <option value="v19.0" {{ old('meta_api_version', $whatsapp?->meta_api_version) == 'v19.0' ? 'selected' : '' }}>v19.0 (Latest)</option>
                                <option value="v18.0" {{ old('meta_api_version', $whatsapp?->meta_api_version) == 'v18.0' ? 'selected' : '' }}>v18.0</option>
                                <option value="v17.0" {{ old('meta_api_version', $whatsapp?->meta_api_version) == 'v17.0' ? 'selected' : '' }}>v17.0</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Twilio fields -->
                <div id="creds-twilio" class="provider-fields" style="display:none">
                    <div class="info-banner blue" style="margin-bottom:20px">
                        <i class="fa-solid fa-circle-info"></i>
                        <div>
                            <strong>Twilio</strong> — Find your credentials in the
                            <a href="https://console.twilio.com" target="_blank" style="color:#0069d9;font-weight:600">Twilio Console</a>
                            under Account Info.
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="field-group">
                            <label class="field-label">Account SID <span class="req">*</span></label>
                            <input type="text" name="twilio_account_sid" class="field-input monospace"
                                value="{{ old('twilio_account_sid', $whatsapp?->twilio_account_sid) }}"
                                placeholder="ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
                        </div>
                        <div class="field-group">
                            <label class="field-label">Auth Token <span class="req">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="twilioToken" name="twilio_auth_token" class="field-input monospace"
                                    value="{{ old('twilio_auth_token', $whatsapp?->twilio_auth_token) }}"
                                    placeholder="••••••••••••••••••••••••••••••••">
                                <button type="button" onclick="togglePass('twilioToken', this)"
                                    style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="field-group col-full">
                            <label class="field-label">Twilio WhatsApp Number <span class="req">*</span></label>
                            <input type="text" name="twilio_from_number" class="field-input"
                                value="{{ old('twilio_from_number', $whatsapp?->twilio_from_number) }}"
                                placeholder="whatsapp:+14155238886">
                            <span class="field-hint">Include the <code>whatsapp:</code> prefix.</span>
                        </div>
                    </div>
                </div>

                <!-- WATI / Interakt / AiSensy / 360dialog — API Key only -->
                <div id="creds-apikey" class="provider-fields" style="display:none">
                    <div class="form-grid">
                        <div class="field-group col-full">
                            <label class="field-label">API Endpoint URL <span class="req">*</span></label>
                            <input type="url" name="api_endpoint" class="field-input monospace"
                                value="{{ old('api_endpoint', $whatsapp?->api_endpoint) }}"
                                placeholder="https://live-server.wati.io">
                            <span class="field-hint">The base URL provided by your provider dashboard.</span>
                        </div>
                        <div class="field-group col-full">
                            <label class="field-label">API Key / Access Token <span class="req">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="apikeyToken" name="api_key" class="field-input monospace"
                                    value="{{ old('api_key', $whatsapp?->api_key) }}"
                                    placeholder="••••••••••••••••••••••••••••••••">
                                <button type="button" onclick="togglePass('apikeyToken', this)"
                                    style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            <span class="field-hint">Copy this from your provider's API settings page.</span>
                        </div>
                    </div>
                </div>

                <!-- Empty state -->
                <div id="creds-empty" style="text-align:center;padding:32px 0;color:var(--text-hint)">
                    <i class="fa fa-plug" style="font-size:32px;color:var(--border);display:block;margin-bottom:10px"></i>
                    Select a provider above to see credential fields.
                </div>

            </div>

            <hr class="section-divider">

            <!-- ── Webhook ── -->
            <div class="settings-section" id="wa-webhook">
                <div class="settings-section-title">
                    <i class="fa-solid fa-webhook"></i> Webhook Configuration
                </div>
                <p class="settings-section-desc">
                    Register this webhook URL in your provider's dashboard to receive incoming messages and delivery status updates.
                </p>

                <div class="form-grid">
                    <div class="field-group col-full">
                        <label class="field-label">Webhook URL (auto-generated)</label>
                        <div style="display:flex;gap:8px">
                            <input type="text" class="field-input monospace"
                                value="{{ url('api/webhooks/whatsapp') }}" readonly
                                id="webhookUrl" style="background:var(--bg);color:var(--text-secondary)">
                            <button type="button" onclick="copyWebhook()"
                                style="display:inline-flex;align-items:center;gap:6px;padding:0 14px;height:38px;border:1px solid var(--border);border-radius:var(--radius-sm);background:var(--surface);font-size:12.5px;font-family:var(--font);cursor:pointer;color:var(--text-secondary);white-space:nowrap;flex-shrink:0">
                                <i class="fa fa-copy"></i> Copy
                            </button>
                        </div>
                    </div>
                    <div class="field-group col-full">
                        <label class="field-label">Webhook Verify Token</label>
                        <div style="position:relative">
                            <input type="password" id="webhookSecret" name="webhook_verify_token"
                                class="field-input monospace"
                                value="{{ old('webhook_verify_token', $whatsapp?->webhook_verify_token) }}"
                                placeholder="Your secret verify token">
                            <button type="button" onclick="togglePass('webhookSecret', this)"
                                style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        <span class="field-hint">Set this same token in your provider's webhook settings.</span>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <!-- ── Send Settings ── -->
            <div class="settings-section" id="wa-settings">
                <div class="settings-section-title">
                    <i class="fa-solid fa-sliders"></i> Send Settings
                </div>
                <p class="settings-section-desc">
                    Control when and how WhatsApp messages are sent to customers.
                </p>

                <div class="toggle-row">
                    <div>
                        <div class="toggle-info-label">Enable WhatsApp Notifications</div>
                        <div class="toggle-info-sub">Master switch — turns all WhatsApp messaging on or off.</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="enabled" {{ old('enabled', $whatsapp?->enabled) ? 'checked' : '' }}>
                        <span class="toggle-track"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div>
                        <div class="toggle-info-label">Order Confirmation</div>
                        <div class="toggle-info-sub">Send a message when an order is placed.</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="notify_order_placed" {{ old('notify_order_placed', $whatsapp?->notify_order_placed) ? 'checked' : '' }}>
                        <span class="toggle-track"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div>
                        <div class="toggle-info-label">Order Shipped</div>
                        <div class="toggle-info-sub">Notify customer when their order is dispatched.</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="notify_order_shipped" {{ old('notify_order_shipped', $whatsapp?->notify_order_shipped) ? 'checked' : '' }}>
                        <span class="toggle-track"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div>
                        <div class="toggle-info-label">Order Delivered</div>
                        <div class="toggle-info-sub">Send a delivery confirmation message.</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="notify_order_delivered" {{ old('notify_order_delivered', $whatsapp?->notify_order_delivered) ? 'checked' : '' }}>
                        <span class="toggle-track"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div>
                        <div class="toggle-info-label">Order Cancelled / Refund</div>
                        <div class="toggle-info-sub">Notify on cancellation or refund initiation.</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="notify_order_cancelled" {{ old('notify_order_cancelled', $whatsapp?->notify_order_cancelled) ? 'checked' : '' }}>
                        <span class="toggle-track"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div>
                        <div class="toggle-info-label">Abandoned Cart Reminder</div>
                        <div class="toggle-info-sub">Send a reminder when a customer leaves items in cart.</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="notify_abandoned_cart" {{ old('notify_abandoned_cart', $whatsapp?->notify_abandoned_cart) ? 'checked' : '' }}>
                        <span class="toggle-track"></span>
                    </label>
                </div>

                <div class="toggle-row">
                    <div>
                        <div class="toggle-info-label">COD Order Confirmation OTP</div>
                        <div class="toggle-info-sub">Send OTP to verify Cash on Delivery orders.</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="notify_cod_otp" {{ old('notify_cod_otp', $whatsapp?->notify_cod_otp) ? 'checked' : '' }}>
                        <span class="toggle-track"></span>
                    </label>
                </div>

            </div>

        </div><!-- /settings-content -->
    </div><!-- /settings-layout -->

    <div class="action-bar">
        <button type="button" class="btn-test" onclick="testWhatsApp()">
            <i class="fa fa-paper-plane"></i> Send Test Message
        </button>
        <button type="button" class="btn-secondary-dash">Discard Changes</button>
        <button type="submit" class="btn-primary-dash" onclick="saveSettings(this)">
            <i class="fa fa-save"></i> Save WhatsApp Settings
        </button>
    </div>

</form>

<script>
function toggleProvider(val) {
    document.querySelectorAll('.provider-fields').forEach(el => el.style.display = 'none');
    document.getElementById('creds-empty').style.display = 'none';
    if (val === 'meta')    document.getElementById('creds-meta').style.display   = 'block';
    else if (val === 'twilio') document.getElementById('creds-twilio').style.display = 'block';
    else if (['wati','interakt','aisensy','360dialog'].includes(val))
        document.getElementById('creds-apikey').style.display = 'block';
    else document.getElementById('creds-empty').style.display = 'block';
}

// Init on load
(function() {
    const saved = "{{ old('provider', $whatsapp?->provider) }}";
    if (saved) toggleProvider(saved);
})();

function copyWebhook() {
    const url = document.getElementById('webhookUrl').value;
    navigator.clipboard.writeText(url).then(() => {
        Swal.fire({ icon:'success', title:'Copied!', text:'Webhook URL copied to clipboard.', timer:1500, showConfirmButton:false });
    });
}

function testWhatsApp() {
    Swal.fire({
        title: 'Send Test Message',
        input: 'text',
        inputLabel: 'Enter WhatsApp number (with country code)',
        inputPlaceholder: '+91 98765 43210',
        showCancelButton: true,
        confirmButtonColor: '#303d89',
        confirmButtonText: 'Send',
    }).then(result => {
        if (result.isConfirmed && result.value) {
            Swal.fire({ icon:'success', title:'Sent!', text:`Test message sent to ${result.value}`, timer:2000, showConfirmButton:false });
        }
    });
}
</script>