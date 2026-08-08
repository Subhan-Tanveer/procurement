@extends('admin.layouts.app')

@section('title', 'Marketing Templates')

@push('styles')
<style>
/* ===== MARKETING TEMPLATE GENERATOR ===== */
:root {
    --gps-primary: #426693;
    --gps-primary-dark: #34526f;
    --gps-primary-light: #5a82ad;
    --gps-accent: #78B547;
    --gps-accent-dark: #5f9a33;
    --gps-accent-light: #93cc66;
    --gps-dark: #1a2332;
    --gps-mid: #2d3e50;
    --gps-light: #f0f4f8;
    --gps-gold: #d4a843;
    --gps-white: #ffffff;
}

.mt-page-header {
    background: linear-gradient(135deg, var(--gps-primary) 0%, var(--gps-primary-dark) 100%);
    border-radius: 16px;
    padding: 28px 32px;
    margin-bottom: 28px;
    color: #fff;
}
.mt-page-header h1 {
    font-size: 24px;
    font-weight: 700;
    margin: 0;
}
.mt-page-header p {
    opacity: 0.8;
    margin: 6px 0 0;
    font-size: 14px;
}

/* Template Grid */
.mt-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}
.mt-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}
.mt-card:hover {
    box-shadow: 0 8px 28px rgba(66,102,147,0.18);
    transform: translateY(-4px);
}
.mt-card.active {
    border-color: var(--gps-accent);
    box-shadow: 0 0 0 3px rgba(120,181,71,0.2), 0 8px 28px rgba(66,102,147,0.15);
}
.mt-card-preview {
    position: relative;
    overflow: hidden;
    background: #f5f7fa;
}
.mt-card-preview .template-wrap {
    transform: scale(0.32);
    transform-origin: top left;
    width: 1080px;
    height: 1080px;
    pointer-events: none;
}
.mt-card-preview-container {
    width: 100%;
    height: 0;
    padding-bottom: 100%;
    position: relative;
    overflow: hidden;
}
.mt-card-preview-container .template-wrap {
    position: absolute;
    top: 0;
    left: 0;
}
.mt-card-info {
    padding: 14px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.mt-card-info h4 {
    font-size: 14px;
    font-weight: 600;
    margin: 0;
    color: #333;
}
.mt-card-info .badge {
    font-size: 11px;
    font-weight: 500;
}

/* Editor Panel */
.mt-editor-panel {
    position: fixed;
    right: -520px;
    top: 0;
    width: 520px;
    height: 100vh;
    background: #fff;
    box-shadow: -8px 0 40px rgba(0,0,0,0.12);
    z-index: 1050;
    transition: right 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.mt-editor-panel.open {
    right: 0;
}
.mt-editor-header {
    padding: 20px 24px;
    background: linear-gradient(135deg, var(--gps-primary) 0%, var(--gps-primary-dark) 100%);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}
.mt-editor-header h3 {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
}
.mt-editor-header .btn-close-editor {
    background: rgba(255,255,255,0.15);
    border: none;
    color: #fff;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s;
}
.mt-editor-header .btn-close-editor:hover {
    background: rgba(255,255,255,0.3);
}
.mt-editor-body {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
}
.mt-editor-body label {
    font-size: 13px;
    font-weight: 600;
    color: #555;
    margin-bottom: 6px;
}
.mt-editor-body .form-control,
.mt-editor-body .form-select {
    border-radius: 10px;
    border-color: #e0e5eb;
    font-size: 14px;
    padding: 10px 14px;
}
.mt-editor-body .form-control:focus,
.mt-editor-body .form-select:focus {
    border-color: var(--gps-accent);
    box-shadow: 0 0 0 3px rgba(120,181,71,0.15);
}
.mt-editor-body textarea.form-control {
    min-height: 80px;
    resize: vertical;
}
.mt-editor-footer {
    padding: 16px 24px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 12px;
    flex-shrink: 0;
}
.mt-editor-footer .btn {
    flex: 1;
    border-radius: 10px;
    padding: 12px 16px;
    font-weight: 600;
    font-size: 14px;
}

/* Preview Modal */
.mt-preview-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    z-index: 1100;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 40px;
}
.mt-preview-overlay.show {
    display: flex;
}
.mt-preview-wrapper {
    max-width: 1080px;
    max-height: 90vh;
    overflow: auto;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    position: relative;
}
.mt-preview-close {
    position: fixed;
    top: 20px;
    right: 20px;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(255,255,255,0.9);
    border: none;
    font-size: 24px;
    cursor: pointer;
    z-index: 1110;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.mt-preview-actions {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 12px;
    z-index: 1110;
}
.mt-preview-actions .btn {
    border-radius: 25px;
    padding: 12px 28px;
    font-weight: 600;
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
}

/* Editor backdrop */
.mt-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.3);
    z-index: 1040;
    display: none;
}
.mt-backdrop.show {
    display: block;
}

/* Category Filters */
.mt-filters {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}
.mt-filter-btn {
    padding: 8px 18px;
    border-radius: 25px;
    border: 1px solid #ddd;
    background: #fff;
    font-size: 13px;
    font-weight: 500;
    color: #666;
    cursor: pointer;
    transition: all 0.2s;
}
.mt-filter-btn:hover,
.mt-filter-btn.active {
    background: var(--gps-primary);
    border-color: var(--gps-primary);
    color: #fff;
}

/* ===== TEMPLATE STYLES ===== */
/* All templates are 1080x1080 (Instagram-ready) */
.template-wrap {
    width: 1080px;
    height: 1080px;
    position: relative;
    overflow: hidden;
    font-family: 'Instrument Sans', 'Segoe UI', Arial, sans-serif;
    color: #fff;
}
.template-wrap * {
    box-sizing: border-box;
}

/* Logo styles used across templates */
.tpl-logo { position: absolute; z-index: 10; }
.tpl-logo img { display: block; object-fit: contain; }

/* Shared image styles */
.tpl-photo {
    position: absolute;
    overflow: hidden;
    background: rgba(255,255,255,0.08);
    border-radius: 18px;
    box-shadow: 0 14px 40px rgba(0,0,0,0.18);
}
.tpl-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.tpl-photo-circle {
    border-radius: 50%;
}
.tpl-photo-frame {
    padding: 10px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.2);
}
.tpl-photo-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0.35;
}

/* === T1: Bold Diagonal === */
.tpl-bold-diagonal {
    background: var(--gps-primary);
}
.tpl-bold-diagonal::before {
    content: '';
    position: absolute;
    top: -200px;
    right: -100px;
    width: 800px;
    height: 800px;
    background: var(--gps-accent);
    transform: rotate(35deg);
    opacity: 0.15;
}
.tpl-bold-diagonal::after {
    content: '';
    position: absolute;
    bottom: -300px;
    left: -200px;
    width: 900px;
    height: 600px;
    background: var(--gps-accent);
    transform: rotate(-20deg);
}
.tpl-bold-diagonal .tpl-logo {
    top: 50px;
    left: 60px;
}
.tpl-bold-diagonal .tpl-logo img {
    height: 70px;
}
.tpl-bold-diagonal .tpl-content {
    position: absolute;
    top: 180px;
    left: 60px;
    right: 60px;
    z-index: 5;
}
.tpl-bold-diagonal .tpl-headline {
    font-size: 72px;
    font-weight: 800;
    line-height: 1.05;
    margin-bottom: 24px;
    text-transform: uppercase;
    letter-spacing: -1px;
}
.tpl-bold-diagonal .tpl-subtext {
    font-size: 26px;
    opacity: 0.9;
    line-height: 1.4;
    max-width: 600px;
}
.tpl-bold-diagonal .tpl-cta {
    position: absolute;
    bottom: 80px;
    left: 60px;
    z-index: 5;
    background: #fff;
    color: var(--gps-primary);
    padding: 18px 48px;
    font-size: 22px;
    font-weight: 700;
    border-radius: 50px;
    letter-spacing: 1px;
}
.tpl-bold-diagonal .tpl-footer-text {
    position: absolute;
    bottom: 40px;
    right: 60px;
    z-index: 5;
    font-size: 16px;
    opacity: 0.7;
}
.tpl-bold-diagonal .tpl-photo-1 {
    width: 320px;
    height: 320px;
    right: 80px;
    bottom: 140px;
    transform: rotate(-3deg);
}

/* === T2: Clean Split === */
.tpl-clean-split {
    background: #fff;
    color: var(--gps-dark);
}
.tpl-clean-split .tpl-left {
    position: absolute;
    left: 0;
    top: 0;
    width: 50%;
    height: 100%;
    background: var(--gps-primary);
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 60px;
    color: #fff;
}
.tpl-clean-split .tpl-right {
    position: absolute;
    right: 0;
    top: 0;
    width: 50%;
    height: 100%;
    background: var(--gps-accent);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 60px;
}
.tpl-clean-split .tpl-logo {
    top: 50px;
    left: 60px;
}
.tpl-clean-split .tpl-logo img {
    height: 55px;
    filter: brightness(10);
}
.tpl-clean-split .tpl-headline {
    font-size: 58px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 20px;
}
.tpl-clean-split .tpl-subtext {
    font-size: 22px;
    opacity: 0.85;
    line-height: 1.5;
}
.tpl-clean-split .tpl-right-headline {
    font-size: 120px;
    font-weight: 900;
    color: rgba(255,255,255,0.15);
    line-height: 1;
    text-align: center;
}
.tpl-clean-split .tpl-right-text {
    font-size: 28px;
    font-weight: 700;
    color: #fff;
    text-align: center;
    margin-top: 10px;
}
.tpl-clean-split .tpl-cta {
    margin-top: 32px;
    background: rgba(255,255,255,0.2);
    color: #fff;
    padding: 14px 36px;
    font-size: 18px;
    font-weight: 700;
    border-radius: 8px;
    display: inline-block;
    border: 2px solid rgba(255,255,255,0.4);
}
.tpl-clean-split .tpl-photo-1 {
    width: 320px;
    height: 420px;
    position: absolute;
    bottom: 80px;
    right: 80px;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
}

/* === T3: Gradient Burst === */
.tpl-gradient-burst {
    background: linear-gradient(135deg, var(--gps-dark) 0%, var(--gps-primary) 50%, var(--gps-accent) 100%);
}
.tpl-gradient-burst .tpl-circle-deco {
    position: absolute;
    border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.08);
}
.tpl-gradient-burst .tpl-circle-1 {
    width: 600px; height: 600px;
    top: -150px; right: -150px;
}
.tpl-gradient-burst .tpl-circle-2 {
    width: 400px; height: 400px;
    bottom: -100px; left: -100px;
}
.tpl-gradient-burst .tpl-circle-3 {
    width: 200px; height: 200px;
    top: 40%; left: 40%;
    background: rgba(120,181,71,0.1);
}
.tpl-gradient-burst .tpl-logo {
    top: 50px;
    right: 60px;
}
.tpl-gradient-burst .tpl-logo img {
    height: 60px;
}
.tpl-gradient-burst .tpl-content {
    position: absolute;
    bottom: 100px;
    left: 70px;
    right: 70px;
    z-index: 5;
}
.tpl-gradient-burst .tpl-headline {
    font-size: 64px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 20px;
}
.tpl-gradient-burst .tpl-subtext {
    font-size: 24px;
    opacity: 0.85;
    line-height: 1.5;
    max-width: 700px;
}
.tpl-gradient-burst .tpl-tag {
    position: absolute;
    top: 60px;
    left: 70px;
    background: var(--gps-accent);
    padding: 10px 28px;
    font-size: 16px;
    font-weight: 700;
    border-radius: 25px;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.tpl-gradient-burst .tpl-photo-1 {
    width: 280px;
    height: 280px;
    right: 80px;
    bottom: 120px;
    border-radius: 50%;
    border: 6px solid rgba(255,255,255,0.2);
    box-shadow: 0 18px 40px rgba(0,0,0,0.25);
}

/* === T4: Minimal Card === */
.tpl-minimal-card {
    background: var(--gps-light);
    color: var(--gps-dark);
    display: flex;
    align-items: center;
    justify-content: center;
}
.tpl-minimal-card .tpl-card-inner {
    width: 860px;
    background: #fff;
    border-radius: 32px;
    padding: 80px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.08);
    text-align: center;
}
.tpl-minimal-card .tpl-logo {
    position: relative;
    display: flex;
    justify-content: center;
    margin-bottom: 40px;
}
.tpl-minimal-card .tpl-logo img {
    height: 60px;
}
.tpl-minimal-card .tpl-headline {
    font-size: 52px;
    font-weight: 800;
    color: var(--gps-primary);
    line-height: 1.15;
    margin-bottom: 24px;
}
.tpl-minimal-card .tpl-subtext {
    font-size: 22px;
    color: #666;
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto 36px;
}
.tpl-minimal-card .tpl-cta {
    display: inline-block;
    background: var(--gps-accent);
    color: #fff;
    padding: 16px 48px;
    font-size: 20px;
    font-weight: 700;
    border-radius: 50px;
}
.tpl-minimal-card .tpl-accent-line {
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, var(--gps-primary), var(--gps-accent));
    margin: 0 auto 36px;
    border-radius: 2px;
}
.tpl-minimal-card .tpl-photo-1 {
    position: relative;
    width: 100%;
    height: 240px;
    margin: 0 auto 30px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 16px 40px rgba(0,0,0,0.12);
}

/* === T5: Stats Showcase === */
.tpl-stats-showcase {
    background: var(--gps-dark);
}
.tpl-stats-showcase::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.tpl-stats-showcase .tpl-logo {
    top: 50px;
    left: 50%;
    transform: translateX(-50%);
}
.tpl-stats-showcase .tpl-logo img {
    height: 55px;
}
.tpl-stats-showcase .tpl-headline {
    position: absolute;
    top: 160px;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 48px;
    font-weight: 800;
    z-index: 5;
    padding: 0 60px;
}
.tpl-stats-showcase .tpl-stats-grid {
    position: absolute;
    top: 320px;
    left: 60px;
    right: 60px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    z-index: 5;
}
.tpl-stats-showcase .tpl-stat-item {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: 40px;
    text-align: center;
}
.tpl-stats-showcase .tpl-stat-number {
    font-size: 64px;
    font-weight: 900;
    color: var(--gps-accent);
    line-height: 1;
    margin-bottom: 10px;
}
.tpl-stats-showcase .tpl-stat-label {
    font-size: 18px;
    opacity: 0.7;
    text-transform: uppercase;
    letter-spacing: 2px;
}
.tpl-stats-showcase .tpl-footer-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 8px;
    background: linear-gradient(90deg, var(--gps-primary), var(--gps-accent));
}
.tpl-stats-showcase .tpl-photo-1 {
    width: 220px;
    height: 220px;
    bottom: 90px;
    right: 70px;
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.05);
    z-index: 4;
}

