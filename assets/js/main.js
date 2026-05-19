// assets/js/main.js
document.addEventListener('DOMContentLoaded', () => {
    
    // Navbar Scroll Effect
    let lastScroll = 0;
    const navbar = document.querySelector('.navbar');
    
    if (navbar) {
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll <= 0) {
                navbar.classList.remove('hidden');
                return;
            }
            
            if (currentScroll > lastScroll && !navbar.classList.contains('hidden')) {
                // Scroll Down
                navbar.classList.add('hidden');
            } else if (currentScroll < lastScroll && navbar.classList.contains('hidden')) {
                // Scroll Up
                navbar.classList.remove('hidden');
            }
            
            lastScroll = currentScroll;
        });
    }

    // Hero Animation Trigger
    const hero = document.querySelector('.hero');
    if(hero) {
        setTimeout(() => {
            hero.classList.add('loaded');
        }, 100);
    }

    // Scroll Reveal Elements
    const reveals = document.querySelectorAll('.reveal');
    const revealOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    if (reveals.length > 0) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target);
                }
            });
        }, revealOptions);

        reveals.forEach(reveal => {
            revealObserver.observe(reveal);
        });
    }

    // Cart Drawer Logic
    const cartToggleBtns = document.querySelectorAll('.js-cart-toggle');
    const cartDrawer = document.getElementById('cartDrawer');
    const cartOverlay = document.getElementById('cartOverlay');

    function toggleCart(e) {
        if(e) e.preventDefault();
        if (cartDrawer && cartOverlay) {
            cartDrawer.classList.toggle('active');
            cartOverlay.classList.toggle('active');
            document.body.style.overflow = cartDrawer.classList.contains('active') ? 'hidden' : '';
        }
    }

    cartToggleBtns.forEach(btn => {
        btn.addEventListener('click', toggleCart);
    });

    if(cartOverlay) {
        cartOverlay.addEventListener('click', toggleCart);
    }

    // ==========================================
    // PREMIUM CART SYSTEM
    // ==========================================
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    const cartItemsContainer = document.getElementById('cartItems');
    const cartSubtotalEl = document.getElementById('cartSubtotal');

    // Make functions globally accessible for inline onclicks in generated markup
    window.removeFromCart = function(index) {
        cart.splice(index, 1);
        saveAndRender();
    };

    window.updateQty = function(index, delta) {
        cart[index].qty += delta;
        if (cart[index].qty <= 0) {
            cart.splice(index, 1);
        }
        saveAndRender();
    };

    function saveAndRender() {
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
        
        // Custom event for updating other pages (like checkout)
        window.dispatchEvent(new Event('cartUpdated'));
    }

    function renderCart() {
        if (!cartItemsContainer) return;

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = `
                <div style="text-align: center; color: var(--color-text-muted); margin-top: 3rem; animation: fadeIn 0.3s ease-out;">
                    <p style="font-size: 0.95rem; font-weight: 300; letter-spacing: 0.05em; margin-bottom: 1rem;">Your bag is empty</p>
                    <a href="shop.php" class="js-cart-toggle" style="color: var(--color-text); text-decoration: underline; font-size: 0.85rem; font-weight: 500;">Continue Shopping</a>
                </div>
            `;
            if (cartSubtotalEl) {
                cartSubtotalEl.innerHTML = '&#8369;0.00';
            }
            
            // Re-bind the newly generated continue shopping link
            const newToggles = cartItemsContainer.querySelectorAll('.js-cart-toggle');
            newToggles.forEach(t => t.addEventListener('click', toggleCart));
            return;
        }

        let html = '';
        let subtotal = 0;

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.qty;
            subtotal += itemTotal;

            html += `
                <div style="display: flex; gap: 1.2rem; margin-bottom: 1.8rem; animation: itemSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) ${index * 0.05}s both;">
                    <img src="${item.image}" style="width: 70px; height: 90px; object-fit: cover; border-radius: 8px; border: 1px solid var(--color-border);" alt="${item.name}">
                    <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 0.5rem;">
                                <h4 style="font-weight: 500; font-size: 0.95rem; margin: 0; line-height: 1.3; color: var(--color-text);">${item.name}</h4>
                                <button onclick="removeFromCart(${index})" style="background: none; border: none; padding: 0.2rem; cursor: pointer; color: var(--color-text-muted); transition: color 0.2s;" onmouseover="this.style.color='var(--color-text)'" onmouseout="this.style.color='var(--color-text-muted)'">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                            <div style="color: var(--color-text-muted); font-size: 0.8rem; margin-top: 0.25rem; font-weight: 400; letter-spacing: 0.02em;">
                                Size: ${item.size} | Color: ${item.color}
                            </div>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                            <!-- Quantity Controls -->
                            <div style="display: flex; align-items: center; border: 1px solid var(--color-border); border-radius: 4px; padding: 0.15rem;">
                                <button onclick="updateQty(${index}, -1)" style="background: none; border: none; color: var(--color-text); width: 24px; height: 24px; cursor: pointer; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; justify-content: center;">-</button>
                                <span style="font-size: 0.85rem; font-weight: 500; width: 20px; text-align: center; color: var(--color-text);">${item.qty}</span>
                                <button onclick="updateQty(${index}, 1)" style="background: none; border: none; color: var(--color-text); width: 24px; height: 24px; cursor: pointer; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; justify-content: center;">+</button>
                            </div>
                            <!-- Price -->
                            <div style="font-weight: 500; font-size: 0.9rem; color: var(--color-text);">&#8369;${itemTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</div>
                        </div>
                    </div>
                </div>
            `;
        });

        cartItemsContainer.innerHTML = html;
        if (cartSubtotalEl) {
            cartSubtotalEl.innerHTML = `&#8369;${subtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }
    }

    // Add to Cart Event Listener
    const addToCartBtn = document.querySelector('.js-add-to-cart');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const id = addToCartBtn.getAttribute('data-id');
            const name = addToCartBtn.getAttribute('data-name');
            const price = parseFloat(addToCartBtn.getAttribute('data-price'));
            const image = addToCartBtn.getAttribute('data-image');
            const color = addToCartBtn.getAttribute('data-color');
            
            const activeSizeBtn = document.querySelector('.size-btn.active');
            const sizeBtns = document.querySelectorAll('.size-btn');
            if (sizeBtns.length > 0 && !activeSizeBtn) {
                alert('Please select a size.');
                return;
            }
            const size = activeSizeBtn ? activeSizeBtn.textContent.trim() : 'One Size';
            
            let existingItem = cart.find(item => item.id === id && item.size === size && item.color === color);
            if (existingItem) {
                existingItem.qty += 1;
            } else {
                cart.push({ id, name, price, image, size, color, qty: 1 });
            }
            
            saveAndRender();
            
            // Open cart drawer
            if (cartDrawer && !cartDrawer.classList.contains('active')) {
                toggleCart();
            }
        });
    }

    // Render initially
    renderCart();
});
