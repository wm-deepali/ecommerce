<form action="/admin/settings/sms" method="POST">
    <input type="hidden" name="_token" value="">

    <div class="settings-layout">

        <!-- Section nav -->
        <div class="settings-sidenav">
            <span class="settings-sidenav-label">Sections</span>
            <a href="#sms-provider" class="active"><i class="fa-solid fa-plug"></i> Provider</a>
            <a href="#sms-credentials"><i class="fa-solid fa-key"></i> API Credentials</a>
            <a href="#sms-sender"><i class="fa-solid fa-id-badge"></i> Sender ID</a>
            <a href="#sms-notifications"><i class="fa-solid fa-bell"></i> Notifications</a>
        </div>

        <!-- Content -->
        <div class="settings-content">

            <!-- ── Provider ── -->
            <div class="settings-section" id="sms-api">
                <div class="settings-section-title">
                    <i class="fa-solid fa-message"></i> SMS Provider
                </div>
                <p class="settings-section-desc">
                    Select your SMS gateway provider. Only one provider can be active at a time. API credentials below will update based on your selection.
                </p>

                <div class="form-grid">
                    <div class="field-group col-full">
                        <label class="field-label">Active Provider <span class="req">*</span></label>
                        <select name="provider" id="smsProvider" class="field-select" onchange="toggleSmsProvider(this.value)">
                            <option value="">— Select Provider —</option>
                            <option value="twilio">Twilio</option>
                            <option value="msg91">MSG91</option>
                            <option value="textlocal">Textlocal</option>
                            <option value="kaleyra">Kaleyra (Solutions Infini)</option>
                            <option value="vonage">Vonage (Nexmo)</option>
                            <option value="aws_sns">AWS SNS</option>
                            <option value="fast2sms">Fast2SMS</option>
                            <option value="sinch">Sinch</option>
                        </select>
                        <span class="field-hint">Only the selected provider will be used for all outgoing SMS. Switching providers does not delete saved credentials.</span>
                    </div>

                    <div class="field-group col-full">
                        <div class="info-banner amber" style="margin-bottom:0">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <div>
                                <strong>One provider at a time.</strong> Saving this form activates the selected provider and pauses all others. Make sure you have valid credentials entered before saving.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <!-- ── API Credentials ── -->
            <div class="settings-section" id="sms-credentials">
                <div class="settings-section-title">
                    <i class="fa-solid fa-key"></i> API Credentials
                </div>
                <p class="settings-section-desc">
                    Enter the credentials for your selected SMS provider. These are stored encrypted and never exposed in logs.
                </p>

                <!-- Empty state -->
                <div id="sms-creds-empty" style="text-align:center;padding:32px 0;color:var(--text-hint)">
                    <i class="fa fa-plug" style="font-size:32px;color:var(--border);display:block;margin-bottom:10px"></i>
                    Select a provider above to see credential fields.
                </div>

                <!-- ── Twilio ── -->
                <div id="sms-creds-twilio" class="sms-provider-fields" style="display:none">
                    <div class="info-banner blue" style="margin-bottom:20px">
                        <i class="fa-solid fa-circle-info"></i>
                        <div>
                            <strong>Twilio</strong> — Get your credentials from the
                            <a href="https://console.twilio.com" target="_blank" style="color:#0069d9;font-weight:600">Twilio Console</a>
                            under Account Info.
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="field-group">
                            <label class="field-label">Account SID <span class="req">*</span></label>
                            <input type="text" name="twilio_account_sid" class="field-input monospace" placeholder="ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
                        </div>
                        <div class="field-group">
                            <label class="field-label">Auth Token <span class="req">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="twilioSmsToken" name="twilio_auth_token" class="field-input monospace" placeholder="••••••••••••••••••••••••••••••••">
                                <button type="button" onclick="togglePass('twilioSmsToken', this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)"><i class="fa fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="field-group col-full">
                            <label class="field-label">From Number <span class="req">*</span></label>
                            <input type="text" name="twilio_from_number" class="field-input" placeholder="+14155238886">
                            <span class="field-hint">The Twilio phone number to send SMS from. Must include country code.</span>
                        </div>
                    </div>
                </div>

                <!-- ── MSG91 ── -->
                <div id="sms-creds-msg91" class="sms-provider-fields" style="display:none">
                    <div class="info-banner blue" style="margin-bottom:20px">
                        <i class="fa-solid fa-circle-info"></i>
                        <div>
                            <strong>MSG91</strong> — Find your Auth Key in the
                            <a href="https://msg91.com/in/signup" target="_blank" style="color:#0069d9;font-weight:600">MSG91 Dashboard</a>
                            under API &rarr; Auth Key.
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="field-group col-full">
                            <label class="field-label">Auth Key <span class="req">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="msg91AuthKey" name="msg91_auth_key" class="field-input monospace" placeholder="••••••••••••••••••••••••••••">
                                <button type="button" onclick="togglePass('msg91AuthKey', this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)"><i class="fa fa-eye"></i></button>
                            </div>
                            <span class="field-hint">Your MSG91 authentication key from the dashboard.</span>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Route</label>
                            <select name="msg91_route" class="field-select">
                                <option value="4">Transactional (Route 4)</option>
                                <option value="1">Promotional (Route 1)</option>
                            </select>
                            <span class="field-hint">Use Transactional for order/OTP SMS.</span>
                        </div>
                        <div class="field-group">
                            <label class="field-label">DLT Entity ID</label>
                            <input type="text" name="msg91_dlt_entity_id" class="field-input monospace" placeholder="DLT-registered Entity ID">
                            <span class="field-hint">Required for India. Register on TRAI DLT portal.</span>
                        </div>
                        <div class="field-group col-full">
                            <label class="field-label">Template IDs (JSON)</label>
                            <textarea name="msg91_template_ids" class="field-textarea monospace" placeholder='{"order_confirmed":"template_id","otp":"template_id","shipped":"template_id"}'></textarea>
                            <span class="field-hint">Map event names to your DLT-approved MSG91 template IDs.</span>
                        </div>
                    </div>
                </div>

                <!-- ── Textlocal ── -->
                <div id="sms-creds-textlocal" class="sms-provider-fields" style="display:none">
                    <div class="info-banner blue" style="margin-bottom:20px">
                        <i class="fa-solid fa-circle-info"></i>
                        <div>
                            <strong>Textlocal</strong> — Retrieve your API Key from
                            <a href="https://www.textlocal.in" target="_blank" style="color:#0069d9;font-weight:600">Textlocal Dashboard</a>
                            under Settings &rarr; API Keys.
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="field-group col-full">
                            <label class="field-label">API Key <span class="req">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="textlocalKey" name="textlocal_api_key" class="field-input monospace" placeholder="••••••••••••••••••••••••••••••••">
                                <button type="button" onclick="togglePass('textlocalKey', this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)"><i class="fa fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="field-group col-full">
                            <label class="field-label">Registered Username / Email</label>
                            <input type="text" name="textlocal_username" class="field-input" placeholder="your@email.com">
                            <span class="field-hint">The email used to register your Textlocal account.</span>
                        </div>
                    </div>
                </div>

                <!-- ── Kaleyra ── -->
                <div id="sms-creds-kaleyra" class="sms-provider-fields" style="display:none">
                    <div class="info-banner blue" style="margin-bottom:20px">
                        <i class="fa-solid fa-circle-info"></i>
                        <div>
                            <strong>Kaleyra (Solutions Infini)</strong> — Get your SID and API Key from the
                            <a href="https://kaleyra.com" target="_blank" style="color:#0069d9;font-weight:600">Kaleyra Console</a>.
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="field-group">
                            <label class="field-label">Account SID <span class="req">*</span></label>
                            <input type="text" name="kaleyra_sid" class="field-input monospace" placeholder="KLxxxxxxxxxxxxxxxx">
                        </div>
                        <div class="field-group">
                            <label class="field-label">API Key <span class="req">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="kaleyraKey" name="kaleyra_api_key" class="field-input monospace" placeholder="••••••••••••••••••••••••">
                                <button type="button" onclick="togglePass('kaleyraKey', this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)"><i class="fa fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="field-group">
                            <label class="field-label">DLT Entity ID</label>
                            <input type="text" name="kaleyra_dlt_entity_id" class="field-input monospace" placeholder="DLT Entity ID">
                        </div>
                        <div class="field-group">
                            <label class="field-label">DLT Template ID (default)</label>
                            <input type="text" name="kaleyra_dlt_template_id" class="field-input monospace" placeholder="DLT Template ID">
                        </div>
                    </div>
                </div>

                <!-- ── Vonage / Nexmo ── -->
                <div id="sms-creds-vonage" class="sms-provider-fields" style="display:none">
                    <div class="info-banner blue" style="margin-bottom:20px">
                        <i class="fa-solid fa-circle-info"></i>
                        <div>
                            <strong>Vonage (Nexmo)</strong> — Your API Key and Secret are on the
                            <a href="https://dashboard.nexmo.com" target="_blank" style="color:#0069d9;font-weight:600">Vonage Dashboard</a>
                            home page.
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="field-group">
                            <label class="field-label">API Key <span class="req">*</span></label>
                            <input type="text" name="vonage_api_key" class="field-input monospace" placeholder="xxxxxxxx">
                        </div>
                        <div class="field-group">
                            <label class="field-label">API Secret <span class="req">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="vonageSecret" name="vonage_api_secret" class="field-input monospace" placeholder="••••••••••••••••••••••••••••••••">
                                <button type="button" onclick="togglePass('vonageSecret', this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)"><i class="fa fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="field-group col-full">
                            <label class="field-label">From Name / Number <span class="req">*</span></label>
                            <input type="text" name="vonage_from" class="field-input" placeholder="YourBrand or +14155238886">
                            <span class="field-hint">Alphanumeric sender ID (max 11 chars) or a virtual number.</span>
                        </div>
                    </div>
                </div>

                <!-- ── AWS SNS ── -->
                <div id="sms-creds-aws_sns" class="sms-provider-fields" style="display:none">
                    <div class="info-banner blue" style="margin-bottom:20px">
                        <i class="fa-solid fa-circle-info"></i>
                        <div>
                            <strong>AWS SNS</strong> — Create an IAM user with <code>sns:Publish</code> permission and generate Access Keys in the
                            <a href="https://console.aws.amazon.com/iam" target="_blank" style="color:#0069d9;font-weight:600">AWS IAM Console</a>.
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="field-group">
                            <label class="field-label">Access Key ID <span class="req">*</span></label>
                            <input type="text" name="aws_access_key_id" class="field-input monospace" placeholder="AKIAxxxxxxxxxxxxxxxxxxxx">
                        </div>
                        <div class="field-group">
                            <label class="field-label">Secret Access Key <span class="req">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="awsSecretKey" name="aws_secret_access_key" class="field-input monospace" placeholder="••••••••••••••••••••••••••••••••••••••••">
                                <button type="button" onclick="togglePass('awsSecretKey', this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)"><i class="fa fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="field-group">
                            <label class="field-label">AWS Region <span class="req">*</span></label>
                            <select name="aws_region" class="field-select">
                                <option value="ap-south-1">ap-south-1 (Mumbai)</option>
                                <option value="us-east-1">us-east-1 (N. Virginia)</option>
                                <option value="us-west-2">us-west-2 (Oregon)</option>
                                <option value="eu-west-1">eu-west-1 (Ireland)</option>
                                <option value="ap-southeast-1">ap-southeast-1 (Singapore)</option>
                            </select>
                        </div>
                        <div class="field-group">
                            <label class="field-label">SMS Type</label>
                            <select name="aws_sms_type" class="field-select">
                                <option value="Transactional">Transactional</option>
                                <option value="Promotional">Promotional</option>
                            </select>
                            <span class="field-hint">Transactional has higher priority and delivery reliability.</span>
                        </div>
                    </div>
                </div>

                <!-- ── Fast2SMS ── -->
                <div id="sms-creds-fast2sms" class="sms-provider-fields" style="display:none">
                    <div class="info-banner blue" style="margin-bottom:20px">
                        <i class="fa-solid fa-circle-info"></i>
                        <div>
                            <strong>Fast2SMS</strong> — Copy your API Key from the
                            <a href="https://www.fast2sms.com/dashboard/dev-api" target="_blank" style="color:#0069d9;font-weight:600">Fast2SMS Developer API</a>
                            page.
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="field-group col-full">
                            <label class="field-label">API Key <span class="req">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="fast2smsKey" name="fast2sms_api_key" class="field-input monospace" placeholder="••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••">
                                <button type="button" onclick="togglePass('fast2smsKey', this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)"><i class="fa fa-eye"></i></button>
                            </div>
                            <span class="field-hint">Long API key from your Fast2SMS account developer panel.</span>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Route</label>
                            <select name="fast2sms_route" class="field-select">
                                <option value="dlt">DLT (Transactional)</option>
                                <option value="v3">Quick SMS (Promotional)</option>
                            </select>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Language</label>
                            <select name="fast2sms_language" class="field-select">
                                <option value="english">English</option>
                                <option value="unicode">Unicode</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ── Sinch ── -->
                <div id="sms-creds-sinch" class="sms-provider-fields" style="display:none">
                    <div class="info-banner blue" style="margin-bottom:20px">
                        <i class="fa-solid fa-circle-info"></i>
                        <div>
                            <strong>Sinch</strong> — Retrieve your Service Plan ID and API Token from the
                            <a href="https://dashboard.sinch.com/sms/api/rest" target="_blank" style="color:#0069d9;font-weight:600">Sinch Dashboard</a>.
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="field-group">
                            <label class="field-label">Service Plan ID <span class="req">*</span></label>
                            <input type="text" name="sinch_service_plan_id" class="field-input monospace" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
                        </div>
                        <div class="field-group">
                            <label class="field-label">API Token <span class="req">*</span></label>
                            <div style="position:relative">
                                <input type="password" id="sinchToken" name="sinch_api_token" class="field-input monospace" placeholder="••••••••••••••••••••••••••••••••">
                                <button type="button" onclick="togglePass('sinchToken', this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-hint)"><i class="fa fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="field-group col-full">
                            <label class="field-label">From Number <span class="req">*</span></label>
                            <input type="text" name="sinch_from_number" class="field-input" placeholder="+14155238886">
                            <span class="field-hint">Virtual number rented from Sinch, with country code.</span>
                        </div>
                    </div>
                </div>

            </div>

            <hr class="section-divider">

            <!-- ── Sender ID ── -->
            <div class="settings-section" id="sms-sender">
                <div class="settings-section-title">
                    <i class="fa-solid fa-id-badge"></i> Sender ID / From Name
                </div>
                <p class="settings-section-desc">
                    Configure the sender name or number shown to customers. This must match your DLT registration in India.
                </p>

                <div class="form-grid">
                    <div class="field-group">
                        <label class="field-label">Sender ID / Name <span class="req">*</span></label>
                        <input type="text" name="sender_id" class="field-input" placeholder="MYSHOP" maxlength="11">
                        <span class="field-hint">Max 11 characters (alphanumeric). Must be registered with your telecom operator in India.</span>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Country Code Default</label>
                        <div class="input-wrap">
                            <span class="input-prefix">+</span>
                            <input type="text" name="default_country_code" class="field-input" placeholder="91" value="91">
                        </div>
                        <span class="field-hint">Prepended to numbers that don't already include a country code.</span>
                    </div>
                    <div class="field-group col-full">
                        <label class="field-label">DLT Principal Entity ID</label>
                        <input type="text" name="dlt_entity_id" class="field-input monospace" placeholder="1701xxxxxxxxxxxxxxx">
                        <span class="field-hint">Mandatory for India (TRAI DLT). Register at <a href="https://www.trai.gov.in/dlt" target="_blank" style="color:var(--accent)">trai.gov.in</a>.</span>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <!-- ── Notification Toggles ── -->
            <div class="settings-section" id="sms-notifications">
                <div class="settings-section-title">
                    <i class="fa-solid fa-bell"></i> Notification Events
                </div>
                <p class="settings-section-desc">
                    Choose which events trigger an SMS to the customer. The master switch must be on for any SMS to send.
                </p>

                <div class="toggle-row">
                    <div>
                        <div class="toggle-info-label">Enable SMS Notifications</div>
                        <div class="toggle-info-sub">Master switch — turns all SMS messaging on or off.</div>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="enabled" id="smsMasterToggle" onchange="toggleSmsNotifs(this)">
                        <span class="toggle-track"></span>
                    </label>
                </div>

                <div id="sms-notif-rows" style="opacity:0.4;pointer-events:none;transition:opacity .2s">

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-info-label">Order Placed / Confirmed</div>
                            <div class="toggle-info-sub">Send SMS when a new order is successfully placed.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notify_order_placed">
                            <span class="toggle-track"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-info-label">OTP / Order Verification</div>
                            <div class="toggle-info-sub">Send OTP for account login, COD confirmation, or order changes.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notify_otp">
                            <span class="toggle-track"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-info-label">Payment Received</div>
                            <div class="toggle-info-sub">Notify customer when payment is successfully processed.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notify_payment_received">
                            <span class="toggle-track"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-info-label">Order Shipped</div>
                            <div class="toggle-info-sub">Alert customer when the order is dispatched with tracking info.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notify_order_shipped">
                            <span class="toggle-track"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-info-label">Out for Delivery</div>
                            <div class="toggle-info-sub">Notify when the order is out for delivery.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notify_out_for_delivery">
                            <span class="toggle-track"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-info-label">Order Delivered</div>
                            <div class="toggle-info-sub">Send a delivery confirmation SMS to the customer.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notify_order_delivered">
                            <span class="toggle-track"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-info-label">Order Cancelled</div>
                            <div class="toggle-info-sub">Notify customer when their order is cancelled.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notify_order_cancelled">
                            <span class="toggle-track"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-info-label">Refund Initiated</div>
                            <div class="toggle-info-sub">Inform customer when a refund has been processed.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notify_refund_initiated">
                            <span class="toggle-track"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-info-label">Abandoned Cart Reminder</div>
                            <div class="toggle-info-sub">Send a reminder SMS when a customer leaves items in cart.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notify_abandoned_cart">
                            <span class="toggle-track"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-info-label">Promotional / Marketing</div>
                            <div class="toggle-info-sub">Send promotional campaigns and offers via SMS.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notify_promotional">
                            <span class="toggle-track"></span>
                        </label>
                    </div>

                </div>
            </div>

        </div><!-- /settings-content -->
    </div><!-- /settings-layout -->

    <div class="action-bar">
        <button type="button" class="btn-test" onclick="testSms()">
            <i class="fa fa-paper-plane"></i> Send Test SMS
        </button>
        <button type="button" class="btn-secondary-dash" onclick="window.location.reload()">Discard Changes</button>
        <button type="submit" class="btn-primary-dash">
            <i class="fa fa-save"></i> Save SMS Settings
        </button>
    </div>

