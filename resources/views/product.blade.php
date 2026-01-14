@extends('layouts.master')

@section('title', ($product->name ?? 'Product') . ' • Legacy Leather Works')

@if($product ?? null)
@php
  $productDescription = strip_tags($product->description ?? 'Premium leather product from Legacy Leather Works');
  $metaDescription = strlen($productDescription) > 160 ? substr($productDescription, 0, 157) . '...' : $productDescription;
  $ogDescription = strlen($productDescription) > 200 ? substr($productDescription, 0, 197) . '...' : $productDescription;
@endphp
@endif

@if($product ?? null)
@section('meta_description', $metaDescription)
@section('meta_keywords', ($product->name ?? '') . ', leather goods, premium leather, ' . ($product->category ?? '') . ', Legacy Leather Works')
@section('og_title', ($product->name ?? 'Product') . ' • Legacy Leather Works')
@section('og_description', $ogDescription)
@section('og_image', image_url($product->image ?? null, asset('assets/img/logo.png')))
@section('og_type', 'product')
@section('og_url', route('product.show', $product->id))
@section('canonical_url', route('product.show', $product->id))
@endif

@if($product ?? null)
@section('structured_data')
@php
$categoryJson = $product->category ? '"category": "' . addslashes($product->category) . '",' : '';
@endphp
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Product",
  "name": "{{ $product->name }}",
  "description": "{{ strip_tags($product->description ?? '') }}",
  "image": "{{ image_url($product->image ?? null, asset('assets/img/logo.png')) }}",
  "brand": {
    "@@type": "Brand",
    "name": "{{ $siteSettings['site_name'] ?? 'Legacy Leather Works' }}"
  },
  "offers": {
    "@@type": "Offer",
    "url": "{{ route('product.show', $product->id) }}",
    "priceCurrency": "{{ $siteSettings['default_currency'] ?? 'USD' }}",
    "price": "{{ $product->price }}",
    "availability": "https://schema.org/{{ $product->is_active ? 'InStock' : 'OutOfStock' }}",
    "itemCondition": "https://schema.org/NewCondition"
  }@if($product->category),
  "category": "{{ $product->category }}"@endif,
  "sku": "{{ $product->id }}"
}
</script>
@endsection
@endif

