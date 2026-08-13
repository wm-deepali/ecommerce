<form method="POST" action="{{ route('admin.smtp-settings.store') }}">
    @csrf
    <div class="settings-layout">

    <div class="settings-sidenav">
        <span class="settings-sidenav-label">Sections</span>
        <a href="#smtp-config" class="active"><i class="fa-solid fa-server"></i> SMTP Config</a>
        <a href="#smtp-sender"><i class="fa-solid fa-user"></i> Sender Details</a>
        <a href="#smtp-templates"><i class="fa-solid fa-envelope-open-text"></i> Email Events</a>
    </div>

    <div class="settings-content">

        <div class="info-banner blue">
            <i class="fa-solid fa-circle-info"></i>
            <div>Configure your SMTP credentials to send order confirmations, OTPs, and notification emails through your
                own mail server.</div>
        </div>

        <!-- SMTP Config -->
        <div class="settings-section" id="smtp-config">
            <div class="settings-section-title"><i class="fa-solid fa-server"></i> SMTP Configuration</div>
            <p class="settings-section-desc">Enter your mail server credentials. Works with Gmail, Mailgun, SendGrid,
                and any SMTP provider.</p>

            <div class="form-grid">

                <div class="field-group">
                    <label class="field-label">SMTP Host <span class="req">*</span></label>
                    <input type="text" name="smtp_host" class="field-input"
                        value="{{ old('smtp_host', $smtp->smtp_host ?? '') }}" placeholder="smtp.gmail.com">
                </div>
                <div class="field-group">
                    <label class="field-label">SMTP Port <span class="req">*</span></label>
                    <select class="field-select" name="smtp_port">
                        <option value="465" {{ old('smtp_port', $smtp->smtp_port ?? '') == '465' ? 'selected' : '' }}>465
                            (SSL)</option>
                        <option value="587" {{ old('smtp_port', $smtp->smtp_port ?? '587') == '587' ? 'selected' : '' }}>
                            587 (TLS)</option>
                        <option value="25" {{ old('smtp_port', $smtp->smtp_port ?? '') == '25' ? 'selected' : '' }}>25
                        </option>
                    </select>
                </div>
                <div class="field-group">
                    <label class="field-label">SMTP Username <span class="req">*</span></label>
                    <input type="email" name="smtp_username" class="field-input"
                        value="{{ old('smtp_username', $smtp->smtp_username ?? '') }}">
                </div>
                <div class="field-group">
                    <label class="field-label">SMTP Password <span class="req">*</span></label>
                    <div class="input-wrap">
                        <input type="password" name="smtp_password" class="field-input" id="smtpPass"
                            value="{{ old('smtp_password', $smtp->smtp_password ?? '') }}">
                        <button type="button" onclick="togglePass('smtpPass', this)"
                            style="border:1px solid var(--border);border-left:none;border-radius:0 var(--radius-sm) var(--radius-sm) 0;background:var(--bg);padding:0 12px;cursor:pointer;color:var(--text-hint);flex-shrink:0"><i
                                class="fa fa-eye"></i></button>
                    </div>
                </div>
                <div class="field-group">
                    <label class="field-label">Encryption</label>
                    <select class="field-select" name="smtp_encryption">
                        <option value="tls" {{ old('smtp_encryption', $smtp->smtp_encryption ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                        <option value="ssl" {{ old('smtp_encryption', $smtp->smtp_encryption ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                        <option value="none" {{ old('smtp_encryption', $smtp->smtp_encryption ?? '') == 'none' ? 'selected' : '' }}>None</option>
                    </select>
                </div>
            </div>
        </div>

        <hr class="section-divider">

        <!-- Sender Details -->
        <div class="settings-section" id="smtp-sender">
            <div class="settings-section-title"><i class="fa-solid fa-user"></i> Sender Details</div>
            <p class="settings-section-desc">The name and address your customers see in their inbox.</p>

            <div class="form-grid">
                <div class="field-group">
                    <label class="field-label">From Name</label>
                    <input type="text" name="from_name" class="field-input"
                        value="{{ old('from_name', $smtp->from_name ?? '') }}">
                </div>
                <div class="field-group">
                    <label class="field-label">From Email</label>
                    <input type="email" name="from_email" class="field-input"
                        value="{{ old('from_email', $smtp->from_email ?? '') }}">
                </div>
                <div class="field-group">
                    <label class="field-label">Reply-To Name</label>
                    <input type="text" name="reply_to_name" class="field-input"
                        value="{{ old('reply_to_name', $smtp->reply_to_name ?? '') }}">
                </div>
                <div class="field-group">
                    <label class="field-label">Reply-To Email</label>
                    <input type="email" name="reply_to_email" class="field-input"
                        value="{{ old('reply_to_email', $smtp->reply_to_email ?? '') }}">
                </div>
            </div>
        </div>

        <hr class="section-divider">

        <!-- Email Events -->
        <div class="settings-section" id="smtp-templates">
            <div class="settings-section-title"><i class="fa-solid fa-envelope-open-text"></i> Email Notification Events
            </div>
            <p class="settings-section-desc">Choose which events trigger an email to the customer or admin.</p>

            <div class="toggle-row">
                <div>
                    <div class="toggle-info-label">Order Confirmation</div>
                    <div class="toggle-info-sub">Email customer when order is placed successfully.</div>
                </div>
                <label class="toggle-switch"><input type="checkbox"
       name="order_confirmation"
       value="1"
       {{ old('order_confirmation', $smtp->order_confirmation ?? 1) ? 'checked' : '' }}><span class="toggle-track"></span></label>
            </div>
            <div class="toggle-row">
                <div>
                    <div class="toggle-info-label">Order Shipped</div>
                    <div class="toggle-info-sub">Send tracking details when order is dispatched.</div>
                </div>
                <label class="toggle-switch"><input type="checkbox"
       name="order_shipped"
       value="1"
       {{ old('order_shipped', $smtp->order_shipped ?? 1) ? 'checked' : '' }}><span class="toggle-track"></span></label>
            </div>
            <div class="toggle-row">
                <div>
                    <div class="toggle-info-label">Order Delivered</div>
                    <div class="toggle-info-sub">Notify customer on delivery confirmation.</div>
                </div>
                <label class="toggle-switch"><input type="checkbox"
       name="order_delivered"
       value="1"
       {{ old('order_delivered', $smtp->order_delivered ?? 1) ? 'checked' : '' }}><span class="toggle-track"></span></label>
            </div>
           
            <div class="toggle-row">
                <div>
                    <div class="toggle-info-label">New Order Alert (Admin)</div>
                    <div class="toggle-info-sub">Notify admin email on every new order.</div>
                </div>
                <label class="toggle-switch"><input type="checkbox"
       name="new_order_alert"
       value="1"
       {{ old('new_order_alert', $smtp->new_order_alert ?? 1) ? 'checked' : '' }}><span class="toggle-track"></span></label>
            </div>
            <div class="toggle-row">
                <div>
                    <div class="toggle-info-label">Low Stock Alert (Admin)</div>
                    <div class="toggle-info-sub">Notify admin when stock falls below threshold.</div>
                </div>
                <label class="toggle-switch"><input type="checkbox"
       name="low_stock_alert"
       value="1"
       {{ old('low_stock_alert', $smtp->low_stock_alert ?? 0) ? 'checked' : '' }}><span class="toggle-track"></span></label>
            </div>
        </div>

    </div>
</div>

<div class="action-bar">
    <button class="btn-secondary-dash">Discard Changes</button>
    <button class="btn-primary-dash" type="submit">
        <i class="fa fa-save"></i> Save SMTP Settings
    </button>
</div>

</form>