</form>

<script>
function toggleSmsProvider(val) {
    document.querySelectorAll('.sms-provider-fields').forEach(el => el.style.display = 'none');
    const emptyEl = document.getElementById('sms-creds-empty');
    emptyEl.style.display = 'none';
    const target = document.getElementById('sms-creds-' + val);
    if (target) {
        target.style.display = 'block';
    } else {
        emptyEl.style.display = 'block';
    }
}

function toggleSmsNotifs(checkbox) {
    const rows = document.getElementById('sms-notif-rows');
    rows.style.opacity = checkbox.checked ? '1' : '0.4';
    rows.style.pointerEvents = checkbox.checked ? 'auto' : 'none';
}

function testSms() {
    const provider = document.getElementById('smsProvider').value;
    if (!provider) {
        Swal.fire({ icon: 'warning', title: 'No provider selected', text: 'Please select and configure an SMS provider first.', confirmButtonColor: '#303d89' });
        return;
    }
    Swal.fire({
        title: 'Send Test SMS',
        input: 'text',
        inputLabel: 'Enter mobile number (with country code)',
        inputPlaceholder: '+91 98765 43210',
        showCancelButton: true,
        confirmButtonColor: '#303d89',
        confirmButtonText: 'Send',
    }).then(result => {
        if (result.isConfirmed && result.value) {
            Swal.fire({ icon: 'success', title: 'Test SMS Sent!', text: 'Test message dispatched to ' + result.value + ' via ' + provider + '.', timer: 2500, showConfirmButton: false });
        }
    });
}
</script>