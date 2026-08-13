{{-- resources/views/emails/partials/_styles.blade.php --}}
<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Inter:wght@300;400;500;600&display=swap');

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    background-color: #f6f4f0;
    font-family: 'Inter', Arial, sans-serif;
    font-size: 14px;
    color: #2c2c2c;
    -webkit-font-smoothing: antialiased;
  }

  .wrapper { max-width: 620px; margin: 40px auto; background: #ffffff; }

  .email-header {
    background-color: #1a1a1a;
    padding: 30px 40px;
    text-align: center;
  }
  .email-header .brand {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 26px;
    font-weight: 600;
    color: #d4af7a;
    letter-spacing: 0.08em;
  }
  .email-header .tagline {
    font-size: 11px;
    color: #888;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    margin-top: 4px;
  }

  .meta-bar {
    background: #f6f4f0;
    border-top: 1px solid #e8e3db;
    border-bottom: 1px solid #e8e3db;
    padding: 18px 40px;
    display: table;
    width: 100%;
  }
  .meta-cell {
    display: table-cell;
    text-align: center;
    padding: 0 8px;
    border-right: 1px solid #ddd8d0;
  }
  .meta-cell:last-child { border-right: none; }
  .meta-label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em; color: #999; display: block; margin-bottom: 3px; }
  .meta-value { font-size: 13px; font-weight: 600; color: #1a1a1a; }

  .body { padding: 32px 40px; }

  .greeting { font-size: 15px; font-weight: 500; color: #2c2c2c; margin-bottom: 8px; }
  .intro { font-size: 13px; color: #666; line-height: 1.7; margin-bottom: 28px; }

  .section-title {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #b08d57;
    font-weight: 600;
    border-bottom: 1px solid #ede8e0;
    padding-bottom: 7px;
    margin-bottom: 14px;
  }

  .item-row { display: table; width: 100%; padding: 12px 0; border-bottom: 1px solid #f0ece5; }
  .item-row:last-child { border-bottom: none; }
  .item-img-cell { display: table-cell; width: 56px; vertical-align: top; }
  .item-img { width: 48px; height: 60px; object-fit: cover; border-radius: 4px; display: block; }
  .item-img-placeholder { width: 48px; height: 60px; background: #f0ece5; border-radius: 4px; display: block; }
  .item-detail-cell { display: table-cell; vertical-align: top; padding: 0 10px; }
  .item-name { font-size: 13px; font-weight: 600; color: #1a1a1a; margin-bottom: 3px; }
  .item-meta { font-size: 11px; color: #999; }
  .item-price-cell { display: table-cell; vertical-align: top; text-align: right; font-size: 13px; font-weight: 600; color: #1a1a1a; white-space: nowrap; }

  .info-grid { display: table; width: 100%; margin-top: 24px; }
  .info-col { display: table-cell; width: 50%; vertical-align: top; padding-right: 16px; }
  .info-col:last-child { padding-right: 0; padding-left: 16px; }
  .info-box { background: #f9f7f4; border-radius: 6px; padding: 14px 16px; }
  .info-box p { font-size: 12px; color: #555; line-height: 1.8; }
  .info-box strong { font-size: 12px; font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 2px; }

  .cta-section { text-align: center; margin: 32px 0 8px; }
  .cta-btn {
    display: inline-block;
    background: #1a1a1a;
    color: #d4af7a !important;
    text-decoration: none;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 13px 28px;
    border-radius: 2px;
  }

  .help-strip {
    background: #f9f7f4;
    border-top: 1px solid #ede8e0;
    padding: 18px 40px;
    text-align: center;
  }
  .help-strip p { font-size: 12px; color: #888; line-height: 1.7; }
  .help-strip a { color: #b08d57; text-decoration: none; }

  .email-footer {
    background: #1a1a1a;
    padding: 24px 40px;
    text-align: center;
  }
  .email-footer .brand-footer {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 14px;
    color: #d4af7a;
    display: block;
    margin-bottom: 8px;
  }
  .email-footer p { font-size: 11px; color: #555; line-height: 1.7; }
  .email-footer a { color: #777; text-decoration: none; }
</style>