/* === T6: Product Spotlight === */
.tpl-product-spotlight {
    background: linear-gradient(160deg, var(--gps-primary) 0%, var(--gps-primary-dark) 100%);
}
.tpl-product-spotlight .tpl-accent-circle {
    position: absolute;
    width: 700px;
    height: 700px;
    border-radius: 50%;
    background: var(--gps-accent);
    right: -200px;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.12;
}
.tpl-product-spotlight .tpl-logo {
    top: 50px;
    left: 60px;
}
.tpl-product-spotlight .tpl-logo img {
    height: 55px;
}
.tpl-product-spotlight .tpl-badge {
    position: absolute;
    top: 55px;
    right: 60px;
    background: var(--gps-accent);
    color: #fff;
    padding: 8px 24px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    z-index: 5;
}
.tpl-product-spotlight .tpl-content {
    position: absolute;
    left: 60px;
    right: 60px;
    top: 160px;
    z-index: 5;
}
.tpl-product-spotlight .tpl-product-name {
    font-size: 20px;
    text-transform: uppercase;
    letter-spacing: 3px;
    opacity: 0.6;
    margin-bottom: 16px;
}
.tpl-product-spotlight .tpl-headline {
    font-size: 64px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 24px;
}
.tpl-product-spotlight .tpl-subtext {
    font-size: 22px;
    opacity: 0.8;
    line-height: 1.5;
    max-width: 600px;
}
.tpl-product-spotlight .tpl-features {
    position: absolute;
    bottom: 120px;
    left: 60px;
    right: 60px;
    display: flex;
    gap: 40px;
    z-index: 5;
}
.tpl-product-spotlight .tpl-feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 18px;
}
.tpl-product-spotlight .tpl-feature-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--gps-accent);
    flex-shrink: 0;
}
.tpl-product-spotlight .tpl-bottom-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: var(--gps-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 700;
    letter-spacing: 1px;
}
.tpl-product-spotlight .tpl-photo-1 {
    width: 360px;
    height: 480px;
    right: 80px;
    bottom: 140px;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    border: 1px solid rgba(255,255,255,0.15);
}

/* === T7: Geometric Pattern === */
.tpl-geometric {
    background: var(--gps-primary);
}
.tpl-geometric .tpl-geo-shape {
    position: absolute;
    border: 3px solid rgba(255,255,255,0.08);
}
.tpl-geometric .tpl-geo-1 {
    width: 300px; height: 300px;
    top: -50px; right: -50px;
    transform: rotate(45deg);
}
.tpl-geometric .tpl-geo-2 {
    width: 200px; height: 200px;
    bottom: 100px; right: 200px;
    transform: rotate(30deg);
    border-color: rgba(120,181,71,0.2);
}
.tpl-geometric .tpl-geo-3 {
    width: 150px; height: 150px;
    top: 300px; left: -30px;
    transform: rotate(60deg);
}
.tpl-geometric .tpl-geo-4 {
    width: 400px; height: 400px;
    bottom: -150px; left: 200px;
    border-radius: 50%;
    border-width: 2px;
    border-color: rgba(120,181,71,0.12);
}
.tpl-geometric .tpl-logo {
    top: 60px;
    left: 70px;
}
.tpl-geometric .tpl-logo img {
    height: 55px;
}
.tpl-geometric .tpl-content {
    position: absolute;
    left: 70px;
    right: 70px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 5;
}
.tpl-geometric .tpl-headline {
    font-size: 68px;
    font-weight: 800;
    line-height: 1.05;
    margin-bottom: 28px;
}
.tpl-geometric .tpl-divider {
    width: 100px;
    height: 5px;
    background: var(--gps-accent);
    margin-bottom: 28px;
    border-radius: 3px;
}
.tpl-geometric .tpl-subtext {
    font-size: 24px;
    line-height: 1.5;
    opacity: 0.85;
    max-width: 600px;
}
.tpl-geometric .tpl-website {
    position: absolute;
    bottom: 50px;
    left: 70px;
    font-size: 18px;
    opacity: 0.5;
    z-index: 5;
    letter-spacing: 1px;
}
.tpl-geometric .tpl-photo-1 {
    width: 320px;
    height: 320px;
    right: 80px;
    bottom: 160px;
    transform: rotate(6deg);
    border-radius: 20px;
}

/* === T8: Full Accent === */
.tpl-full-accent {
    background: var(--gps-accent);
}
.tpl-full-accent .tpl-stripe {
    position: absolute;
    height: 100%;
    background: rgba(255,255,255,0.06);
    transform: skewX(-12deg);
}
.tpl-full-accent .tpl-stripe-1 { width: 120px; left: 15%; }
.tpl-full-accent .tpl-stripe-2 { width: 60px; left: 35%; }
.tpl-full-accent .tpl-stripe-3 { width: 180px; left: 65%; }
.tpl-full-accent .tpl-logo {
    bottom: 60px;
    right: 60px;
}
.tpl-full-accent .tpl-logo img {
    height: 50px;
}
.tpl-full-accent .tpl-content {
    position: absolute;
    left: 80px;
    right: 80px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 5;
    text-align: center;
}
.tpl-full-accent .tpl-headline {
    font-size: 72px;
    font-weight: 900;
    line-height: 1.05;
    margin-bottom: 28px;
    text-shadow: 0 2px 20px rgba(0,0,0,0.1);
}
.tpl-full-accent .tpl-subtext {
    font-size: 26px;
    line-height: 1.5;
    opacity: 0.9;
    max-width: 650px;
    margin: 0 auto;
}
.tpl-full-accent .tpl-top-badge {
    position: absolute;
    top: 50px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--gps-primary);
    padding: 12px 36px;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    z-index: 5;
}
.tpl-full-accent .tpl-photo-1 {
    width: 520px;
    height: 520px;
    left: 50%;
    top: 160px;
    transform: translateX(-50%);
    border-radius: 28px;
    box-shadow: 0 18px 50px rgba(0,0,0,0.2);
    z-index: 3;
}

/* === T9: Duo Tone === */
.tpl-duo-tone {
    background: var(--gps-primary);
}
.tpl-duo-tone .tpl-bottom-half {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 45%;
    background: var(--gps-dark);
}
.tpl-duo-tone .tpl-accent-stripe {
    position: absolute;
    top: 55%;
    left: 0;
    right: 0;
    height: 8px;
    background: var(--gps-accent);
    z-index: 5;
    transform: translateY(-50%);
}
.tpl-duo-tone .tpl-logo {
    top: 50px;
    left: 60px;
    z-index: 5;
}
.tpl-duo-tone .tpl-logo img {
    height: 55px;
}
.tpl-duo-tone .tpl-content {
    position: absolute;
    left: 60px;
    right: 60px;
    top: 50%;
    transform: translateY(-60%);
    z-index: 10;
}
.tpl-duo-tone .tpl-headline {
    font-size: 62px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 20px;
}
.tpl-duo-tone .tpl-subtext {
    font-size: 24px;
    line-height: 1.5;
    opacity: 0.85;
    max-width: 650px;
}
.tpl-duo-tone .tpl-cta {
    position: absolute;
    bottom: 60px;
    left: 60px;
    background: var(--gps-accent);
    padding: 16px 44px;
    font-size: 20px;
    font-weight: 700;
    border-radius: 8px;
    z-index: 10;
    color: #fff;
}
.tpl-duo-tone .tpl-website {
    position: absolute;
    bottom: 68px;
    right: 60px;
    font-size: 16px;
    opacity: 0.5;
    z-index: 10;
}

/* === T10: Corner Accent === */
.tpl-corner-accent {
    background: #fff;
    color: var(--gps-dark);
}
.tpl-corner-accent .tpl-corner-tl {
    position: absolute;
    top: 0;
    left: 0;
    width: 350px;
    height: 350px;
    background: var(--gps-primary);
    clip-path: polygon(0 0, 100% 0, 0 100%);
}
.tpl-corner-accent .tpl-corner-br {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 400px;
    height: 400px;
    background: var(--gps-accent);
    clip-path: polygon(100% 0, 100% 100%, 0 100%);
}
.tpl-corner-accent .tpl-logo {
    top: 35px;
    left: 40px;
    z-index: 5;
}
.tpl-corner-accent .tpl-logo img {
    height: 45px;
    filter: brightness(10);
}
.tpl-corner-accent .tpl-content {
    position: absolute;
    left: 80px;
    right: 80px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 5;
    text-align: center;
}
.tpl-corner-accent .tpl-headline {
    font-size: 60px;
    font-weight: 800;
    color: var(--gps-primary);
    line-height: 1.1;
    margin-bottom: 24px;
}
.tpl-corner-accent .tpl-subtext {
    font-size: 24px;
    color: #555;
    line-height: 1.5;
    max-width: 600px;
    margin: 0 auto 36px;
}
.tpl-corner-accent .tpl-cta {
    display: inline-block;
    background: var(--gps-primary);
    color: #fff;
    padding: 16px 48px;
    font-size: 20px;
    font-weight: 700;
    border-radius: 8px;
}

/* === T11: Wave Banner === */
.tpl-wave-banner {
    background: var(--gps-primary);
}
.tpl-wave-banner .tpl-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 300px;
    background: var(--gps-accent);
    clip-path: ellipse(70% 100% at 50% 100%);
}
.tpl-wave-banner .tpl-wave-inner {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 250px;
    background: var(--gps-accent-dark);
    clip-path: ellipse(60% 100% at 50% 100%);
}
.tpl-wave-banner .tpl-logo {
    top: 50px;
    left: 50%;
    transform: translateX(-50%);
}
.tpl-wave-banner .tpl-logo img {
    height: 60px;
}
.tpl-wave-banner .tpl-content {
    position: absolute;
    top: 180px;
    left: 70px;
    right: 70px;
    text-align: center;
    z-index: 5;
}
.tpl-wave-banner .tpl-headline {
    font-size: 62px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 24px;
}
.tpl-wave-banner .tpl-subtext {
    font-size: 24px;
    opacity: 0.85;
    line-height: 1.5;
    max-width: 650px;
    margin: 0 auto;
}
.tpl-wave-banner .tpl-bottom-text {
    position: absolute;
    bottom: 50px;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 20px;
    font-weight: 700;
    z-index: 10;
    letter-spacing: 1px;
}

/* === T12: Bold Quote === */
.tpl-bold-quote {
    background: var(--gps-dark);
}
.tpl-bold-quote .tpl-quote-mark {
    position: absolute;
    top: 60px;
    right: 80px;
    font-size: 300px;
    color: var(--gps-accent);
    opacity: 0.1;
    font-family: Georgia, serif;
    line-height: 1;
}
.tpl-bold-quote .tpl-logo {
    top: 50px;
    left: 70px;
}
.tpl-bold-quote .tpl-logo img {
    height: 50px;
}
.tpl-bold-quote .tpl-content {
    position: absolute;
    left: 70px;
    right: 70px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 5;
}
.tpl-bold-quote .tpl-headline {
    font-size: 52px;
    font-weight: 700;
    line-height: 1.3;
    font-style: italic;
    margin-bottom: 36px;
    border-left: 6px solid var(--gps-accent);
    padding-left: 32px;
}
.tpl-bold-quote .tpl-author {
    font-size: 22px;
    color: var(--gps-accent);
    font-weight: 700;
    padding-left: 38px;
}
.tpl-bold-quote .tpl-author-role {
    font-size: 16px;
    opacity: 0.5;
    padding-left: 38px;
    margin-top: 6px;
}

/* === T13: Grid Overlay === */
.tpl-grid-overlay {
    background: var(--gps-primary);
}
.tpl-grid-overlay .tpl-grid-bg {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
    background-size: 60px 60px;
}
.tpl-grid-overlay .tpl-logo {
    bottom: 60px;
    left: 60px;
}
.tpl-grid-overlay .tpl-logo img {
    height: 50px;
}
.tpl-grid-overlay .tpl-accent-block {
    position: absolute;
    top: 0;
    right: 0;
    width: 300px;
    height: 100%;
    background: var(--gps-accent);
    opacity: 0.15;
}
.tpl-grid-overlay .tpl-content {
    position: absolute;
    top: 50%;
    left: 70px;
    right: 70px;
    transform: translateY(-50%);
    z-index: 5;
}
.tpl-grid-overlay .tpl-tag {
    display: inline-block;
    background: var(--gps-accent);
    padding: 8px 22px;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 24px;
    border-radius: 4px;
}
.tpl-grid-overlay .tpl-headline {
    font-size: 66px;
    font-weight: 800;
    line-height: 1.08;
    margin-bottom: 24px;
}
.tpl-grid-overlay .tpl-subtext {
    font-size: 22px;
    opacity: 0.8;
    line-height: 1.5;
    max-width: 650px;
}

/* === T14: Stacked Bars === */
.tpl-stacked-bars {
    background: #fff;
    color: var(--gps-dark);
}
.tpl-stacked-bars .tpl-bar {
    position: absolute;
    left: 0;
    right: 0;
    z-index: 1;
}
.tpl-stacked-bars .tpl-bar-1 {
    top: 0;
    height: 120px;
    background: var(--gps-primary);
}
.tpl-stacked-bars .tpl-bar-2 {
    top: 120px;
    height: 12px;
    background: var(--gps-accent);
}
.tpl-stacked-bars .tpl-bar-3 {
    bottom: 0;
    height: 120px;
    background: var(--gps-primary);
}
.tpl-stacked-bars .tpl-bar-4 {
    bottom: 120px;
    height: 12px;
    background: var(--gps-accent);
}
.tpl-stacked-bars .tpl-logo {
    top: 30px;
    left: 60px;
    z-index: 5;
}
.tpl-stacked-bars .tpl-logo img {
    height: 55px;
    filter: brightness(10);
}
.tpl-stacked-bars .tpl-content {
    position: absolute;
    left: 80px;
    right: 80px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 5;
    text-align: center;
}
.tpl-stacked-bars .tpl-headline {
    font-size: 58px;
    font-weight: 800;
    color: var(--gps-primary);
    line-height: 1.1;
    margin-bottom: 24px;
}
.tpl-stacked-bars .tpl-subtext {
    font-size: 22px;
    color: #666;
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto 36px;
}
.tpl-stacked-bars .tpl-cta {
    display: inline-block;
    background: var(--gps-accent);
    color: #fff;
    padding: 16px 44px;
    font-size: 20px;
    font-weight: 700;
    border-radius: 50px;
}
.tpl-stacked-bars .tpl-footer-text {
    position: absolute;
    bottom: 38px;
    left: 0;
    right: 0;
    text-align: center;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    z-index: 5;
}

