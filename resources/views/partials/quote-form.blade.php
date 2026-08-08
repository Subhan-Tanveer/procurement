{{-- Quote Request Form Partial --}}
<div class="quote-form-box wow fadeInUp" data-wow-delay="0.4s">
    <form action="{{ route('quotations.store') }}" method="POST" class="contact-form quote-request-form">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Full Name <span class="required">*</span></label>
                    <input type="text"
                           name="customer_name"
                           class="form-control @error('customer_name') is-invalid @enderror"
                           placeholder="Enter your full name"
                           value="{{ old('customer_name') }}"
                           required>
                    @error('customer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Email Address <span class="required">*</span></label>
                    <input type="email"
                           name="customer_email"
                           class="form-control @error('customer_email') is-invalid @enderror"
                           placeholder="Enter your email"
                           value="{{ old('customer_email') }}"
                           required>
                    @error('customer_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel"
                           name="customer_phone"
                           class="form-control @error('customer_phone') is-invalid @enderror"
                           placeholder="Enter your phone number"
                           value="{{ old('customer_phone') }}">
                    @error('customer_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text"
                           name="customer_company"
                           class="form-control @error('customer_company') is-invalid @enderror"
                           placeholder="Enter your company name"
                           value="{{ old('customer_company') }}">
                    @error('customer_company')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="product-info-banner">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4><i class="fa-solid fa-box me-2"></i>{{ $product->name }}</h4>
                            @if($product->sku)
                                <p class="product-sku mb-0">SKU: {{ $product->sku }}</p>
                            @endif
                        </div>
                        <div class="col-md-4 text-md-end">
                            @if($product->price > 0)
                                <p class="product-price mb-0">
                                    Base Price: <strong>{{ $product->currency }} {{ number_format($product->price, 2) }}</strong>
                                </p>
                            @else
                                <p class="product-price mb-0">
                                    <strong>Price on Request</strong>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Quantity <span class="required">*</span></label>
                    <input type="number"
                           name="quantity"
                           class="form-control @error('quantity') is-invalid @enderror"
                           placeholder="Enter quantity"
                           value="{{ old('quantity', 1) }}"
                           min="1"
                           required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text"
                           name="subject"
                           class="form-control @error('subject') is-invalid @enderror"
                           placeholder="Quote subject"
                           value="{{ old('subject', 'Quote Request for ' . $product->name) }}">
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label>Specifications / Additional Requirements</label>
                    <textarea name="specifications"
                              class="form-control @error('specifications') is-invalid @enderror"
                              rows="5"
                              placeholder="Please specify any custom requirements, specifications, or questions you have about this product...">{{ old('specifications') }}</textarea>
                    <small class="form-text text-muted">
                        <i class="fa-solid fa-circle-info me-1"></i>
                        Include details like preferred delivery date, special packaging, bulk order requirements, etc.
                    </small>
                    @error('specifications')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn-default btn-large w-100 w-md-auto">
                    <i class="fa-solid fa-paper-plane me-2"></i> Request Quote
                </button>
                <p class="form-notice mt-3 mb-0">
                    <i class="fa-solid fa-shield-halved me-1"></i>
                    Your information is secure and will only be used to process your quote request.
                </p>
            </div>
        </div>
    </form>
</div>

<style>
    .quote-form-box {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 5px 30px rgba(0,0,0,0.08);
    }

    .quote-request-form .form-group {
        margin-bottom: 25px;
    }

    .quote-request-form label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: block;
        font-size: 14px;
    }

    .quote-request-form .required {
        color: #dc3545;
    }

    .quote-request-form .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .quote-request-form .form-control:focus {
        border-color: #78B547;
        box-shadow: 0 0 0 0.2rem rgba(120, 181, 71, 0.15);
    }

    .quote-request-form .form-control.is-invalid {
        border-color: #dc3545;
    }

    .quote-request-form .form-control.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
    }

    .quote-request-form .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
    }

    .quote-request-form textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .product-info-banner {
        background: linear-gradient(135deg, #78B547 0%, #426693 100%);
        color: white;
        padding: 25px;
        border-radius: 10px;
        margin: 10px 0 20px 0;
    }

    .product-info-banner h4 {
        color: white;
        margin-bottom: 8px;
        font-size: 20px;
    }

    .product-info-banner .product-sku {
        color: rgba(255, 255, 255, 0.9);
        font-size: 14px;
    }

    .product-info-banner .product-price {
        font-size: 16px;
        color: white;
    }

    .product-info-banner .product-price strong {
        font-size: 20px;
        display: block;
        margin-top: 5px;
    }

    .btn-large {
        padding: 15px 40px;
        font-size: 16px;
        font-weight: 600;
    }

    .form-notice {
        color: #666;
        font-size: 13px;
        font-style: italic;
    }

    .form-notice i {
        color: #78B547;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .quote-form-box {
            padding: 25px 20px;
        }

        .product-info-banner {
            padding: 20px;
        }

        .product-info-banner h4 {
            font-size: 18px;
        }

        .product-info-banner .product-price strong {
            font-size: 18px;
        }

        .btn-large {
            padding: 12px 30px;
            font-size: 15px;
        }
    }
</style>