@push('styles')
<style>
  :root {
    --product-primary: #6B3F2A;
    --product-cream: #fbf7f2;
    --product-gray: #666;
    --product-border: rgba(0,0,0,.1);
  }

  .product-page {
    padding: 40px 0 80px;
    background: var(--product-cream);
    min-height: 60vh;
  }

  .product-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
  }

  /* Breadcrumbs */
  .breadcrumbs {
    margin-bottom: 24px;
    font-size: 13px;
    color: var(--product-gray);
  }

  .breadcrumbs a {
    color: var(--product-primary);
    text-decoration: none;
    transition: opacity 0.2s;
  }

  .breadcrumbs a:hover {
    opacity: 0.7;
  }

  .breadcrumbs span {
    margin: 0 8px;
    color: var(--product-gray);
  }

  /* Product Grid */
  .product-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    margin-bottom: 80px;
  }

  @media (max-width: 968px) {
    .product-grid {
      grid-template-columns: 1fr;
      gap: 40px;
    }
  }

  /* Image Gallery */
  .product-gallery {
    position: sticky;
    top: 100px;
  }

  @media (max-width: 968px) {
    .product-gallery {
      position: static;
    }
  }

  .product-main-image {
    width: 100%;
    aspect-ratio: 1;
    object-fit: cover;
    border-radius: 12px;
    background: #fff;
    margin-bottom: 16px;
    cursor: zoom-in;
    transition: transform 0.3s;
  }

  .product-main-image:hover {
    transform: scale(1.02);
  }

  .product-thumbnails {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 12px;
  }

  .product-thumbnail {
    width: 100%;
    aspect-ratio: 1;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s;
    background: #fff;
  }

  .product-thumbnail:hover {
    border-color: var(--product-primary);
    transform: scale(1.05);
  }

  .product-thumbnail.active {
    border-color: var(--product-primary);
  }

  /* Product Info */
  .product-info {
    padding-top: 20px;
  }

  .product-vendor {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--product-primary);
    margin-bottom: 12px;
    font-weight: 500;
  }

  .product-title {
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 16px;
    line-height: 1.3;
    color: #1a1a1a;
    font-family: ui-serif, Georgia, "Times New Roman", serif;
  }

  @media (max-width: 640px) {
    .product-title {
      font-size: 24px;
    }
  }

  .product-price {
    font-size: 28px;
    font-weight: 700;
    color: var(--product-primary);
    margin-bottom: 24px;
  }

  .product-description {
    font-size: 16px;
    line-height: 1.7;
    color: var(--product-gray);
    margin-bottom: 32px;
  }

  /* Product Form */
  .product-form {
    margin-bottom: 32px;
  }

  .product-option {
    margin-bottom: 24px;
  }

  .product-option-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 8px;
    color: #1a1a1a;
  }

  .quantity-selector {
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid var(--product-border);
    border-radius: 8px;
    width: fit-content;
    overflow: hidden;
  }

  .quantity-btn {
    background: transparent;
    border: none;
    padding: 12px 16px;
    cursor: pointer;
    font-size: 18px;
    color: #1a1a1a;
    transition: background 0.2s;
  }

  .quantity-btn:hover {
    background: rgba(0,0,0,.05);
  }

  .quantity-input {
    border: none;
    width: 60px;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    padding: 12px 0;
    background: transparent;
  }

  .quantity-input:focus {
    outline: none;
  }

  /* Buttons */
  .product-buttons {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
  }

  .btn-add-to-cart {
    flex: 1;
    min-width: 200px;
    background: var(--product-primary);
    color: #fff;
    border: none;
    padding: 16px 32px;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .btn-add-to-cart:hover {
    background: #5a3322;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(107, 63, 42, 0.3);
  }

  .btn-add-to-cart:active {
    transform: translateY(0);
  }

  .btn-buy-now {
    flex: 1;
    min-width: 200px;
    background: transparent;
    color: var(--product-primary);
    border: 2px solid var(--product-primary);
    padding: 14px 32px;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .btn-buy-now:hover {
    background: var(--product-primary);
    color: #fff;
    transform: translateY(-2px);
  }

  /* Product Details Tabs */
  .product-details {
    margin-top: 60px;
    border-top: 1px solid var(--product-border);
    padding-top: 40px;
  }

  .product-tabs {
    display: flex;
    gap: 32px;
    border-bottom: 1px solid var(--product-border);
    margin-bottom: 32px;
    flex-wrap: wrap;
  }

  .product-tab {
    background: none;
    border: none;
    padding: 12px 0;
    font-size: 16px;
    font-weight: 500;
    color: var(--product-gray);
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all 0.2s;
    position: relative;
    top: 1px;
  }

  .product-tab:hover {
    color: var(--product-primary);
  }

  .product-tab.active {
    color: var(--product-primary);
    border-bottom-color: var(--product-primary);
  }

  .product-tab-content {
    display: none;
    font-size: 16px;
    line-height: 1.8;
    color: var(--product-gray);
  }

  .product-tab-content.active {
    display: block;
  }

  .product-tab-content ul {
    list-style: none;
    padding: 0;
  }

  .product-tab-content li {
    padding: 8px 0;
    border-bottom: 1px solid var(--product-border);
  }

  .product-tab-content li:last-child {
    border-bottom: none;
  }

  .product-tab-content strong {
    color: #1a1a1a;
    display: inline-block;
    min-width: 120px;
  }

  /* Related Products */
  .related-products {
    margin-top: 80px;
    padding-top: 60px;
    border-top: 1px solid var(--product-border);
  }

  .related-products-title {
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 40px;
    text-align: center;
    color: #1a1a1a;
    font-family: ui-serif, Georgia, "Times New Roman", serif;
  }

  .related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 24px;
  }

  @media (max-width: 640px) {
    .related-grid {
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 16px;
    }
  }

  .related-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
    text-decoration: none;
    color: inherit;
    display: block;
  }

  .related-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
  }

  .related-card-image {
    width: 100%;
    aspect-ratio: 1;
    object-fit: cover;
    background: var(--product-cream);
  }

  .related-card-info {
    padding: 16px;
  }

  .related-card-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #1a1a1a;
  }

  .related-card-price {
    font-size: 18px;
    font-weight: 700;
    color: var(--product-primary);
  }

  /* Toast Notification */
  .toast {
    position: fixed;
    right: 20px;
    bottom: 20px;
    background: #1a1a1a;
    color: #fff;
    padding: 16px 24px;
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    z-index: 9999;
    transform: translateY(20px);
    opacity: 0;
    transition: all 0.3s;
    pointer-events: none;
  }

  .toast.show {
    transform: translateY(0);
    opacity: 1;
    pointer-events: auto;
  }

  /* Loading State */
  .btn-add-to-cart.loading {
    opacity: 0.7;
    cursor: not-allowed;
    pointer-events: none;
  }

  .btn-add-to-cart.loading::after {
    content: '';
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255,255,255,0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
    margin-left: 8px;
  }

  @keyframes spin {
    to { transform: rotate(360deg); }
  }
</style>
@endpush

