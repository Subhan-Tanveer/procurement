{{-- Contact Form: Quote/contact request form --}}
<div class="page-contact-us page-block">
    <div class="container">
        @if($content['section_title'] ?? false)
            <div class="row section-row">
                <div class="col-lg-12">
                    <div class="section-title section-title-center">
                        @if($content['description'] ?? false)
                            <h3 class="wow fadeInUp">{{ $content['description'] }}</h3>
                        @endif
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $content['section_title'] }}</h2>
                    </div>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="contact-us-form">
                    <div class="section-title section-title-center">
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Send a Message</h2>
                    </div>

                    <div class="contact-form">
                        <form action="{{ route('quotations.store') }}" method="POST" data-toggle="validator" class="wow fadeInUp">
                            @csrf
                            @if(isset($product))
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                            @endif

                            <div class="row">
                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="customer_name" class="form-control" placeholder="Full Name *" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <input type="email" name="customer_email" class="form-control" placeholder="Email Address *" required>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <input type="tel" name="customer_phone" class="form-control" placeholder="Phone Number">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="customer_company" class="form-control" placeholder="Company Name">
                                    <div class="help-block with-errors"></div>
                                </div>

                                @if(isset($product))
                                    <div class="form-group col-md-6 mb-4">
                                        <input type="number" name="quantity" class="form-control" placeholder="Quantity" value="1" min="1">
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <input type="text" name="subject" class="form-control" placeholder="Subject" value="Quote Request for {{ $product->name }}">
                                    </div>
                                    <div class="form-group col-md-12 mb-5">
                                        <textarea name="specifications" class="form-control" rows="5" placeholder="Specifications or additional requirements"></textarea>
                                    </div>
                                @else
                                    <div class="form-group col-md-12 mb-4">
                                        <input type="text" name="subject" class="form-control" placeholder="Subject">
                                    </div>
                                    <div class="form-group col-md-12 mb-5">
                                        <textarea name="message" class="form-control" rows="5" placeholder="Your Message"></textarea>
                                    </div>
                                @endif

                                <div class="col-lg-12">
                                    <div class="contact-form-btn">
                                        <button type="submit" class="btn-default"><span>{{ ($content['form_type'] ?? 'quote') === 'quote' ? 'Request Quote' : 'Send Message' }}</span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