/* === T15: Radial Glow === */
.tpl-radial-glow {
    background: var(--gps-dark);
}
.tpl-radial-glow::before {
    content: '';
    position: absolute;
    width: 800px;
    height: 800px;
    border-radius: 50%;
    background: radial-gradient(circle, var(--gps-primary) 0%, transparent 70%);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0.4;
}
.tpl-radial-glow .tpl-logo {
    top: 50px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 5;
}
.tpl-radial-glow .tpl-logo img {
    height: 65px;
}
.tpl-radial-glow .tpl-content {
    position: absolute;
    left: 70px;
    right: 70px;
    top: 50%;
    transform: translateY(-50%);
    text-align: center;
    z-index: 5;
}
.tpl-radial-glow .tpl-headline {
    font-size: 68px;
    font-weight: 800;
    line-height: 1.08;
    margin-bottom: 24px;
}
.tpl-radial-glow .tpl-subtext {
    font-size: 24px;
    opacity: 0.75;
    line-height: 1.5;
    max-width: 650px;
    margin: 0 auto;
}
.tpl-radial-glow .tpl-bottom-cta {
    position: absolute;
    bottom: 70px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--gps-accent);
    color: #fff;
    padding: 18px 56px;
    font-size: 22px;
    font-weight: 700;
    border-radius: 50px;
    z-index: 5;
}

/* === T16: Horizontal Thirds === */
.tpl-h-thirds {
    background: var(--gps-primary);
}
.tpl-h-thirds .tpl-third-1 {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 33.33%;
    background: var(--gps-dark);
    display: flex;
    align-items: center;
    padding: 0 70px;
}
.tpl-h-thirds .tpl-third-2 {
    position: absolute;
    top: 33.33%;
    left: 0;
    right: 0;
    height: 33.34%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 70px;
}
.tpl-h-thirds .tpl-third-3 {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 33.33%;
    background: var(--gps-accent);
    display: flex;
    align-items: center;
    padding: 0 70px;
}
.tpl-h-thirds .tpl-logo img {
    height: 55px;
}
.tpl-h-thirds .tpl-headline {
    font-size: 60px;
    font-weight: 800;
    line-height: 1.1;
    text-align: center;
}
.tpl-h-thirds .tpl-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}
.tpl-h-thirds .tpl-subtext {
    font-size: 24px;
    font-weight: 600;
    max-width: 600px;
}
.tpl-h-thirds .tpl-cta {
    background: #fff;
    color: var(--gps-accent-dark);
    padding: 14px 36px;
    font-size: 18px;
    font-weight: 700;
    border-radius: 8px;
    white-space: nowrap;
}

/* === T17: Dotted Frame === */
.tpl-dotted-frame {
    background: var(--gps-primary);
}
.tpl-dotted-frame .tpl-frame {
    position: absolute;
    top: 40px;
    left: 40px;
    right: 40px;
    bottom: 40px;
    border: 3px dotted rgba(255,255,255,0.2);
    border-radius: 20px;
}
.tpl-dotted-frame .tpl-inner-frame {
    position: absolute;
    top: 70px;
    left: 70px;
    right: 70px;
    bottom: 70px;
    border: 2px solid rgba(120,181,71,0.3);
    border-radius: 16px;
}
.tpl-dotted-frame .tpl-logo {
    top: 65px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 5;
}
.tpl-dotted-frame .tpl-logo img {
    height: 55px;
}
.tpl-dotted-frame .tpl-content {
    position: absolute;
    left: 100px;
    right: 100px;
    top: 50%;
    transform: translateY(-50%);
    text-align: center;
    z-index: 5;
}
.tpl-dotted-frame .tpl-headline {
    font-size: 56px;
    font-weight: 800;
    line-height: 1.15;
    margin-bottom: 28px;
}
.tpl-dotted-frame .tpl-divider {
    width: 60px;
    height: 4px;
    background: var(--gps-accent);
    margin: 0 auto 28px;
    border-radius: 2px;
}
.tpl-dotted-frame .tpl-subtext {
    font-size: 22px;
    opacity: 0.85;
    line-height: 1.5;
    max-width: 550px;
    margin: 0 auto;
}
.tpl-dotted-frame .tpl-website {
    position: absolute;
    bottom: 65px;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 16px;
    opacity: 0.5;
    z-index: 5;
}

/* === T18: Angled Blocks === */
.tpl-angled-blocks {
    background: var(--gps-dark);
}
.tpl-angled-blocks .tpl-angle-1 {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 55%;
    background: var(--gps-primary);
    clip-path: polygon(0 0, 100% 0, 100% 80%, 0 100%);
}
.tpl-angled-blocks .tpl-angle-accent {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 58%;
    background: var(--gps-accent);
    clip-path: polygon(0 0, 100% 0, 100% 78%, 0 98%);
    opacity: 0.1;
}
.tpl-angled-blocks .tpl-logo {
    top: 50px;
    left: 60px;
    z-index: 5;
}
.tpl-angled-blocks .tpl-logo img {
    height: 55px;
}
.tpl-angled-blocks .tpl-content {
    position: absolute;
    top: 160px;
    left: 70px;
    right: 70px;
    z-index: 5;
}
.tpl-angled-blocks .tpl-headline {
    font-size: 64px;
    font-weight: 800;
    line-height: 1.08;
    margin-bottom: 20px;
}
.tpl-angled-blocks .tpl-subtext {
    font-size: 22px;
    opacity: 0.9;
    line-height: 1.5;
    max-width: 550px;
}
.tpl-angled-blocks .tpl-bottom-content {
    position: absolute;
    bottom: 70px;
    left: 70px;
    right: 70px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    z-index: 5;
}
.tpl-angled-blocks .tpl-cta {
    background: var(--gps-accent);
    color: #fff;
    padding: 16px 44px;
    font-size: 20px;
    font-weight: 700;
    border-radius: 8px;
}
.tpl-angled-blocks .tpl-contact-info {
    text-align: right;
    font-size: 16px;
    opacity: 0.6;
    line-height: 1.8;
}

/* === T19: Hexagonal === */
.tpl-hexagonal {
    background: linear-gradient(180deg, var(--gps-primary-dark) 0%, var(--gps-primary) 100%);
}
.tpl-hexagonal .tpl-hex {
    position: absolute;
    width: 200px;
    height: 230px;
    background: rgba(120,181,71,0.06);
    clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
}
.tpl-hexagonal .tpl-hex-1 { top: -40px; right: 80px; }
.tpl-hexagonal .tpl-hex-2 { top: 150px; right: -30px; width: 160px; height: 185px; }
.tpl-hexagonal .tpl-hex-3 { bottom: 60px; left: -40px; width: 180px; height: 207px; }
.tpl-hexagonal .tpl-hex-4 {
    bottom: -60px; right: 200px;
    width: 140px; height: 161px;
    background: rgba(255,255,255,0.04);
}
.tpl-hexagonal .tpl-logo {
    top: 50px;
    left: 60px;
    z-index: 5;
}
.tpl-hexagonal .tpl-logo img {
    height: 55px;
}
.tpl-hexagonal .tpl-content {
    position: absolute;
    left: 60px;
    right: 60px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 5;
}
.tpl-hexagonal .tpl-headline {
    font-size: 62px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 24px;
}
.tpl-hexagonal .tpl-subtext {
    font-size: 22px;
    opacity: 0.8;
    line-height: 1.5;
    max-width: 650px;
}
.tpl-hexagonal .tpl-cta {
    position: absolute;
    bottom: 60px;
    left: 60px;
    display: inline-block;
    background: var(--gps-accent);
    color: #fff;
    padding: 16px 48px;
    font-size: 20px;
    font-weight: 700;
    border-radius: 8px;
    z-index: 5;
}
.tpl-hexagonal .tpl-website {
    position: absolute;
    bottom: 68px;
    right: 60px;
    font-size: 16px;
    opacity: 0.5;
    z-index: 5;
}

/* === T20: Executive Premium === */
.tpl-executive {
    background: var(--gps-dark);
}
.tpl-executive .tpl-gold-line-v {
    position: absolute;
    left: 80px;
    top: 0;
    bottom: 0;
    width: 1px;
    background: linear-gradient(180deg, transparent 0%, var(--gps-gold) 20%, var(--gps-gold) 80%, transparent 100%);
    opacity: 0.3;
}
.tpl-executive .tpl-gold-line-h {
    position: absolute;
    top: 80px;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, var(--gps-gold) 20%, var(--gps-gold) 80%, transparent 100%);
    opacity: 0.3;
}
.tpl-executive .tpl-corner-deco {
    position: absolute;
    width: 40px;
    height: 40px;
}
.tpl-executive .tpl-corner-deco::before,
.tpl-executive .tpl-corner-deco::after {
    content: '';
    position: absolute;
    background: var(--gps-gold);
    opacity: 0.4;
}
.tpl-executive .tpl-cd-tl { top: 60px; left: 60px; }
.tpl-executive .tpl-cd-tl::before { top: 0; left: 0; width: 40px; height: 2px; }
.tpl-executive .tpl-cd-tl::after { top: 0; left: 0; width: 2px; height: 40px; }
.tpl-executive .tpl-cd-br { bottom: 60px; right: 60px; }
.tpl-executive .tpl-cd-br::before { bottom: 0; right: 0; width: 40px; height: 2px; }
.tpl-executive .tpl-cd-br::after { bottom: 0; right: 0; width: 2px; height: 40px; }
.tpl-executive .tpl-logo {
    top: 50px;
    right: 60px;
    z-index: 5;
}
.tpl-executive .tpl-logo img {
    height: 50px;
}
.tpl-executive .tpl-content {
    position: absolute;
    left: 120px;
    right: 100px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 5;
}
.tpl-executive .tpl-overline {
    font-size: 15px;
    text-transform: uppercase;
    letter-spacing: 5px;
    color: var(--gps-gold);
    margin-bottom: 20px;
    font-weight: 600;
}
.tpl-executive .tpl-headline {
    font-size: 58px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 24px;
}
.tpl-executive .tpl-divider {
    width: 80px;
    height: 3px;
    background: linear-gradient(90deg, var(--gps-gold), var(--gps-accent));
    margin-bottom: 24px;
}
.tpl-executive .tpl-subtext {
    font-size: 22px;
    opacity: 0.7;
    line-height: 1.6;
    max-width: 600px;
}
.tpl-executive .tpl-footer-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(90deg, var(--gps-primary), var(--gps-accent));
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 5;
}
.tpl-executive .tpl-footer-bar span {
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 3px;
    text-transform: uppercase;
}

/* === T21: Photo Panel === */
.tpl-photo-panel {
    background: #fff;
    color: var(--gps-dark);
}
.tpl-photo-panel .tpl-photo-1 {
    left: 0;
    top: 0;
    width: 56%;
    height: 100%;
    border-radius: 0;
    box-shadow: none;
}
.tpl-photo-panel .tpl-logo {
    top: 50px;
    right: 60px;
}
.tpl-photo-panel .tpl-logo img {
    height: 52px;
}
.tpl-photo-panel .tpl-content {
    position: absolute;
    right: 70px;
    top: 50%;
    transform: translateY(-50%);
    width: 36%;
    z-index: 5;
}
.tpl-photo-panel .tpl-headline {
    font-size: 52px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 18px;
}
.tpl-photo-panel .tpl-subtext {
    font-size: 20px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 26px;
}
.tpl-photo-panel .tpl-cta {
    display: inline-block;
    background: var(--gps-primary);
    color: #fff;
    padding: 14px 36px;
    font-size: 18px;
    font-weight: 700;
    border-radius: 8px;
}
.tpl-photo-panel .tpl-accent {
    width: 60px;
    height: 4px;
    background: var(--gps-accent);
    margin-bottom: 20px;
    border-radius: 2px;
}

/* === T22: Photo Overlay === */
.tpl-photo-overlay {
    background: #0f172a;
    color: #fff;
}
.tpl-photo-overlay::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(15,23,42,0.15) 0%, rgba(15,23,42,0.85) 100%);
    z-index: 2;
}
.tpl-photo-overlay .tpl-photo-bg {
    z-index: 1;
    opacity: 0.65;
}
.tpl-photo-overlay .tpl-logo {
    top: 50px;
    left: 60px;
    z-index: 5;
}
.tpl-photo-overlay .tpl-logo img {
    height: 55px;
}
.tpl-photo-overlay .tpl-content {
    position: absolute;
    left: 60px;
    right: 60px;
    bottom: 120px;
    z-index: 5;
}
.tpl-photo-overlay .tpl-tag {
    display: inline-block;
    background: var(--gps-accent);
    padding: 10px 28px;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    border-radius: 20px;
    margin-bottom: 22px;
}
.tpl-photo-overlay .tpl-headline {
    font-size: 64px;
    font-weight: 800;
    line-height: 1.08;
    margin-bottom: 18px;
}
.tpl-photo-overlay .tpl-subtext {
    font-size: 22px;
    opacity: 0.85;
    line-height: 1.5;
    max-width: 700px;
}
.tpl-photo-overlay .tpl-cta {
    position: absolute;
    right: 60px;
    bottom: 60px;
    background: #fff;
    color: var(--gps-primary);
    padding: 14px 36px;
    font-size: 18px;
    font-weight: 700;
    border-radius: 999px;
    z-index: 6;
}

/* === T23: Editorial Cover === */
.tpl-editorial {
    background: #f8fafc;
    color: var(--gps-dark);
}
.tpl-editorial .tpl-photo-1 {
    width: 100%;
    height: 62%;
    top: 0;
    left: 0;
    border-radius: 0;
    box-shadow: none;
}
.tpl-editorial .tpl-logo {
    top: 40px;
    left: 50px;
}
.tpl-editorial .tpl-logo img { height: 50px; }
.tpl-editorial .tpl-content {
    position: absolute;
    left: 60px;
    right: 60px;
    bottom: 90px;
    z-index: 5;
}
.tpl-editorial .tpl-headline {
    font-size: 64px;
    font-weight: 800;
    line-height: 1.05;
    margin-bottom: 16px;
}
.tpl-editorial .tpl-subtext {
    font-size: 22px;
    color: #475569;
    line-height: 1.5;
}
.tpl-editorial .tpl-cta {
    position: absolute;
    right: 60px;
    bottom: 40px;
    background: var(--gps-primary);
    color: #fff;
    padding: 12px 30px;
    border-radius: 999px;
    font-weight: 700;
}

