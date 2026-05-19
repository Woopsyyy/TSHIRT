<?php
require_once __DIR__ . '/components/header.php';
?>

<style>
.checkout-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: var(--spacing-xl);
    padding-top: calc(var(--spacing-lg) + 60px);
}

.checkout-form-group {
    margin-bottom: var(--spacing-md);
}

.checkout-label {
    display: block;
    margin-bottom: var(--spacing-xs);
    font-size: 0.9rem;
    color: var(--color-text-muted);
}

.checkout-input {
    width: 100%;
    padding: 1rem;
    background: transparent;
    border: 1px solid var(--color-border);
    color: var(--color-text);
    font-family: var(--font-main);
    border-radius: var(--radius-sm);
    transition: border-color var(--transition-fast);
}

.checkout-input:focus {
    outline: none;
    border-color: var(--color-text);
}

.order-summary {
    background: var(--color-surface);
    padding: var(--spacing-md);
    border-radius: var(--radius-md);
    position: sticky;
    top: 100px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: var(--spacing-sm);
    padding-bottom: var(--spacing-sm);
    border-bottom: 1px solid var(--color-border);
}

.summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 1.2rem;
    font-weight: 500;
    margin-top: var(--spacing-md);
}

@media (max-width: 900px) {
    .checkout-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<section class="section-padding" style="min-height: 100vh;">
    <div class="container">
        <div class="checkout-grid">
            
            <div class="checkout-details reveal">
                <h1 style="margin-bottom: var(--spacing-lg); font-weight: 300;">Checkout</h1>
                
                <h3 style="margin-bottom: var(--spacing-sm); color: var(--color-text-muted);">Contact Information</h3>
                <div class="checkout-form-group">
                    <input type="email" class="checkout-input" placeholder="Email Address">
                </div>

                <h3 style="margin-bottom: var(--spacing-sm); margin-top: var(--spacing-lg); color: var(--color-text-muted);">Shipping Address</h3>
                <div class="grid-2" style="gap: var(--spacing-sm);">
                    <div class="checkout-form-group">
                        <input type="text" class="checkout-input" placeholder="First Name">
                    </div>
                    <div class="checkout-form-group">
                        <input type="text" class="checkout-input" placeholder="Last Name">
                    </div>
                </div>
                <div class="checkout-form-group">
                    <input type="text" class="checkout-input" placeholder="Address">
                </div>
                <div class="grid-2" style="gap: var(--spacing-sm);">
                    <div class="checkout-form-group">
                        <input type="text" class="checkout-input" placeholder="City">
                    </div>
                    <div class="checkout-form-group">
                        <input type="text" class="checkout-input" placeholder="Postal Code">
                    </div>
                </div>

                <h3 style="margin-bottom: var(--spacing-sm); margin-top: var(--spacing-lg); color: var(--color-text-muted);">Payment</h3>
                <div style="padding: 1rem; border: 1px solid var(--color-border); border-radius: var(--radius-sm); margin-bottom: var(--spacing-lg);">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="radio" name="payment" checked>
                        <span>Cash on Delivery</span>
                    </label>
                </div>

                <button class="btn btn-primary" style="width: 100%; padding: 1.5rem;">Complete Order</button>
            </div>
            
            <div class="order-summary reveal" style="transition-delay: 0.2s;">
                <h3 style="margin-bottom: var(--spacing-md);">Order Summary</h3>
                
                <!-- Dynamic Items Container -->
                <div id="checkoutItems">
                    <!-- Javascript will render rows here -->
                </div>
                
                <div class="summary-item" style="border-top: 1px solid var(--color-border); padding-top: var(--spacing-md); margin-top: var(--spacing-md);">
                    <span style="color: var(--color-text-muted);">Subtotal</span>
                    <span id="checkoutSubtotal">&#8369;0.00</span>
                </div>
                <div class="summary-item">
                    <span style="color: var(--color-text-muted);">Shipping</span>
                    <span>Free</span>
                </div>
                
                <div class="summary-total">
                    <span>Total</span>
                    <span id="checkoutTotal">&#8369;0.00</span>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    function renderCheckoutSummary() {
        const checkoutItemsContainer = document.getElementById('checkoutItems');
        const checkoutSubtotalEl = document.getElementById('checkoutSubtotal');
        const checkoutTotalEl = document.getElementById('checkoutTotal');
        
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        if (!checkoutItemsContainer) return;
        
        if (cart.length === 0) {
            checkoutItemsContainer.innerHTML = '<p style="color: var(--color-text-muted); text-align: center; margin: 2rem 0;">Your cart is empty.</p>';
            if (checkoutSubtotalEl) checkoutSubtotalEl.innerHTML = '&#8369;0.00';
            if (checkoutTotalEl) checkoutTotalEl.innerHTML = '&#8369;0.00';
            return;
        }
        
        let html = '';
        let subtotal = 0;
        
        cart.forEach(item => {
            const itemTotal = item.price * item.qty;
            subtotal += itemTotal;
            
            html += `
                <div style="display: flex; gap: 1rem; margin-bottom: var(--spacing-md); align-items: center;">
                    <img src="${item.image}" style="width: 60px; height: 80px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--color-border);" alt="${item.name}">
                    <div style="flex: 1;">
                        <div style="font-weight: 500; font-size: 0.95rem;">${item.name}</div>
                        <div style="color: var(--color-text-muted); font-size: 0.85rem; margin-top: 0.2rem;">
                            Size: ${item.size} | Color: ${item.color} | Qty: ${item.qty}
                        </div>
                    </div>
                    <div style="font-weight: 500;">&#8369;${itemTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</div>
                </div>
            `;
        });
        
        checkoutItemsContainer.innerHTML = html;
        
        if (checkoutSubtotalEl) {
            checkoutSubtotalEl.innerHTML = `&#8369;${subtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }
        if (checkoutTotalEl) {
            checkoutTotalEl.innerHTML = `&#8369;${subtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }
    }
    
    renderCheckoutSummary();
    
    // Handle Complete Order Interaction
    const completeBtn = document.querySelector('button[style*="1.5rem"]');
    if (completeBtn) {
        completeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                alert('Your bag is empty! Please add products to shop.');
                return;
            }
            alert('Order placed successfully! Thank you for shopping with Moyce Jae.');
            localStorage.removeItem('cart');
            window.location.href = 'index.php';
        });
    }
});
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