@section('content')
<div class="product-page">
  <div class="product-container">
    @if($product)
      <!-- Breadcrumbs -->
      <nav class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a>
        <span>/</span>
        <a href="{{ route('shop') }}">Shop</a>
        @if($product->category)
          <span>/</span>
          <a href="{{ route('shop') }}?cat={{ urlencode($product->category) }}">{{ $product->category }}</a>
        @endif
        <span>/</span>
        <span>{{ $product->name }}</span>
      </nav>

      <!-- Product Grid -->
      <div class="product-grid">
        <!-- Image Gallery -->
        <div class="product-gallery">
          <img 
            id="mainImage" 
            src="{{ image_url($product->image, 'assets/img/placeholder.jpg') }}" 
            alt="{{ $product->name }}"
            class="product-main-image"
          >
          <div class="product-thumbnails">
            <img 
              src="{{ image_url($product->image, 'assets/img/placeholder.jpg') }}" 
              alt="{{ $product->name }}"
              class="product-thumbnail active"
              data-image="{{ image_url($product->image, 'assets/img/placeholder.jpg') }}"
            >
            <!-- Additional thumbnails can be added here if product has multiple images -->
          </div>
        </div>

        <!-- Product Info -->
        <div class="product-info">
          <div class="product-vendor">Legacy Leather Works</div>
          <h1 class="product-title">{{ $product->name }}</h1>
          <div class="product-price">${{ number_format($product->price, 0) }}</div>
          
          @if($product->description)
            <div class="product-description">
              {{ $product->description }}
            </div>
          @endif

          <!-- Product Form -->
          <form class="product-form" id="productForm">
            <div class="product-option">
              <label class="product-option-label">Quantity</label>
              <div class="quantity-selector">
                <button type="button" class="quantity-btn" id="decreaseQty">−</button>
                <input 
                  type="number" 
                  id="quantity" 
                  class="quantity-input" 
                  value="1" 
                  min="1" 
                  max="99"
                  readonly
                >
                <button type="button" class="quantity-btn" id="increaseQty">+</button>
              </div>
            </div>

            <div class="product-buttons">
              <button type="submit" class="btn-add-to-cart" id="addToCartBtn">
                <i class="bi bi-cart-plus"></i>
                Add to Cart
              </button>
              <a href="{{ route('checkout') }}" class="btn-buy-now">
                <i class="bi bi-bag-check"></i>
                Buy Now
              </a>
            </div>
          </form>

          <!-- Product Details Tabs -->
          <div class="product-details">
            <div class="product-tabs">
              <button class="product-tab active" data-tab="description">Description</button>
              <button class="product-tab" data-tab="shipping">Shipping</button>
              <button class="product-tab" data-tab="returns">Returns</button>
            </div>

            <div class="product-tab-content active" id="tab-description">
              @if($product->description)
                <p>{{ $product->description }}</p>
              @else
                <p>Premium leather product crafted with attention to detail and quality materials.</p>
              @endif
            </div>

            <div class="product-tab-content" id="tab-shipping">
              <ul>
                <li><strong>Standard Shipping:</strong> 5-7 business days</li>
                <li><strong>Express Shipping:</strong> 2-3 business days</li>
                <li><strong>International:</strong> 10-14 business days</li>
                <li><strong>Free Shipping:</strong> On orders over $100</li>
              </ul>
              <p style="margin-top: 16px;">For more details, visit our <a href="{{ route('policies') }}" style="color: var(--product-primary);">Shipping Policy</a>.</p>
            </div>

            <div class="product-tab-content" id="tab-returns">
              <ul>
                <li><strong>Return Period:</strong> 30 days from delivery</li>
                <li><strong>Condition:</strong> Unused, original packaging</li>
                <li><strong>Process:</strong> Contact us to initiate return</li>
                <li><strong>Refund:</strong> Processed within 5-7 business days</li>
              </ul>
              <p style="margin-top: 16px;">For more details, visit our <a href="{{ route('policies') }}#returns" style="color: var(--product-primary);">Returns Policy</a>.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Related Products -->
      @if($relatedProducts && $relatedProducts->count() > 0)
        <div class="related-products">
          <h2 class="related-products-title">You May Also Like</h2>
          <div class="related-grid">
            @foreach($relatedProducts as $related)
              <a href="{{ route('product.show', $related->id) }}" class="related-card">
                <img 
                  src="{{ image_url($related->image, 'assets/img/placeholder.jpg') }}" 
                  alt="{{ $related->name }}"
                  class="related-card-image"
                >
                <div class="related-card-info">
                  <div class="related-card-title">{{ $related->name }}</div>
                  <div class="related-card-price">${{ number_format($related->price, 0) }}</div>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif
    @else
      <div style="text-align: center; padding: 80px 20px;">
        <h2 style="margin-bottom: 16px;">Product Not Found</h2>
        <p style="color: var(--product-gray); margin-bottom: 24px;">The product you're looking for doesn't exist.</p>
        <a href="{{ route('shop') }}" style="display: inline-block; padding: 12px 24px; background: var(--product-primary); color: #fff; text-decoration: none; border-radius: 8px;">Back to Shop</a>
      </div>
    @endif
  </div>