/* === T24: Product Grid === */
.tpl-product-grid {
    background: var(--gps-dark);
}
.tpl-product-grid .tpl-logo {
    top: 50px;
    left: 60px;
}
.tpl-product-grid .tpl-logo img { height: 48px; }
.tpl-product-grid .tpl-content {
    position: absolute;
    top: 150px;
    left: 60px;
    right: 60px;
    z-index: 5;
}
.tpl-product-grid .tpl-headline {
    font-size: 52px;
    font-weight: 800;
    margin-bottom: 14px;
}
.tpl-product-grid .tpl-subtext {
    font-size: 20px;
    opacity: 0.8;
}
.tpl-product-grid .tpl-grid {
    position: absolute;
    left: 60px;
    right: 60px;
    bottom: 80px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    z-index: 5;
}
.tpl-product-grid .tpl-grid .tpl-photo {
    height: 170px;
    border-radius: 16px;
    position: relative;
}
.tpl-product-grid .tpl-cta {
    position: absolute;
    bottom: 28px;
    left: 60px;
    background: var(--gps-accent);
    color: #fff;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 700;
}

/* === T25: Testimonial Stack === */
.tpl-testimonial {
    background: #0f172a;
}
.tpl-testimonial .tpl-logo {
    top: 50px;
    right: 60px;
}
.tpl-testimonial .tpl-logo img { height: 50px; }
.tpl-testimonial .tpl-card {
    position: absolute;
    left: 70px;
    right: 70px;
    top: 170px;
    background: #fff;
    color: #0f172a;
    border-radius: 24px;
    padding: 50px;
    box-shadow: 0 24px 60px rgba(0,0,0,0.25);
}
.tpl-testimonial .tpl-headline {
    font-size: 36px;
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 26px;
}
.tpl-testimonial .tpl-author {
    font-size: 18px;
    font-weight: 700;
}
.tpl-testimonial .tpl-author-role {
    font-size: 14px;
    color: #64748b;
    margin-top: 4px;
}
.tpl-testimonial .tpl-photo-1 {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    right: 90px;
    top: 120px;
    border: 6px solid rgba(120,181,71,0.25);
}

/* === T26: Event Poster === */
.tpl-event {
    background: linear-gradient(135deg, var(--gps-primary) 0%, var(--gps-accent) 100%);
}
.tpl-event .tpl-photo-1 {
    width: 360px;
    height: 520px;
    left: 70px;
    top: 180px;
    border-radius: 26px;
}
.tpl-event .tpl-content {
    position: absolute;
    right: 80px;
    top: 200px;
    width: 44%;
    z-index: 5;
}
.tpl-event .tpl-tag {
    display: inline-block;
    background: rgba(0,0,0,0.2);
    padding: 8px 22px;
    border-radius: 20px;
    font-size: 14px;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 18px;
}
.tpl-event .tpl-headline {
    font-size: 58px;
    font-weight: 800;
    line-height: 1.05;
    margin-bottom: 16px;
}
.tpl-event .tpl-subtext {
    font-size: 20px;
    opacity: 0.9;
    margin-bottom: 22px;
}
.tpl-event .tpl-cta {
    display: inline-block;
    background: #fff;
    color: var(--gps-primary);
    padding: 12px 30px;
    border-radius: 999px;
    font-weight: 700;
}

/* === T27: Countdown Promo === */
.tpl-countdown {
    background: #111827;
}
.tpl-countdown .tpl-photo-bg { opacity: 0.25; }
.tpl-countdown .tpl-logo { top: 50px; left: 60px; }
.tpl-countdown .tpl-logo img { height: 48px; }
.tpl-countdown .tpl-content {
    position: absolute;
    left: 60px;
    right: 60px;
    top: 180px;
    z-index: 5;
}
.tpl-countdown .tpl-headline {
    font-size: 64px;
    font-weight: 900;
    margin-bottom: 18px;
}
.tpl-countdown .tpl-subtext {
    font-size: 22px;
    opacity: 0.85;
    margin-bottom: 26px;
}
.tpl-countdown .tpl-count {
    display: flex;
    gap: 16px;
}
.tpl-countdown .tpl-count-item {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 16px 20px;
    min-width: 90px;
    text-align: center;
}
.tpl-countdown .tpl-count-num {
    font-size: 28px;
    font-weight: 800;
}
.tpl-countdown .tpl-count-label {
    font-size: 12px;
    opacity: 0.7;
    text-transform: uppercase;
    letter-spacing: 2px;
}
.tpl-countdown .tpl-cta {
    position: absolute;
    right: 60px;
    bottom: 60px;
    background: var(--gps-accent);
    color: #fff;
    padding: 14px 34px;
    border-radius: 8px;
    font-weight: 700;
}

/* === T28: Case Study === */
.tpl-case-study {
    background: #f1f5f9;
    color: #0f172a;
}
.tpl-case-study .tpl-photo-1 {
    width: 420px;
    height: 520px;
    right: 70px;
    top: 160px;
    border-radius: 26px;
}
.tpl-case-study .tpl-content {
    position: absolute;
    left: 70px;
    top: 190px;
    width: 46%;
}
.tpl-case-study .tpl-tag {
    display: inline-block;
    background: var(--gps-primary);
    color: #fff;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 13px;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 18px;
}
.tpl-case-study .tpl-headline {
    font-size: 50px;
    font-weight: 800;
    margin-bottom: 16px;
}
.tpl-case-study .tpl-subtext {
    font-size: 20px;
    color: #475569;
    margin-bottom: 24px;
}
.tpl-case-study .tpl-cta {
    display: inline-block;
    background: var(--gps-accent);
    color: #fff;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 700;
}

/* === T29: Services Overview === */
.tpl-services {
    background: var(--gps-primary);
}
.tpl-services .tpl-logo { top: 50px; left: 60px; }
.tpl-services .tpl-logo img { height: 48px; }
.tpl-services .tpl-content {
    position: absolute;
    top: 150px;
    left: 60px;
    right: 60px;
}
.tpl-services .tpl-headline {
    font-size: 56px;
    font-weight: 800;
    margin-bottom: 18px;
}
.tpl-services .tpl-subtext {
    font-size: 20px;
    opacity: 0.85;
}
.tpl-services .tpl-grid {
    position: absolute;
    left: 60px;
    right: 60px;
    bottom: 80px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}
.tpl-services .tpl-card {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 16px;
    padding: 24px;
    min-height: 170px;
}
.tpl-services .tpl-card-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 10px;
}
.tpl-services .tpl-card-text {
    font-size: 14px;
    opacity: 0.8;
}

/* === T30: Monochrome Minimal === */
.tpl-mono {
    background: #0b0f17;
}
.tpl-mono::before {
    content: '';
    position: absolute;
    inset: 60px;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
}
.tpl-mono .tpl-logo {
    top: 70px;
    left: 80px;
}
.tpl-mono .tpl-logo img {
    height: 50px;
    filter: grayscale(1) brightness(1.2);
}
.tpl-mono .tpl-content {
    position: absolute;
    left: 90px;
    right: 90px;
    top: 50%;
    transform: translateY(-50%);
    text-align: center;
}
.tpl-mono .tpl-headline {
    font-size: 64px;
    font-weight: 800;
    margin-bottom: 18px;
}
.tpl-mono .tpl-subtext {
    font-size: 22px;
    opacity: 0.7;
    max-width: 680px;
    margin: 0 auto 26px;
}
.tpl-mono .tpl-cta {
    display: inline-block;
    border: 1px solid rgba(255,255,255,0.2);
    padding: 12px 30px;
    border-radius: 999px;
    font-weight: 700;
}

/* === T31: Aurora Focus === */
.tpl-aurora {
    background: radial-gradient(circle at 20% 20%, rgba(120,181,71,0.35), transparent 55%),
                radial-gradient(circle at 80% 0%, rgba(66,102,147,0.45), transparent 60%),
                #0f1b2d;
}
.tpl-aurora::before {
    content: '';
    position: absolute;
    inset: 80px;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 28px;
}
.tpl-aurora .tpl-photo-1 {
    width: 360px;
    height: 360px;
    top: 140px;
    left: 90px;
    border-radius: 50%;
    border: 8px solid rgba(255,255,255,0.12);
}
.tpl-aurora .tpl-tag {
    position: absolute;
    top: 90px;
    right: 90px;
    background: rgba(120,181,71,0.9);
    padding: 10px 26px;
    border-radius: 999px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-size: 12px;
}
.tpl-aurora .tpl-content {
    position: absolute;
    right: 90px;
    bottom: 120px;
    max-width: 520px;
}
.tpl-aurora .tpl-headline {
    font-size: 58px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 16px;
}
.tpl-aurora .tpl-subtext {
    font-size: 20px;
    opacity: 0.8;
    line-height: 1.5;
}
.tpl-aurora .tpl-cta {
    margin-top: 22px;
    display: inline-block;
    background: #fff;
    color: #0f1b2d;
    padding: 12px 28px;
    border-radius: 999px;
    font-weight: 700;
}

/* === T32: Split Gallery === */
.tpl-split-gallery {
    background: #f6f8fb;
    color: var(--gps-dark);
}
.tpl-split-gallery .tpl-left {
    position: absolute;
    left: 0;
    top: 0;
    width: 52%;
    height: 100%;
    padding: 90px 70px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.tpl-split-gallery .tpl-right {
    position: absolute;
    right: 0;
    top: 0;
    width: 48%;
    height: 100%;
    padding: 80px 70px;
    display: grid;
    grid-template-rows: 1fr 1fr;
    gap: 18px;
}
.tpl-split-gallery .tpl-tag {
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--gps-primary);
    font-size: 12px;
    margin-bottom: 14px;
}
.tpl-split-gallery .tpl-headline {
    font-size: 56px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 18px;
}
.tpl-split-gallery .tpl-subtext {
    font-size: 20px;
    color: #4b5a6a;
    line-height: 1.6;
}
.tpl-split-gallery .tpl-cta {
    margin-top: 26px;
    display: inline-block;
    background: var(--gps-primary);
    color: #fff;
    padding: 12px 26px;
    border-radius: 10px;
    font-weight: 700;
}
.tpl-split-gallery .tpl-photo {
    border-radius: 22px;
}
.tpl-split-gallery .tpl-photo-1,
.tpl-split-gallery .tpl-photo-2 {
    position: relative;
    width: 100%;
    height: 100%;
}

/* === T33: Minimal Poster === */
.tpl-minimal-poster {
    background: #fdfbf7;
    color: #1c222b;
}
.tpl-minimal-poster .tpl-photo-bg {
    opacity: 0.18;
}
.tpl-minimal-poster .tpl-content {
    position: absolute;
    top: 110px;
    left: 90px;
    right: 90px;
}
.tpl-minimal-poster .tpl-headline {
    font-size: 70px;
    font-weight: 800;
    line-height: 1.05;
    margin-bottom: 18px;
}
.tpl-minimal-poster .tpl-subtext {
    font-size: 22px;
    color: #4c5664;
    max-width: 620px;
    line-height: 1.6;
}
.tpl-minimal-poster .tpl-cta {
    position: absolute;
    bottom: 90px;
    left: 90px;
    background: var(--gps-accent);
    color: #fff;
    padding: 14px 32px;
    border-radius: 999px;
    font-weight: 700;
}
.tpl-minimal-poster .tpl-tag {
    position: absolute;
    top: 70px;
    right: 90px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 3px;
    color: var(--gps-primary);
    font-size: 12px;
}

/* === T34: Diagonal Frame === */
.tpl-diagonal-frame {
    background: #121826;
}
.tpl-diagonal-frame .tpl-frame {
    position: absolute;
    inset: 110px;
    border: 1px solid rgba(255,255,255,0.08);
    transform: rotate(-3deg);
}
.tpl-diagonal-frame .tpl-photo-1 {
    width: 520px;
    height: 520px;
    right: 120px;
    top: 140px;
    transform: rotate(6deg);
    border-radius: 28px;
}
.tpl-diagonal-frame .tpl-content {
    position: absolute;
    left: 90px;
    bottom: 120px;
    max-width: 480px;
}
.tpl-diagonal-frame .tpl-headline {
    font-size: 56px;
    font-weight: 800;
    margin-bottom: 16px;
}
.tpl-diagonal-frame .tpl-subtext {
    font-size: 20px;
    opacity: 0.8;
}
.tpl-diagonal-frame .tpl-cta {
    margin-top: 20px;
    display: inline-block;
    background: var(--gps-accent);
    color: #fff;
    padding: 12px 26px;
    border-radius: 12px;
    font-weight: 700;
}

/* === T35: Stacked Cards === */
.tpl-stacked-cards {
    background: linear-gradient(160deg, #0f1b2d 0%, #1e3352 100%);
}
.tpl-stacked-cards .tpl-content {
    position: absolute;
    top: 90px;
    left: 90px;
    right: 90px;
}
.tpl-stacked-cards .tpl-headline {
    font-size: 52px;
    font-weight: 800;
    margin-bottom: 14px;
}
.tpl-stacked-cards .tpl-subtext {
    font-size: 20px;
    opacity: 0.8;
}
.tpl-stacked-cards .tpl-card-stack {
    position: absolute;
    bottom: 90px;
    left: 90px;
    right: 90px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}
.tpl-stacked-cards .tpl-mini-card {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.14);
    border-radius: 18px;
    padding: 22px;
    min-height: 180px;
}
.tpl-stacked-cards .tpl-mini-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 10px;
}
.tpl-stacked-cards .tpl-mini-text {
    font-size: 14px;
    opacity: 0.75;
    line-height: 1.5;
}

