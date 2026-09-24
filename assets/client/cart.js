document.addEventListener("DOMContentLoaded", function () {
    // Logic cho nút tăng/giảm số lượng ở trang chi tiết
    const btnMinus = document.getElementById('btn-qty-minus');
    const btnPlus = document.getElementById('btn-qty-plus');
    const qtyDetail = document.getElementById('qty-detail');
    
    if (btnMinus && btnPlus && qtyDetail) {
        btnMinus.addEventListener('click', function() {
            let val = parseInt(qtyDetail.value) || 1;
            if (val > 1) qtyDetail.value = val - 1;
        });
        btnPlus.addEventListener('click', function() {
            let val = parseInt(qtyDetail.value) || 1;
            qtyDetail.value = val + 1;
        });
    }

    // Thêm vào giỏ hàng
    document.querySelectorAll(".btn-add-cart").forEach(button => {
        button.addEventListener("click", function () {
            const productid = this.dataset.productid;
            const formData = new FormData();
            formData.append("productid", productid);
            
            // Nếu có ô nhập số lượng (ở trang chi tiết), thì lấy số lượng đó
            if (qtyDetail) {
                formData.append("quantity", qtyDetail.value);
            } else {
                formData.append("quantity", 1);
            }
            
            fetch(BASE_URL + "cart/add", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast("Thành công", data.message, "success");
                    const countEl = document.querySelector("#cartCount");
                    if(countEl) countEl.textContent = data.cartCount;
                } else {
                    showToast("Lỗi", data.message, "danger");
                }
            })
            .catch(error => {
                console.error("Lỗi:", error);
            });
        });
    });
});

function updateCart(productid, change) {
    const qtyInput = document.querySelector(`#quantity-${productid}`);
    if (!qtyInput) return;
    
    let currentQty = parseInt(qtyInput.value) || 0;
    let newQty = currentQty + change;
    
    if (newQty < 0) newQty = 0;
    
    const formData = new FormData();
    formData.append("productid", productid);
    formData.append("quantity", newQty);
    
    fetch(BASE_URL + "cart/update", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (newQty === 0) {
                const row = document.querySelector(`#cart-item-${productid}`);
                if (row) row.remove();
            } else {
                const itemTotalEl = document.querySelector(`#item-total-${productid}`);
                const qtyInput = document.querySelector(`#quantity-${productid}`);
                if (itemTotalEl) itemTotalEl.textContent = data.itemTotal;
                if (qtyInput) qtyInput.value = newQty;
            }
            
            const cartTotalEl = document.querySelector("#cartTotal");
            if (cartTotalEl) cartTotalEl.textContent = data.cartTotal;
            
            const countEl = document.querySelector("#cartCount");
            if(countEl) countEl.textContent = data.cartCount;
            
            showToast("Thành công", data.message, "success");
            
            if (data.cartCount === 0) {
                location.reload();
            }
        }
    })
    .catch(error => {
        console.error("Lỗi:", error);
    });
}

function removeCart(productid) {
    if (!confirm("Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?")) return;
    
    const formData = new FormData();
    formData.append("productid", productid);
    
    fetch(BASE_URL + "cart/remove", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = document.querySelector(`#cart-item-${productid}`);
            if (row) row.remove();
            
            const cartTotalEl = document.querySelector("#cartTotal");
            if (cartTotalEl) cartTotalEl.textContent = data.cartTotal;
            
            const countEl = document.querySelector("#cartCount");
            if(countEl) countEl.textContent = data.cartCount;
            
            showToast("Thành công", data.message, "success");
            
            if (data.cartCount === 0) {
                location.reload();
            }
        }
    })
    .catch(error => {
        console.error("Lỗi:", error);
    });
}

function showToast(title, message, type) {
    const toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) return;
    
    let bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
    
    const toastHtml = `
        <div class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong>${title}</strong><br>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    const toastElements = toastContainer.querySelectorAll('.toast');
    const newToast = new bootstrap.Toast(toastElements[toastElements.length - 1], { delay: 3000 });
    newToast.show();
}