</div>

<!-- Toast Notification -->
<div class="toast" id="toast"></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  @if($product)
  const product = {
    id: {{ $product->id }},
    name: @json($product->name),
    price: {{ $product->price }},
    image: @json(image_url($product->image ?? null, 'assets/img/placeholder.jpg'))
  };
  @else
  const product = null;
  @endif
  
  if (!product || !product.id) return;

  // Quantity Controls
  const quantityInput = document.getElementById('quantity');
  const decreaseBtn = document.getElementById('decreaseQty');
  const increaseBtn = document.getElementById('increaseQty');

  decreaseBtn?.addEventListener('click', () => {
    const current = parseInt(quantityInput.value) || 1;
    if (current > 1) {
      quantityInput.value = current - 1;
    }
  });

  increaseBtn?.addEventListener('click', () => {
    const current = parseInt(quantityInput.value) || 1;
    if (current < 99) {
      quantityInput.value = current + 1;
    }
  });

  // Thumbnail Click
  document.querySelectorAll('.product-thumbnail').forEach(thumb => {
    thumb.addEventListener('click', function() {
      const mainImage = document.getElementById('mainImage');
      if (mainImage) {
        mainImage.src = this.dataset.image;
      }
      document.querySelectorAll('.product-thumbnail').forEach(t => t.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // Tab Switching
  document.querySelectorAll('.product-tab').forEach(tab => {
    tab.addEventListener('click', function() {
      const tabName = this.dataset.tab;
      
      // Update active tab
      document.querySelectorAll('.product-tab').forEach(t => t.classList.remove('active'));
      this.classList.add('active');
      
      // Update active content
      document.querySelectorAll('.product-tab-content').forEach(c => c.classList.remove('active'));
      const content = document.getElementById('tab-' + tabName);
      if (content) {
        content.classList.add('active');
      }
    });
  });

  // Add to Cart
  const addToCartBtn = document.getElementById('addToCartBtn');
  const productForm = document.getElementById('productForm');

  productForm?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const quantity = parseInt(quantityInput.value) || 1;
    const btn = addToCartBtn;
    
    // Disable button and show loading
    btn.classList.add('loading');
    btn.disabled = true;

    try {
      // Add to cart via API
      const response = await fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({
          product_id: product.id,
          name: product.name,
          price: product.price,
          img: product.image || '',
          qty: quantity
        })
      });

      const data = await response.json();

      if (response.ok && data.ok) {
        showToast('Added to cart!');
        
        // Update cart count
        updateCartCount();
      } else {
        showToast(data.message || 'Failed to add to cart', 'error');
      }
    } catch (error) {
      console.error('Error adding to cart:', error);
      showToast('Something went wrong. Please try again.', 'error');
    } finally {
      btn.classList.remove('loading');
      btn.disabled = false;
    }
  });

  // Buy Now - redirect to checkout with product
  document.querySelector('.btn-buy-now')?.addEventListener('click', async function(e) {
    e.preventDefault();
    
    const quantity = parseInt(quantityInput.value) || 1;
    const btn = this;
    
    // Disable button
    btn.style.opacity = '0.7';
    btn.style.pointerEvents = 'none';

    try {
      // Add to cart first
      const response = await fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({
          product_id: product.id,
          name: product.name,
          price: product.price,
          img: product.image || '',
          qty: quantity
        })
      });

      const data = await response.json();

      if (response.ok && data.ok) {
        // Redirect to checkout
        window.location.href = '{{ route("checkout") }}';
      } else {
        showToast(data.message || 'Failed to add to cart', 'error');
        btn.style.opacity = '1';
        btn.style.pointerEvents = 'auto';
      }
    } catch (error) {
      console.error('Error:', error);
      showToast('Something went wrong. Please try again.', 'error');
      btn.style.opacity = '1';
      btn.style.pointerEvents = 'auto';
    }
  });

  // Toast Notification
  function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    if (!toast) return;

    toast.textContent = message;
    toast.style.background = type === 'error' ? '#ef4444' : '#1a1a1a';
    toast.classList.add('show');

    setTimeout(() => {
      toast.classList.remove('show');
    }, 3000);
  }

  // Update Cart Count
  async function updateCartCount() {
    try {
      const response = await fetch('{{ route("cart.count") }}');
      const data = await response.json();
      
      document.querySelectorAll('[data-cart-count]').forEach(el => {
        el.textContent = data.count || 0;
      });
    } catch (error) {
      console.error('Error updating cart count:', error);
    }
  }
});
</script>
@endpush