/* === T36: Outline Glow === */
.tpl-outline-glow {
    background: #0c1220;
}
.tpl-outline-glow::before {
    content: '';
    position: absolute;
    inset: 70px;
    border-radius: 26px;
    border: 1px solid rgba(255,255,255,0.12);
    box-shadow: 0 0 30px rgba(120,181,71,0.18);
}
.tpl-outline-glow .tpl-content {
    position: absolute;
    left: 90px;
    top: 120px;
    right: 90px;
    text-align: center;
}
.tpl-outline-glow .tpl-headline {
    font-size: 60px;
    font-weight: 800;
    margin-bottom: 16px;
}
.tpl-outline-glow .tpl-subtext {
    font-size: 22px;
    opacity: 0.75;
    max-width: 700px;
    margin: 0 auto;
}
.tpl-outline-glow .tpl-photo-1 {
    width: 220px;
    height: 220px;
    left: 50%;
    bottom: 120px;
    transform: translateX(-50%);
    border-radius: 50%;
}
.tpl-outline-glow .tpl-cta {
    position: absolute;
    bottom: 80px;
    left: 50%;
    transform: translateX(-50%);
    background: #fff;
    color: #0c1220;
    padding: 12px 30px;
    border-radius: 999px;
    font-weight: 700;
}

/* === T37: Magazine Cutout === */
.tpl-magazine-cut {
    background: #ffffff;
    color: #111827;
}
.tpl-magazine-cut .tpl-photo-1 {
    width: 520px;
    height: 640px;
    left: 90px;
    top: 140px;
    border-radius: 28px;
    box-shadow: 0 30px 80px rgba(17,24,39,0.2);
}
.tpl-magazine-cut .tpl-content {
    position: absolute;
    right: 90px;
    top: 180px;
    max-width: 360px;
}
.tpl-magazine-cut .tpl-tag {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--gps-primary);
    font-weight: 700;
    margin-bottom: 12px;
}
.tpl-magazine-cut .tpl-headline {
    font-size: 50px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 16px;
}
.tpl-magazine-cut .tpl-subtext {
    font-size: 18px;
    color: #4b5563;
    line-height: 1.6;
}
.tpl-magazine-cut .tpl-cta {
    margin-top: 24px;
    display: inline-block;
    background: var(--gps-primary);
    color: #fff;
    padding: 12px 26px;
    border-radius: 10px;
    font-weight: 700;
}

/* === T38: Trust Badges === */
.tpl-trust-badges {
    background: #0f172a;
}
.tpl-trust-badges .tpl-content {
    position: absolute;
    top: 90px;
    left: 90px;
    right: 90px;
    text-align: center;
}
.tpl-trust-badges .tpl-headline {
    font-size: 52px;
    font-weight: 800;
    margin-bottom: 14px;
}
.tpl-trust-badges .tpl-subtext {
    font-size: 20px;
    opacity: 0.75;
    max-width: 700px;
    margin: 0 auto;
}
.tpl-trust-badges .tpl-badge-grid {
    position: absolute;
    left: 90px;
    right: 90px;
    bottom: 90px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}
.tpl-trust-badges .tpl-badge-card {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 18px;
    padding: 26px;
    min-height: 180px;
    text-align: left;
}
.tpl-trust-badges .tpl-badge-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 10px;
}
.tpl-trust-badges .tpl-badge-text {
    font-size: 14px;
    opacity: 0.7;
    line-height: 1.5;
}

/* === T39: Event Ticket === */
.tpl-event-ticket {
    background: #121826;
}
.tpl-event-ticket::before,
.tpl-event-ticket::after {
    content: '';
    position: absolute;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #0c111b;
}
.tpl-event-ticket::before {
    left: -40px;
    top: 50%;
    transform: translateY(-50%);
}
.tpl-event-ticket::after {
    right: -40px;
    top: 50%;
    transform: translateY(-50%);
}
.tpl-event-ticket .tpl-content {
    position: absolute;
    left: 90px;
    right: 90px;
    top: 140px;
}
.tpl-event-ticket .tpl-tag {
    background: rgba(120,181,71,0.85);
    padding: 8px 18px;
    border-radius: 999px;
    display: inline-block;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 700;
}
.tpl-event-ticket .tpl-headline {
    font-size: 56px;
    font-weight: 800;
    margin: 20px 0 12px;
}
.tpl-event-ticket .tpl-subtext {
    font-size: 20px;
    opacity: 0.75;
    max-width: 640px;
}
.tpl-event-ticket .tpl-photo-1 {
    width: 260px;
    height: 260px;
    right: 90px;
    bottom: 110px;
    border-radius: 20px;
}
.tpl-event-ticket .tpl-cta {
    position: absolute;
    left: 90px;
    bottom: 100px;
    background: #fff;
    color: #121826;
    padding: 12px 28px;
    border-radius: 10px;
    font-weight: 700;
}

/* === T40: Story Panel === */
.tpl-story-panel {
    background: #f8fafc;
    color: #111827;
}
.tpl-story-panel .tpl-photo-1 {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 520px;
    border-radius: 0;
    box-shadow: none;
}
.tpl-story-panel .tpl-content {
    position: absolute;
    left: 90px;
    right: 90px;
    bottom: 90px;
}
.tpl-story-panel .tpl-tag {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--gps-primary);
    font-weight: 700;
    margin-bottom: 12px;
}
.tpl-story-panel .tpl-headline {
    font-size: 52px;
    font-weight: 800;
    margin-bottom: 12px;
}
.tpl-story-panel .tpl-subtext {
    font-size: 20px;
    color: #4b5563;
    max-width: 640px;
}
.tpl-story-panel .tpl-cta {
    margin-top: 18px;
    display: inline-block;
    background: var(--gps-primary);
    color: #fff;
    padding: 12px 26px;
    border-radius: 999px;
    font-weight: 700;
}

/* ===== RESPONSIVE ADJUSTMENTS ===== */
@media (max-width: 768px) {
    .mt-grid {
        grid-template-columns: 1fr;
    }
    .mt-editor-panel {
        width: 100%;
        right: -100%;
    }
}
</style>
@endpush

@section('content')

<!-- Page Header -->
<div class="mt-page-header">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1>Marketing Template Generator</h1>
            <p>Create stunning marketing graphics with your brand. Select a template, customize text, and download.</p>
        </div>
    </div>
</div>

<!-- Category Filters -->
<div class="mt-filters">
    <button class="mt-filter-btn active" data-filter="all">All Templates</button>
    <button class="mt-filter-btn" data-filter="social">Social Media</button>
    <button class="mt-filter-btn" data-filter="product">Product</button>
    <button class="mt-filter-btn" data-filter="promo">Promotional</button>
    <button class="mt-filter-btn" data-filter="corporate">Corporate</button>
    <button class="mt-filter-btn" data-filter="quote">Quote</button>
</div>

<!-- Template Grid -->
<div class="mt-grid" id="templateGrid">

    {{-- T1: Bold Diagonal --}}
    <div class="mt-card" data-template="1" data-category="social">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-bold-diagonal" id="tpl-thumb-1">
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-photo tpl-photo-frame tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-1.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-cta">Learn More</div>
                    <div class="tpl-footer-text">www.goodprocurement.com</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Bold Diagonal</h4>
            <span class="badge bg-info">Social Media</span>
        </div>
    </div>

    {{-- T2: Clean Split --}}
    <div class="mt-card" data-template="2" data-category="product">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-clean-split" id="tpl-thumb-2">
                    <div class="tpl-left">
                        <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                        <div style="margin-top: 100px;">
                            <div class="tpl-headline">Your Headline Here</div>
                            <div class="tpl-subtext">Supporting text goes here</div>
                            <div class="tpl-cta">Get Started</div>
                        </div>
                    </div>
                    <div class="tpl-right">
                        <div class="tpl-right-headline">01</div>
                        <div class="tpl-right-text">Feature Highlight</div>
                        <div class="tpl-photo tpl-photo-1">
                            <img class="tpl-photo-img-alt" src="{{ asset('site/assets/images/gallery-2.jpg') }}" alt="Template image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Clean Split</h4>
            <span class="badge bg-success">Product</span>
        </div>
    </div>

    {{-- T3: Gradient Burst --}}
    <div class="mt-card" data-template="3" data-category="promo">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-gradient-burst" id="tpl-thumb-3">
                    <div class="tpl-circle-deco tpl-circle-1"></div>
                    <div class="tpl-circle-deco tpl-circle-2"></div>
                    <div class="tpl-circle-deco tpl-circle-3"></div>
                    <div class="tpl-tag">Special Offer</div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-photo tpl-photo-1 tpl-photo-circle">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-3.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Gradient Burst</h4>
            <span class="badge bg-warning text-dark">Promotional</span>
        </div>
    </div>

    {{-- T4: Minimal Card --}}
    <div class="mt-card" data-template="4" data-category="corporate">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-minimal-card" id="tpl-thumb-4">
                    <div class="tpl-card-inner">
                        <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                        <div class="tpl-photo tpl-photo-1">
                            <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-4.jpg') }}" alt="Template image">
                        </div>
                        <div class="tpl-accent-line"></div>
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                        <div class="tpl-cta">Contact Us</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Minimal Card</h4>
            <span class="badge bg-secondary">Corporate</span>
        </div>
    </div>

    {{-- T5: Stats Showcase --}}
    <div class="mt-card" data-template="5" data-category="corporate">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-stats-showcase" id="tpl-thumb-5">
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-5.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-headline">Your Headline Here</div>
                    <div class="tpl-stats-grid">
                        <div class="tpl-stat-item">
                            <div class="tpl-stat-number">500+</div>
                            <div class="tpl-stat-label">Projects</div>
                        </div>
                        <div class="tpl-stat-item">
                            <div class="tpl-stat-number">98%</div>
                            <div class="tpl-stat-label">Satisfaction</div>
                        </div>
                        <div class="tpl-stat-item">
                            <div class="tpl-stat-number">15+</div>
                            <div class="tpl-stat-label">Years</div>
                        </div>
                        <div class="tpl-stat-item">
                            <div class="tpl-stat-number">24/7</div>
                            <div class="tpl-stat-label">Support</div>
                        </div>
                    </div>
                    <div class="tpl-footer-bar"></div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Stats Showcase</h4>
            <span class="badge bg-secondary">Corporate</span>
        </div>
    </div>

    {{-- T6: Product Spotlight --}}
    <div class="mt-card" data-template="6" data-category="product">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-product-spotlight" id="tpl-thumb-6">
                    <div class="tpl-accent-circle"></div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-badge">New Product</div>
                    <div class="tpl-content">
                        <div class="tpl-product-name">Product Category</div>
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-6.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-features">
                        <div class="tpl-feature-item"><span class="tpl-feature-dot"></span> Feature One</div>
                        <div class="tpl-feature-item"><span class="tpl-feature-dot"></span> Feature Two</div>
                        <div class="tpl-feature-item"><span class="tpl-feature-dot"></span> Feature Three</div>
                    </div>
                    <div class="tpl-bottom-bar">GET A QUOTE TODAY</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Product Spotlight</h4>
            <span class="badge bg-success">Product</span>
        </div>
    </div>

    {{-- T7: Geometric Pattern --}}
    <div class="mt-card" data-template="7" data-category="social">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-geometric" id="tpl-thumb-7">
                    <div class="tpl-geo-shape tpl-geo-1"></div>
                    <div class="tpl-geo-shape tpl-geo-2"></div>
                    <div class="tpl-geo-shape tpl-geo-3"></div>
                    <div class="tpl-geo-shape tpl-geo-4"></div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-divider"></div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-7.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-website">www.goodprocurement.com</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Geometric Pattern</h4>
            <span class="badge bg-info">Social Media</span>
        </div>
    </div>

    {{-- T8: Full Accent --}}
    <div class="mt-card" data-template="8" data-category="promo">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-full-accent" id="tpl-thumb-8">
                    <div class="tpl-stripe tpl-stripe-1"></div>
                    <div class="tpl-stripe tpl-stripe-2"></div>
                    <div class="tpl-stripe tpl-stripe-3"></div>
                    <div class="tpl-top-badge">Limited Time</div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-8.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Full Accent</h4>
            <span class="badge bg-warning text-dark">Promotional</span>
        </div>
    </div>

    {{-- T9: Duo Tone --}}
    <div class="mt-card" data-template="9" data-category="social">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-duo-tone" id="tpl-thumb-9">
                    <div class="tpl-bottom-half"></div>
                    <div class="tpl-accent-stripe"></div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-cta">Learn More</div>
                    <div class="tpl-website">www.goodprocurement.com</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Duo Tone</h4>
            <span class="badge bg-info">Social Media</span>
        </div>
    </div>

    {{-- T10: Corner Accent --}}
    <div class="mt-card" data-template="10" data-category="corporate">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-corner-accent" id="tpl-thumb-10">
                    <div class="tpl-corner-tl"></div>
                    <div class="tpl-corner-br"></div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                        <div class="tpl-cta">Get in Touch</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Corner Accent</h4>
            <span class="badge bg-secondary">Corporate</span>
        </div>
    </div>

    {{-- T11: Wave Banner --}}
    <div class="mt-card" data-template="11" data-category="promo">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-wave-banner" id="tpl-thumb-11">
                    <div class="tpl-wave"></div>
                    <div class="tpl-wave-inner"></div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-bottom-text">www.goodprocurement.com</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Wave Banner</h4>
            <span class="badge bg-warning text-dark">Promotional</span>
        </div>
    </div>

    {{-- T12: Bold Quote --}}
    <div class="mt-card" data-template="12" data-category="quote">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-bold-quote" id="tpl-thumb-12">
                    <div class="tpl-quote-mark">&ldquo;</div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your inspiring quote or testimonial text goes here</div>
                        <div class="tpl-author">Author Name</div>
                        <div class="tpl-author-role">Position / Company</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Bold Quote</h4>
            <span class="badge bg-dark">Quote</span>
        </div>
    </div>

    {{-- T13: Grid Overlay --}}
    <div class="mt-card" data-template="13" data-category="social">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-grid-overlay" id="tpl-thumb-13">
                    <div class="tpl-grid-bg"></div>
                    <div class="tpl-accent-block"></div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-tag">Announcement</div>
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Grid Overlay</h4>
            <span class="badge bg-info">Social Media</span>
        </div>
    </div>

    {{-- T14: Stacked Bars --}}
    <div class="mt-card" data-template="14" data-category="corporate">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-stacked-bars" id="tpl-thumb-14">
                    <div class="tpl-bar tpl-bar-1"></div>
                    <div class="tpl-bar tpl-bar-2"></div>
                    <div class="tpl-bar tpl-bar-3"></div>
                    <div class="tpl-bar tpl-bar-4"></div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                        <div class="tpl-cta">Learn More</div>
                    </div>
                    <div class="tpl-footer-text">www.goodprocurement.com</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Stacked Bars</h4>
            <span class="badge bg-secondary">Corporate</span>
        </div>
    </div>

    {{-- T15: Radial Glow --}}
    <div class="mt-card" data-template="15" data-category="social">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-radial-glow" id="tpl-thumb-15">
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-bottom-cta">Get Started Today</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Radial Glow</h4>
            <span class="badge bg-info">Social Media</span>
        </div>
    </div>

    {{-- T16: Horizontal Thirds --}}
    <div class="mt-card" data-template="16" data-category="promo">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-h-thirds" id="tpl-thumb-16">
                    <div class="tpl-third-1">
                        <div class="tpl-logo" style="position:relative;"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    </div>
                    <div class="tpl-third-2">
                        <div class="tpl-headline">Your Headline Here</div>
                    </div>
                    <div class="tpl-third-3">
                        <div class="tpl-bottom-content">
                            <div class="tpl-subtext">Supporting text goes here</div>
                            <div class="tpl-cta">Shop Now</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Horizontal Thirds</h4>
            <span class="badge bg-warning text-dark">Promotional</span>
        </div>
    </div>

    {{-- T17: Dotted Frame --}}
    <div class="mt-card" data-template="17" data-category="corporate">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-dotted-frame" id="tpl-thumb-17">
                    <div class="tpl-frame"></div>
                    <div class="tpl-inner-frame"></div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-divider"></div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-website">www.goodprocurement.com</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Dotted Frame</h4>
            <span class="badge bg-secondary">Corporate</span>
        </div>
    </div>

    {{-- T18: Angled Blocks --}}
    <div class="mt-card" data-template="18" data-category="product">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-angled-blocks" id="tpl-thumb-18">
                    <div class="tpl-angle-1"></div>
                    <div class="tpl-angle-accent"></div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-bottom-content">
                        <div class="tpl-cta">Request Quote</div>
                        <div class="tpl-contact-info">info@goodprocurement.com<br>+1 234 567 890</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Angled Blocks</h4>
            <span class="badge bg-success">Product</span>
        </div>
    </div>

    {{-- T19: Hexagonal --}}
    <div class="mt-card" data-template="19" data-category="product">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-hexagonal" id="tpl-thumb-19">
                    <div class="tpl-hex tpl-hex-1"></div>
                    <div class="tpl-hex tpl-hex-2"></div>
                    <div class="tpl-hex tpl-hex-3"></div>
                    <div class="tpl-hex tpl-hex-4"></div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-cta">Explore Products</div>
                    <div class="tpl-website">www.goodprocurement.com</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Hexagonal</h4>
            <span class="badge bg-success">Product</span>
        </div>
    </div>

    {{-- T20: Executive Premium --}}
    <div class="mt-card" data-template="20" data-category="corporate">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-executive" id="tpl-thumb-20">
                    <div class="tpl-gold-line-v"></div>
                    <div class="tpl-gold-line-h"></div>
                    <div class="tpl-corner-deco tpl-cd-tl"></div>
                    <div class="tpl-corner-deco tpl-cd-br"></div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-overline">Good Procurement</div>
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-divider"></div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-footer-bar"><span>Excellence in Procurement</span></div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Executive Premium</h4>
            <span class="badge bg-secondary">Corporate</span>
        </div>
    </div>

    {{-- T21: Photo Panel --}}
    <div class="mt-card" data-template="21" data-category="product">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-photo-panel" id="tpl-thumb-21">
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-2.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-accent"></div>
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                        <div class="tpl-cta">Get a Quote</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Photo Panel</h4>
            <span class="badge bg-success">Product</span>
        </div>
    </div>

    {{-- T22: Photo Overlay --}}
    <div class="mt-card" data-template="22" data-category="promo">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-photo-overlay" id="tpl-thumb-22">
                    <div class="tpl-photo-bg" style="background-image:url('{{ asset('site/assets/images/gallery-9.jpg') }}');"></div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-tag">Limited Offer</div>
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-cta">Contact Us</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Photo Overlay</h4>
            <span class="badge bg-warning text-dark">Promotional</span>
        </div>
    </div>

    {{-- T23: Editorial Cover --}}
    <div class="mt-card" data-template="23" data-category="social">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-editorial" id="tpl-thumb-23">
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-1.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-cta">Read More</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Editorial Cover</h4>
            <span class="badge bg-info">Social Media</span>
        </div>
    </div>

    {{-- T24: Product Grid --}}
    <div class="mt-card" data-template="24" data-category="product">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-product-grid" id="tpl-thumb-24">
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-grid">
                        <div class="tpl-photo"><img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-2.jpg') }}" alt="Template image"></div>
                        <div class="tpl-photo"><img class="tpl-photo-img-alt" src="{{ asset('site/assets/images/gallery-3.jpg') }}" alt="Template image"></div>
                        <div class="tpl-photo"><img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-4.jpg') }}" alt="Template image"></div>
                    </div>
                    <div class="tpl-cta">Explore</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Product Grid</h4>
            <span class="badge bg-success">Product</span>
        </div>
    </div>

    {{-- T25: Testimonial Stack --}}
    <div class="mt-card" data-template="25" data-category="quote">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-testimonial" id="tpl-thumb-25">
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img-alt" src="{{ asset('site/assets/images/gallery-5.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-card">
                        <div class="tpl-headline">“Your inspiring quote or testimonial text goes here.”</div>
                        <div class="tpl-author">Author Name</div>
                        <div class="tpl-author-role">Position / Company</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Testimonial Stack</h4>
            <span class="badge bg-dark">Quote</span>
        </div>
    </div>

    {{-- T26: Event Poster --}}
    <div class="mt-card" data-template="26" data-category="promo">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-event" id="tpl-thumb-26">
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-6.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-content">
                        <div class="tpl-tag">Live Event</div>
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                        <div class="tpl-cta">Register Now</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Event Poster</h4>
            <span class="badge bg-warning text-dark">Promotional</span>
        </div>
    </div>

    {{-- T27: Countdown Promo --}}
    <div class="mt-card" data-template="27" data-category="promo">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-countdown" id="tpl-thumb-27">
                    <div class="tpl-photo-bg" style="background-image:url('{{ asset('site/assets/images/gallery-7.jpg') }}');"></div>
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                        <div class="tpl-count">
                            <div class="tpl-count-item"><div class="tpl-count-num">05</div><div class="tpl-count-label">Days</div></div>
                            <div class="tpl-count-item"><div class="tpl-count-num">12</div><div class="tpl-count-label">Hrs</div></div>
                            <div class="tpl-count-item"><div class="tpl-count-num">48</div><div class="tpl-count-label">Min</div></div>
                        </div>
                    </div>
                    <div class="tpl-cta">Claim Offer</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Countdown Promo</h4>
            <span class="badge bg-warning text-dark">Promotional</span>
        </div>
    </div>

    {{-- T28: Case Study --}}
    <div class="mt-card" data-template="28" data-category="corporate">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-case-study" id="tpl-thumb-28">
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img-alt" src="{{ asset('site/assets/images/gallery-8.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-content">
                        <div class="tpl-tag">Case Study</div>
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                        <div class="tpl-cta">Read Results</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Case Study</h4>
            <span class="badge bg-secondary">Corporate</span>
        </div>
    </div>

    {{-- T29: Services Overview --}}
    <div class="mt-card" data-template="29" data-category="corporate">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-services" id="tpl-thumb-29">
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-grid">
                        <div class="tpl-card"><div class="tpl-card-title">Service One</div><div class="tpl-card-text">Short description</div></div>
                        <div class="tpl-card"><div class="tpl-card-title">Service Two</div><div class="tpl-card-text">Short description</div></div>
                        <div class="tpl-card"><div class="tpl-card-title">Service Three</div><div class="tpl-card-text">Short description</div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Services Overview</h4>
            <span class="badge bg-secondary">Corporate</span>
        </div>
    </div>

    {{-- T30: Monochrome Minimal --}}
    <div class="mt-card" data-template="30" data-category="social">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-mono" id="tpl-thumb-30">
                    <div class="tpl-logo"><img src="{{ asset('site/assets/images/gps logo.png') }}" alt="GPS"></div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                        <div class="tpl-cta">Learn More</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Monochrome Minimal</h4>
            <span class="badge bg-info">Social Media</span>
        </div>
    </div>

    {{-- T31: Aurora Focus --}}
    <div class="mt-card" data-template="31" data-category="social">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-aurora" id="tpl-thumb-31">
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-5.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-tag">New Release</div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                        <div class="tpl-cta">Learn More</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Aurora Focus</h4>
            <span class="badge bg-info">Social Media</span>
        </div>
    </div>

    {{-- T32: Split Gallery --}}
    <div class="mt-card" data-template="32" data-category="corporate">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-split-gallery" id="tpl-thumb-32">
                    <div class="tpl-left">
                        <div class="tpl-tag">Portfolio</div>
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                        <div class="tpl-cta">View Work</div>
                    </div>
                    <div class="tpl-right">
                        <div class="tpl-photo tpl-photo-1">
                            <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-3.jpg') }}" alt="Template image">
                        </div>
                        <div class="tpl-photo tpl-photo-2">
                            <img class="tpl-photo-img-alt" src="{{ asset('site/assets/images/gallery-4.jpg') }}" alt="Template image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Split Gallery</h4>
            <span class="badge bg-secondary">Corporate</span>
        </div>
    </div>

    {{-- T33: Minimal Poster --}}
    <div class="mt-card" data-template="33" data-category="promotional">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-minimal-poster" id="tpl-thumb-33">
                    <div class="tpl-photo-bg" style="background-image:url('{{ asset('site/assets/images/gallery-6.jpg') }}');"></div>
                    <div class="tpl-tag">Limited</div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-cta">Get Offer</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Minimal Poster</h4>
            <span class="badge bg-warning text-dark">Promotional</span>
        </div>
    </div>

    {{-- T34: Diagonal Frame --}}
    <div class="mt-card" data-template="34" data-category="corporate">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-diagonal-frame" id="tpl-thumb-34">
                    <div class="tpl-frame"></div>
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-2.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                        <div class="tpl-cta">View Details</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Diagonal Frame</h4>
            <span class="badge bg-secondary">Corporate</span>
        </div>
    </div>

    {{-- T35: Stacked Cards --}}
    <div class="mt-card" data-template="35" data-category="social">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-stacked-cards" id="tpl-thumb-35">
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-card-stack">
                        <div class="tpl-mini-card">
                            <div class="tpl-mini-title">Insight One</div>
                            <div class="tpl-mini-text">Short highlight for the audience.</div>
                        </div>
                        <div class="tpl-mini-card">
                            <div class="tpl-mini-title">Insight Two</div>
                            <div class="tpl-mini-text">Short highlight for the audience.</div>
                        </div>
                        <div class="tpl-mini-card">
                            <div class="tpl-mini-title">Insight Three</div>
                            <div class="tpl-mini-text">Short highlight for the audience.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Stacked Cards</h4>
            <span class="badge bg-info">Social Media</span>
        </div>
    </div>

    {{-- T36: Outline Glow --}}
    <div class="mt-card" data-template="36" data-category="promotional">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-outline-glow" id="tpl-thumb-36">
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-7.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-cta">Get Started</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Outline Glow</h4>
            <span class="badge bg-warning text-dark">Promotional</span>
        </div>
    </div>

    {{-- T37: Magazine Cutout --}}
    <div class="mt-card" data-template="37" data-category="corporate">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-magazine-cut" id="tpl-thumb-37">
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-9.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-content">
                        <div class="tpl-tag">Spotlight</div>
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                        <div class="tpl-cta">Discover More</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Magazine Cutout</h4>
            <span class="badge bg-secondary">Corporate</span>
        </div>
    </div>

    {{-- T38: Trust Badges --}}
    <div class="mt-card" data-template="38" data-category="corporate">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-trust-badges" id="tpl-thumb-38">
                    <div class="tpl-content">
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-badge-grid">
                        <div class="tpl-badge-card">
                            <div class="tpl-badge-title">Certified Quality</div>
                            <div class="tpl-badge-text">Verified processes with measurable results.</div>
                        </div>
                        <div class="tpl-badge-card">
                            <div class="tpl-badge-title">Global Network</div>
                            <div class="tpl-badge-text">Reliable partners across key industries.</div>
                        </div>
                        <div class="tpl-badge-card">
                            <div class="tpl-badge-title">On-Time Delivery</div>
                            <div class="tpl-badge-text">Trackable timelines you can trust.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Trust Badges</h4>
            <span class="badge bg-secondary">Corporate</span>
        </div>
    </div>

    {{-- T39: Event Ticket --}}
    <div class="mt-card" data-template="39" data-category="promotional">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-event-ticket" id="tpl-thumb-39">
                    <div class="tpl-content">
                        <div class="tpl-tag">Live Session</div>
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                    </div>
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-10.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-cta">Reserve Seat</div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Event Ticket</h4>
            <span class="badge bg-warning text-dark">Promotional</span>
        </div>
    </div>

    {{-- T40: Story Panel --}}
    <div class="mt-card" data-template="40" data-category="social">
        <div class="mt-card-preview">
            <div class="mt-card-preview-container">
                <div class="template-wrap tpl-story-panel" id="tpl-thumb-40">
                    <div class="tpl-photo tpl-photo-1">
                        <img class="tpl-photo-img" src="{{ asset('site/assets/images/gallery-11.jpg') }}" alt="Template image">
                    </div>
                    <div class="tpl-content">
                        <div class="tpl-tag">Story</div>
                        <div class="tpl-headline">Your Headline Here</div>
                        <div class="tpl-subtext">Supporting text goes here with your message</div>
                        <div class="tpl-cta">Read Story</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-card-info">
            <h4>Story Panel</h4>
            <span class="badge bg-info">Social Media</span>
        </div>
    </div>

</div>

<!-- Editor Backdrop -->
<div class="mt-backdrop" id="editorBackdrop"></div>

<!-- Editor Slide Panel -->
<div class="mt-editor-panel" id="editorPanel">
    <div class="mt-editor-header">
        <h3>Customize Template</h3>
        <button class="btn-close-editor" id="closeEditor"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="mt-editor-body">
        <div class="mb-3" data-field-requires=".tpl-headline">
            <label class="form-label">Headline</label>
            <textarea class="form-control" id="edHeadline" rows="2" placeholder="Enter your main headline...">Your Headline Here</textarea>
        </div>
        <div class="mb-3" data-field-requires=".tpl-subtext">
            <label class="form-label">Supporting Text</label>
            <textarea class="form-control" id="edSubtext" rows="3" placeholder="Enter your supporting text...">Supporting text goes here with your message</textarea>
        </div>
        <div class="mb-3" data-field-requires=".tpl-cta">
            <label class="form-label">CTA / Button Text</label>
            <input type="text" class="form-control" id="edCta" value="Learn More" placeholder="e.g. Get a Quote, Shop Now...">
        </div>
        <div class="mb-3" data-field-requires=".tpl-tag, .tpl-badge, .tpl-top-badge">
            <label class="form-label">Tag / Badge Text</label>
            <input type="text" class="form-control" id="edTag" value="Special Offer" placeholder="e.g. New, Limited Time, Sale...">
        </div>

        <div class="mt-editor-section" data-requires=".tpl-photo, .tpl-photo-img, .tpl-photo-img-alt, .tpl-photo-bg">
            <hr class="my-3">
            <h6 class="text-muted mb-3" style="font-size:13px; text-transform:uppercase; letter-spacing:1px;">Images</h6>
            <div class="mb-3">
                <label class="form-label">Primary Image URL</label>
                <input type="text" class="form-control" id="edImageMain" value="{{ asset('site/assets/images/gallery-1.jpg') }}" placeholder="Paste image URL">
                <input type="file" class="form-control mt-2" id="edImageMainFile" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">Secondary Image URL (optional)</label>
                <input type="text" class="form-control" id="edImageAlt" value="{{ asset('site/assets/images/gallery-2.jpg') }}" placeholder="Paste image URL">
                <input type="file" class="form-control mt-2" id="edImageAltFile" accept="image/*">
            </div>
        </div>

        <div class="mt-editor-section" data-requires=".tpl-stat-item">
            <hr class="my-3">
            <h6 class="text-muted mb-3" style="font-size:13px; text-transform:uppercase; letter-spacing:1px;">Stats (Template 5)</h6>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Stat 1 Number</label>
                    <input type="text" class="form-control" id="edStat1Num" value="500+" placeholder="e.g. 500+">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Stat 1 Label</label>
                    <input type="text" class="form-control" id="edStat1Label" value="Projects" placeholder="e.g. Projects">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Stat 2 Number</label>
                    <input type="text" class="form-control" id="edStat2Num" value="98%" placeholder="e.g. 98%">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Stat 2 Label</label>
                    <input type="text" class="form-control" id="edStat2Label" value="Satisfaction" placeholder="e.g. Satisfaction">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Stat 3 Number</label>
                    <input type="text" class="form-control" id="edStat3Num" value="15+" placeholder="e.g. 15+">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Stat 3 Label</label>
                    <input type="text" class="form-control" id="edStat3Label" value="Years" placeholder="e.g. Years">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Stat 4 Number</label>
                    <input type="text" class="form-control" id="edStat4Num" value="24/7" placeholder="e.g. 24/7">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Stat 4 Label</label>
                    <input type="text" class="form-control" id="edStat4Label" value="Support" placeholder="e.g. Support">
                </div>
            </div>
        </div>

        <div class="mt-editor-section" data-requires=".tpl-product-name, .tpl-feature-item">
            <hr class="my-3">
            <h6 class="text-muted mb-3" style="font-size:13px; text-transform:uppercase; letter-spacing:1px;">Product (Template 6)</h6>
            <div class="mb-3">
                <label class="form-label">Product Category</label>
                <input type="text" class="form-control" id="edProductCat" value="Product Category" placeholder="e.g. Oil & Gas Equipment">
            </div>
            <div class="row">
                <div class="col-4 mb-3">
                    <label class="form-label">Feature 1</label>
                    <input type="text" class="form-control" id="edFeature1" value="Feature One" placeholder="Feature">
                </div>
                <div class="col-4 mb-3">
                    <label class="form-label">Feature 2</label>
                    <input type="text" class="form-control" id="edFeature2" value="Feature Two" placeholder="Feature">
                </div>
                <div class="col-4 mb-3">
                    <label class="form-label">Feature 3</label>
                    <input type="text" class="form-control" id="edFeature3" value="Feature Three" placeholder="Feature">
                </div>
            </div>
        </div>

        <div class="mt-editor-section" data-requires=".tpl-author, .tpl-author-role">
            <hr class="my-3">
            <h6 class="text-muted mb-3" style="font-size:13px; text-transform:uppercase; letter-spacing:1px;">Quote (Template 12)</h6>
            <div class="mb-3">
                <label class="form-label">Author Name</label>
                <input type="text" class="form-control" id="edAuthor" value="Author Name" placeholder="e.g. John Smith">
            </div>
            <div class="mb-3">
                <label class="form-label">Author Role</label>
                <input type="text" class="form-control" id="edAuthorRole" value="Position / Company" placeholder="e.g. CEO, Good Procurement">
            </div>
        </div>

        <div class="mt-editor-section" data-requires=".tpl-right-headline, .tpl-right-text">
            <hr class="my-3">
            <h6 class="text-muted mb-3" style="font-size:13px; text-transform:uppercase; letter-spacing:1px;">Split Card (Template 2)</h6>
            <div class="mb-3">
                <label class="form-label">Right Side Large Text</label>
                <input type="text" class="form-control" id="edRightBig" value="01" placeholder="e.g. 01, #1, NEW">
            </div>
            <div class="mb-3">
                <label class="form-label">Right Side Label</label>
                <input type="text" class="form-control" id="edRightLabel" value="Feature Highlight" placeholder="e.g. Feature Highlight">
            </div>
        </div>

        <div class="mt-editor-section" data-requires=".tpl-website, .tpl-footer-text, .tpl-bottom-text, .tpl-contact-info, .tpl-footer-bar, .tpl-overline">
            <hr class="my-3">
            <h6 class="text-muted mb-3" style="font-size:13px; text-transform:uppercase; letter-spacing:1px;">Footer & Contact</h6>
            <div class="mb-3">
                <label class="form-label">Website URL</label>
                <input type="text" class="form-control" id="edWebsite" value="www.goodprocurement.com" placeholder="e.g. www.yoursite.com">
            </div>
            <div class="mb-3">
                <label class="form-label">Contact Info (for Angled Blocks)</label>
                <textarea class="form-control" id="edContact" rows="2" placeholder="e.g. info@goodprocurement.com\n+1 234 567 890">info@goodprocurement.com
+1 234 567 890</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Footer Bar Text</label>
                <input type="text" class="form-control" id="edFooterBar" value="Excellence in Procurement" placeholder="e.g. Your tagline here">
            </div>
            <div class="mb-3">
                <label class="form-label">Overline Text (Executive)</label>
                <input type="text" class="form-control" id="edOverline" value="Good Procurement" placeholder="e.g. Good Procurement">
            </div>
        </div>
    </div>
    <div class="mt-editor-footer">
        <button class="btn btn-outline-secondary" id="btnResetText"><i class="fa-solid fa-rotate-left me-1"></i> Reset</button>
        <button class="btn btn-primary" id="btnApplyText" style="background: var(--gps-accent) !important; border-color: var(--gps-accent) !important;"><i class="fa-solid fa-check me-1"></i> Apply Changes</button>
    </div>
</div>

<!-- Full Preview Overlay -->
<div class="mt-preview-overlay" id="previewOverlay">
    <button class="mt-preview-close" id="closePreview"><i class="fa-solid fa-xmark"></i></button>
    <div class="mt-preview-wrapper" id="previewWrapper">
        <!-- Full-size template rendered here -->
    </div>
    <div class="mt-preview-actions">
        <button class="btn btn-light" id="btnEdit"><i class="fa-solid fa-pen me-2"></i>Edit Text</button>
        <button class="btn text-white" id="btnDownload" style="background: var(--gps-accent);"><i class="fa-solid fa-download me-2"></i>Download PNG</button>
        <button class="btn text-white" id="btnDownloadJpg" style="background: var(--gps-primary);"><i class="fa-solid fa-image me-2"></i>Download JPG</button>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // ===== TEMPLATE DATA MAP =====
    const templateClasses = {
        1: 'tpl-bold-diagonal',
        2: 'tpl-clean-split',
        3: 'tpl-gradient-burst',
        4: 'tpl-minimal-card',
        5: 'tpl-stats-showcase',
        6: 'tpl-product-spotlight',
        7: 'tpl-geometric',
        8: 'tpl-full-accent',
        9: 'tpl-duo-tone',
        10: 'tpl-corner-accent',
        11: 'tpl-wave-banner',
        12: 'tpl-bold-quote',
        13: 'tpl-grid-overlay',
        14: 'tpl-stacked-bars',
        15: 'tpl-radial-glow',
        16: 'tpl-h-thirds',
        17: 'tpl-dotted-frame',
        18: 'tpl-angled-blocks',
        19: 'tpl-hexagonal',
        20: 'tpl-executive',
        21: 'tpl-photo-panel',
        22: 'tpl-photo-overlay',
        23: 'tpl-editorial',
        24: 'tpl-product-grid',
        25: 'tpl-testimonial',
        26: 'tpl-event',
        27: 'tpl-countdown',
        28: 'tpl-case-study',
        29: 'tpl-services',
        30: 'tpl-mono',
        31: 'tpl-aurora',
        32: 'tpl-split-gallery',
        33: 'tpl-minimal-poster',
        34: 'tpl-diagonal-frame',
        35: 'tpl-stacked-cards',
        36: 'tpl-outline-glow',
        37: 'tpl-magazine-cut',
        38: 'tpl-trust-badges',
        39: 'tpl-event-ticket',
        40: 'tpl-story-panel'
    };

    let activeTemplate = null;
    const logoSrc = "{{ asset('site/assets/images/gps logo.png') }}";
    const templateState = {};
    const templateBaseState = {};

    // ===== CATEGORY FILTERING =====
    document.querySelectorAll('.mt-filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.mt-filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            document.querySelectorAll('.mt-card').forEach(card => {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    function clone(obj) {
        return JSON.parse(JSON.stringify(obj));
    }

    function getDefaultInputs() {
        return {
            headline: document.getElementById('edHeadline').value,
            subtext: document.getElementById('edSubtext').value,
            cta: document.getElementById('edCta').value,
            tag: document.getElementById('edTag').value,
            imageMain: document.getElementById('edImageMain').value,
            imageAlt: document.getElementById('edImageAlt').value,
            stat1Num: document.getElementById('edStat1Num').value,
            stat1Label: document.getElementById('edStat1Label').value,
            stat2Num: document.getElementById('edStat2Num').value,
            stat2Label: document.getElementById('edStat2Label').value,
            stat3Num: document.getElementById('edStat3Num').value,
            stat3Label: document.getElementById('edStat3Label').value,
            stat4Num: document.getElementById('edStat4Num').value,
            stat4Label: document.getElementById('edStat4Label').value,
            productCat: document.getElementById('edProductCat').value,
            feature1: document.getElementById('edFeature1').value,
            feature2: document.getElementById('edFeature2').value,
            feature3: document.getElementById('edFeature3').value,
            author: document.getElementById('edAuthor').value,
            authorRole: document.getElementById('edAuthorRole').value,
            rightBig: document.getElementById('edRightBig').value,
            rightLabel: document.getElementById('edRightLabel').value,
            website: document.getElementById('edWebsite').value,
            contact: document.getElementById('edContact').value,
            footerBar: document.getElementById('edFooterBar').value,
            overline: document.getElementById('edOverline').value,
        };
    }

    function setEditorValues(v) {
        document.getElementById('edHeadline').value = v.headline;
        document.getElementById('edSubtext').value = v.subtext;
        document.getElementById('edCta').value = v.cta;
        document.getElementById('edTag').value = v.tag;
        document.getElementById('edImageMain').value = v.imageMain;
        document.getElementById('edImageAlt').value = v.imageAlt;
        document.getElementById('edStat1Num').value = v.stat1Num;
        document.getElementById('edStat1Label').value = v.stat1Label;
        document.getElementById('edStat2Num').value = v.stat2Num;
        document.getElementById('edStat2Label').value = v.stat2Label;
        document.getElementById('edStat3Num').value = v.stat3Num;
        document.getElementById('edStat3Label').value = v.stat3Label;
        document.getElementById('edStat4Num').value = v.stat4Num;
        document.getElementById('edStat4Label').value = v.stat4Label;
        document.getElementById('edProductCat').value = v.productCat;
        document.getElementById('edFeature1').value = v.feature1;
        document.getElementById('edFeature2').value = v.feature2;
        document.getElementById('edFeature3').value = v.feature3;
        document.getElementById('edAuthor').value = v.author;
        document.getElementById('edAuthorRole').value = v.authorRole;
        document.getElementById('edRightBig').value = v.rightBig;
        document.getElementById('edRightLabel').value = v.rightLabel;
        document.getElementById('edWebsite').value = v.website;
        document.getElementById('edContact').value = v.contact;
        document.getElementById('edFooterBar').value = v.footerBar;
        document.getElementById('edOverline').value = v.overline;
    }

    function parseBgUrl(value) {
        if (!value) return '';
        const match = value.match(/url\\([\"']?(.*?)[\"']?\\)/);
        return match ? match[1] : '';
    }

    function extractValuesFromTemplate(el) {
        const defaults = getDefaultInputs();
        const getText = (selector, fallback) => {
            const node = el.querySelector(selector);
            return node ? node.textContent.trim() : fallback;
        };
        const featureText = (node, fallback) => {
            if (!node) return fallback;
            const text = node.textContent.replace(/^•\\s*/, '').trim();
            return text || fallback;
        };
        const imageMain = el.querySelector('.tpl-photo-img')?.getAttribute('src')
            || parseBgUrl(el.querySelector('.tpl-photo-bg')?.style.backgroundImage)
            || defaults.imageMain;
        const imageAlt = el.querySelector('.tpl-photo-img-alt')?.getAttribute('src') || defaults.imageAlt;

        const values = {
            headline: getText('.tpl-headline', defaults.headline),
            subtext: getText('.tpl-subtext', defaults.subtext),
            cta: getText('.tpl-cta', defaults.cta),
            tag: getText('.tpl-tag, .tpl-badge, .tpl-top-badge', defaults.tag),
            imageMain,
            imageAlt,
            stat1Num: defaults.stat1Num,
            stat1Label: defaults.stat1Label,
            stat2Num: defaults.stat2Num,
            stat2Label: defaults.stat2Label,
            stat3Num: defaults.stat3Num,
            stat3Label: defaults.stat3Label,
            stat4Num: defaults.stat4Num,
            stat4Label: defaults.stat4Label,
            productCat: getText('.tpl-product-name', defaults.productCat),
            feature1: defaults.feature1,
            feature2: defaults.feature2,
            feature3: defaults.feature3,
            author: getText('.tpl-author', defaults.author),
            authorRole: getText('.tpl-author-role', defaults.authorRole),
            rightBig: getText('.tpl-right-headline', defaults.rightBig),
            rightLabel: getText('.tpl-right-text', defaults.rightLabel),
            website: getText('.tpl-website, .tpl-footer-text, .tpl-bottom-text', defaults.website),
            contact: el.querySelector('.tpl-contact-info') ? el.querySelector('.tpl-contact-info').innerText.trim() : defaults.contact,
            footerBar: getText('.tpl-footer-bar span', defaults.footerBar),
            overline: getText('.tpl-overline', defaults.overline),
        };

        const stats = el.querySelectorAll('.tpl-stat-item');
        if (stats.length) {
            if (stats[0]) { values.stat1Num = stats[0].querySelector('.tpl-stat-number')?.textContent.trim() || values.stat1Num; values.stat1Label = stats[0].querySelector('.tpl-stat-label')?.textContent.trim() || values.stat1Label; }
            if (stats[1]) { values.stat2Num = stats[1].querySelector('.tpl-stat-number')?.textContent.trim() || values.stat2Num; values.stat2Label = stats[1].querySelector('.tpl-stat-label')?.textContent.trim() || values.stat2Label; }
            if (stats[2]) { values.stat3Num = stats[2].querySelector('.tpl-stat-number')?.textContent.trim() || values.stat3Num; values.stat3Label = stats[2].querySelector('.tpl-stat-label')?.textContent.trim() || values.stat3Label; }
            if (stats[3]) { values.stat4Num = stats[3].querySelector('.tpl-stat-number')?.textContent.trim() || values.stat4Num; values.stat4Label = stats[3].querySelector('.tpl-stat-label')?.textContent.trim() || values.stat4Label; }
        }

        const features = el.querySelectorAll('.tpl-feature-item');
        if (features[0]) values.feature1 = featureText(features[0], values.feature1);
        if (features[1]) values.feature2 = featureText(features[1], values.feature2);
        if (features[2]) values.feature3 = featureText(features[2], values.feature3);

        return values;
    }

    function ensureTemplateState(tplId) {
        if (templateState[tplId]) return;
        const el = document.getElementById('tpl-thumb-' + tplId);
        if (!el) return;
        const vals = extractValuesFromTemplate(el);
        templateState[tplId] = vals;
        templateBaseState[tplId] = clone(vals);
    }

    // ===== CARD CLICK -> PREVIEW =====
    document.querySelectorAll('.mt-card').forEach(card => {
        card.addEventListener('click', function() {
            const tplId = parseInt(this.dataset.template);
            activeTemplate = tplId;
            ensureTemplateState(tplId);

            // Highlight active card
            document.querySelectorAll('.mt-card').forEach(c => c.classList.remove('active'));
            this.classList.add('active');

            // Build full-size template
            renderFullPreview(tplId);

            // Show overlay
            document.getElementById('previewOverlay').classList.add('show');
            document.body.style.overflow = 'hidden';
        });
    });

    // ===== CLOSE PREVIEW =====
    document.getElementById('closePreview').addEventListener('click', closePreview);
    document.getElementById('previewOverlay').addEventListener('click', function(e) {
        if (e.target === this) closePreview();
    });

    function closePreview() {
        document.getElementById('previewOverlay').classList.remove('show');
        document.body.style.overflow = '';
    }

    // ===== EDIT BUTTON -> OPEN EDITOR =====
    document.getElementById('btnEdit').addEventListener('click', function() {
        closePreview();
        openEditor();
    });

    // ===== EDITOR PANEL =====
    function openEditor() {
        if (!activeTemplate) {
            alert('Select a template first.');
            return;
        }
        ensureTemplateState(activeTemplate);
        setEditorValues(templateState[activeTemplate]);
        toggleEditorControls(activeTemplate);
        document.getElementById('editorPanel').classList.add('open');
        document.getElementById('editorBackdrop').classList.add('show');
    }
    function closeEditor() {
        document.getElementById('editorPanel').classList.remove('open');
        document.getElementById('editorBackdrop').classList.remove('show');
    }

    document.getElementById('closeEditor').addEventListener('click', closeEditor);
    document.getElementById('editorBackdrop').addEventListener('click', closeEditor);

    function toggleEditorControls(tplId) {
        const tpl = document.getElementById('tpl-thumb-' + tplId);
        if (!tpl) return;

        document.querySelectorAll('.mt-editor-section').forEach(section => {
            const req = section.dataset.requires;
            if (!req) return;
            section.style.display = tpl.querySelector(req) ? '' : 'none';
        });

        document.querySelectorAll('[data-field-requires]').forEach(field => {
            const req = field.dataset.fieldRequires;
            if (!req) return;
            field.style.display = tpl.querySelector(req) ? '' : 'none';
        });
    }

    // ===== IMAGE UPLOAD HELPERS =====
    function handleImageUpload(fileInputId, targetInputId) {
        const fileInput = document.getElementById(fileInputId);
        const targetInput = document.getElementById(targetInputId);
        if (!fileInput || !targetInput) return;

        fileInput.addEventListener('change', function() {
            const file = this.files && this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                targetInput.value = e.target.result;
                updateActiveFromInputs();
            };
            reader.readAsDataURL(file);
        });
    }

    handleImageUpload('edImageMainFile', 'edImageMain');
    handleImageUpload('edImageAltFile', 'edImageAlt');

    function updateActiveFromInputs() {
        if (!activeTemplate) return;
        templateState[activeTemplate] = {
            ...(templateState[activeTemplate] || {}),
            ...getEditorValues(),
        };
        applyTextToTemplate(activeTemplate);
    }

    // ===== APPLY CHANGES =====
    document.getElementById('btnApplyText').addEventListener('click', function() {
        updateActiveFromInputs();
        closeEditor();
        if (activeTemplate) {
            renderFullPreview(activeTemplate);
            document.getElementById('previewOverlay').classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    });

    // ===== RESET (ACTIVE TEMPLATE ONLY) =====
    document.getElementById('btnResetText').addEventListener('click', function() {
        if (!activeTemplate) return;
        ensureTemplateState(activeTemplate);
        const base = templateBaseState[activeTemplate];
        if (!base) return;
        templateState[activeTemplate] = clone(base);
        setEditorValues(clone(base));
        applyTextToTemplate(activeTemplate);
    });

    // ===== GET EDITOR VALUES =====
    function getEditorValues() {
        return {
            headline: document.getElementById('edHeadline').value,
            subtext: document.getElementById('edSubtext').value,
            cta: document.getElementById('edCta').value,
            tag: document.getElementById('edTag').value,
            imageMain: document.getElementById('edImageMain').value,
            imageAlt: document.getElementById('edImageAlt').value,
            stat1Num: document.getElementById('edStat1Num').value,
            stat1Label: document.getElementById('edStat1Label').value,
            stat2Num: document.getElementById('edStat2Num').value,
            stat2Label: document.getElementById('edStat2Label').value,
            stat3Num: document.getElementById('edStat3Num').value,
            stat3Label: document.getElementById('edStat3Label').value,
            stat4Num: document.getElementById('edStat4Num').value,
            stat4Label: document.getElementById('edStat4Label').value,
            productCat: document.getElementById('edProductCat').value,
            feature1: document.getElementById('edFeature1').value,
            feature2: document.getElementById('edFeature2').value,
            feature3: document.getElementById('edFeature3').value,
            author: document.getElementById('edAuthor').value,
            authorRole: document.getElementById('edAuthorRole').value,
            rightBig: document.getElementById('edRightBig').value,
            rightLabel: document.getElementById('edRightLabel').value,
            website: document.getElementById('edWebsite').value,
            contact: document.getElementById('edContact').value,
            footerBar: document.getElementById('edFooterBar').value,
            overline: document.getElementById('edOverline').value,
        };
    }

    // ===== APPLY TEXT TO SINGLE TEMPLATE =====
    function applyTextToTemplate(tplId) {
        const el = document.getElementById('tpl-thumb-' + tplId);
        if (!el) return;
        const v = templateState[tplId] || getEditorValues();

        // Headline
        el.querySelectorAll('.tpl-headline').forEach(h => h.textContent = v.headline);

        // Subtext
        el.querySelectorAll('.tpl-subtext').forEach(s => s.textContent = v.subtext);

        // CTA
        el.querySelectorAll('.tpl-cta').forEach(c => c.textContent = v.cta);

        // Tag/Badge
        el.querySelectorAll('.tpl-tag, .tpl-badge, .tpl-top-badge').forEach(t => t.textContent = v.tag);

        // Website
        el.querySelectorAll('.tpl-website, .tpl-footer-text, .tpl-bottom-text').forEach(w => w.textContent = v.website);

        // Images
        const imageMain = v.imageMain || '';
        const imageAlt = v.imageAlt || v.imageMain || '';
        if (imageMain) {
            el.querySelectorAll('.tpl-photo-img').forEach(img => img.src = imageMain);
            el.querySelectorAll('.tpl-photo-bg').forEach(bg => bg.style.backgroundImage = `url('${imageMain}')`);
        }
        if (imageAlt) {
            el.querySelectorAll('.tpl-photo-img-alt').forEach(img => img.src = imageAlt);
        }

        // Template-specific updates
        if (tplId === 2) {
            const rb = el.querySelector('.tpl-right-headline');
            if (rb) rb.textContent = v.rightBig;
            const rl = el.querySelector('.tpl-right-text');
            if (rl) rl.textContent = v.rightLabel;
        }

        if (tplId === 5) {
            const stats = el.querySelectorAll('.tpl-stat-item');
            if (stats[0]) { stats[0].querySelector('.tpl-stat-number').textContent = v.stat1Num; stats[0].querySelector('.tpl-stat-label').textContent = v.stat1Label; }
            if (stats[1]) { stats[1].querySelector('.tpl-stat-number').textContent = v.stat2Num; stats[1].querySelector('.tpl-stat-label').textContent = v.stat2Label; }
            if (stats[2]) { stats[2].querySelector('.tpl-stat-number').textContent = v.stat3Num; stats[2].querySelector('.tpl-stat-label').textContent = v.stat3Label; }
            if (stats[3]) { stats[3].querySelector('.tpl-stat-number').textContent = v.stat4Num; stats[3].querySelector('.tpl-stat-label').textContent = v.stat4Label; }
        }

        if (tplId === 6) {
            const pn = el.querySelector('.tpl-product-name');
            if (pn) pn.textContent = v.productCat;
            const features = el.querySelectorAll('.tpl-feature-item');
            if (features[0]) features[0].innerHTML = '<span class="tpl-feature-dot"></span> ' + v.feature1;
            if (features[1]) features[1].innerHTML = '<span class="tpl-feature-dot"></span> ' + v.feature2;
            if (features[2]) features[2].innerHTML = '<span class="tpl-feature-dot"></span> ' + v.feature3;
            const bb = el.querySelector('.tpl-bottom-bar');
            if (bb) bb.textContent = v.cta.toUpperCase();
        }

        if (tplId === 12) {
            const au = el.querySelector('.tpl-author');
            if (au) au.textContent = v.author;
            const ar = el.querySelector('.tpl-author-role');
            if (ar) ar.textContent = v.authorRole;
        }

        if (tplId === 18) {
            const ci = el.querySelector('.tpl-contact-info');
            if (ci) ci.innerHTML = v.contact.replace(/\n/g, '<br>');
        }

        if (tplId === 20) {
            const ol = el.querySelector('.tpl-overline');
            if (ol) ol.textContent = v.overline;
            const fb = el.querySelector('.tpl-footer-bar span');
            if (fb) fb.textContent = v.footerBar;
        }
    }

    // ===== RENDER FULL SIZE PREVIEW =====
    function renderFullPreview(tplId) {
        const thumbEl = document.getElementById('tpl-thumb-' + tplId);
        if (!thumbEl) return;

        const wrapper = document.getElementById('previewWrapper');
        // Clone the thumbnail template
        const clone = thumbEl.cloneNode(true);
        clone.removeAttribute('id');
        clone.style.transform = 'none';
        clone.style.pointerEvents = 'auto';

        wrapper.innerHTML = '';
        wrapper.appendChild(clone);
    }

    // ===== DOWNLOAD PNG =====
    document.getElementById('btnDownload').addEventListener('click', function() {
        downloadTemplate('png');
    });

    // ===== DOWNLOAD JPG =====
    document.getElementById('btnDownloadJpg').addEventListener('click', function() {
        downloadTemplate('jpg');
    });

    function downloadTemplate(format) {
        const wrapper = document.getElementById('previewWrapper');
        const templateEl = wrapper.querySelector('.template-wrap');
        if (!templateEl) return;

        const btn = format === 'png' ? document.getElementById('btnDownload') : document.getElementById('btnDownloadJpg');
        const origText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Generating...';
        btn.disabled = true;

        html2canvas(templateEl, {
            width: 1080,
            height: 1080,
            scale: 2,
            useCORS: true,
            allowTaint: true,
            backgroundColor: null,
            logging: false,
        }).then(canvas => {
            const link = document.createElement('a');
            const tplName = templateClasses[activeTemplate] || 'template';

            if (format === 'jpg') {
                link.download = 'gps-' + tplName + '.jpg';
                link.href = canvas.toDataURL('image/jpeg', 0.95);
            } else {
                link.download = 'gps-' + tplName + '.png';
                link.href = canvas.toDataURL('image/png');
            }

            link.click();
            btn.innerHTML = origText;
            btn.disabled = false;
        }).catch(err => {
            console.error('Download error:', err);
            btn.innerHTML = origText;
            btn.disabled = false;
            alert('Failed to generate image. Please try again.');
        });
    }

    // Keyboard shortcut
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePreview();
            closeEditor();
        }
    });

    // Initialize per-template state without cross-editing
    for (let i = 1; i <= 40; i++) {
        ensureTemplateState(i);
        applyTextToTemplate(i);
    }
});
</script>
@endpush
